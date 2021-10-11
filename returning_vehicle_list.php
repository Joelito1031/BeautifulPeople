<?php
$vehicles = json_decode(file_get_contents('./vehicles/vehicles.json'));
foreach($vehicles as $vehicle){
  echo "<tr>";
  echo "<td>";
  echo $vehicle->vehicle;
  echo "</td>";
  echo "<td>";
  echo $vehicle->operator;
  echo "</td>";
  echo "<td>";
  echo $vehicle->route;
  echo "</td>";
  echo "<td>";
  echo $vehicle->contact_num;
  echo "</td>";
  echo "<td>";
  if($vehicle->returning){
    $vh = '"' . $vehicle->vehicle . '"';
    echo "<button class='duty-buttton' style='background-color: #f1c40f; height: 20px; width: 20px; border-radius: 50px; border: none; margin-bottom: 5px;' onclick='vehicleStatus(" . $vh . ")'></button>";
  }else{
    $vh = '"' . $vehicle->vehicle . '"';
    echo "<button class='duty-buttton' style='background-color: #2c3e50; height: 20px; width: 20px; border-radius: 50px; border: none; margin-bottom: 5px;' onclick='vehicleStatus(" . $vh . ")'></button>";
  }
  echo "</td>";
  echo "</tr>";
}
?>
