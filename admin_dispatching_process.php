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
require './db_connection.php';
try{
  $data = $_POST["data"];
  $select_dispatcher_query = $connection->prepare("SELECT OnDuty FROM dispatchers WHERE Name = :name");
  $select_dispatcher_query->bindParam(":name", $data);
  $select_dispatcher_query->execute();
  $result = $select_dispatcher_query->fetchColumn();
  if($result == 1){
    $update_dispatcher_query = $connection->prepare("UPDATE dispatchers SET OnDuty = FALSE WHERE Name = :name");
    $update_dispatcher_query->bindParam(":name", $data);
    $duty = "false";
  }else{
    $update_dispatcher_query = $connection->prepare("UPDATE dispatchers SET OnDuty = TRUE WHERE Name = :name");
    $update_dispatcher_query->bindParam(":name", $data);
    $duty = "true";
  }
  $update_dispatcher_query->execute();
  if($update_dispatcher_query->rowCount() > 0){
    echo $duty;
  }else{
    echo "error";
  }
}catch(Exception $e){
  echo "error";
}
$connection = null;
?>
