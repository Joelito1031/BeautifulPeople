<?php

$request = file_get_contents('php://input');
$request_obj = json_decode($request);

$vehicle_list = file_get_contents('./vehicles/vehicles.json');
$vehicles = json_decode($vehicle_list);
$destination = $request_obj->destination;  // ---->> YOU STOP HERE AND LINE 44. REMEMBER 1 CORINTHIANS 10:31
$availability = false;
$status = "Vehicle not available.";
$puv = "";


foreach ($vehicles as $vehicle){
  if($vehicle->route == $destination){
    if($vehicle->queuing){
      if($vehicle->passengers < $vehicle->capacity){
          $vehicle->passengers = $vehicle->passengers + 1;
          $availability = true;
          $puv = $vehicle->vehicle;
          $route = $vehicle->route;
          break;
      }
      else{
        $status = "Vehicle is full.";
        continue;
      }
    }
  }
}

if($availability){
 $vehicles_to_json = json_encode($vehicles);
 $altered_vehicle_list = fopen('./vehicles/vehicles.json', 'w');

 fwrite($altered_vehicle_list, $vehicles_to_json);
 fclose($altered_vehicle_list);

 $passenger_list = file_get_contents('./vehicles/' . $route . '_' . $puv . '.json');
 $passengers =  json_decode($passenger_list, true);
 $count = 0;

 while($count <= sizeof($passengers)){
   if($passengers[$count] == ""){
     $passengers[$count] = $request_obj->name;
     break;
   }
   $count = $count + 1;
 }

 $passengers_to_json = json_encode($passengers);
 $altered_passenger_list = fopen('./vehicles/' . $route . '_' . $puv . '.json', 'w');

 fwrite($altered_passenger_list, $passengers_to_json);
 fclose($altered_passenger_list);
 echo json_encode($puv);
}
else{
 echo json_encode($status);
}