<?php

$request = file_get_contents('php://input');
$request_obj = json_decode($request);
$vehicle_list = file_get_contents('./vehicles/vehicles.json');
$vehicles = json_decode($vehicle_list);
$destination = $request_obj->destination;  // ---->> YOU STOP HERE AND LINE 44. REMEMBER 1 CORINTHIANS 10:31
$name = $request_obj->name;
$travel = false;
$availability = false;
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

function infoSaving($passengers, $vehicle, $vehicles, $name, $count, $destination){
  $passengers[$count] = $name;
  $vehicle->passengers = $vehicle->passengers + 1;
  $puv = $vehicle->vehicle;
  $route = $vehicle->route;

  checkList($destination, $name);

  $passengers_to_json = json_encode($passengers);
  $altered_passenger_list = fopen('./vehicles/' . $route . '_' . $puv . '.json', 'w');
  $altered_vehicle_list = fopen('./vehicles/vehicles.json', 'w');
  $vehicles_to_json = json_encode($vehicles);

  fwrite($altered_passenger_list, $passengers_to_json);
  fwrite($altered_vehicle_list, $vehicles_to_json);
  fclose($altered_passenger_list);
  fclose($altered_vehicle_list);

  return $puv;
}

foreach($vehicles as $vehicle){
  if($vehicle->route === $destination){
    $travel = true;
    if($vehicle->queuing === true){
      if($vehicle->passengers < $vehicle->capacity){

        $passenger_list = file_get_contents('./vehicles/' . $vehicle->route . '_' . $vehicle->vehicle . '.json');
        $passengers =  json_decode($passenger_list);

        while($count < sizeof($passengers)){
          if($passengers[$count] === $name){
            $status = 'Passenger already loaded';
            break;
          }
          elseif($passengers[$count] === ""){
            $status = infoSaving($passengers, $vehicle, $vehicles, $name, $count, $destination);
            break;
          }
          $count += 1;
        }
        $availability = true;
        break;
      }
    }
  }
}

if(!$travel){
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
