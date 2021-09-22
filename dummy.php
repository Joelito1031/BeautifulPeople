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

if($halt_operation){

  $status = "The operation cannot proceed";

}
else{

  $request_obj = json_decode('{"type":"passenger","name":"Joelito Quiapo Caorte","cnum":"09306319380","destination":"bato"}');

  if(is_writable('./vehicles/queuing_vehicles.json')){

    $queuing_vehicles = json_decode(file_get_contents('./vehicles/queuing_vehicles.json'));

    foreach($queuing_vehicles as $vehicle){

      if($vehicle->route === $request_obj->destination){

          $available = true; //Status: Vehicle available but full.

          if($vehicle->passengers < $vehicle->capacity){

            $vehicle->passengers += 1;

            if($queuing_vehicles_file = fopen('./vehicles/queuing_vehicles.json', 'w')){

              fwrite($queuing_vehicles_file, json_encode($queuing_vehicles));
              fclose($queuing_vehicles_file);

            }
            else{

              $status = "The operation cannot proceed";
              break;

            }

          }

      }

    }

  }
  else{
    $status = "The operation cannot proceed";
  }

  // $waiting_passenger_query = $connection->prepare("SELECT COUNT(*) as COUNT, Destination, Passenger FROM waiting_passengers WHERE Destination = '$request_obj->destination' AND Passenger = '$request_obj->name'");
  // $waiting_passenger_query->execute();
  // $result = $waiting_passenger_query->fetchall();
  //
  // if((int) $result[0]['COUNT'] > 0){
  //
  //   $delete_passenger = $connectio->prepare("DELETE FROM waiting_passengers WHERE Passenger = '$request_obj->name'");
  //   $delete_passenger->execute();
  //
  //   if($delete_passenger->rowCount() > 0){
  //
  //      //Put code here.
  //
  //   }
  //
  // }

}

echo $status;
