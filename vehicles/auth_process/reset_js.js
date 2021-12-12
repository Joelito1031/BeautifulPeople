window.addEventListener('keyup', function(e){
  if(e.keyCode == '13'){
    validate();
  }
});

document.getElementById('q-1').addEventListener('keyup', function(e){
  if(e.keyCode == '13'){
    validate();
  }
  if(document.getElementById('q-1').value == ''){
    if(document.getElementById('mess').innerHTML != ''){
      document.getElementById('mess').innerHTML = '';
    }
  }
})

document.getElementById('q-2').addEventListener('keyup', function(e){
  if(e.keyCode == '13'){
    validate();
  }
  if(document.getElementById('q-2').value == ''){
    if(document.getElementById('mess').innerHTML != ''){
      document.getElementById('mess').innerHTML = '';
    }
  }
})

document.getElementById('q-3').addEventListener('keyup', function(e){
  if(e.keyCode == '13'){
    validate();
  }
  if(document.getElementById('q-3').value == ''){
    if(document.getElementById('mess').innerHTML != ''){
      document.getElementById('mess').innerHTML = '';
    }
  }
})

document.getElementById('q-4').addEventListener('keyup', function(e){
  if(e.keyCode == '13'){
    validate();
  }
  if(document.getElementById('q-4').value == ''){
    if(document.getElementById('mess').innerHTML != ''){
      document.getElementById('mess').innerHTML = '';
    }
  }
})

document.getElementById('q-5').addEventListener('keyup', function(e){
  if(e.keyCode == '13'){
    validate();
  }
  if(document.getElementById('q-5').value == ''){
    if(document.getElementById('mess').innerHTML != ''){
      document.getElementById('mess').innerHTML = '';
    }
  }
})

const validate = () => {
  let qOne = document.getElementById('q-1').value.replace(/\s+/g, '');
  let qTwo = document.getElementById('q-2').value.replace(/\s+/g, '');
  let qThree = document.getElementById('q-3').value.replace(/\s+/g, '');
  let qFour = document.getElementById('q-4').value.replace(/\s+/g, '');
  let qFive = document.getElementById('q-5').value.replace(/\s+/g, '');

  if(qOne.trim() == '' || qTwo.trim() == '' || qThree.trim() == '' || qFour.trim() == '' || qFive.trim() == ''){
    document.getElementById('mess').innerHTML = 'Please answer all questions';
  }else{
    const compareAnswer = new XMLHttpRequest();
    compareAnswer.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){
        if(this.responseText == 'success'){
          window.location.replace('./passwordreset');
        }else if(this.responseText == 'notset'){
          document.getElementById('mess').innerHTML = 'Default has not changed';
        }else if(this.responseText == 'fail'){
          document.getElementById('mess').innerHTML = 'Some answers did not match';
        }else if(this.responseText == 'error'){
          document.getElementById('mess').innerHTML = 'Please answer all the questions';
        }else{
          document.getElementById('mess').innerHTML = 'Something went wrong';
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
