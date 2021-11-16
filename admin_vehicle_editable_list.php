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
  foreach($puvs as $puv){
    $fname = '"' . $puv['FirstName'] . '"';
    $mname = '"' . $puv['MiddleName'] . '"';
    $lname = '"' . $puv['LastName'] . '"';
    $suffix = '"' . $puv['Suffix'] . '"';
    $capacity = '"' . $puv['Capacity'] . '"';
    $route = '"' . $puv['Route'] . '"';
    echo "<div class='container p-3 my-3 border' style='border-radius: 5px'>";
    echo "<div class='p-2' style='font-size: 2em; font-weight: bold; color: #007bff;'>$puv[PlateNo]</div>";
    echo "<div class='p-2' style='font-size: 13px; font-weight: bold;'>";
    echo "<span style='font-style: italic'>Destination: </span>" . strtoupper($puv['Route']) . "<br>";
    echo "<span style='font-style: italic'>Operator: </span>" . $puv['FirstName'] . " " . $puv['MiddleName'] . " " . $puv['LastName'] . " " . $puv['Suffix'] . "<br>";
    echo "<span style='font-style: italic'>Capacity: </span>" . $puv['Capacity'] . "<br>";
    echo "<span style='font-style: italic'>Contact: </span>" . $puv['Contact'] . "<br>";
    echo "</div>";
    echo "<div class='p-2'>";
    echo "<span style='margin-right: 5px'><button type='button' data-toggle='modal' data-target='#popupEdit' style='font-size: 10px;' class='btn btn-primary' onclick='editData(" . $fname . "," . $mname . "," . $lname . "," . $suffix . "," . $capacity . "," . $route . ")'>Edit</button></span>";
    echo "<button style='font-size: 10px;' type='button' class='btn btn-danger'>Unregister</button>";
    echo "</div>";
    echo "</div>";
  }
}catch(Exception $e){
  echo "<div class='container p-3 my-3 border' style='border-radius: 5px; text-align: center'>Something went wrong.</div>";
}
?>
