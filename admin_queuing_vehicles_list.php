<?php
  $queuing_vehicles = json_decode(file_get_contents('./vehicles/queuing_vehicles.json'));
  if(sizeof($queuing_vehicles) > 0){
    foreach($queuing_vehicles as $vehicle){
      $puv = '"' . $vehicle->vehicle . '"';
      echo "<div class='queuing-vehicle-container'>";
      echo "<div>" . $vehicle->vehicle .   "</div>";
      echo "<div>" . strtoupper($vehicle->route) . "</div>";
      echo "<div>" . $vehicle->passengers . "/" . $vehicle->capacity . "</div>";
      echo "<div>";
      echo "<button type='button' onclick='unqueueConfirmation(" . $puv . ")'><img src='./images/admin_unqueue.png'></button>";
      echo "</div></div>";
    }
  }
  else {
    echo "<div>";
    echo "<div style='width: 100%; height: 100% position: relative'>";
    echo "<span style='position: absolute; top: 30%; left: 50%; transform: translate(-50%, -30%)'>No queuing vehicles</span>";
    echo "</div>";
    echo "</div>";
  }
?>
