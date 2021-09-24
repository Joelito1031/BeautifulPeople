<?php

//This function is for decrypting data.
function decryptor($cipheredtext){
  $key = "udWH+XfEbKB44oqM";
  $c = base64_decode($cipheredtext);
  $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
  $iv = substr($c, 0, $ivlen);
  $hmac = substr($c, $ivlen, $sha2len=32);
  $cipheredtext_raw = substr($c, $ivlen+$sha2len);
  $plain_string = openssl_decrypt($cipheredtext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
  $calcmac = hash_hmac('sha256', $cipheredtext_raw, $key, $as_binary=true);
  if (hash_equals($hmac, $calcmac))
  {
      return $plain_string;
  }
}

function checkList($destination, $passenger){
  $waiting_passenger_query = $GLOBALS['connection']->prepare("SELECT COUNT(*) as COUNT, Destination, Passenger FROM waiting_passengers WHERE Destination = '$destination' AND Passenger = '$passenger'");
  $waiting_passenger_query->execute();
  $result = $waiting_passenger_query->fetchall();

  if((int) $result[0]['COUNT'] > 0){
    $delete_passenger = $GLOBALS['connection']->prepare("DELETE FROM waiting_passengers WHERE Destination = '$destination' AND Passenger = '$passenger'");
    $delete_passenger->execute();
    $rowCount = $delete_passenger->rowCount();

    if($rowCount > 0){
      return true;
    }
    elseif($rowCount == 0) {
      return true;
    }
    else{
      return false;
    }
  }
  else{
    return true;
  }
}

//Database variables
$servername = "localhost";
$username = "root";
$password = "";
$database = "ocqms";
$halt_operation = false;

try{

  $connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
  $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}catch(PDOException $e){

  $halt_operation = true;

}

if($halt_operation){

  $status = "The operation cannot proceed";

}
else{

  $data = json_decode(file_get_contents('php://input'));
  $request_obj = json_decode(decryptor($data->data));

  if($request_obj->type === "passenger"){

    $loaded_passenger_query = $connection->prepare("SELECT COUNT(*) as COUNT, Vehicle, Passenger FROM loaded_passengers WHERE Passenger  = '$request_obj->name'");
    $loaded_passenger_query->execute();
    $result = $loaded_passenger_query->fetchall();

    if((int) $result[0]['COUNT'] > 0){

      $loaded = true;
      $status = "Onboard " . $result[0]['Vehicle'];

    }
    else{
      $registered = false;
      $availability = false;
      $notfull = false;

      if(is_writable('./vehicles/vehicles.json')){
        $vehicle_list = json_decode(file_get_contents('./vehicles/vehicles.json'));

        foreach($vehicle_list as $registered_vehicle){
          if($registered_vehicle->route === $request_obj->destination){
            $registered = true;
            if(is_writable('./vehicles/queuing_vehicles.json')){
              $queuing_vehicles = json_decode(file_get_contents('./vehicles/queuing_vehicles.json'));

              foreach($queuing_vehicles as $vehicle){
                if($vehicle->route === $request_obj->destination){
                    $availability = true; //Status: Vehicle available but full.

                    if($vehicle->passengers < $vehicle->capacity){
                      $notfull = true;
                      $state = checkList($request_obj->destination, $request_obj->name);
                      if($state || !$state){
                        $vehicle->passengers += 1;
                        $queuing_vehicles_file = fopen('./vehicles/queuing_vehicles.json', 'w');

                        fwrite($queuing_vehicles_file, json_encode($queuing_vehicles));
                        fclose($queuing_vehicles_file);

                        if(is_writable("./vehicles/" . $vehicle->route . "_" . $vehicle->vehicle . ".json")){
                          $count = 0;
                          $passenger_name_list = json_decode(file_get_contents("./vehicles/" . $vehicle->route . "_" . $vehicle->vehicle . ".json"));

                          while($count < sizeof($passenger_name_list)){
                            if($passenger_name_list[$count] === ""){
                              $passenger_name_list[$count] = $request_obj->name;
                              break;
                            }
                            $count += 1;
                          }

                          $passenger_name_list_file = fopen("./vehicles/" . $vehicle->route . "_" . $vehicle->vehicle . ".json", "w");
                          fwrite($passenger_name_list_file, json_encode($passenger_name_list));
                          fclose($passenger_name_list_file);

                          $insert_passenger_query = "INSERT INTO loaded_passengers (Vehicle, Passenger) VALUES ('$vehicle->vehicle', '$request_obj->name')";
                          $connection->exec($insert_passenger_query);
                          $status = $vehicle->vehicle;
                          break;
                        }
                      }
                    }
                }
              }
            }
            else{
              $status = "The operation cannot proceed";
            }
          }
        }
        if(!$registered){
          $status = "Vehicle is not registered";
        }
        elseif(!$availability){
          $waiting_passenger_query = $GLOBALS['connection']->prepare("SELECT COUNT(*) as COUNT, Destination, Passenger FROM waiting_passengers WHERE Destination = '$request_obj->destination' AND Passenger = '$request_obj->name'");
          $waiting_passenger_query->execute();
          $result = $waiting_passenger_query->fetchall();

          if((int) $result[0]['COUNT'] > 0){
            $status = "Already on waiting list";
          }
          else{
            $insert_passenger_query = "INSERT INTO waiting_passengers (Destination, Passenger) VALUES ('$request_obj->destination', '$request_obj->name')";
            $connection->exec($insert_passenger_query);
            $status = "Passenger added to waiting list";
          }
        }
        elseif (!$notfull) {
          $waiting_passenger_query = $GLOBALS['connection']->prepare("SELECT COUNT(*) as COUNT, Destination, Passenger FROM waiting_passengers WHERE Destination = '$request_obj->destination' AND Passenger = '$request_obj->name'");
          $waiting_passenger_query->execute();
          $result = $waiting_passenger_query->fetchall();

          if((int) $result[0]['COUNT'] > 0){
            $status = "Already on waiting list";
          }
          else{
            $insert_passenger_query = "INSERT INTO waiting_passengers (Destination, Passenger) VALUES ('$request_obj->destination', '$request_obj->name')";
            $connection->exec($insert_passenger_query);
            $status = "Passenger added to waiting list";
          }
        }
      }
    }
  }
  elseif($request_obj->type === "vehicle"){

    $queue_vehicles = json_decode(file_get_contents('./vehicles/vehicles.json'));
    $registered = false;

    foreach($queue_vehicles as $vehicle){
      if($vehicle->vehicle === $request_obj->plateno){
        $registered = true;
        if($vehicle->queuing === false){
          $vehicle->queuing = true;
          $queuing_list = json_decode(file_get_contents('./vehicles/queuing_vehicles.json'));
          $queuing_info = array("vehicle" => $vehicle->vehicle, "route" => $vehicle->route, "capacity" => $vehicle->capacity, "passengers" => 0);
          array_push($queuing_list, $queuing_info);
          $altered_queuing_list = fopen('./vehicles/queuing_vehicles.json', 'w');
          $altered_vehicle_list = fopen('./vehicles/vehicles.json', 'w');

          fwrite($altered_queuing_list, json_encode($queuing_list));
          fwrite($altered_vehicle_list, json_encode($queue_vehicles));
          fclose($altered_queuing_list);
          fclose($altered_vehicle_list);

          $status = 'Vehicle is set to queuing';
          break;
        }
        elseif($vehicle->queuing === true){
          $status = 'Vehicle already queuing';
          break;
        }
      }
    }

    if(!$registered){
      $status = "Vehicle is not registered";
    }
  }
}

echo json_encode($status);
