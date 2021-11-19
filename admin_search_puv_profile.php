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
try{
  $data = "";
  if(isset($_POST['data'])){
    $data = $_POST['data'];
  }
  require './db_connection.php';
  $plateno = "%" . $_POST['search'] . "%";
  $retrieve_registered_puv = $connection->prepare("SELECT * FROM registered_vehicles WHERE PlateNo LIKE :plateno");
  $retrieve_registered_puv->bindParam(":plateno", $plateno);
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
      echo "<div class='container p-3 my-3 border' style='border-radius: 5px'>";
      echo "<div style='font-size: 2em; font-weight: bold; color: #007bff;'>$puv[PlateNo]</div>";
      echo "<div style='font-size: 13px; font-weight: bold;'>";
      echo "<span style='font-style: italic'>Destination: </span>" . strtoupper($puv['Route']) . "<br>";
      echo "<span style='font-style: italic'>Operator: </span>" . $puv['FirstName'] . " " . $puv['MiddleName'] . " " . $puv['LastName'] . " " . $puv['Suffix'] . "<br>";
      echo "<span style='font-style: italic'>Capacity: </span>" . $puv['Capacity'] . "<br>";
      echo "<span style='font-style: italic'>Mobile #: </span>" . $puv['Contact'] . "<br>";
      echo "</div>";
      echo "<div style='padding-top: 4px;'>";
      echo "<span style='margin-right: 5px'><button type='button' data-toggle='modal' data-target='#popupEdit' style='font-size: 10px;' class='btn btn-primary' onclick='editData(" . $fname . "," . $mname . "," . $lname . "," . $suffix . "," . $capacity . "," . $route . "," . $plateno . "," . $tel . ")'>Edit</button></span>";
      echo "<button style='font-size: 10px;' type='button' class='btn btn-danger' onclick='deletePUV(" . $plateno . ")'>Remove</button>";
      echo "</div>";
      echo "</div>";
    }
  }else{
    echo "<div class='container p-3 my-3 border' style='text-align: center'>Nothing was found in your search.</div>";
  }
}catch(Exception $e){
  echo "<div class='container p-3 my-3 border' style='text-align: center'>Something went wrong</div>";
}
?>
