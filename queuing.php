<?php

$request = file_get_contents('php://input');
$request_obj = json_decode($request);
$vehicle_list = file_get_contents('./vehicles/vehicles.json');
$vehicles = json_decode($vehicle_list);

foreach($vehicles as $vehicle){
  if($vehicle->vehicle === $request_obj->plateno){
    if($vehicle->queuing === false){
      $vehicle->queuing = true;
      $queuing_vehicles = file_get_contents('./vehicles/queuing_vehicles.json');
      $queuing_list = json_decode($queuing_vehicles);
      $queuing_info = array("vehicle" => $vehicle->vehicle, "route" => $vehicle->route, "capacity" => $vehicle->capacity, "passengers" => 0);
      array_push($queuing_list, $queuing_info);
      $queuing_list_to_json = json_encode($queuing_list);
      $vehicles_to_json = json_encode($vehicles);
      $altered_queuing_list = fopen('./vehicles/queuing_vehicles.json', 'w');
      $altered_vehicle_list = fopen('./vehicles/vehicles.json', 'w');

      fwrite($altered_queuing_list, $queuing_list_to_json);
      fwrite($altered_vehicle_list, $vehicles_to_json);
      fclose($altered_queuing_list);
      fclose($altered_vehicle_list);

      $status = 'Vehicle is set to queuing.';
      break;
    }
    elseif($vehicle->queuing === true){
      $status = 'Vehicle already queuing';
      break;
    }
  }
  else{
    $status = 'Vehicle is not registered';
  }
}

echo json_encode($status);
