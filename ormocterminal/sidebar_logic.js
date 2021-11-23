function loadAdminImage(){
  const loadImage = new XMLHttpRequest();
  loadImage.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
      if(this.responseText == 'error'){
        document.getElementById('message').innerHTML = "Something is wrong";
      }else{
        let data = JSON.parse(this.responseText);
        document.getElementById('admin-profile-pic').src = '../auth_process/' + data.profile;
        document.getElementById('profile-image').src = '../auth_process/' + data.profile;
        document.getElementById('uname').innerHTML = data.name;
        document.getElementById('admin-name').innerHTML = data.name;
      }
      console.log(this.responseText);
    }
  }
  loadImage.open("POST", "../auth_process/auth_process_load_image.php", true);
  loadImage.send();
}

loadAdminImage();

function authenticate(){
  let password = document.getElementById('pass_word').value;
  const authenticate = new XMLHttpRequest();
  authenticate.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
      if(this.responseText == 'success'){
        $('#authentication-modal').modal('hide');
        $('#editModal').modal('show');
      }else if(this.responseText == 'fail'){
        document.getElementById('message').innerHTML = 'Authentication failed';
      }else{
        document.getElementById('message').innerHTML = 'Something went wrong';
      }
      console.log(this.responseText);
    }
  }
  authenticate.open("POST", "../admin_password_auth.php", true);
  authenticate.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  authenticate.send("pass=" + password);
}

function checkAuth(){
  const checkAuth = new XMLHttpRequest();
  checkAuth.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
      if(this.responseText == 'authorized'){
        $('#editModal').modal('show')
      }else if(this.responseText == 'notauthorized'){
        $('#authentication-modal').modal('show')
      }
    }
  }
  checkAuth.open("POST", "../admin_check_auth.php", true);
  checkAuth.send();
}

function showPassSignIn(){
 document.getElementById('pass_word').type = 'text';
}

function hidePassSignIn(){
  document.getElementById('pass_word').type = 'password';
}

document.getElementById('icon').addEventListener('mousedown', function(){
  showPassSignIn();
})

window.addEventListener('mouseup', function(){
  hidePassSignIn();
})
