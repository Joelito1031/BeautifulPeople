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
$data = "";
if(isset($_POST['data'])){
  $data = $_POST['data'];
}
$vehicles = json_decode(file_get_contents('./vehicles/vehicles.json'));
echo "<table class='returning-vehicle-table'>";
echo "<tr class='rvt'>";
echo "<th>Vehicle</th>";
echo "<th>Operator</th>";
echo "<th>Route</th>";
echo "<th>Contact #</th>";
echo "<th>Returning</th>";
echo "</tr>";
if(sizeof($vehicles) > 0){
  if($data != ''){
    foreach($vehicles as $vehicle){
      if($vehicle->route == $data){
        echo "<tr>";
        echo "<td>";
        echo $vehicle->vehicle;
        echo "</td>";
        echo "<td>";
        echo $vehicle->operator;
        echo "</td>";
        echo "<td>";
        echo strtoupper($vehicle->route);
        echo "</td>";
        echo "<td>";
        echo $vehicle->contact_num;
        echo "</td>";
        echo "<td>";
        if($vehicle->returning){
          $vh = '"' . $vehicle->vehicle . '"';
          echo "<button style='box-shadow: -2px 2px 5px black; background-color: #f1c40f; height: 20px; width: 20px; border-radius: 50px; border: none; margin-bottom: 5px;' onclick='vehicleStatus(" . $vh . ")'></button>";
        }else{
          $vh = '"' . $vehicle->vehicle . '"';
          echo "<button style='box-shadow: -2px 2px 5px black; background-color: #2c3e50; height: 20px; width: 20px; border-radius: 50px; border: none; margin-bottom: 5px;' onclick='vehicleStatus(" . $vh . ")'></button>";
        }
        echo "</td>";
        echo "</tr>";
      }
    }
  }else{
    foreach($vehicles as $vehicle){
      echo "<tr>";
      echo "<td>";
      echo $vehicle->vehicle;
      echo "</td>";
      echo "<td>";
      echo $vehicle->operator;
      echo "</td>";
      echo "<td>";
      echo strtoupper($vehicle->route);
      echo "</td>";
      echo "<td>";
      echo $vehicle->contact_num;
      echo "</td>";
      echo "<td>";
      if($vehicle->returning){
        $vh = '"' . $vehicle->vehicle . '"';
        echo "<button class='duty-buttton' style='box-shadow: -2px 2px 5px black; background-color: #f1c40f; height: 20px; width: 20px; border-radius: 50px; border: none; margin-bottom: 5px;' onclick='vehicleStatus(" . $vh . ")'></button>";
      }else{
        $vh = '"' . $vehicle->vehicle . '"';
        echo "<button class='duty-buttton' style='box-shadow: -2px 2px 5px black; background-color: #2c3e50; height: 20px; width: 20px; border-radius: 50px; border: none; margin-bottom: 5px;' onclick='vehicleStatus(" . $vh . ")'></button>";
      }
      echo "</td>";
      echo "</tr>";
    }
  }
}
else{
  echo "<tr><td colspan='6'>No registered vehicles</td></tr>";
}

echo "</table>";
?>
