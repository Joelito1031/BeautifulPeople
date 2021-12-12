function exit(){
  window.location.replace('../admin_out.php');
}

document.getElementById("one").classList.add("active");

function time(){
  let today = new Date();
  let meridian = today.getHours() >= 12 ? 'PM' : 'AM';
  var timeNow = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds() + " " + meridian;
  return timeNow;
}



setInterval(function(){
  document.getElementById('time').innerHTML = time();
}, 1000);

function loadRegisteredPUV(){
  const registeredPUV = new XMLHttpRequest();
  registeredPUV.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
      document.getElementById('reged-puv').innerHTML = this.responseText + "<p>Registered PUV</p>";
    }
  }
  registeredPUV.open("POST", "./registered_puv_count.php", true);
  registeredPUV.send();
}

function loadRegisteredDispatcher(){
  const registeredDispatcher = new XMLHttpRequest();
  registeredDispatcher.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
      document.getElementById('reged-dispatcher').innerHTML = this.responseText + "<p>Registered Dispatcher</p>";
    }
  }
  registeredDispatcher.open("POST", "./registered_dispatcher_count.php", true);
  registeredDispatcher.send();
}

function loadQueuingPUV(){
  const queuingPUV = new XMLHttpRequest();
  queuingPUV.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
      document.getElementById('queue-puv').innerHTML = this.responseText + "<p>Queueing PUVs</p>";
    }
  }
  queuingPUV.open("POST", "./queuing_vehicle_count.php", true);
  queuingPUV.send();
}

function loadOnDutyDispatchers(){
  const onDuty = new XMLHttpRequest();
  onDuty.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
      document.getElementById('onduty-dispatchers').innerHTML = this.responseText + "<p>On Duty Dispatchers</p>";
    }
  }
  onDuty.open("POST", "./retrieve_on_duty_dispatchers.php", true);
  onDuty.send();
}

setInterval(function(){
  loadRegisteredPUV();
  loadRegisteredDispatcher();
  loadQueuingPUV();
  loadOnDutyDispatchers();
}, 2000);


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
