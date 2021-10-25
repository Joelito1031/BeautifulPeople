<?php
session_start();
$_SESSION['reset'] = false;
if(trim($_POST['qone']) == '' || trim($_POST['qtwo']) == '' || trim($_POST['qthree']) == '' || trim($_POST['qfour']) == '' || trim($_POST['qfive']) == ''){
  echo "error";
}else{
  require '../db_connection.php';
  $default_username = sha1('admin');
  $default_password = sha1('admin');
  $verify_admin = $connection->prepare("SELECT COUNT(*) FROM admin WHERE Uname = :username AND Password = :password");
  $verify_admin->bindParam(':username', $default_username);
  $verify_admin->bindParam(':password', $default_password);
  $verify_admin->execute();
  $still_admin = $verify_admin->fetchColumn();
  if($still_admin > 0){
    $connection = null;
    echo 'notset';
  }else{
    $qone = sha1(strtolower($_POST['qone']));
    $qtwo = sha1(strtolower($_POST['qtwo']));
    $qthree = sha1(strtolower($_POST['qthree']));
    $qfour = sha1(strtolower($_POST['qfour']));
    $qfive = sha1(strtolower($_POST['qfive']));
    $one = false;
    $two = false;
    $three = false;
    $four = false;
    $five = false;
    $compare_answer = $connection->prepare("SELECT Answer FROM questions WHERE Answer = :answer");
    $compare_answer->bindParam(':answer', $qone);
    $compare_answer->execute();
    if($compare_answer->rowCount() > 0){
      $one = true;
    }
    $compare_answer->bindParam(':answer', $qtwo);
    $compare_answer->execute();
    if($compare_answer->rowCount() > 0){
      $two = true;
    }
    $compare_answer->bindParam(':answer', $qthree);
    $compare_answer->execute();
    if($compare_answer->rowCount() > 0){
      $three = true;
    }
    $compare_answer->bindParam(':answer', $qfour);
    $compare_answer->execute();
    if($compare_answer->rowCount() > 0){
      $four = true;
    }
    $compare_answer->bindParam(':answer', $qfive);
    $compare_answer->execute();
    if($compare_answer->rowCount() > 0){
      $five = true;
    }

    if($one && $two && $three && $four && $five){
      $_SESSION['reset'] = true;
      echo "success";
    }else{
      echo "fail";
    }
    $connection = null;
  }
}

?>
