<?php

$request = file_get_contents('php://input');
$request_obj = json_decode($request);
$vehicle_list = file_get_contents('./vehicles/vehicles.json');
$vehicles = json_decode($vehicle_list);
$destination = $request_obj->destination;  // ---->> YOU STOP HERE AND LINE 44. REMEMBER 1 CORINTHIANS 10:31
$name = $request_obj->name;
$availability = false;

foreach($vehicles as $vehicle){
  if($vehicle->route === $destination){
    if($vehicle->queuing === true){
      if($vehicle->passengers < $vehicle->capacity){
          $vehicle->passengers = $vehicle->passengers + 1;
          $availability = true;
          $puv = $vehicle->vehicle;
          $status = $puv;
          $route = $vehicle->route;
          break;
      }
      else{
        $status = 'Vehicle is full';
      }
    }
    elseif($vehicle->queuing === false){
      $status = 'No vehicle queuing on that destination';
    }
    else{
      $status = 'Invalid QR Code';
    }
  }
}

if($availability){
  $waiting_list = file_get_contents('./queuing/' .$destination . '.json');
  $passenger_waiting = json_decode($waiting_list);
  $count = 0;

  while($count <= sizeof($passenger_waiting)){
    if($passenger_waiting[$count] === $name){
      array_splice($passenger_waiting, $count, 1, null);
      break;
    }
    $count += 1;
  }

  $waiting_to_json = json_encode($passenger_waiting);
  $vehicles_to_json = json_encode($vehicles);
  $altered_vehicle_list = fopen('./vehicles/vehicles.json', 'w');
  $altered_waiting_list = fopen('./queuing/' . $destination . '.json', 'w');

  fwrite($altered_vehicle_list, $vehicles_to_json);
  fwrite($altered_waiting_list, $waiting_to_json);
  fclose($altered_vehicle_list);
  fclose($altered_waiting_list);

  $passenger_list = file_get_contents('./vehicles/' . $route . '_' . $puv . '.json');
  $passengers =  json_decode($passenger_list, true);
  $count = 0;

  while($count <= sizeof($passengers)){
    if($passengers[$count] === $name){
      $status = 'Passenger already loaded';
      break;
    }
    elseif($passengers[$count] === ""){
      $passengers[$count] = $name;
      break;
    }
    $count += 1;
  }

  $passengers_to_json = json_encode($passengers);
  $altered_passenger_list = fopen('./vehicles/' . $route . '_' . $puv . '.json', 'w');

  fwrite($altered_passenger_list, $passengers_to_json);
  fclose($altered_passenger_list);
}
else{
  $list = file_get_contents('./queuing/' . $destination . '.json');
  $list_array = json_decode($list);
  $list_user = true;

  foreach($list_array as $passenger){
    if($passenger === $name){
      $status = 'Already included in waiting list';
      $list_user = false;
      break;
    }
  }

  if($list_user){
    array_push($list_array, $name);
    $list_string = json_encode($list_array);
    $list_file = fopen('./queuing/' . $destination . '.json', 'w');
    fwrite($list_file, $list_string);
    fclose($list_file);
  }
}

echo json_encode($status);
