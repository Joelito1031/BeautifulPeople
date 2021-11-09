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
