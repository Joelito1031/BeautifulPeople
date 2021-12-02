var ws = new WebSocket('ws://192.168.1.25:8082');

document.getElementById("two").classList.add("active");

function dutyChangeError(message){
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

function dutyChangeSuccess(message){
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

function retrieveRegisteredDispatcher(){
  Loader.open();
  const retrieveDispatcher = new XMLHttpRequest();
  retrieveDispatcher.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
      Loader.close();
      document.querySelector('.dispatchers-table').innerHTML = this.responseText;
    }
  }
  retrieveDispatcher.open("POST", "../admin_dispatchers_list.php", true);
  retrieveDispatcher.send();
}

const choosenFile = document.getElementById('profile-pic');

function registerDispatcher(){
  let contactNumber = document.getElementById('dis_c_num');
  let genPin = document.getElementById('gen-pin');
  Loader.open();
  if(contactNumber.checkValidity() && genPin.checkValidity()){
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
        const registerDispatch = new XMLHttpRequest();
        registerDispatch.onreadystatechange = function(){
          if(this.readyState == 4 && this.status == 200){
            if(this.responseText == "registered"){
              Loader.close();
              popupWarning('Dispatcher already registered');
            }else if(this.responseText == "success"){
              uploadThePhoto(dis_fname, dis_mname, dis_lname, dis_suffix);
              document.getElementById('dis_f_name').value = "";
              document.getElementById('dis_m_name').value = "";
              document.getElementById('dis_l_name').value = "";
              document.getElementById('dis_c_num').value = "";
              document.getElementById('gen-pin').value = "";
              document.getElementById('suffix').value = "";
              document.getElementById('address').value = "";
              choosenFile.value = "";
            }else if(this.responseText == "pinexist"){
              Loader.close();
              popupError('PIN already used, please generate another one');
            }else if(this.responseText == "error"){
              Loader.close();
              popupError('Something went wrong');
            }else if(this.responseText == "incomplete"){
              Loader.close();
              popupWarning('Please fill all the fields');
            }else{
              Loader.close();
              popupError('Something went wrong');
            }
          }
        }
        registerDispatch.open("POST", "../admin_dispatcher_process.php", true);
        registerDispatch.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        registerDispatch.send("dis_fname=" + dis_fname.trim() + "&dis_mname=" + dis_mname.trim() + "&dis_lname=" + dis_lname.trim() + "&dis_suffix=" + dis_suffix + "&dis_cnum=" + "0" + dis_cnum + "&dis_pin=" + dis_pin + "&address=" + address);
      }
    }
  }else{
    Loader.close();
    popupWarning('An invalid input was detected, please recheck all the fields');
  }
}

const uploadThePhoto = (fname, mname, lname, suffix) => {
  if(choosenFile.value == ''){
    Loader.close();
    popupSuccess("Dispatcher successfully registered with default profile picture");
    retrieveRegisteredDispatcher();
  }else{
    const formData = new FormData();
    const file = choosenFile.files[0];
    formData.append('profile-pic', file, file.name);
    formData.append('fname', fname);
    formData.append('mname', mname);
    formData.append('lname', lname);
    formData.append('suffix', suffix);
    const uploadPhoto = new XMLHttpRequest();
    uploadPhoto.open('POST', '../admin_upload_dispatcher_photo.php', true);
    uploadPhoto.onload = function(){
      if(uploadPhoto.status == 200){
        Loader.close();
        if(this.responseText == 'notapic'){
          popupInfo("Image is not acceptable, dispatcher information is saved with default profile picture");
          retrieveRegisteredDispatcher();
        }else if(this.responseText == 'fileexist'){
          popupInfo("Image already exist, dispatcher information is saved with default profile picture");
          retrieveRegisteredDispatcher();
        }else if(this.responseText == 'sizelimit'){
          retrieveRegisteredDispatcher();
          popupInfo("Image exceed size limit, dispatcher information is saved with default profile picture");
        }else if(this.responseText == 'upload'){
          popupSuccess("Dispatcher successfully registered");
          document.getElementById('actual-pic').src = "./images/adminUserProfile.png";
          retrieveRegisteredDispatcher();
        }else if(this.responseText == 'error'){
          popupError("Something went wrong");
        }else{
          popupError("Something went wrong");
        }
        console.log(this.responseText);
      }else{
        Loader.close();
        popupError("Failed to upload the photo");
      }
    };
    uploadPhoto.send(formData);
  }
}

function dutyChange(data){
  Loader.open();
  const changeDuty = new XMLHttpRequest();
  changeDuty.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
      Loader.close();
      if(this.responseText == "true"){
        dutyChangeSuccess("Dispatcher is on duty");
        retrieveRegisteredDispatcher();
      }
      else if(this.responseText == "false"){
        dutyChangeSuccess("Dispatcher is off duty");
        retrieveRegisteredDispatcher();
        ws.send(data);
      }
      else if(this.responseText == "error"){
        dutyChangeError('Something went wrong');
      }
      else{
        dutyChangeError('Something went wrong');
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

retrieveRegisteredDispatcher();

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
      tempName = tempName + name[i];
    }
  }
  return finalName.trim();
}

function exit(){
  window.location.replace('../admin_out.php');
}

function resetImage(){
  document.getElementById('actual-pic').src = './images/adminUserProfile.png';
  choosenFile.value = '';
}
