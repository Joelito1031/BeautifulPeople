<?php
  session_start();
  if(isset($_POST['uname']) && isset($_POST['pass'])){
    if(!empty(trim($_POST['uname'])) && !empty(trim($_POST['pass']))){
      require '../db_connection.php';
      $verify_admin = $connection->prepare("SELECT COUNT(*) FROM admin WHERE Uname= :username AND Password= :password");
      if(trim($_POST['uname']) === 'admin' && $_POST['pass'] === 'admin'){
        $username = sha1(trim($_POST['uname']));
        $password = sha1($_POST['pass']);
        $verify_admin->bindParam(':username', $username);
        $verify_admin->bindParam(':password', $password);
        $verify_admin->execute();
        $still_admin = $verify_admin->fetchColumn();
        if($still_admin > 0){
          $connection = null;
          echo "default";
        }
        else{
          $connection = null;
          echo "notfound";
        }
      }
      else{
        $username = sha1(trim($_POST['uname']));
        $password = sha1($_POST['pass']);
        $verify_admin->bindParam(':username', $username);
        $verify_admin->bindParam(':password', $password);
        $verify_admin->execute();
        $verified_admin = $verify_admin->fetchColumn();
        if($verified_admin > 0){
          $connection = null;
          $_SESSION['loggedin'] = true;
          echo 'login';
        }
        else{
          $connection = null;
          echo "notfound";
        }
      }
    }
  }
?>
