<?php
session_start();
if(isset($_SESSION['reset'])){
  unset($_SESSION['reset']);
}
if(isset($_SESSION['loggedin'])){
  if($_SESSION['loggedin']){
    header('Location: ./ormocterminal');
  }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr" id="top-container">
  <head>
    <meta charset="utf-8">
    <title>Q R M O C Admin | Sign in</title>
    <link rel="stylesheet" href="./ormocterminal/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="signin_style.css" type="text/css">
    <script type="text/javascript" src="./auth_process/signin_js.js" defer></script>
    <link rel="icon" href="./auth_process/images/logoQrmoc.png">
  </head>
  <body>
    <div class="main-container">
      <div class=signin-container>
        <div class="profile-image">
          <img src="" id="profile-image">
        </div>
        <div class="uname">
          <span id="uname"></span>
        </div>
        <div class="password-container">
          <a href="javascript:;" id="icon"><i class="icon fas fa-eye"></i></a>
          <input name="pass" placeholder="password" type="password" class="cred" id="pass_word">
        </div>
        <a class="forgot-password" href='./reset'>RESET PASSWORD</a>
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
