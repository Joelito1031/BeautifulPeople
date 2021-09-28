<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "ocqms";

try{
  $connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
  $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $data = $_GET['data'];

  $select_query = $connection->prepare("SELECT OnDuty FROM dispatchers WHERE Name = '$data'");
  $select_query->execute();
  $result = $select_query->fetch(PDO::FETCH_ASSOC);

  if($result){
    if($result['OnDuty'] == 1){
      $update_query = $connection->prepare("UPDATE dispatchers SET OnDuty = FALSE WHERE Name = '$data'");
      $duty  = "false";
    }
    else{
      $update_query = $connection->prepare("UPDATE dispatchers SET OnDuty = TRUE WHERE Name = '$data'");
      $duty = "true";
    }

    $update_query->execute();

    if($update_query->rowCount() > 0){
      header("Location: ./index.php?dispatchconfig=true&name=" . $data . "&duty=" . $duty);
    }
  }
  else{
    header("Location: ./index.php?dispatchconfig=false");
  }
}catch(PDOException $e){
  echo "Something went wrong";
}

$connection = null;

?>
