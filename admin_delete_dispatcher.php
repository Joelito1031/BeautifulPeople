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
  $select_file_directory = $connection->prepare("SELECT Profile, OnDuty FROM dispatchers WHERE ID = :id");
  $select_file_directory->bindParam(":id", $id);
  $select_file_directory->execute();
  $data = $select_file_directory->fetchAll();
  if($data[0]['OnDuty'] == 0){
    if($data[0]['Profile'] != ''){
      if(file_exists($data[0]['Profile'])){
        if(unlink($data[0]['Profile'])){
          $delete_dispatcher = $connection->prepare("DELETE FROM dispatchers WHERE ID = :id");
          $delete_dispatcher->bindParam(':id', $id);
          $delete_dispatcher->execute();
          echo "success";
        }else{
          echo "error";
        }
      }else{
        echo "error";
      }
    }else{
      $delete_dispatcher = $connection->prepare("DELETE FROM dispatchers WHERE ID = :id");
      $delete_dispatcher->bindParam(':id', $id);
      $delete_dispatcher->execute();
      echo "success";
    }
    $connection = null;
  }else{
    echo "notallowed";
  }
}catch(Exception $e){
  echo "error";
}
?>
