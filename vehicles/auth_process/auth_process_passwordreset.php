<?php
session_start();
if(isset($_SESSION['reset'])){
  if($_SESSION['reset']){
    if(trim($_POST['password']) == ''){
      echo 'error';
    }else{
      require '../db_connection.php';
      try{
        $password = sha1($_POST['password']);
        $change_password = $connection->prepare("UPDATE admin SET Password = :password WHERE AdminId = 1");
        $change_password->bindParam(':password', $password);
        $change_password->execute();
        if($change_password->rowCount() > 0){
          unset($_SESSION['reset']);
          echo 'success';
        }else{
          echo 'fail';
        }
        $connection = null;
      }catch(Exception $e){
        $connection = null;
        echo "error";
      }
    }
  }else{
    echo "restricted";
  }
}else{
  echo "restricted";
}
?>
