function exit(){
  window.location.replace('../admin_out.php');
}

document.getElementById("one").classList.add("active");

function loadAdminImage(){
  const loadImage = new XMLHttpRequest();
  loadImage.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
      if(this.responseText == 'error'){
        document.getElementById('message').innerHTML = "Something is wrong";
      }else{
        let data = JSON.parse(this.responseText);
        document.getElementById('admin-profile-pic').src = '../auth_process/' + data.profile;
        document.getElementById('admin-name').innerHTML = data.name;
      }
      console.log(this.responseText);
    }
  }
  loadImage.open("POST", "../auth_process/auth_process_load_image.php", true);
  loadImage.send();
}

function time(){
  let today = new Date();
  console.log(today.getMonth());
}

time();

loadAdminImage();

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
