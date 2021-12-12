document.getElementById("four").classList.add("active");

function popupInfo(message){
  swal.fire({
    icon: 'info',
    text: message
  });
}

function popupSuccess(message){
  swal.fire({
    icon: 'success',
    text: message
  });
}

function popupError(message){
  swal.fire({
    icon: 'error',
    text: message
  });
}

function popupWarning(message){
  swal.fire({
    icon: 'warning',
    text: message
  });
}

function loadQueuingVehicles(){
  if(document.getElementById('search-input').value != ''){
    let searchedDestination = document.getElementById('search-input').value;
    const queuingVehicles = new XMLHttpRequest();
    queuingVehicles.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){
        document.querySelector('.subfield-6-1-sub').innerHTML = this.responseText;
      }
    };
    queuingVehicles.open("POST", "../admin_queuing_vehicles_list.php", true);
    queuingVehicles.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    queuingVehicles.send("data=" + searchedDestination);
  }else if(document.getElementById('searched-destination').value != ''){
    let searchedDestination = document.getElementById('searched-destination').value;
    const queuingVehicles = new XMLHttpRequest();
    queuingVehicles.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){
        document.querySelector('.subfield-6-1-sub').innerHTML = this.responseText;
      }
    };
    queuingVehicles.open("POST", "../admin_queuing_vehicles_list.php", true);
    queuingVehicles.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    queuingVehicles.send("data=" + searchedDestination);
  }else{
    const queuingVehicles = new XMLHttpRequest();
    queuingVehicles.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){
        document.querySelector('.subfield-6-1-sub').innerHTML = this.responseText;
      }
    };
    queuingVehicles.open("POST", "../admin_queuing_vehicles_list.php", true);
    queuingVehicles.send();
  }
}

function unqueueVehicle(data){
  Swal.fire({
  title: 'Are you sure you want to remove ' + data + ' in queuing list?',
  showCancelButton: true,
  confirmButtonText: 'Dequeue',
  }).then((result) => {
    if(result.isConfirmed){
      const unqueuePUV = new XMLHttpRequest();
      unqueuePUV.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
          if(this.responseText == "success"){
            popupSuccess('Vehicle is successfully unqueued');
          }
          else if(this.responseText == "error"){
            popupError('Something went wrong');
          }
          else{
            popupError('Something went wrong');
          }
          console.log(this.responseText);
        }
      };
      unqueuePUV.open("POST", "../admin_unqueue_vehicle.php", true);
      unqueuePUV.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      unqueuePUV.send("data=" + data);
    }else if (result.isDenied){
      Swal.fire('Nothing has been done.', '', 'info');
    }
  })
}

setInterval(function(){
  loadQueuingVehicles();
}, 1500);

function exit(){
  window.location.replace('../admin_out.php');
}

function makePlateNoCorrect(value){
  let length = value.length;
  let plateNo = value.toUpperCase();
  let finalValue = "";
  let invalid_char = /[\s!"#$%&'()*+,-./:;<=>?@[\]^_`{|}~]/g;
  let invalid_str = /\d/;
  for(i = 0; i < length; i++){
    if(i < 3){
      if(invalid_str.test(plateNo[i]) || invalid_char.test(plateNo[i])){
        finalValue = finalValue + "";
      }else{
        finalValue = finalValue + plateNo[i];
      }
    }else if(i == 3){
      finalValue = finalValue + "-";
    }else if(i > 3){
      if(!invalid_str.test(plateNo[i]) || invalid_char.test(plateNo[i])){
        finalValue = finalValue + "";
      }else{
        finalValue = finalValue + plateNo[i];
      }
    }
  }
  return finalValue;
}
