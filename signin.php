<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Ormoc Terminal Admin | SignIn</title>
    <link rel="stylesheet" href="signin_style.css" type="text/css">
  </head>
  <body>
    <div class="main-container">
      <form method="POST" action="signin.php">
        <div class="signin-main-container">
          <div class="signin-sub-container">
            <div class=signin-container>
                <div>
                  <label for="u_name">Username</label>
                </div>
                <div>
                  <input name="uname" type="text" class="cred" id="u_name">
                </div>
                <div>
                  <label for="pass_word">Password</label>
                  <a href="#">Forgot Password?</a>
                </div>
                <div>
                  <input name="pass" type="password" class="cred" id="pass_word">
                </div>
                <div id="label-notset">
                  <label for="conf-pass">Confirm Password</label>
                </div>
                <div id="password-notset">
                  <input name="conf" type="password" class="cred" id="conf_pass">
                </div>
                <input class="submit-button" id="admin-signin" type="submit" value="Sign in">
            </div>
            <?php
            if(isset($_POST['uname']) && isset($_POST['pass']) && isset($_POST['conf'])){
              if(!empty(trim($_POST['uname'])) && !empty(trim($_POST['pass'])) && empty(trim($_POST['conf']))){
                if(strlen($_POST['uname']) > 50 || strlen($_POST['pass']) > 50){
                  echo "<div id='exceedField' class='warning'><div class='sub-cont'><div>Username or Password exceeds 50 characters.</div><div><button type='button' onclick='hideExceedField()'><img src='./images/xbox.png'></button></div></div></div>";
                }
                else{
                  $server = 'localhost';
                  $username = 'root';
                  $password = '';
                  $dbname = 'ocqms';
                  $uname = $_POST['uname'];
                  $pass = $_POST['pass'];

                  try{
                    $san_uname = sha1(filter_var($_POST['uname'], FILTER_SANITIZE_STRING));
                    $san_pass = sha1(filter_var($_POST['pass'], FILTER_SANITIZE_STRING));
                    $connection = new PDO("mysql:host=$server;dbname=$dbname", $username, $password);
                    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $select_query = $connection->prepare("SELECT COUNT(*) as count FROM admin WHERE Uname='$san_uname' AND Password='$san_pass'");
                    $select_query->execute();
                    $result = $select_query->fetch(PDO::FETCH_ASSOC);

                    if($result){
                      if($uname === 'admin' && $pass === 'admin'){
                        if($result['count'] > 0){
                          header('Location: http://localhost/CapstoneWeb/signin.php?set=set');
                        }
                      }
                      elseif($result['count'] > 0){
                          echo "signed in";
                      }
                      else{
                        echo "<div id='loginError' class='warning'><div class='sub-cont'><div>Wrong username or password</div><div><button type='button' onclick='hideLoginError()'><img src='./images/xbox.png'></button></div></div></div>";
                      }
                    }
                  }catch(PDOException $e){
                    echo "<div id='eRror' class='warning'><div class='sub-cont'><div>Something went wrong signing in</div><div><button type='button' onclick='hideeRror()'><img src='./images/xbox.png'></button></div></div></div>";
                  }
                }
              }
              elseif(!empty(trim($_POST['uname'])) && !empty(trim($_POST['pass'])) && !empty(trim($_POST['conf']))){
                if(!empty(trim($_POST['q_one'])) && !empty(trim($_POST['q_two'])) && !empty(trim($_POST['q_three'])) && !empty(trim($_POST['q_four'])) && !empty(trim($_POST['q_five']))){
                  if(strlen($_POST['uname']) > 50 || strlen($_POST['pass']) > 50){
                    echo "<div id='exceedField' class='warning'><div class='sub-cont'><div>Username or Password exceeds 50 characters.</div><div><button type='button' onclick='hideExceedField()'><img src='./images/xbox.png'></button></div></div></div>";
                  }
                  else{
                    $server = 'localhost';
                    $username = 'root';
                    $password = '';
                    $dbname = 'ocqms';
                    $uname = sha1(filter_var($_POST['uname'], FILTER_SANITIZE_STRING));
                    $pass = sha1(filter_var($_POST['pass'], FILTER_SANITIZE_STRING));
                    $user_name = sha1('admin');
                    $pass_word = sha1('admin');
                    try{
                      $connection = new PDO("mysql:host=$server;dbname=$dbname", $username, $password);
                      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                      $update_query = $connection->prepare("UPDATE admin SET Uname='$uname', Password='$pass' WHERE Uname='$user_name' AND Password='$pass_word'");
                      $update_query->execute();
                      if($update_query->rowCount() > 0){
                        $answer_one = sha1(strtolower($_POST['q_one']));
                        $answer_two = sha1(strtolower($_POST['q_two']));
                        $answer_three = sha1(strtolower($_POST['q_three']));
                        $answer_four = sha1(strtolower($_POST['q_four']));
                        $answer_five = sha1(strtolower($_POST['q_five']));
                        $connection->beginTransaction();
                        $connection->exec("UPDATE questions SET Answer='$answer_one' WHERE Question='What is your favorite color?'");
                        $connection->exec("UPDATE questions SET Answer='$answer_two' WHERE Question='What is your mother\'s maiden name?'");
                        $connection->exec("UPDATE questions SET Answer='$answer_three' WHERE Question='What elementary school did you attend?'");
                        $connection->exec("UPDATE questions SET Answer='$answer_four' WHERE Question='When you were young, what did you want to be when you grew up?'");
                        $connection->exec("UPDATE questions SET Answer='$answer_five' WHERE Question='What is the name of the town where you were born?'");
                        $connection->commit();
                      }
                    }catch(PDOException $e){
                      //connection->rollback here!!!!!
                      echo $e;
                    }
                  }
                }
                else{
                  echo "<div class='warning' id='warn-missing-field'>";
                  echo "<div class='sub-cont'>";
                  echo "<div>Please write your answers to all the questions.</div>";
                  echo "<div><button type='button'onclick='hideMissingField()'>";
                  echo "<img src='./images/xbox.png'>";
                  echo "</button></div>";
                  echo "</div></div>";
                }
              }
              else{
                echo "<div class='warning' id='warn-missing-field'>";
                echo "<div class='sub-cont'>";
                echo "<div>Please fill all the field.</div>";
                echo "<div><button type='button'onclick='hideMissingField()'>";
                echo "<img src='./images/xbox.png'>";
                echo "</button></div>";
                echo "</div></div>";
              }
            }
            ?>
            <div id="admin-not-set" class='warning'>
              <div class='sub-cont'>
                <div id='sign-up-warning'>
                  Sign up for first use.
                </div>
                <div>
                  <button type="button" onclick="hideSignUpWarning()">
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
              <input class="submit-button" id="admin-signup" type="submit" value="Sign up">
            </div>
          </div>
        </div>
      </form>
    </div>
    <script type="text/javascript" defer>

      const showQuestions = () => {
        let uname = document.getElementById('u_name');
        let pass = document.getElementById('pass_word');
        let conf = document.getElementById('conf_pass');

        if(uname.value.trim() === '' || pass.value === '' || conf.value === ''){
          document.getElementById('sign-up-warning').innerHTML = 'Please fill all the fields.';
          document.getElementById('admin-not-set').style.display = 'block';
        }
        else if(!/^[a-zA-Z]+$/.test(uname.value)){
          document.getElementById('sign-up-warning').innerHTML = 'Only alphabets are allowed in username.';
          document.getElementById('admin-not-set').style.display = 'block';
        }
        else if(pass.value != conf.value){
          document.getElementById('sign-up-warning').innerHTML = 'Password did not match.';
          document.getElementById('admin-not-set').style.display = 'block';
        }
        else{
          document.querySelector('.signin-main-container').style.display = 'none';
          document.querySelector('.questions-main-container').style.display = 'block';
        }
      }

      const hideMissingField = () => {
        document.getElementById('warn-missing-field').style.display = 'none';
      }

      const hideSignUpWarning = () => {
        document.getElementById('admin-not-set').style.display = 'none';
      }

      const hideExceedField = () => {
        document.getElementById('exceedField').style.display = 'none';
      }

      const hideeRror = () => {
        document.getElementById('eRror').style.display = 'none';
      }

      const hideLoginError = () => {
        document.getElementById('loginError').style.display = 'none';
      }

      const urlString = window.location.search;
      const urlParams = new URLSearchParams(urlString);
      const parameter = urlParams.get('set');

      if(parameter == null){
        document.getElementById("label-notset").style.display = 'none';
        document.getElementById("password-notset").style.display = 'none';
      }
      else if(parameter === 'set'){
        let admin_button = document.getElementById("admin-signin");
        document.getElementById("label-notset").style.display = 'block';
        document.getElementById("password-notset").style.display = 'block';
        admin_button.value = 'Next';
        admin_button.type = 'button';
        admin_button.addEventListener('click', function(){
          showQuestions();
        })
        document.querySelector("a").style.display = 'none';
        document.getElementById("admin-not-set").style.display = 'block';
      }
    </script>
  </body>
</html>
