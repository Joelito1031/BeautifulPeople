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
  echo "<th>Operator</th>";
  echo "<th>Driver</th>";
  echo "<th>Route</th>";
  echo "<th>Passengers</th>";
  echo "<th>Dequeue</th>";
  echo "</tr>";
  if(sizeof($queuing_vehicles) > 0){
    if($data != ''){
      $seen = false;
      foreach($queuing_vehicles as $vehicle){
        if($vehicle->route == $data || $vehicle->vehicle == $data){
          $seen = true;
          $puv = '"' . $vehicle->vehicle . '"';
          if($vehicle->passengers == $vehicle->capacity){
            echo "<tr style='background-color: #CD6155; border-top: 1px solid #808B96; color: white'>";
            echo "<td>" . $vehicle->vehicle .   "</td>";
            echo "<td>" . $vehicle->operator . "</td>";
            echo "<td>" . $vehicle->driver . "</td>";
            echo "<td>" . strtoupper($vehicle->route) . "</td>";
            echo "<td>" . $vehicle->passengers . "/" . $vehicle->capacity . "</td>";
            echo "<td><button class='fas fa-sign-out-alt' type='button' style='background-color: #F4D03F; width: 30px; height: 20px; padding: 0; border: none; border-radius: 3px; margin-top: 3px;' onclick='unqueueVehicle(" . $puv . ")'></button></td>";
            echo "</tr>";
          }else{
            echo "<tr style='background-color: #2ECC71; border-top: 1px solid #808B96; color: white'>";
            echo "<td>" . $vehicle->vehicle .   "</td>";
            echo "<td>" . $vehicle->operator . "</td>";
            echo "<td>" . $vehicle->driver . "</td>";
            echo "<td>" . strtoupper($vehicle->route) . "</td>";
            echo "<td>" . $vehicle->passengers . "/" . $vehicle->capacity . "</td>";
            echo "<td><button class='fas fa-sign-out-alt' type='button' style='background-color: #F4D03F; width: 30px; height: 20px; padding: 0; border: none; border-radius: 3px; margin-top: 3px;' onclick='unqueueVehicle(" . $puv . ")'></button></td>";
            echo "</tr>";
          }
          break;
        }
      }
      if($seen == false){

      }
    }
    else{
      foreach($queuing_vehicles as $vehicle){
        $puv = '"' . $vehicle->vehicle . '"';
        if($vehicle->passengers == $vehicle->capacity){
          echo "<tr style='background-color: #CD6155; border-top: 1px solid #808B96; color: white'>";
          echo "<td>" . $vehicle->vehicle .   "</td>";
          echo "<td>" . $vehicle->operator . "</td>";
          echo "<td>" . $vehicle->driver . "</td>";
          echo "<td>" . strtoupper($vehicle->route) . "</td>";
          echo "<td>" . $vehicle->passengers . "/" . $vehicle->capacity . "</td>";
          echo "<td><button class='fas fa-sign-out-alt' type='button' style='background-color: #F4D03F; width: 30px; height: 20px; padding: 0; border: none; border-radius: 3px; margin-top: 3px;' onclick='unqueueVehicle(" . $puv . ")'></button></td>";
          echo "</tr>";
        }else{
          echo "<tr style='background-color: #2ECC71; border-top: 1px solid #808B96; color: white'>";
          echo "<td>" . $vehicle->vehicle .   "</td>";
          echo "<td>" . $vehicle->operator . "</td>";
          echo "<td>" . $vehicle->driver . "</td>";
          echo "<td>" . strtoupper($vehicle->route) . "</td>";
          echo "<td>" . $vehicle->passengers . "/" . $vehicle->capacity . "</td>";
          echo "<td><button class='fas fa-sign-out-alt' type='button' style='background-color: #F4D03F; width: 30px; height: 20px; padding: 0; border: none; border-radius: 3px; margin-top: 3px;' onclick='unqueueVehicle(" . $puv . ")'></button></td>";
          echo "</tr>";
        }
      }
    }
  }
  else{
    echo "<tr><td colspan='6'>No queuing vehicles</td></tr>";
  }
  echo "</table>";
?>
