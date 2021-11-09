const validate = () => {
  let qOne = document.getElementById('q-1').value.replace(/\s+/g, '');
  let qTwo = document.getElementById('q-2').value.replace(/\s+/g, '');
  let qThree = document.getElementById('q-3').value.replace(/\s+/g, '');
  let qFour = document.getElementById('q-4').value.replace(/\s+/g, '');
  let qFive = document.getElementById('q-5').value.replace(/\s+/g, '');
  let questionInfo = document.getElementById('reset-question-info');
  let questionMessageInfo = document.getElementById('info-question-message');

  if(qOne.trim() == '' || qTwo.trim() == '' || qThree.trim() == '' || qFour.trim() == '' || qFive.trim() == ''){
    questionInfo.style.display = 'block';
    questionMessageInfo.innerHTML = 'Please answer all the questions';
  }else{
    const compareAnswer = new XMLHttpRequest();
    compareAnswer.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){
        if(this.responseText == 'success'){
          window.location.replace('./passwordreset');
        }else if(this.responseText == 'notset'){
          questionInfo.style.display = 'block';
          questionMessageInfo.innerHTML = 'Default has not change';
        }else if(this.responseText == 'fail'){
          questionInfo.style.display = 'block';
          questionMessageInfo.innerHTML = 'Some answers did not match';
        }else if(this.responseText == 'error'){
          questionInfo.style.display = 'block';
          questionMessageInfo.innerHTML = 'Please answer all the questions';
        }else{
          questionInfo.style.display = 'block';
          questionMessageInfo.innerHTML = 'Something went wrong';
        }
      }
    }
    compareAnswer.open('POST', './auth_process/auth_process_reset.php', true);
    compareAnswer.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    compareAnswer.send('qone=' + qOne + '&qtwo=' + qTwo + '&qthree=' + qThree + '&qfour=' + qFour + '&qfive=' + qFive);
  }
}

const closeInfo = () => {
  document.getElementById('reset-question-info').style.display = 'none';
}
