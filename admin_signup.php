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
    <link rel="stylesheet" href="./signup_style.css" type="text/css">
    <script type="text/javascript" src="./auth_process/signup_js.js" defer></script>
  </head>
  <body>
    <div class="main-container">
        <div class="signup-main-container">
          <div class="signup-sub-container">
            <div class=signup-container>
                <div>
                  <label for="u_name">Username</label>
                </div>
                <div>
                  <input maxlength="20" name="uname" type="text" class="cred" id="u_name">
                </div>
                <div>
                  <label for="pass_word">Password</label>
                </div>
                <div>
                  <input name="pass" type="password" class="cred" id="pass_word">
                  <button onclick="showPassSignUp()"><img src="./images/show.png"></button>
                </div>
                <div>
                  <label for="conf-pass">Confirm Password</label>
                </div>
                <div>
                  <input name="conf" type="password" class="cred" id="conf_pass">
                  <button onclick="showPassConfSignUp()"><img src="./images/show.png"></button>
                </div>
                <input class="submit-button" value="Next" type="button" onclick="next()">
            </div>
            <div id="signup-info" class='info'>
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
        <div class="questions-main-container">
          <div class="questions-sub-container">
            <div class="questions-container">
              <div>
                <h4>Security questions</h4>
                <p>In case you forget your password</p>
              </div>
              <div>
                <label for="q-1">What is your favorite color?</label>
              </div>
              <div>
                <input name="q_one" class="answers" type="text" id="q-1">
              </div>
              <div>
                <label for="q-2">What is your mother's maiden name?</label>
              </div>
              <div>
                <input name="q_two" class="answers" type="text" id="q-2">
              </div>
              <div>
                <label for="q-3">What elementary school did you attend?</label>
              </div>
              <div>
                <input name="q_three" class="answers" type="text" id="q-3">
              </div>
              <div>
                <label for="q-4">When you were young, what did you want to be when you grew up?</label>
              </div>
              <div>
                <input name="q_four" class="answers" type="text" id="q-4">
              </div>
              <div>
                <label for="q-5">What is the name of the town where you were born?</label>
              </div>
              <div>
                <input name="q_five" class="answers" type="text" id="q-5">
              </div>
              <input class="submit-button" id="admin-signup" type="button" value="Sign up" onclick="signup()">
            </div>
            <div id="signup-question-info" class='info'>
              <div class='info-sub-cont'>
                <div id='info-question-message'>
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