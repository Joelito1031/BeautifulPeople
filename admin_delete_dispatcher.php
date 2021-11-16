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
$id = $_POST['data'];
try{
  $select_file_directory = $connection->prepare("SELECT Profile FROM dispatchers WHERE ID = :id");
  $select_file_directory->bindParam(":id", $id);
  $select_file_directory->execute();
  $directory = $select_file_directory->fetchColumn();
  if($directory != ''){
    if(unlink($directory)){
      $delete_dispatcher = $connection->prepare("DELETE FROM dispatchers WHERE ID = :id");
      $delete_dispatcher->bindParam(':id', $id);
      $delete_dispatcher->execute();
    }else{
      echo "error";
    }
  }else{
    $delete_dispatcher = $connection->prepare("DELETE FROM dispatchers WHERE ID = :id");
    $delete_dispatcher->bindParam(':id', $id);
    $delete_dispatcher->execute();
  }
  $connection = null;
  echo "success";
}catch(Exception $e){
  echo "error";
}
?>
