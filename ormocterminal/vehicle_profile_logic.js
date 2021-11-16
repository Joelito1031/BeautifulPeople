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


function retrieveRegisteredPUV(){
  Loader.open();
  const retrieveDispatcher = new XMLHttpRequest();
  retrieveDispatcher.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
      Loader.close();
      document.querySelector('.puvs-table').innerHTML = this.responseText;
    }else{
      Loader.open();
    }
  }
  retrieveDispatcher.open("POST", "../admin_vehicle_editable_list.php", true);
  retrieveDispatcher.send();
}

function searchVehicle(value){
  if(document.getElementById('search-input').value == ''){
    document.getElementById('search-ico').style.display = "inline";
    document.getElementById('loading-ico').style.display = "none";
    retrieveRegisteredPUV();
  }else{
    const retrieveDispatcher = new XMLHttpRequest();
    retrieveDispatcher.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){
        if(this.responseText != ""){
          document.getElementById('search-ico').style.display = "inline";
          document.getElementById('loading-ico').style.display = "none";
          document.querySelector('.puvs-table').innerHTML = this.responseText;
        }else{
          document.getElementById('search-ico').style.display = "none";
          document.getElementById('loading-ico').style.display = "inline";
        }
      }else{
        document.getElementById('search-ico').style.display = "inline";
        document.getElementById('loading-ico').style.display = "none";
      }
    }
    retrieveDispatcher.open("POST", "../search_puv_profile.php", true);
    retrieveDispatcher.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    retrieveDispatcher.send("search=" + value.toUpperCase());
  }
}

retrieveRegisteredPUV();
