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

function retrieveRegisteredDispatcher(){
  const retrieveDispatcher = new XMLHttpRequest();
  retrieveDispatcher.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
      document.querySelector('.dispatchers-table').innerHTML = this.responseText;
    }
  }
  retrieveDispatcher.open("POST", "../admin_dispatchers_list.php", true);
  retrieveDispatcher.send();
}

function registerDispatcher(){
  let contactNumber = document.getElementById('dis_c_num');
  let genPin = document.getElementById('gen-pin');
  if(contactNumber.checkValidity() && genPin.checkValidity()){
    let dis_fname = document.getElementById('dis_f_name').value;
    let dis_mname = document.getElementById('dis_m_name').value;
    let dis_lname = document.getElementById('dis_l_name').value;
    let dis_cnum = document.getElementById('dis_c_num').value;
    let dis_pin = document.getElementById('gen-pin').value;
    const registerDispatch = new XMLHttpRequest();
    registerDispatch.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){
        if(this.responseText == "registered"){
          warningsRegistered('Dispatcher already registered');
        }
        else if(this.responseText == "success"){
          warningsSuccess('Dispatcher successfully registered');
          document.getElementById('dis_f_name').value = "";
          document.getElementById('dis_m_name').value = "";
          document.getElementById('dis_l_name').value = "";
          document.getElementById('dis_c_num').value = "";
          document.getElementById('gen-pin').value = "";
          retrieveRegisteredDispatcher();
        }
        else if(this.responseText == "error"){
          warningsError('Something went wrong');
        }
        else if(this.responseText == "incomplete"){
          warningsIncomplete('Please fill all the fields');
        }
        else{
          warningsError('Something went wrong');
        }
      }
    };
    registerDispatch.open("POST", "../admin_dispatcher_process.php", true);
    registerDispatch.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    registerDispatch.send("dis_fname=" + dis_fname + "&dis_mname=" + dis_mname + "&dis_lname=" + dis_lname + "&dis_cnum=" + dis_cnum + "&dis_pin=" + dis_pin);
  }else{
    warningsIncomplete('Invalid input');
  }
}

function dutyChange(data){
  const changeDuty = new XMLHttpRequest();
  changeDuty.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
      if(this.responseText == "true"){
        warningsSuccess("Dispatcher is on duty");
        retrieveRegisteredDispatcher();
      }
      else if(this.responseText == "false"){
        warningsSuccess("Dispatcher is not on duty");
        retrieveRegisteredDispatcher();
        ws.send(data);
      }
      else if(this.responseText == "error"){
        warningsError('Something went wrong');
      }
      else{
        warningsError('Something went wrong');
      }
    }
  }
  changeDuty.open("POST", "../admin_dispatching_process.php", true);
  changeDuty.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  changeDuty.send("data=" + data);
}

function pinGenerator(){
  document.getElementById('gen-pin').value = Math.floor(1000 + Math.random() * 9000);
}

function deleteDispatcher(data){
  if(confirm(data + " will be deleted from the list.")){
    const delDispatcher = new XMLHttpRequest();
    delDispatcher.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){
        if(this.responseText == "success"){
          retrieveRegisteredDispatcher();
          warningsSuccess('Dispatcher successfully removed');
          ws.send(data);
        }
        else if(this.responseText == "error"){
          warningsError('Something went wrong');
        }
        else{
          warningsError('Something went wrong');
        }
        console.log(this.responseText);
      }
    }
    delDispatcher.open("POST", "../admin_delete_dispatcher.php", true);
    delDispatcher.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    delDispatcher.send("data=" + data);
  }
}

retrieveRegisteredDispatcher();
