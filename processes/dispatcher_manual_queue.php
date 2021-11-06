<?php
require "./db_connection.php";
$data = json_decode(file_get_contents("php://input"));
$qr = $data->data;
$destination = $data->destination;
$passenger_name = $data->name;
$companion = $data->companion;
try{
  $vehicle_available = false;
  $vehicle_not_full = false;
  $queuing_vehicles = json_decode(file_get_contents("../vehicles/queuing_vehicles.json"));
  foreach($queuing_vehicles as $vehicle){
    if($vehicle->route == $destination){
      $vehicle_available = true;
      if($vehicle->passengers < $vehicle->capacity){
        $vehicle_not_full = true;
        $check_if_waiting = $connection->prepare("SELECT Count(*) as Count FROM waiting_passengers WHERE Passenger = :passenger");
        $check_if_waiting->bindParam(":passenger", $passenger_name);
        $check_if_waiting->execute();
        $is_waiting = $check_if_waiting->fetch();
        if($is_waiting['Count'] > 0){
          $remove_passenger = $connection->prepare("DELETE FROM waiting_passengers WHERE Passenger = :passenger");
          $remove_passenger->bindParam(":passenger", $passenger_name);
          $remove_passenger->execute();
        }
        $vehicle->passengers += 1;
        $store_passenger = $connection->prepare("INSERT INTO loaded_passengers(Vehicle, Passenger, QR) VALUES(:vehicle, :passenger, :qr)");
        $store_passenger->bindParam(":vehicle", $vehicle->vehicle);
        $store_passenger->bindParam(":passenger", $passenger_name);
        $store_passenger->bindParam(":qr", $qr);
        $store_passenger->execute();
        $vehicle_filename = $vehicle->route . "_" . $vehicle->vehicle . ".json";
        $vehicle_manifest = json_decode(file_get_contents("../vehicles/" . $vehicle_filename));
        foreach($vehicle_manifest as $vehicle_passenger){
          if($vehicle_passenger->Name == "" && $vehicle_passenger->Companion == ""){
            $vehicle_passenger->Name = $passenger_name;
            $vehicle_passenger->Companion = $companion;
            break;
          }
        }
        $file_increment_vehicle = fopen("../vehicles/queuing_vehicles.json", "w");
        fwrite($file_increment_vehicle, json_encode($queuing_vehicles));
        fclose($file_increment_vehicle);
        $file_add_passenger = fopen("../vehicles/" . $vehicle_filename, "w");
        fwrite($file_add_passenger, json_encode($vehicle_manifest));
        fclose($file_add_passenger);
        echo json_encode($vehicle->vehicle);
        break;
      }
    }
  }
  if(!$vehicle_available){
    echo json_encode("No PUV available");
  }else if(!$vehicle_not_full){
    echo json_encode("No PUV available");
  }
}catch(Exception $e){
  echo json_encode("error");
}
?>
