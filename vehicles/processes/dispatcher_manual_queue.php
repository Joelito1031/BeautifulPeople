<?php
require "./db_connection.php";
$data = json_decode(file_get_contents("php://input"));
try{
  $queuing_vehicles = json_decode(file_get_contents("../vehicles/queuing_vehicles.json"));
  $vehicle_not_full = false;
  $vehicle_available = false;
  foreach($queuing_vehicles as $vehicle){
    if($vehicle->route == $data->destination){
      $vehicle_available = true;
      if($vehicle->passengers < $vehicle->capacity){
        $vehicle_not_full = true;
        $vehicle->passengers = $vehicle->passengers + 1;
        $write_the_passenger = json_decode(file_get_contents("../vehicles/" . $vehicle->route . "_" . $vehicle->vehicle . ".json"));
        foreach($write_the_passenger as $passenger_name){
          if($passenger_name->Name == "" && $passenger_name->Companion == "" && $passenger_name->Number == ""){
            $passenger_name->Number = $data->number;
            $passenger_name->Name = $data->name;
            $passenger_name->Companion = $data->companion;
            $load_passenger = $connection->prepare("INSERT INTO loaded_passengers(Vehicle, Passenger, QR) VALUES(:vehicle, :passenger, :qr)");
            $load_passenger->bindParam(":vehicle", $vehicle->vehicle);
            $load_passenger->bindParam(":passenger", $data->name);
            $load_passenger->bindParam(":qr", $data->data);
            $load_passenger->execute();
            $vehicle_file = fopen("../vehicles/queuing_vehicles.json", "w");
            fwrite($vehicle_file, json_encode($queuing_vehicles));
            fclose($vehicle_file);
            $passenger_file = fopen("../vehicles/" . $vehicle->route . "_" . $vehicle->vehicle . ".json", "w");
            fwrite($passenger_file, json_encode($write_the_passenger));
            fclose($passenger_file);
            echo json_encode("Go directly to " . $vehicle->vehicle);
            break;
          }
        }
      }
      break;
    }
  }
  if($vehicle_not_full == false && $vehicle_available == false){
    echo json_encode("PUV is not available");
  }
}catch(Exception $e){
  echo json_encode("error");
}
?>
