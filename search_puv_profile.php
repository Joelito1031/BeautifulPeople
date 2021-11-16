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
require './db_connection.php';
$plateno = $_POST['search'];
$retrieve_registered_puv = $connection->prepare("SELECT * FROM  registered_vehicles WHERE PlateNo = :plateno");
$retrieve_registered_puv->bindParam(":plateno", $plateno);
$retrieve_registered_puv->execute();
$puvs = $retrieve_registered_puv->fetchAll();
foreach($puvs as $puv){
  echo "<div class='container p-3 my-3 border' style='border-radius: 5px'>";
  echo "<div class='p-2' style='font-size: 2em; font-weight: bold; color: #007bff;'>$puv[PlateNo]</div>";
  echo "<div class='p-2' style='font-size: 13px; font-weight: bold;'>";
  echo "<span style='font-style: italic'>Destination: </span>" . strtoupper($puv['Route']) . "<br>";
  echo "<span style='font-style: italic'>Operator: </span>" . $puv['FirstName'] . " " . $puv['MiddleName'] . " " . $puv['LastName'] . " " . $puv['Suffix'] . "<br>";
  echo "<span style='font-style: italic'>Capacity: </span>" . $puv['Capacity'] . "<br>";
  echo "<span style='font-style: italic'>Contact: </span>" . $puv['Contact'] . "<br>";
  echo "</div>";
  echo "<div class='p-2'>";
  echo "<span style='margin-right: 5px'><button type='button' data-toggle='modal' data-target='#popupEdit' style='font-size: 10px;' class='btn btn-primary'>Edit</button></span>";
  echo "<button style='font-size: 10px;' type='button' class='btn btn-danger'>Remove</button>";
  echo "</div>";
  echo "</div>";
}
?>
