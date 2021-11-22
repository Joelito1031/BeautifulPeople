<?php
session_start();
if(isset($_SESSION['loggedin'])){
  if($_SESSION['loggedin']){
    header("Location: ./ormocterminal");
  }
}else{
  if(!$_SESSION['default']){
    header("Location: ./signin");
  }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Ormoc Terminal Admin | Sign up</title>
    <link rel="stylesheet" href="./ormocterminal/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="./signup_style.css" type="text/css">
    <script type="text/javascript" src="./auth_process/signup_js.js" defer></script>
    <link rel="icon" href="./auth_process/images/logoQrmoc.png">
  </head>
  <body>
    <div class="main-container">
      <div class="signup-main-container">
        <div class="page">
          <span>Sign up</span>
        </div>
        <div class="admin-prof-container">
          <div title="Upload profile picture (Optional)">
            <img id="actual-pic" src="./auth_process/images/adminUserProfile.png">
            <div class="front-word" onclick="openFile()" title="Upload profile picture">
              <span class="fas fa-plus"></span>
            </div>
            <div class="back-element">
              <input id="profile-pic" type="file" accept="image/*">
            </div>
          </div>
        </div>
        <div>
          <input maxlength="20" placeholder="username" name="uname" type="text" class="cred" id="u_name">
        </div>
        <div class="password-container">
          <a href="javascript:;" id="icon"><i class="icon fas fa-eye"></i></a>
          <input name="pass" placeholder="password" type="password" class="cred" id="pass_word">
        </div>
        <div class="password-container">
          <a href="javascript:;" id="conf-icon"><i class="icon fas fa-eye"></i></a>
          <input name="conf" placeholder="confirm password" type="password" class="cred" id="conf_pass">
        </div>
        <span id="message"></span>
      </div>
      <div class='logo-container'>
        <img src='./auth_process/images/logoQrmoc.png' alt="J3 logo" class="qrmoc">
        <div>
          <span>Q R M O C</span>
        </div>
      </div>
        <div class="questions-main-container">
          <div class="holder">
            <h4>Security questions</h4>
            <p>In case you forget your password</p>
          </div>
          <br>
          <div class="holder">
            <div>
              <label for="q-1">What is your favorite color?</label>
            </div>
            <div>
              <input name="q_one" class="answers" type="text" id="q-1">
            </div>
          </div>
          <div class="holder">
            <div>
              <label for="q-2">What is your mother's maiden name?</label>
            </div>
            <div>
              <input name="q_two" class="answers" type="text" id="q-2">
            </div>
          </div>
          <div class="holder">
            <div>
              <label for="q-3">What elementary school did you attend?</label>
            </div>
            <div>
              <input name="q_three" class="answers" type="text" id="q-3">
            </div>
          </div>
          <div class="holder">
            <div>
              <label for="q-4">When you were young, what did you want to be when you grew up?</label>
            </div>
            <div>
              <input name="q_four" class="answers" type="text" id="q-4">
            </div>
          </div>
          <div class="holder">
            <div>
              <label for="q-5">What is the name of the town where you were born?</label>
            </div>
            <div>
              <input name="q_five" class="answers" type="text" id="q-5">
            </div>
          </div>
          <span id="mess"></span>
        </div>
    </div>
  </body>
</html>
