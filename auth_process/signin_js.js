const signin = () => {
  let uname = document.getElementById('u_name').value;
  let pass = document.getElementById('pass_word').value;
  document.getElementById('admin-signin').value = 'Signing in...';
  var signInProcess = new XMLHttpRequest();
  signInProcess.onreadystatechange = function () {
    if(this.readyState == 4 && this.status == 200) {
      if(this.responseText == "default"){
        window.location.replace('./signup.html');
      }
      else if(this.responseText == "notfound"){
        document.getElementById('signin-info').style.display = 'block';
        document.getElementById('info-message').innerHTML = 'Username or Password is incorrect';
        document.getElementById('admin-signin').value = 'Sign in';
      }
      else if(this.responseText == 'error_connection'){
        document.getElementById('signin-info').style.display = 'block';
        document.getElementById('info-message').innerHTML = 'Connection error';
        document.getElementById('admin-signin').value = 'Sign in';
      }
    }
  }
  signInProcess.open("POST", "./auth_process/auth_process_signin.php", true);
  signInProcess.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  signInProcess.send("uname=" + uname + "&pass=" + pass);
}
