<?php
session_start();
if(isset($_SESSION['loggedin'])){
  if(!$_SESSION['loggedin']){
    echo "data is restricted";
  }else{
    try{
      require '../db_connection.php';
      $retrieve_dispatcher_list = $connection->prepare("SELECT * FROM dispatchers WHERE OnDuty = '1'");
      $retrieve_dispatcher_list->execute();
      $result = $retrieve_dispatcher_list->rowCount();
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
