<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Ormoc Terminal Admin | SignIn</title>
    <link rel="stylesheet" href="signin_style.css" type="text/css">
  </head>
  <body>
    <div class="main-container">
      <div class="sub-container">
        <div class="sub2-container">
          <div class=signin-container>
            <form method="POST" action="signin.php">
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
              <input class="submit-button" id="s-b" type="submit" value="Sign in">
            </form>
          </div>
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
              echo "<div class='warning'><div class='sub-cont'><div>Please fill all the field.</div><div><button><img src='./images/xbox.png'></button></div></div></div>";
            }
          }
          ?>
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
    </div>
    <script type="text/javascript">
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
        document.getElementById(".admin-not-set").style.display = 'block';
      }
    </script>
  </body>
</html>
