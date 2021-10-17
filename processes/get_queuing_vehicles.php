<?php

$data = json_decode(file_get_contents('php://input'));
$queuing_vehicles = json_decode(file_get_contents('../vehicles/queuing_vehicles.json'));
$vehicle_queuing = array();

foreach ($queuing_vehicles as $vehicle) {
  if($vehicle->route == $data->data){
    array_push($vehicle_queuing, array("Vehicle" => $vehicle->vehicle, "Capacity" => $vehicle->capacity));
  }
}

echo json_encode(json_encode($vehicle_queuing));
?>
