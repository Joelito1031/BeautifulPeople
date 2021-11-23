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
if(isset($_POST['pass'])){
  if(!empty(trim($_POST['pass']))){
    try{
      require './db_connection.php';
      $password = sha1($_POST['pass']);
      $check_password = $connection->prepare("SELECT * FROM admin WHERE Password = :password");
      $check_password->bindParam(":password", $password);
      $check_password->execute();
      if($check_password->fetchColumn() > 0){
        $_SESSION['authentication'] = true;
        echo "success";
      }else{
        echo "fail";
      }
    }catch(Exception $e){
      echo "error";
    }
  }else{
    echo "error";
  }
}
?>
