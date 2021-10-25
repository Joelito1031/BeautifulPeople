<?php
session_start();
if(isset($_SESSION['loggedin'])){
  if(!$_SESSION['loggedin']){
    header('Location: ./');
  }
}
else{
  header('Location: ./');
}
$vehicles = json_decode(file_get_contents('./vehicles/vehicles.json'));
$data = $_POST['data'];

if(sizeof($vehicles) > 0){
  foreach($vehicles as $vehicle){
    if($vehicle->vehicle === $data){
      if($vehicle->returning){
        $vehicle->returning = false;
        echo "success-off";
      }
      else{
        $vehicle->returning = true;
        echo "success-on";
      }
      break;
    }
  }
  $file = fopen('./vehicles/vehicles.json', 'w');
  fwrite($file, json_encode($vehicles));
  fclose($file);
}
?>
