const changePassword = () => {
  let f_pass = document.getElementById('pass_word').value;
  let s_pass = document.getElementById('conf_pass').value;
  if(f_pass.trim() == '' || s_pass.trim() == ''){
    document.getElementById('reset-info').style.display = 'block';
    document.getElementById('info-message').innerHTML = 'Please fill all the fields';
  }
  else if(f_pass != s_pass){
    document.getElementById('reset-info').style.display = 'block';
    document.getElementById('info-message').innerHTML = 'Password did not match';
  }
  else if((f_pass == s_pass) && (f_pass.length < 8 && s_pass.length < 8)){
    document.getElementById('reset-info').style.display = 'block';
    document.getElementById('info-message').innerHTML = 'Password is less than eight characters';
  }
  else{
    changePass = new XMLHttpRequest();
    changePass.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){
        if(this.responseText == 'success'){
          window.location.replace('./signin');
        }else if(this.responseText == 'fail'){
          document.getElementById('reset-info').style.display = 'block';
          document.getElementById('info-message').innerHTML = 'Unable to reset password';
        }else if(this.responseText == 'error'){
          document.getElementById('reset-info').style.display = 'block';
          document.getElementById('info-message').innerHTML = 'Something went wrong';
        }else if(this.responseText == 'restricted'){
          document.getElementById('reset-info').style.display = 'block';
          document.getElementById('info-message').innerHTML = 'Not that fast!';
        }else{
          document.getElementById('reset-info').style.display = 'block';
          document.getElementById('info-message').innerHTML = 'Something went wrong';
        }
      }
    }
    changePass.open("POST", "./auth_process/auth_process_passwordreset.php", true);
    changePass.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    changePass.send('password=' + f_pass);
  }
}

const closeInfo = () => {
  document.getElementById('reset-info').style.display = 'none';
}

function showPassReset(){
  let pass = document.getElementById('pass_word');
  if(pass.type == 'password'){
    pass.type = 'text';
  }
  else{
    pass.type = 'password';
  }
}

function showPassConfReset(){
  let pass_conf = document.getElementById('conf_pass');
  if(pass_conf.type == 'password'){
    pass_conf.type = 'text';
  }
  else{
    pass_conf.type = 'password';
  }
}
