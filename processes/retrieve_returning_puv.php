<?php

$data = json_decode(file_get_contents('php://input'));
$vehicles = json_decode(file_get_contents('./vehicles/vehicles.json'));
$returning_vehicles = [];

foreach($vehicles as $vehicle){
  if($vehicle->route == $data->data && $vehicle->returning){
    array_push($returning_vehicles, array("Vehicle" => $vehicle->vehicle, "Capacity" => $vehicle->capacity));
  }
}

echo json_encode(json_encode($returning_vehicles));

?>
