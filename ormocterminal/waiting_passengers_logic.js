document.getElementById("five").classList.add("active");

function loadWaitingPassengers(){
  const waitingPassengers = new XMLHttpRequest();
  waitingPassengers.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
      document.querySelector('.subfield-5-1').innerHTML = this.responseText;
    }
  };
  waitingPassengers.open("POST", "../admin_passenger_list.php", true);
  waitingPassengers.send();
}

setInterval(function(){
  loadWaitingPassengers();
}, 1500);

function exit(){
  window.location.replace('../admin_out.php');
}

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

loadAdminImage();
