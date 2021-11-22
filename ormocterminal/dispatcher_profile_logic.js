document.getElementById("seven").classList.add("active");

let pinState = '';
let profileState = '';

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

function retrieveRegisteredDispatcher(){
  Loader.open();
  const retrieveDispatcher = new XMLHttpRequest();
  retrieveDispatcher.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
      Loader.close();
      document.querySelector('.dispatchers-table-profile').innerHTML = this.responseText;
    }else{
      Loader.open();
    }
  }
  retrieveDispatcher.open("POST", "../admin_dispatcher_editable_list.php", true);
  retrieveDispatcher.send();
}


function deleteDispatcher(data, name){
  Swal.fire({
  title: 'Are you sure you want to remove ' + name + '?',
  showCancelButton: true,
  confirmButtonText: 'Unregister',
  }).then((result) => {
    if (result.isConfirmed) {
      Loader.open();
      const delDispatcher = new XMLHttpRequest();
      delDispatcher.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
          Loader.close();
          if(this.responseText == "success"){
            retrieveRegisteredDispatcher();
            Swal.fire('Dispatcher successfully removed', '', 'success');
          }else if(this.responseText == "error"){
            popupError('Something went wrong');
          }else if(this.responseText == "notallowed"){
            popupInfo('Dispatcher is on duty, deletion is restricted');
          }else{
            popupError('Something went wrong');
          }
          console.log(this.responseText);
        }else{
          Loader.close();
          popupError('Failed to remove dispatcher');
        }
      }
      delDispatcher.open("POST", "../admin_delete_dispatcher.php", true);
      delDispatcher.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      delDispatcher.send("data=" + data);
    } else if (result.isDenied) {
      Swal.fire('Nothing has been done.', '', 'info')
    }
  })
}

retrieveRegisteredDispatcher();

const choosenFile = document.getElementById('profile-pic');

const editDispatcher = (id, fname, mname, lname, suffix, contact, profile, pin, address) => {
  const name = fname + " " + mname + " " + lname + " " + suffix;
  document.getElementById('modalTitle').innerHTML = name;
  document.getElementById('dis_f_name').value = fname;
  document.getElementById('dis_m_name').value = mname;
  document.getElementById('dis_l_name').value = lname;
  document.getElementById('suffix').value = suffix;
  document.getElementById('dis_c_num').value = contact.slice(1);
  document.getElementById('address').value = address;
  profileState = profile;
  if(profile == ''){
    document.getElementById('actual-pic').src = "../dispatcher_profile/adminUserProfile.png";
  }else{
    document.getElementById('actual-pic').src = "." + profile;
  }
  document.getElementById('save-button').value = id;
  document.getElementById('gen-pin').value = pin;
  profilePic = profile;
  pinState = pin;
}

function pinGenerator(){
  document.getElementById('gen-pin').value = Math.floor(1000 + Math.random() * 9000);
}

const openFile = () => {
  document.getElementById('profile-pic').click();
}

choosenFile.addEventListener("change", function(){
  previewFile();
});

const previewFile = () => {
  const actualPic = document.getElementById('actual-pic');
  const pic = choosenFile.files[0];
  if(pic){
    const picReader = new FileReader();
    picReader.readAsDataURL(pic);
    picReader.addEventListener("load", function(){
      actualPic.src = this.result;
    });
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

const saveEditedData = (value) => {
  let contactNumber = document.getElementById('dis_c_num');
  let genPin = document.getElementById('gen-pin');
  Loader.open();
  if(contactNumber.checkValidity() && genPin.checkValidity()){
    let changepin = false;
    if(pinState != genPin.value){
      changepin = 'true';
    }
    let dis_fname = document.getElementById('dis_f_name').value;
    let dis_mname = document.getElementById('dis_m_name').value;
    let dis_lname = document.getElementById('dis_l_name').value;
    let invalid_str = /\d/;
    if(invalid_str.test(dis_fname) || invalid_str.test(dis_mname) || invalid_str.test(dis_lname)){
      Loader.close();
      popupWarning('An invalid input was detected, please recheck all the fields');
    }else{
      let invalid_char = /[!"#$%&'()*+,-./:;<=>?@[\]^_`{|}~]/g;
      if(invalid_char.test(dis_fname) || invalid_char.test(dis_mname) || invalid_char.test(dis_lname)){
        Loader.close();
        popupWarning('An invalid input was detected, please recheck all the fields');
      }else{
        let dis_cnum = document.getElementById('dis_c_num').value;
        let dis_pin = document.getElementById('gen-pin').value;
        let dis_suffix = document.getElementById('suffix').value;
        let address = document.getElementById('address').value;
        let name = dis_fname.trim() + dis_mname.trim() + dis_lname.trim() + dis_suffix.trim();
        const registerDispatch = new XMLHttpRequest();
        registerDispatch.onreadystatechange = function(){
          if(this.readyState == 4 && this.status == 200){
            if(this.responseText == "success"){
              uploadThePhoto(value, name);
            }else if(this.responseText == "nochanges"){
              if(choosenFile.value != ''){
                uploadThePhoto(value, name);
              }else{
                Loader.close();
                popupWarning('No changes are made');
              }
            }else if(this.responseText == "pinexist"){
              Loader.close();
              popupError('PIN already used, please generate another one');
            }else if(this.responseText == "error"){
              Loader.close();
              popupError('Something went wrong');
            }else if(this.responseText == "incomplete"){
              Loader.close();
              popupWarning('Please fill all the fields');
            }else if(this.responseText == "notallowed"){
              popupInfo("Cannot edit a dispatcher that is on duty");
            }else{
              Loader.close();
              popupError('Something went wrong');
            }
            console.log(this.responseText);
            $('#popupEdit').modal('hide')
          }else{
            Loader.close();
            $('#popupEdit').modal('hide')
            popupError("Failed to save changes");
          }
        }
        registerDispatch.open("POST", "../admin_register_edited_dispatcher.php", true);
        registerDispatch.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        registerDispatch.send("dis_fname=" + dis_fname.trim() + "&dis_mname=" + dis_mname.trim() + "&dis_lname=" + dis_lname.trim() + "&dis_suffix=" + dis_suffix + "&dis_cnum=" + "0" + dis_cnum + "&dis_pin=" + dis_pin + "&id=" + value + "&changepin=" + changepin + "&address=" + address);
      }
    }
  }else{
    Loader.close();
    popupWarning('An invalid input was detected, please recheck all the fields');
  }
}

const uploadThePhoto = (dispatcherId, dispatcherName) => {
  if(choosenFile.value == ''){
    Loader.close();
    popupSuccess("Changes are successfully saved");
    retrieveRegisteredDispatcher();
  }else{
    const formData = new FormData();
    const file = choosenFile.files[0];
    formData.append('profile-pic', file, file.name);
    formData.append('id', dispatcherId);
    formData.append('name', dispatcherName);
    const uploadPhoto = new XMLHttpRequest();
    uploadPhoto.open('POST', '../admin_upload_dispatcher_edited_photo.php', true);
    uploadPhoto.onload = function(){
      if(uploadPhoto.status == 200){
        Loader.close();
        if(this.responseText == 'notapic'){
          popupInfo("Image is not acceptable, dispatcher information is saved with default profile picture");
        }else if(this.responseText == 'fileexist'){
          popupInfo("Image already exist, dispatcher information is saved with default profile picture");
        }else if(this.responseText == 'sizelimit'){
          popupInfo("Image exceed size limit, dispatcher information is saved with default profile picture");
        }else if(this.responseText == 'upload'){
          choosenFile.value = '';
          popupSuccess("Dispatcher successfully edited");
        }else if(this.responseText == 'error'){
          popupError("Something went wrong, dispatcher information is saved with default profile picture");
        }else if(this.responseText == 'notallowed'){
          popupInfo("All is well except the photo");
        }else{
          popupError("Something went wrong, dispatcher information is saved with default profile picture");
        }
        choosenFile.value = "";
        retrieveRegisteredDispatcher();
        console.log(this.responseText);
      }else{
        Loader.close();
        popupError("Failed to upload the photo");
      }
    };
    uploadPhoto.send(formData);
  }
}

function searchDispatcher(value){
  if(document.getElementById('search-input').value == ''){
    document.getElementById('search-ico').style.display = "inline";
    document.getElementById('loading-ico').style.display = "none";
    retrieveRegisteredDispatcher()
  }else{
    const retrieveDispatcher= new XMLHttpRequest();
    retrieveDispatcher.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){
        if(this.responseText != ""){
          document.getElementById('search-ico').style.display = "inline";
          document.getElementById('loading-ico').style.display = "none";
          document.querySelector('.dispatchers-table-profile').innerHTML = this.responseText;
        }else{
          document.getElementById('search-ico').style.display = "none";
          document.getElementById('loading-ico').style.display = "inline";
        }
      }else{
        document.getElementById('search-ico').style.display = "inline";
        document.getElementById('loading-ico').style.display = "none";
      }
    }
    retrieveDispatcher.open("POST", "../admin_search_dispatcher_profile.php", true);
    retrieveDispatcher.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    retrieveDispatcher.send("search=" + value);
  }
}

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
