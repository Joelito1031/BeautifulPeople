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
try{
  require './db_connection.php';
  $retrieve_registered_puv = $connection->prepare("SELECT * FROM  registered_vehicles");
  $retrieve_registered_puv->execute();
  $puvs = $retrieve_registered_puv->fetchAll();
  if($retrieve_registered_puv->rowCount() > 0){
    foreach($puvs as $puv){
      $fname = '"' . $puv['FirstName'] . '"';
      $mname = '"' . $puv['MiddleName'] . '"';
      $lname = '"' . $puv['LastName'] . '"';
      $suffix = '"' . $puv['Suffix'] . '"';
      $capacity = '"' . $puv['Capacity'] . '"';
      $route = '"' . $puv['Route'] . '"';
      $plateno = '"' . $puv['PlateNo'] . '"';
      $tel = '"' . $puv['Contact'] . '"';
      $dfname = '"' . $puv['DFirstName'] . '"';
      $dmname = '"' . $puv['DMiddleName'] . '"';
      $dlname = '"' . $puv['DLastName'] . '"';
      $dsuffix = '"' . $puv['DSuffix'] . '"';
      $dcontact = '"' . $puv['DContact'] . '"';
      $daddress = '"' . $puv['DAddress'] . '"';
      $address = '"' . $puv['Address'] . '"';
      $pic = '"' . $puv['VehicleProfile'] . '"';
      echo "<div class='container p-3 border' style='border-radius: 5px; margin-bottom: 5px; display: flex; position: relative;'>";
      if($puv['VehicleProfile'] != ""){
        echo "<div style='padding: 5px; display: inline-block;'><img style='width: 200px; height: 200px;' src='." . $puv['VehicleProfile'] . "'></div>";
      }else{
        echo "<div style='padding: 5px; border-radius: 5px; display: inline-block;'><img style='width: 200px; height: 200px;'src='../vehicle_images/vehicleImage.png'></div>";
      }
      echo "<div style='display: flex; flex-direction: column; align-items: flex-start; justify-content: space-around; padding-left: 10px;'>";
      echo "<div style='display: flex; align-items: center;'><div style='font-size: 2em; font-weight: bold;'>" . $puv['PlateNo'] . "</div>";
      echo "<div style='margin-left: 5px; font-size: 18px; background-color: #29b563; color: black; padding: 5px; border-radius: 3px;'>" . strtoupper($puv['Route']) . "</div></div>";
      echo "<div style='font-size: 13px;'>";
      echo "<span style='font-weight: bold;'>Capacity:&ensp;</span>" . $puv['Capacity'] . "<br>";
      echo "<span style='font-weight: bold;'>Operator:&ensp;</span>" . $puv['FirstName'] . " " . $puv['MiddleName'] . " " . $puv['LastName'] . " " . $puv['Suffix'] . "<br>";
      echo "<span style='font-weight: bold;'>Operator's address:&ensp;</span>" . $puv['Address'] . ", Ormoc City<br>";
      echo "<span style='font-weight: bold;'>Operator's mobile #:&ensp;</span>" . $puv['Contact'] . "<br>";
      echo "<span style='font-weight: bold;'>Driver:&ensp;</span>" . $puv['DFirstName'] . " " . $puv['DMiddleName'] . " " . $puv['DLastName'] . " " . $puv['DSuffix'] . "<br>";
      echo "<span style='font-weight: bold;'>Driver's address:&ensp;</span>" . $puv['DAddress'] . ", Ormoc City<br>";
      echo "<span style='font-weight: bold;'>Driver's mobile #:&ensp;</span>" . $puv['DContact'] . "<br>";
      echo "</div>";
      echo "</div>";
      echo "<div style='position: absolute; right: 10px; bottom: 10px;'>";
      echo "<span style='margin-right: 5px'><button type='button' data-toggle='modal' data-target='#popupEdit' style='font-size: 10px;' class='btn btn-primary' onclick='editData(" . $fname . "," . $mname . "," . $lname . "," . $suffix . "," . $capacity .
      "," . $route . "," . $plateno . "," . $tel . "," . $dfname . "," . $dmname . "," . $dlname . "," . $dsuffix . "," . $dcontact . "," . $daddress . "," . $address . "," . $pic .")'>Edit</button></span>";
      echo "<button style='font-size: 10px;' type='button' class='btn btn-danger' onclick='deletePUV(" . $plateno . ")'>Remove</button>";
      echo "</div>";
      echo "<div style='position: absolute; right: 0; top: 0; border-radius: 5px;' title='Click to download'>";
      echo "<a download href='../qrs/" . $puv['PlateNo'] . ".png'>";
      echo "<img style='width: 150px; height: 150px;' src='../qrs/" . $puv['PlateNo'] . ".png" . "'></img></a></div>";
      echo "</div>";
    }
  }else{
    echo "<div class='container p-3 my-3 border' style='border-radius: 5px; text-align: center'>No registered PUV.</div>";
  }
}catch(Exception $e){
  echo "<div class='container p-3 my-3 border' style='border-radius: 5px; text-align: center'>Something went wrong.</div>";
}
?>
