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
if(isset($_SESSION['authentication'])){
  if($_SESSION['authentication']){
    if(isset($_POST['uname']) && !empty(trim($_POST['uname']))){
      if($_POST['unset'] == "true"){
        unset($_SESSION['authentication']);
      }
      try{
        require "./db_connection.php";
        $update_username = $connection->prepare("UPDATE admin SET Uname = :uname");
        $update_username->bindParam(":uname", $_POST['uname']);
        $update_username->execute();
        if($update_username->rowCount() > 0){
          echo "success";
        }else{
          echo "nochanges";
        }
      }catch(Exception $e){
        echo "error";
      }
    }
  }else{
    echo "notauthorized";
  }
}else{
  echo "notauthorized";
}
?>
