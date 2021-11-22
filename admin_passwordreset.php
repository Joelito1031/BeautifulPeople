<?php
session_start();
if(isset($_SESSION['loggedin'])){
  if($_SESSION['loggedin']){
    header('Location: ./ormocterminal');
  }
}else{
  if(isset($_SESSION['reset'])){
    if($_SESSION['reset']){
      require "./auth_process/auth_reset_check.php";
    }else{
      header("Location: ./reset");
    }
  }else{
    header("Location: ./reset");
  }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Q R M O C Terminal Admin | Password Reset</title>
    <link rel="stylesheet" href="./passwordreset_style.css" type="text/css">
    <link rel="stylesheet" href="./ormocterminal/plugins/fontawesome-free/css/all.min.css">
    <script type="text/javascript" src="./auth_process/passwordreset_js.js" defer></script>
    <link rel="icon" href="./auth_process/images/logoQrmoc.png">
  </head>
  <body>
    <div class="main-container">
      <div class="reset-main-container">
        <div class="page">
          <span>Reset Password</span>
        </div>
        <div class="password-container">
          <a href="javascript:;" id="icon"><i class="icon fas fa-eye"></i></a>
          <input tabindex="1" name="pass" placeholder="password" type="password" class="cred" id="pass_word">
        </div>
        <div class="password-container">
          <a href="javascript:;" id="conf-icon"><i class="icon fas fa-eye"></i></a>
          <input tabindex="2" name="conf" placeholder="confirm password" type="password" class="cred" id="conf_pass">
        </div>
        <div class="validate-holder-cred">
          <button tabindex="3" class="validate-cred" onclick="changePassword()">Reset</button>
        </div>
        <span id="message"></span>
      </div>
      <div class='logo-container'>
        <img src='./auth_process/images/logoQrmoc.png' alt="J3 logo" class="qrmoc">
        <div>
          <span>Q R M O C</span>
        </div>
      </div>
    </div>
  </body>
</html>
