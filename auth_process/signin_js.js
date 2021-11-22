document.getElementById('pass_word').addEventListener('keyup', function(key){
  if(key.keyCode == "13"){
    signin();
  }
  if(document.getElementById('pass_word').value == ''){
    if(document.getElementById('message').innerHTML != ''){
      document.getElementById('message').innerHTML = '';
    }
  }
})

document.getElementById('icon').addEventListener('mousedown', function(){
  showPassSignIn();
})

window.addEventListener('mouseup', function(){
  hidePassSignIn();
});

function loadAdminImage(){
  const loadImage = new XMLHttpRequest();
  loadImage.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
      if(this.responseText == 'error'){
        document.getElementById('message').innerHTML = "Something is wrong";
      }else{
        let data = JSON.parse(this.responseText);
        document.getElementById('profile-image').src = 'auth_process/' + data.profile;
        document.getElementById('uname').innerHTML = data.name;
      }
      console.log(this.responseText);
    }
  }
  loadImage.open("POST", "./auth_process/auth_process_load_image.php", true);
  loadImage.send();
}

loadAdminImage();

const signin = () => {
  let uname = document.getElementById('uname').innerHTML;
  let pass = document.getElementById('pass_word').value;
  if(uname.trim() == '' || pass.trim() == ''){
    document.getElementById('message').innerHTML = 'Enter your password';
  }else{
    var signInProcess = new XMLHttpRequest();
    signInProcess.onreadystatechange = function () {
      if(this.readyState == 4 && this.status == 200) {
        if(this.responseText == "default"){
          window.location.replace('./signup');
        }
        else if(this.responseText == "notfound"){
          document.getElementById('message').innerHTML = "Authentication failed";
        }
        else if(this.responseText == 'error_connection'){
          document.getElementById('signin-info').style.display = 'block';
          document.getElementById('info-message').innerHTML = 'Connection error';
          document.getElementById('admin-signin').value = 'Sign in';
        }
        else if(this.responseText == 'login'){
          window.location.replace('./ormocterminal/dashboard');
        }
        else{
          document.getElementById('message').innerHTML = "Something went wrong";
        }
        console.log(this.responseText);
      }
    }
    signInProcess.open("POST", "./auth_process/auth_process_signin.php", true);
    signInProcess.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    signInProcess.send("uname=" + uname + "&pass=" + pass);
  }
}

window.addEventListener('keyup', function(e){
  if(e.keyCode == '13'){
    signin();
  }
})

function showPassSignIn(){
 document.getElementById('pass_word').type = 'text';
}

function hidePassSignIn(){
  document.getElementById('pass_word').type = 'password';
}

const closeInfo = () => {
  document.getElementById('signin-info').style.display = 'none';
}
