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
  $data = '';
  if(isset($_POST['data'])){
    $data = $_POST['data'];
  }
  $queuing_vehicles = json_decode(file_get_contents('./vehicles/queuing_vehicles.json'));
  echo "<table class='queuing-vehicle-table'>";
  echo "<tr class='rvt'>";
  echo "<th>Vehicle</th>";
  echo "<th>Route</th>";
  echo "<th>Passengers</th>";
  echo "<th>Unqueue</th>";
  echo "</tr>";
  if(sizeof($queuing_vehicles) > 0){
    if($data != ''){
      foreach($queuing_vehicles as $vehicle){
        if($vehicle->route == $data){
          $puv = '"' . $vehicle->vehicle . '"';
          echo "<tr>";
          echo "<td>" . $vehicle->vehicle .   "</td>";
          echo "<td>" . strtoupper($vehicle->route) . "</td>";
          echo "<td>" . $vehicle->passengers . "/" . $vehicle->capacity . "</td>";
          echo "<td><button type='button' style='width: 20px; height: 20px; padding: 0; border: none; border-radius: 50px; margin-top: 3px;' onclick='unqueueVehicle(" . $puv . ")'><img style='width: 20px; height; 20px' src='./images/xbox.png'></button></td>";
          echo "</tr>";
        }
      }
    }
    else{
      foreach($queuing_vehicles as $vehicle){
        $puv = '"' . $vehicle->vehicle . '"';
        echo "<tr>";
        echo "<td>" . $vehicle->vehicle .   "</td>";
        echo "<td>" . strtoupper($vehicle->route) . "</td>";
        echo "<td>" . $vehicle->passengers . "/" . $vehicle->capacity . "</td>";
        echo "<td><button type='button' style='width: 20px; height: 20px; padding: 0; border: none; border-radius: 50px; margin-top: 3px;' onclick='unqueueVehicle(" . $puv . ")'><img style='width: 20px; height; 20px' src='./images/xbox.png'></button></td>";
        echo "</tr>";
      }
    }
  }
  else{
    echo "<tr><td colspan='4'>No queuing vehicles</td></tr>";
  }
  echo "</table>";
?>
