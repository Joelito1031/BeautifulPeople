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
require 'db_connection.php';
$dispatcher_name = $_POST['data'];
try{
  $delete_dispatcher = $connection->prepare("DELETE FROM dispatchers WHERE Name = :dispatcher");
  $delete_dispatcher->bindParam(':dispatcher', $dispatcher_name);
  $delete_dispatcher->execute();
  $connection = null;
  echo "success";
}catch(Exception $e){
  echo "error";
}
?>
