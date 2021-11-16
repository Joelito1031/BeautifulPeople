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
    <title>Ormoc Terminal Admin | Password Reset</title>
    <link rel="stylesheet" href="./passwordreset_style.css" type="text/css">
    <script type="text/javascript" src="./auth_process/passwordreset_js.js" defer></script>
  </head>
  <body>
    <div class="main-container">
        <div class="reset-main-container">
          <div class="reset-sub-container">
            <div class=reset-container>
                <div>
                  <label for="pass_word">Password</label>
                </div>
                <div>
                  <input name="pass" type="password" class="cred" id="pass_word">
                  <button onclick="showPassReset()"><img src="./images/show.png"></button>
                </div>
                <div>
                  <label for="conf-pass">Confirm Password</label>
                </div>
                <div>
                  <input name="conf" type="password" class="cred" id="conf_pass">
                  <button onclick="showPassConfReset()"><img src="./images/show.png"></button>
                </div>
                <input class="submit-button" value="Change Password" type="button" onclick="changePassword()">
            </div>
            <div id="reset-info" class='info'>
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