<?php

$request = file_get_contents('php://input');
$request_obj = json_decode($request);
$vehicle_list = file_get_contents('./vehicles/vehicles.json');
$vehicles = json_decode($vehicle_list);

foreach($vehicles as $vehicle){
  if($vehicle->vehicle === $request_obj->plateno){
    if($vehicle->queuing === false){
      $vehicle->queuing = true;
      $status = 'Vehicle is set to queuing.';
      break;
    }
    elseif($vehicle->queuing === true){
      $status = 'Vehicle already queuing';
      break;
    }
    else{
      $status = 'Invalid QR Code';
      break;
    }
  }
  else{
    $status = 'Vehicle is not registered';
  }
}

$vehicles_to_json = json_encode($vehicles);
$altered_vehicle_list = fopen('./vehicles/vehicles.json', 'w');

fwrite($altered_vehicle_list, $vehicles_to_json);
fclose($altered_vehicle_list);


echo json_encode($status);
