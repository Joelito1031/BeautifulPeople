document.getElementById('u_name').addEventListener('keyup', function(e){
  if(e.keyCode == '13'){
    next();
  }
  if(document.getElementById('u_name').value == ''){
    if(document.getElementById('message').innerHTML != ''){
      document.getElementById('message').innerHTML = '';
    }
  }
});

document.getElementById('pass_word').addEventListener('keyup', function(e){
  if(e.keyCode == '13'){
    next();
  }
  if(document.getElementById('pass_word').value == ''){
    if(document.getElementById('message').innerHTML != ''){
      document.getElementById('message').innerHTML = '';
    }
  }
});

document.getElementById('conf_pass').addEventListener('keyup', function(e){
  if(e.keyCode == '13'){
    next();
  }
  if(document.getElementById('conf_pass').value == ''){
    if(document.getElementById('message').innerHTML != ''){
      document.getElementById('message').innerHTML = '';
    }
  }
});



const next = () => {
  let uname = document.getElementById('u_name').value;
  let f_pass = document.getElementById('pass_word').value;
  let s_pass = document.getElementById('conf_pass').value;
  if(uname.trim() == ''){
    document.getElementById('message').innerHTML = 'Username is required';
  }
  else if(f_pass.trim() == '' || s_pass.trim() == ''){
    document.getElementById('message').innerHTML = 'Password is required';
  }
  else if(f_pass != s_pass){
    document.getElementById('message').innerHTML = 'Password did not match';
  }
  else if((f_pass == s_pass) && (f_pass.length < 8 && s_pass.length < 8)){
    document.getElementById('message').innerHTML = 'Password is less than eight characters';
  }
  else{
    document.querySelector('.questions-main-container').style.display = 'flex';
    document.querySelector('.signup-main-container').style.display = 'none';
  }
}

const signup = () => {
  let uname = document.getElementById('u_name').value;
  let f_pass = document.getElementById('pass_word').value;
  let s_pass = document.getElementById('conf_pass').value;
  let first_answer = document.getElementById('q-1').value;
  let second_answer = document.getElementById('q-2').value;
  let third_answer = document.getElementById('q-3').value;
  let fourth_answer = document.getElementById('q-4').value;
  let fifth_answer = document.getElementById('q-5').value;

  if(uname.trim() == ''){
    document.getElementById('mess').innerHTML = 'Username is required';
  }
  else if(f_pass.trim() == '' || s_pass.trim() == ''){
    document.getElementById('mess').innerHTML = 'Password is required';
  }
  else if(f_pass.trim() != s_pass.trim()){
    document.getElementById('mess').innerHTML = 'Password did not match';
  }
  else if(first_answer.trim() == '' || second_answer.trim() == '' || third_answer.trim() == '' || fourth_answer.trim() == '' || fifth_answer.trim() == ''){
    document.getElementById('mess').innerHTML = 'Please answer all the questions';
  }
  else if((f_pass.trim() == s_pass.trim()) && (f_pass.trim().length < 8 && s_pass.trim().length < 8)){
    document.getElementById('mess').innerHTML = 'Password is less than eight characters';
  }
  else{
    var signUpProcess = new XMLHttpRequest();
    signUpProcess.onreadystatechange = function () {
      if(this.readyState == 4 && this.status == 200){
        if(this.responseText == "changed"){
          document.getElementById('mess').innerHTML = 'Admin is already set';
        }
        else if(this.responseText == "success"){
          uploadPhoto(uname);
        }
        else if(this.responseText == "reset"){
          document.getElementById('mess').innerHTML = 'Something went wrong';
        }
        else if(this.responseText == "severe"){
          document.getElementById('mess').innerHTML = 'Something severe happened';
        }
        else{
          document.getElementById('mess').innerHTML = 'Something went wrong';
        }
        console.log(this.responseText);
      }
    }
    signUpProcess.open("POST", "./auth_process/auth_process_signup.php", true);
    signUpProcess.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    signUpProcess.send("uname=" + uname.trim() + "&password=" + f_pass + "&first_answer=" + first_answer.trim() +
    "&second_answer=" + second_answer.trim() + "&third_answer=" + third_answer.trim() + "&fourth_answer=" +
    fourth_answer.trim() + "&fifth_answer=" + fifth_answer.trim());
  }
}

function uploadPhoto(uname){
  if(choosenFile.value == ''){
    window.location.replace('./signin');
  }else{
    const formData = new FormData();
    const file = choosenFile.files[0];
    formData.append('profile-pic', file, file.name);
    formData.append('uname', uname);
    const uploadPhoto = new XMLHttpRequest();
    uploadPhoto.open('POST', './auth_process/auth_process_upload_photo.php', true);
    uploadPhoto.onload = function(){
      if(uploadPhoto.status == 200){
        if(this.responseText == 'notapic'){
          document.getElementById('message').innerHTML = 'File not supported';
        }else if(this.responseText == 'fileexist'){
          document.getElementById('message').innerHTML = 'Not allowed';
        }else if(this.responseText == 'sizelimit'){
          document.getElementById('message').innerHTML = 'File size exceed';
        }else if(this.responseText == 'upload'){
          window.location.replace('./signin');
        }else if(this.responseText == 'error'){
          document.getElementById('message').innerHTML = 'Unable to upload photo, default photo was set. Redirecting...';
          setTimeout(function(){
            window.location.replace('./signin');
          }, 2000)
        }else{
          document.getElementById('message').innerHTML = 'Unable to upload photo, default photo was set. Redirecting...';
          setTimeout(function(){
            window.location.replace('./signin');
          }, 2000)
        }
        console.log(this.responseText);
      }else{
        document.getElementById('message').innerHTML = 'Unable to upload photo, default photo was set. Redirecting...';
        setTimeout(function(){
          window.location.replace('./signin');
        }, 2000)
      }
    };
    uploadPhoto.send(formData);
  }
}


function showPassSignUp(){
  let pass = document.getElementById('pass_word');
  if(pass.type == 'password'){
    pass.type = 'text';
  }
  else{
    pass.type = 'password';
  }
}

function showPassConfSignUp(){
  let pass_conf = document.getElementById('conf_pass');
  if(pass_conf.type == 'password'){
    pass_conf.type = 'text';
  }
  else{
    pass_conf.type = 'password';
  }
}

const choosenFile = document.getElementById('profile-pic');

const openFile = () => {
  document.getElementById('profile-pic').click();
}

const previewFile = () => {
  const actualPic = document.getElementById('actual-pic');
  const pic = choosenFile.files[0];
  if(pic){
    const picReader = new FileReader();
    picReader.readAsDataURL(pic);
    picReader.addEventListener("load", function(){
      actualPic.src = this.result;
    });
  }
}

choosenFile.addEventListener("change", function(){
  previewFile();
});

document.getElementById('q-1').addEventListener('keyup', function(e){
  if(e.keyCode == '13'){
    signup();
  }
  if(document.getElementById('q-1').value == ''){
    if(document.getElementById('mess').innerHTML != ''){
      document.getElementById('mess').innerHTML = '';
    }
  }
});
document.getElementById('q-2').addEventListener('keyup', function(e){
  if(e.keyCode == '13'){
    signup();
  }
  if(document.getElementById('q-2').value == ''){
    if(document.getElementById('mess').innerHTML != ''){
      document.getElementById('mess').innerHTML = '';
    }
  }
});
document.getElementById('q-3').addEventListener('keyup', function(e){
  if(e.keyCode == '13'){
    signup();
  }
  if(document.getElementById('q-3').value == ''){
    if(document.getElementById('mess').innerHTML != ''){
      document.getElementById('mess').innerHTML = '';
    }
  }
});
document.getElementById('q-4').addEventListener('keyup', function(e){
  if(e.keyCode == '13'){
    signup();
  }
  if(document.getElementById('q-4').value == ''){
    if(document.getElementById('mess').innerHTML != ''){
      document.getElementById('mess').innerHTML = '';
    }
  }
});
document.getElementById('q-5').addEventListener('keyup', function(e){
  if(e.keyCode == '13'){
    signup();
  }
  if(document.getElementById('q-5').value == ''){
    if(document.getElementById('mess').innerHTML != ''){
      document.getElementById('mess').innerHTML = '';
    }
  }
});

document.getElementById('icon').addEventListener('mousedown', function(){
  showPassSignIn();
})

window.addEventListener('keyup', function(e){
  if(e.keyCode == '13'){
    next();
  }
})

window.addEventListener('mouseup', function(){
  hidePassSignIn();
  hideConfPassSignIn();
});

function showPassSignIn(){
 document.getElementById('pass_word').type = 'text';
}

function hidePassSignIn(){
  document.getElementById('pass_word').type = 'password';
}

document.getElementById('conf-icon').addEventListener('mousedown', function(){
  showConfPassSignIn();
})

function showConfPassSignIn(){
 document.getElementById('conf_pass').type = 'text';
}

function hideConfPassSignIn(){
  document.getElementById('conf_pass').type = 'password';
}
