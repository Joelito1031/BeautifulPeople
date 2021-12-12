<?php
session_start();
if(isset($_SESSION['loggedin'])){
  if(!$_SESSION['loggedin']){
    echo "data is restricted";
  }else{
    require '../db_connection.php';
    try{
     $retrieve_puv_list = $connection->prepare("SELECT * FROM registered_vehicles");
     $retrieve_puv_list->execute();
     $result = $retrieve_puv_list->rowCount();
     if($result > 0){
       echo "<h3>" . $result . "</h3>";
     }else{
       echo "<h3>0</h3>";
     }
    }catch(Exception $e){
      echo "<h3>error</h3>";
    }
  }
}else{
  echo "<h3>data is restricted</h3>";
}
?>
