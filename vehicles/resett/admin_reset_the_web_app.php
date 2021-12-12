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
    try{
      require '../db_connection.php';
      $password = sha1('admin');
      $reset = $connection->prepare("UPDATE admin SET Uname = 'admin', Password = '$password', Profile = 'images/adminUserProfile.png'");
      $reset->execute();
      if($reset->rowCount() > 0){
        echo "success";
      }else{
        echo "fail";
      }
    }catch(Exception $e){
      echo "error";
    }
  }else{
    echo "notauthorized";
  }
}else{
  echo "notauthorized";
}
?>
