<?php
$vehicles = json_decode(file_get_contents('./vehicles/vehicles.json'));

if(sizeof($vehicles) > 0){
  foreach($vehicles as $vehicle){
    if($vehicle->vehicle === $_GET['data']){
      if($vehicle->returning){
        $vehicle->returning = false;
      }
      else{
        $vehicle->returning = true;
      }
      break;
    }
  }
  $file = fopen('./vehicles/vehicles.json', 'w');
  fwrite($file, json_encode($vehicles));
  fclose($file);
  header('Location: ./index.php?returnConfig=true');
}
?>
