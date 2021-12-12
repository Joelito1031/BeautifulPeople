const changePassword = () => {
  let f_pass = document.getElementById('pass_word').value;
  let s_pass = document.getElementById('conf_pass').value;
  if(f_pass.trim() == '' || s_pass.trim() == ''){
    document.getElementById('message').innerHTML = 'Please fill all the fields';
  }
  else if(f_pass != s_pass){
    document.getElementById('message').innerHTML = 'Password did not match';
  }
  else if((f_pass == s_pass) && (f_pass.length < 8 && s_pass.length < 8)){
    document.getElementById('message').innerHTML = 'Password is less than eight characters';
  }
  else{
    changePass = new XMLHttpRequest();
    changePass.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){
        if(this.responseText == 'success'){
          window.location.replace('./signin');
        }else if(this.responseText == 'fail'){
          document.getElementById('message').innerHTML = 'Unable to reset password';
        }else if(this.responseText == 'error'){
          document.getElementById('message').innerHTML = 'Something went wrong';
        }else if(this.responseText == 'restricted'){
          document.getElementById('message').innerHTML = 'Not that fast!';
        }else{
          document.getElementById('message').innerHTML = 'Something went wrong';
        }
      }
    }
    changePass.open("POST", "./auth_process/auth_process_passwordreset.php", true);
    changePass.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    changePass.send('password=' + f_pass);
  }
}

window.addEventListener('keyup', function(e){
  if(e.keyCode == '13'){
    changePassword();
  }
})

window.addEventListener('mouseup', function(){
  hidePassSignIn();
  hideConfPassSignIn();
});


document.getElementById('pass_word').addEventListener('keyup', function(e){
  if(e.keyCode == '13'){
    changePassword();
  }
  if(document.getElementById('pass_word').value == ''){
    if(document.getElementById('message').innerHTML != ''){
      document.getElementById('message').innerHTML = '';
    }
  }
});

document.getElementById('conf_pass').addEventListener('keyup', function(e){
  if(e.keyCode == '13'){
    changePassword();
  }
  if(document.getElementById('conf_pass').value == ''){
    if(document.getElementById('message').innerHTML != ''){
      document.getElementById('message').innerHTML = '';
    }
  }
});

document.getElementById('icon').addEventListener('mousedown', function(){
  showPassSignIn();
})

document.getElementById('conf-icon').addEventListener('mousedown', function(){
  showConfPassSignIn();
})

function showConfPassSignIn(){
 document.getElementById('conf_pass').type = 'text';
}

function hideConfPassSignIn(){
  document.getElementById('conf_pass').type = 'password';
}

function showPassSignIn(){
 document.getElementById('pass_word').type = 'text';
}

function hidePassSignIn(){
  document.getElementById('pass_word').type = 'password';
}
