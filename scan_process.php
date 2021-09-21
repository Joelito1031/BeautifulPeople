<?php
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

// $request = file_get_contents('php://input');
$request =  file_get_contents('php://input');
$data = json_decode($request);
$decrypted_string = decryptor($data->data);
$request_obj = json_decode($decrypted_string);
$type = $request_obj->type;

$vehicle_list = file_get_contents('./vehicles/queuing_vehicles.json');
$vehicles = json_decode($vehicle_list);
$travel = false;
$availability = false;
$loaded = false;
$count = 0;

//This function is to check whether the passenger is already loaded.
function checkList($destination, $name){
  $waiting_list = file_get_contents('./queuing/' .$destination . '.json');
  $passenger_waiting = json_decode($waiting_list);

  if(sizeof($passenger_waiting) > 0){
    $count = 0;
    while($count < sizeof($passenger_waiting)){  //This here needs to be checked.
      if($passenger_waiting[$count] === $name){
        array_splice($passenger_waiting, $count, 1, null);
        $waiting_to_json = json_encode($passenger_waiting);
        $altered_waiting_list = fopen('./queuing/' . $destination . '.json', 'w');
        fwrite($altered_waiting_list, $waiting_to_json);
        fclose($altered_waiting_list);
        break;
      }
      $count += 1;
    }
  }
}

//This function is to save the passenger.
function infoSaving($vehicle){
  $GLOBALS['vehicle_passenger'][$GLOBALS['count']] = $GLOBALS['name'];
  $vehicle->passengers = $vehicle->passengers + 1;
  $puv = $vehicle->vehicle;
  $route = $vehicle->route;
  $name = $GLOBALS['name'];

  checkList($GLOBALS['destination'], $name);

  $altered_passenger_list = fopen('./vehicles/' . $route . '_' . $puv . '.json', 'w');
  $altered_vehicle_list = fopen('./vehicles/queuing_vehicles.json', 'w');
  $passengers_to_json = json_encode($GLOBALS['vehicle_passenger']);
  $vehicles_to_json = json_encode($GLOBALS['vehicles']);

  $insert_query = "INSERT INTO loaded_passengers(Vehicle, Passenger) VALUES('$puv', '$name')";
  $GLOBALS['connection']->exec($insert_query);

  fwrite($altered_passenger_list, $passengers_to_json);
  fwrite($altered_vehicle_list, $vehicles_to_json);
  fclose($altered_passenger_list);
  fclose($altered_vehicle_list);

  return $puv;
}

if($halt_operation){
  $status = "Operation cannot proceed";
}
else{
  if($type === "passenger"){

    $status = "passenger";
    $destination = $request_obj->destination;
    $name = $request_obj->name;

    if(sizeof($vehicles) > 0){
      foreach($vehicles as $vehicle){
        if($vehicle->route === $destination){
          $travel = true;
          if($vehicle->passengers < $vehicle->capacity){

            $dest = $vehicle->route;
            $plate = $vehicle->vehicle;
            $puv_info = $vehicle;
            // $passenger_list = file_get_contents('./vehicles/' . $vehicle->route . '_' . $vehicle->vehicle . ".json");
            // $passengers =  json_decode($passenger_list);
            $select_query = "SELECT COUNT(*) FROM loaded_passengers WHERE Passenger = '$name'";
            $num_row = $connection->query($select_query);
            $count_row = (int) $num_row->fetchColumn();

            if($count_row > 0){
              $status = 'Passenger already boarded';
              $loaded = true;
            }
            $availability = true;
            break;
          }
        }
      }

      if(!$travel){
        $status = 'No queuing PUV with that destination';
      }
      elseif(!$availability){
        $list = file_get_contents('./queuing/' . $destination . '.json');
        $list_array = json_decode($list);
        $list_user = true;

        if(sizeof($list_array) > 0){
          foreach($list_array as $passenger){
            if($passenger === $name){
              $status = 'Already included in waiting list';
              $list_user = false;
              break;
            }
          }
        }

        if($list_user){
          array_push($list_array, $name);
          $list_string = json_encode($list_array);
          $list_file = fopen('./queuing/' . $destination . '.json', 'w');
          fwrite($list_file, $list_string);
          fclose($list_file);
          $status = 'Passenger is in waiting list'; //Vehicle might be not queuing or full.
        }
      }
      elseif(!$loaded){
        $count = 0;
        $vehicle_passenger_list = file_get_contents('./vehicles/' . $dest . '_' . $plate . '.json');
        $vehicle_passenger = json_decode($vehicle_passenger_list);

        while($count < sizeof($vehicle_passenger)){
          if($vehicle_passenger[$count] === ''){
            $status = infoSaving($puv_info);
            break;
          }
          $count += 1;
        }
      }
    }
    else{
      $status = "No vehicle queuing";
    }
  }

  elseif($type === "vehicle"){


    $queue_vehicle_list = file_get_contents('./vehicles/vehicles.json');
    $queue_vehicles = json_decode($queue_vehicle_list);
    $registered = false;

    foreach($queue_vehicles as $vehicle){
      if($vehicle->vehicle === $request_obj->plateno){
        $registered = true;
        if($vehicle->queuing === false){
          $vehicle->queuing = true;
          $queuing_vehicles = file_get_contents('./vehicles/queuing_vehicles.json');
          $queuing_list = json_decode($queuing_vehicles);
          $queuing_info = array("vehicle" => $vehicle->vehicle, "route" => $vehicle->route, "capacity" => $vehicle->capacity, "passengers" => 0);
          array_push($queuing_list, $queuing_info);
          $queuing_list_to_json = json_encode($queuing_list);
          $vehicles_to_json = json_encode($queue_vehicles);
          $altered_queuing_list = fopen('./vehicles/queuing_vehicles.json', 'w');
          $altered_vehicle_list = fopen('./vehicles/vehicles.json', 'w');

          fwrite($altered_queuing_list, $queuing_list_to_json);
          fwrite($altered_vehicle_list, $vehicles_to_json);
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