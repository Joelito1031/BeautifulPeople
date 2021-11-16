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
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Q R M O C Admin | Sign in</title>
    <link rel="stylesheet" href="signin_style.css" type="text/css">
    <script type="text/javascript" src="./auth_process/signin_js.js" defer></script>
  </head>
  <body>
    <div class="main-container">
        <div class="signin-main-container">
          <div class="signin-sub-container">
            <div class=signin-container>
                <div>
                  <label for="u_name">Username</label>
                </div>
                <div>
                  <input name="uname" type="text" class="cred" id="u_name" tabindex="1">
                </div>
                <div>
                  <label for="pass_word">Password</label>
                  <a href="./reset">Forgot Password?</a>
                </div>
                <div>
                  <input name="pass" type="password" class="cred" id="pass_word" tabindex="2">
                  <button onclick="showPassSignIn()" tabindex="-1"><img src="./images/show.png"></button>
                </div>
                <input class="submit-button" id="admin-signin" type="button" value="Sign in" onclick="signin()" tabindex="3">
            </div>
            <div id="signin-info" class='info'>
              <div class='info-sub-cont'>
                <div id='info-message'>
                </div>
                <div class="close-btn-cont">
                  <button class="close-btn" type="button" onclick="closeInfo()">
                    <img src='./images/xbox.png'>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
  </body>
</html>