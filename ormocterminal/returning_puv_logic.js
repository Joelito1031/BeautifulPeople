function warningsSuccess(message){
  var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
  });

  Toast.fire({
    icon: 'success',
    title: message
  })
}

function warningsRegistered(message){
  var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
  });

  Toast.fire({
    icon: 'info',
    title: message
  })
}

function warningsError(message){
  var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
  });

  Toast.fire({
    icon: 'error',
    title: message
  })
}

function warningsIncomplete(message){
  var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
  });

  Toast.fire({
    icon: 'warning',
    title: message
  })
}

function loadReturningVehicles(){
  if(document.getElementById('searched-returning').value != ''){
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
        warningsSuccess('Vehicle set to return');
      }
      else if(this.responseText == "success-off"){
        warningsIncomplete('Vehicle set to not return');
      }
      else{
        warningsError('Something went wrong');
      }
    }
  }
  changeVehicleStatus.open("POST", "../admin_vehicle_returning_process.php", true);
  changeVehicleStatus.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  changeVehicleStatus.send("data=" + data);
}

function fullyRemoveVehicle(data){
  if(confirm("Are you sure you want to remove " + data)){
    const vehicleToRemove = new XMLHttpRequest();
    vehicleToRemove.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){
        if(this.responseText == "success"){
          warningsSuccess('Vehicle was removed successfully');
        }
        else if(this.responseText == "error"){
          warningsError('Something went wrong');
        }
        else{
          warningsError('Something went wrong');
        }
      }
    }
    vehicleToRemove.open("POST", "../admin_drop_vehicle.php", true);
    vehicleToRemove.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    vehicleToRemove.send("data=" + data);
  }
}

setInterval(function(){
  loadReturningVehicles();
}, 1500);
