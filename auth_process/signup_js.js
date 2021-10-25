const next = () => {
  let uname = document.getElementById('u_name').value;
  let f_pass = document.getElementById('pass_word').value;
  let s_pass = document.getElementById('conf_pass').value;
  if(uname.trim() == ''){
    document.getElementById('signup-info').style.display = 'block';
    document.getElementById('info-message').innerHTML = 'Username is required';
  }
  else if(f_pass.trim() == '' || s_pass.trim() == ''){
    document.getElementById('signup-info').style.display = 'block';
    document.getElementById('info-message').innerHTML = 'Password is required';
  }
  else if(f_pass != s_pass){
    document.getElementById('signup-info').style.display = 'block';
    document.getElementById('info-message').innerHTML = 'Password did not match';
  }
  else if((f_pass == s_pass) && (f_pass.length < 8 && s_pass.length < 8)){
    document.getElementById('signup-info').style.display = 'block';
    document.getElementById('info-message').innerHTML = 'Password is less than eight characters';
  }
  else{
    document.querySelector('.questions-main-container').style.display = 'block';
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
    document.getElementById('signup-question-info').style.display = 'block';
    document.getElementById('info-question-message').innerHTML = 'Username is required';
  }
  else if(f_pass.trim() == '' || s_pass.trim() == ''){
    document.getElementById('signup-question-info').style.display = 'block';
    document.getElementById('info-question-message').innerHTML = 'Password is required';
  }
  else if(f_pass.trim() != s_pass.trim()){
    document.getElementById('signup-question-info').style.display = 'block';
    document.getElementById('info-question-message').innerHTML = 'Password did not match';
  }
  else if(first_answer.trim() == '' || second_answer.trim() == '' || third_answer.trim() == '' || fourth_answer.trim() == '' || fifth_answer.trim() == ''){
    document.getElementById('signup-question-info').style.display = 'block';
    document.getElementById('info-question-message').innerHTML = 'Please answer all the questions';
  }
  else if((f_pass.trim() == s_pass.trim()) && (f_pass.trim().length < 8 && s_pass.trim().length < 8)){
    document.getElementById('signup-info').style.display = 'block';
    document.getElementById('info-message').innerHTML = 'Password is less than eight characters';
  }
  else{
    var signUpProcess = new XMLHttpRequest();
    signUpProcess.onreadystatechange = function () {
      if(this.readyState == 4 && this.status == 200){
        if(this.responseText == "changed"){
          document.getElementById('signup-question-info').style.display = 'block';
          document.getElementById('info-question-message').innerHTML = 'Admin is already set';
        }
        else if(this.responseText == "success"){
          window.location.replace('./');
        }
        else if(this.responseText == "reset"){
          document.getElementById('signup-question-info').style.display = 'block';
          document.getElementById('info-question-message').innerHTML = 'Something went wrong';
        }
        else if(this.responseText == "severe"){
          document.getElementById('signup-question-info').style.display = 'block';
          document.getElementById('info-question-message').innerHTML = 'Something severe happened';
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

const closeInfo = () => {
  if(document.getElementById('signup-info').style.display == 'block'){
    document.getElementById('signup-info').style.display = 'none';
  }
  else if(document.getElementById('signup-question-info').style.display == 'block'){
    document.getElementById('signup-question-info').style.display = 'none';
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
