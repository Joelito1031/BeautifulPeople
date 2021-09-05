<?php

$request = file_get_contents('php://input');
$request_obj = json_decode($request);
$vehicle_list = file_get_contents('./vehicles/queuing_vehicles.json');
$vehicles = json_decode($vehicle_list);
$destination = $request_obj->destination;  // ---->> YOU STOP HERE AND LINE 44. REMEMBER 1 CORINTHIANS 10:31
$name = $request_obj->name;
$travel = false;
$availability = false;
$loaded = false;
$count = 0;

function checkList($destination, $name){
  $waiting_list = file_get_contents('./queuing/' .$destination . '.json');
  $passenger_waiting = json_decode($waiting_list);

  if(sizeof($passenger_waiting) > 0){
    $count = 0;
    while($count < sizeof($passenger_waiting)){
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

function infoSaving($vehicle){
  $GLOBALS['vehicle_passenger'][$GLOBALS['count']] = $GLOBALS['name'];
  $vehicle->passengers = $vehicle->passengers + 1;
  $puv = $vehicle->vehicle;
  $route = $vehicle->route;

  checkList($GLOBALS['destination'], $GLOBALS['name']);

  $loaded_passenger = file_get_contents('./vehicles/loaded_passengers.json');
  $decoded_loaded_passenger = json_decode($loaded_passenger);
  array_push($decoded_loaded_passenger, array('vehicle' => $puv, 'name' => $GLOBALS['name']));
  $altered_loaded_passenger = json_encode($decoded_loaded_passenger);

  $loaded_passenger_list = fopen('./vehicles/loaded_passengers.json', 'w');
  $altered_passenger_list = fopen('./vehicles/' . $route . '_' . $puv . '.json', 'w');
  $altered_vehicle_list = fopen('./vehicles/queuing_vehicles.json', 'w');
  $passengers_to_json = json_encode($GLOBALS['vehicle_passenger']);
  $vehicles_to_json = json_encode($GLOBALS['vehicles']);

  fwrite($loaded_passenger_list, $altered_loaded_passenger);
  fwrite($altered_passenger_list, $passengers_to_json);
  fwrite($altered_vehicle_list, $vehicles_to_json);
  fclose($loaded_passenger_list);
  fclose($altered_passenger_list);
  fclose($altered_vehicle_list);

  return $puv;
}

foreach($vehicles as $vehicle){
  if($vehicle->route === $destination){
    $travel = true;
    if($vehicle->passengers < $vehicle->capacity){

      $dest = $vehicle->route;
      $plate = $vehicle->vehicle;
      $puv_info = $vehicle;
      $passenger_list = file_get_contents('./vehicles/loaded_passengers.json');
      $passengers =  json_decode($passenger_list);

      while($count < sizeof($passengers)){
        if($passengers[$count]->name === $name){
          $status = 'Passenger already loaded on ' . $passengers[$count]->vehicle;
          $loaded = true;
          break;
        }
        $count += 1;
      }
      $availability = true;
      break;
    }
  }
}

if(!$loaded){
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
elseif(!$travel){
  $status = 'No vehicle with that destination';
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

echo json_encode($status);
