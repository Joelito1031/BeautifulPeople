<?php
require "./db_connection.php";
$data = json_decode(file_get_contents("php://input"));
try{
  $passenger_name = json_decode(file_get_contents("../vehicles/" . $data->file));
  foreach($passenger_name as $passenger){
    if($passenger->Name == $data->passenger){
      $passenger->Name = "";
      $passenger->Companion = "";
      $passenger->Number = "";
      $queuing_vehicles = json_decode(file_get_contents("../vehicles/queuing_vehicles.json"));
      foreach($queuing_vehicles as $vehicle){
        if($vehicle->vehicle == $data->vehicle){
          $vehicle->passengers = $vehicle->passengers - 1;
          $delete_the_passenger = $connection->prepare("DELETE FROM loaded_passengers WHERE Passenger = :passenger AND Vehicle = :vehicle");
          $delete_the_passenger->bindParam(":passenger", $data->passenger);
          $delete_the_passenger->bindParam(":vehicle", $data->vehicle);
          $delete_the_passenger->execute();
          $passenger_file = fopen("../vehicles/" . $data->file, "w");
          fwrite($passenger_file, json_encode($passenger_name));
          fclose($passenger_file);
          $vehicle_file = fopen("../vehicles/queuing_vehicles.json", "w");
          fwrite($vehicle_file, json_encode($queuing_vehicles));
          fclose($vehicle_file);
          echo json_encode(json_encode($passenger_name));
          break;
        }
      }
      break;
    }
  }
}catch(Exception $e){
  echo "error";
}
$connection = null;
?>
