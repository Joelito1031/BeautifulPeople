<?php
$data = json_decode(file_get_contents('php://input'));
if($data->mode == 'queuing'){
  $count = 0;
  $queuing_vehicles = json_decode(file_get_contents('../vehicles/queuing_vehicles.json'));
  foreach($queuing_vehicles as $vehicle){
    if($vehicle->route == $data->data){
      $count = $count + 1;
    }
  }
  echo json_encode($count);
}elseif($data->mode == 'returning'){
  $count = 0;
  $returning_vehicles = json_decode(file_get_contents('../vehicles/vehicles.json'));
  foreach($returning_vehicles as $vehicle){
    if($vehicle->route == $data->data && $vehicle->returning){
      $count = $count + 1;
    }
  }
  echo json_encode($count);
}else{
  echo json_encode('error');
}
?>
