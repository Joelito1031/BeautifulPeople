function loadQueuingVehicles(){
  if(document.getElementById('searched-destination').value != ''){
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
  if(confirm("Are you sure you want to unqueue " + data + "?")){
    const unqueuePUV = new XMLHttpRequest();
    unqueuePUV.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){
        if(this.responseText == "success"){
          warningsSuccess('Vehicle is successfully unqueued');
        }
        else if(this.responseText == "error"){
          warningsError('Something went wrong');
        }
        else{
          warningsError('Something went wrong');
        }
        console.log(this.responseText);
      }
    };
    unqueuePUV.open("POST", "../admin_unqueue_vehicle.php", true);
    unqueuePUV.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    unqueuePUV.send("data=" + data);
  }
}

setInterval(function(){
  loadQueuingVehicles();
}, 1500);
