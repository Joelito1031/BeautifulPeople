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
  const retrievePUV = new XMLHttpRequest();
  retrievePUV.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
      Loader.close();
      document.querySelector('.puvs-table').innerHTML = this.responseText;
    }else{
      Loader.open();
    }
  }
  retrievePUV.open("POST", "../admin_vehicle_editable_list.php", true);
  retrievePUV.send();
}

function searchVehicle(value){
  Loader.open();
  if(document.getElementById('search-input').value == ''){
    document.getElementById('search-ico').style.display = "inline";
    document.getElementById('loading-ico').style.display = "none";
    retrieveRegisteredPUV();
  }else{
    const retrievePUV = new XMLHttpRequest();
    retrievePUV.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){
        Loader.close();
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
    retrievePUV.open("POST", "../admin_search_puv_profile.php", true);
    retrievePUV.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    retrievePUV.send("search=" + value.toUpperCase());
  }
}

function editData(fname, mname, lname, suffix, capacity, route, plateno, contact){
  document.getElementById('modalTitle').innerHTML = plateno;
  document.getElementById('rt').value = route;
  document.getElementById('cpcty').value = capacity;
  document.getElementById('f_name').value = fname;
  document.getElementById('m_name').value = mname;
  document.getElementById('l_name').value = lname;
  document.getElementById('suffix').value = suffix;
  document.getElementById('c_num').value = contact.slice(1);
  document.getElementById('save-button').value = plateno;
}

function deletePUV(plateno){
  Swal.fire({
  title: 'Are you sure you want to remove ' + plateno + '?',
  showCancelButton: true,
  confirmButtonText: 'Unregister',
  }).then((result) => {
    if (result.isConfirmed) {
      Loader.open();
      const delPUV = new XMLHttpRequest();
      delPUV.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
          Loader.close();
          if(this.responseText == "success"){
            retrieveRegisteredPUV();
            Swal.fire('PUV successfully removed', '', 'success');
          }else if(this.responseText == "notallowed"){
            popupInfo('Cannot remove a vehicle that is on queue');
          }else if(this.responseText == "error"){
            popupError('Something went wrong');
          }else{
            popupError('Something went wrong');
          }
          console.log(this.responseText);
        }else{
          Loader.close();
          popupError('Failed to remove dispatcher');
        }
      }
      delPUV.open("POST", "../admin_delete_puv.php", true);
      delPUV.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      delPUV.send("data=" + plateno);
    }else if(result.isDenied) {
      Swal.fire('Nothing has been done.', '', 'info')
    }
  })
}

const saveEditedData = (value) => {
  let contactNumber = document.getElementById('c_num');
  Loader.open();
  if(contactNumber.checkValidity()){
    let f_name = document.getElementById('f_name').value;
    let m_name = document.getElementById('m_name').value;
    let l_name = document.getElementById('l_name').value;
    let invalid_str = /\d/;
    if(invalid_str.test(f_name) || invalid_str.test(m_name) || invalid_str.test(l_name)){
      Loader.close();
      popupWarning('An invalid input was detected, please recheck all the fields');
    }else{
      let invalid_char = /[!"#$%&'()*+,-./:;<=>?@[\]^_`{|}~]/g;
      if(invalid_char.test(f_name) || invalid_char.test(m_name) || invalid_char.test(l_name)){
        Loader.close();
        popupWarning('An invalid input was detected, please recheck all the fields');
      }else{
        let suffix = document.getElementById('suffix').value;
        let c_num = document.getElementById('c_num').value;
        let rt = document.getElementById('rt').value;
        let cpcty = document.getElementById('cpcty').value;
        if(cpcty > 50 || cpcty < 0){
          Loader.close();
          popupWarning('Capacity exceeds the limitations');
        }else{
          parameter = value + '_' + rt;
          const registerPUV = new XMLHttpRequest();
          registerPUV.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
              Loader.close();
              $('#popupEdit').modal('hide');
              if(this.responseText == "notallowed"){
                popupInfo('Cannot edit a vehicle that is on queue');
              }else if(this.responseText == 'nochanges'){
                popupWarning('No changes are made');
              }
              else if(this.responseText == "error"){
                popupError('Something went wrong');
              }
              else if(this.responseText == "success"){
                popupSuccess("Changes are successfully saved");
                retrieveRegisteredPUV();
              }
              else{
                popupError('Something went wrong');
              }
              console.log(this.responseText);
            }
          };
          registerPUV.open("POST", "../admin_register_edited_puv.php", true);
          registerPUV.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          registerPUV.send("fname=" + f_name.trim() + "&mname=" + m_name.trim() + "&lname=" + l_name.trim() + "&suffix=" + suffix + "&cnum=0" + c_num + "&plateno=" + value + "&route=" + rt + "&capacity=" + cpcty);
        }
      }
    }
  }else{
    popupWarning('Invalid input');
  }
}

const makeItCorrect = (value) => {
  let name = value.trim().toLowerCase();
  let tempName = '';
  let repoName = '';
  let finalName = '';
  name = name + ' ';
  nameLength = name.length;
  for(i = 0; i < nameLength; i++){
    if(name[i] == ' '){
      if(tempName != ''){
        repoName = tempName.charAt(0).toUpperCase() + tempName.slice(1) + ' ';
        finalName = finalName + repoName;
        tempName = '';
      }
    }else{
      tempName = tempName + name[i]
    }
  }
  return finalName;
}

retrieveRegisteredPUV();

function exit(){
  window.location.replace('../admin_out.php');
}
