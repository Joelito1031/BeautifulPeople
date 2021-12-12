<?php
session_start();
if(trim($_POST['qone']) == '' || trim($_POST['qtwo']) == '' || trim($_POST['qthree']) == '' || trim($_POST['qfour']) == '' || trim($_POST['qfive']) == ''){
  echo "error";
}else{
  require '../db_connection.php';
  $default_username = sha1('admin');
  $default_password = sha1('admin');
  try{
    $verify_admin = $connection->prepare("SELECT COUNT(*) FROM admin WHERE Uname = :username AND Password = :password");
    $verify_admin->bindParam(':username', $default_username);
    $verify_admin->bindParam(':password', $default_password);
    $verify_admin->execute();
    $still_admin = $verify_admin->fetchColumn();
    if($still_admin > 0){
      $connection = null;
      echo 'notset';
    }else{
      $qone = sha1(strtolower(preg_replace('/\s+/', '', $_POST['qone'])));
      $qtwo = sha1(strtolower(preg_replace('/\s+/', '', $_POST['qtwo'])));
      $qthree = sha1(strtolower(preg_replace('/\s+/', '', $_POST['qthree'])));
      $qfour = sha1(strtolower(preg_replace('/\s+/', '', $_POST['qfour'])));
      $qfive = sha1(strtolower(preg_replace('/\s+/', '', $_POST['qfive'])));
      $one = false;
      $two = false;
      $three = false;
      $four = false;
      $five = false;
      $one_value = 1;
      $two_value = 2;
      $three_value = 3;
      $four_value = 4;
      $five_value = 5;
      $compare_answer = $connection->prepare("SELECT Answer FROM questions WHERE Answer = :answer AND QuestionId = :questionid");
      $compare_answer->bindParam(':answer', $qone);
      $compare_answer->bindParam(':questionid', $one_value);
      $compare_answer->execute();
      if($compare_answer->rowCount() > 0){
        $one = true;
      }
      $compare_answer->bindParam(':answer', $qtwo);
      $compare_answer->bindParam(':questionid', $two_value);
      $compare_answer->execute();
      if($compare_answer->rowCount() > 0){
        $two = true;
      }
      $compare_answer->bindParam(':answer', $qthree);
      $compare_answer->bindParam(':questionid', $three_value);
      $compare_answer->execute();
      if($compare_answer->rowCount() > 0){
        $three = true;
      }
      $compare_answer->bindParam(':answer', $qfour);
      $compare_answer->bindParam(':questionid', $four_value);
      $compare_answer->execute();
      if($compare_answer->rowCount() > 0){
        $four = true;
      }
      $compare_answer->bindParam(':answer', $qfive);
      $compare_answer->bindParam(':questionid', $five_value);
      $compare_answer->execute();
      if($compare_answer->rowCount() > 0){
        $five = true;
      }

      if($one && $two && $three && $four && $five){
        $_SESSION['reset'] = true;
        echo "success";
      }else{
        $_SESSION['reset'] = false;
        echo "fail";
      }
    }
    $connection = null;
  }catch(Exception $e){
    $connection = null;
    echo "error";
  }
}

?>
