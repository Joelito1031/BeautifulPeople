document.getElementById("six").classList.add("active");

function returningSetError(message){
  var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
  });

  Toast.fire({
    icon: 'error',
    title: message,
    background: '#EC7063'
  })
}

function returningSetSuccess(message){
  var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
  });

  Toast.fire({
    icon: 'success',
    title: message,
    background: '#9edbff'
  })
}

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

function loadReturningVehicles(){
  if(document.getElementById('search-input').value != ''){
    let searchedReturning = document.getElementById('search-input').value;
    const returningVehicles = new XMLHttpRequest();
    returningVehicles.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){
        document.querySelector('.subfield-4-1-sub').innerHTML = this.responseText;
      }
    };
    returningVehicles.open("POST", "../admin_returning_vehicle_list.php", true);
    returningVehicles.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    returningVehicles.send("data=" + searchedReturning);
  }else if(document.getElementById('searched-returning').value != ''){
    let searchedReturning = document.getElementById('searched-returning').value;
    const returningVehicles = new XMLHttpRequest();
    returningVehicles.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){
        document.querySelector('.subfield-4-1-sub').innerHTML = this.responseText;
      }
    };
    returningVehicles.open("POST", "../admin_returning_vehicle_list.php", true);
    returningVehicles.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    returningVehicles.send("data=" + searchedReturning);
  }else{
    const returningVehicles = new XMLHttpRequest();
    returningVehicles.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){
        document.querySelector('.subfield-4-1-sub').innerHTML = this.responseText;
      }
    };
    returningVehicles.open("POST", "../admin_returning_vehicle_list.php", true);
    returningVehicles.send();
  }
}

function vehicleStatus(data){
  const changeVehicleStatus = new XMLHttpRequest();
  changeVehicleStatus.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
      if(this.responseText == "success-on"){
        returningSetSuccess('Vehicle set to return');
      }
      else if(this.responseText == "success-off"){
        returningSetSuccess('Vehicle set to not return');
      }
      else{
        returningSetError('Something went wrong');
      }
    }
  }
  changeVehicleStatus.open("POST", "../admin_vehicle_returning_process.php", true);
  changeVehicleStatus.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  changeVehicleStatus.send("data=" + data);
}

setInterval(function(){
  loadReturningVehicles();
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
