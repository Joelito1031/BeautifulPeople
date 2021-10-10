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
                  <input name="conf" type="password" class="cred" id="conf-pass">
                </div>
                <input class="submit-button" id="admin-signin" type="submit" value="Sign in">
            </div>
            <div id="admin-not-set" class='warning'>
              <div class='sub-cont'>
                <div>
                  Sign up for first use.
                </div>
                <div>
                  <button>
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
                <label for="q-1">What is your favorite color?</label>
              </div>
              <div>
                <input class="answers" type="text" id="q-1">
              </div>
              <div>
                <label for="q-2">What is your mother's maiden name?</label>
              </div>
              <div>
                <input class="answers" type="text" id="q-2">
              </div>
              <div>
                <label for="q-3">What elementary school did you attend?</label>
              </div>
              <div>
                <input class="answers" type="text" id="q-3">
              </div>
              <div>
                <label for="q-4">When you were young, what did you want to be when you grew up?</label>
              </div>
              <div>
                <input class="answers" type="text" id="q-4">
              </div>
              <div>
                <label for="q-5">What is the name of the town where you were born?</label>
              </div>
              <div>
                <input class="answers" type="text" id="q-5">
              </div>
              <input class="submit-button" id="admin-signup" type="submit" value="Sign in">
            </div>
          </div>
        </div>
      </form>
      <div class="warning-container">
        <?php
        if(isset($_POST['uname']) && isset($_POST['pass'])){
          if(!empty(trim($_POST['uname'])) && !empty(trim($_POST['pass']))){
            if(strlen($_POST['uname']) > 50 || strlen($_POST['pass']) > 50){
              echo "<div class='warning'><div class='sub-cont'><div>Username or Password exceeds 50 characters.</div><div><button><img src='./images/xbox.png'></button></div></div></div>";
            }
            else{
              $server = 'localhost';
              $username = 'root';
              $password = '';
              $dbname = 'ocqms';
              $uname = $_POST['uname'];
              $pass = $_POST['pass'];

              try{
                $connection = new PDO("mysql:host=$server;dbname=$dbname", $username, $password);
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $select_query = "SELECT COUNT(*) FROM admin WHERE Uname='$uname' AND Password='$pass'";
                $num_row = $connection->query($select_query);
                $row_count = $num_row->fetchColumn();
                $count = (int) $row_count;

                if($uname === 'admin' && $pass === 'admin'){
                  if($count > 0){
                    header('Location: http://localhost/CapstoneWeb/signin.php?set=set');
                  }
                }
                elseif($count > 0){

                }
              }catch(PDOException $e){
                echo 'Error:' . ' ' . $e->getMessage();
              }
            }
          }
          else{
            echo "<div class='warning' id='warn-missing-field'>";
            echo "<div class='sub-cont'>";
            echo "<div>Please fill all the field.</div>";
            echo "<div><button onclick='hideMissingField()'>";
            echo "<img src='./images/xbox.png'>";
            echo "</button></div>";
            echo "</div></div>";
          }
        }
        ?>
      </div>
    </div>
    <script type="text/javascript" defer>
      const hideMissingField = () => {
        document.getElementById('warn-missing-field').style.display='none';
      }

      const urlString = window.location.search;
      const urlParams = new URLSearchParams(urlString);
      const parameter = urlParams.get('set');

      if(parameter == null){
        document.getElementById("label-notset").style.display = 'none';
        document.getElementById("password-notset").style.display = 'none';
      }
      else if(parameter === 'set'){
        document.getElementById("label-notset").style.display = 'block';
        document.getElementById("password-notset").style.display = 'block';
        document.getElementById("s-b").value = 'Sign up';
        document.querySelector("a").style.display = 'none';
        document.getElementById("admin-not-set").style.display = 'block';
      }
    </script>
  </body>
</html>
