var parameter = null;

document.getElementById("three").classList.add("active");

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
  window.scrollTo({ top: 0, behavior: 'smooth' });
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

const choosenFile = document.getElementById('profile-pic');

function registerVehicle(){
  let contactNumber = document.getElementById('c_num');
  let plateNumber = document.getElementById('plate_no');
  Loader.open();
  if(contactNumber.checkValidity() && plateNumber.checkValidity()){
    let f_name = document.getElementById('f_name').value;
    let m_name = document.getElementById('m_name').value;
    let l_name = document.getElementById('l_name').value;
    let df_name = document.getElementById('df_name').value;
    let dm_name = document.getElementById('dm_name').value;
    let dl_name = document.getElementById('dl_name').value;
    let invalid_str = /\d/;
    if(invalid_str.test(f_name) || invalid_str.test(m_name) || invalid_str.test(l_name) || invalid_str.test(df_name) || invalid_str.test(dm_name) || invalid_str.test(dl_name)){
      Loader.close();
      popupWarning('Numbers are not allowed in names');
    }else{
      let invalid_char = /[!"#$%&'()*+,-./:;<=>?@[\]^_`{|}~]/g;
      if(invalid_char.test(f_name) || invalid_char.test(m_name) || invalid_char.test(l_name) || invalid_char.test(df_name) || invalid_char.test(dm_name) || invalid_char.test(dl_name)){
        Loader.close();
        popupWarning('Special characters are not allowed in names');
      }else{
        let suffix = document.getElementById('suffix').value;
        let dsuffix = document.getElementById('dsuffix').value;
        let c_num = document.getElementById('c_num').value;
        let dc_num = document.getElementById('dc_num').value;
        let address = document.getElementById('address').value;
        let daddress = document.getElementById('daddress').value;
        let plate_no = document.getElementById('plate_no').value;
        let rt = document.getElementById('rt').value;
        let cpcty = document.getElementById('cpcty').value;
        if(cpcty > 50 || cpcty < 0){
          Loader.close();
          popupWarning('Capacity exceeds the limitations');
        }else{
          parameter = plate_no + '_' + rt;
          const registerPUV = new XMLHttpRequest();
          registerPUV.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
              Loader.close();
              if(this.responseText == "registered"){
                popupInfo('Vehicle Already Registered!');
              }
              else if(this.responseText == "error"){
                popupError('Something went wrong');
              }
              else if(this.responseText == "incomplete"){
                popupWarning('Please fill all the fields');
              }
              else if(this.responseText == plate_no){
                uploadThePhoto(plate_no);
                document.getElementById('vehicle-qrimage').src = '../qrs/' + this.responseText + '.png'; //used
                document.getElementById('vehicle-plateno').innerHTML = this.responseText;
                document.getElementById('f_name').value = '';
                document.getElementById('m_name').value = '';
                document.getElementById('l_name').value = '';
                document.getElementById('c_num').value = '';
                document.getElementById('address').value = '';
                document.getElementById('df_name').value = '';
                document.getElementById('dm_name').value = '';
                document.getElementById('dl_name').value = '';
                document.getElementById('dc_num').value = '';
                document.getElementById('daddress').value = '';
                document.getElementById('plate_no').value = '';
                document.getElementById('rt').value = '';
                document.getElementById('cpcty').value = '';
                document.getElementById('suffix').value = '';
                document.getElementById('dsuffix').value = '';
              }
              else{
                popupError('Something went wrong');
              }
              console.log(this.responseText);
            }
          };
          registerPUV.open("POST", "../admin_registering_vehicle_process.php", true);
          registerPUV.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          registerPUV.send("fname=" + f_name.trim() + "&mname=" + m_name.trim() + "&lname=" + l_name.trim() + "&suffix=" + suffix + "&cnum=0"
                            + c_num + "&plateno=" + plate_no + "&route=" + rt + "&capacity=" + cpcty + "&address=" + address + "&dfname=" + df_name.trim()
                            + "&dmname=" + dm_name.trim() + "&dlname=" + dl_name.trim() + "&dsuffix=" + dsuffix + "&dcnum=0" + dc_num + "&daddress=" + daddress);
        }
      }
    }
  }else{
    Loader.close();
    popupWarning('Invalid input, please recheck all the fields');
  }
}


const uploadThePhoto = (plateno) => {
  if(choosenFile.value == ''){
    Loader.close();
    popupSuccess('PUV successfully registered');
  }else{
    const formData = new FormData();
    const file = choosenFile.files[0];
    formData.append('profile-pic', file, file.name);
    formData.append('plateno', plateno);
    const uploadPhoto = new XMLHttpRequest();
    uploadPhoto.open('POST', '../admin_upload_vehicle_photo.php', true);
    uploadPhoto.onload = function(){
      if(uploadPhoto.status == 200){
        Loader.close();
        if(this.responseText == 'notapic'){
          popupInfo("Image is not acceptable, vehicle information is saved with default profile picture");
        }else if(this.responseText == 'fileexist'){
          popupInfo("Image already exist, vehicle information is saved with default profile picture");
        }else if(this.responseText == 'sizelimit'){
          popupInfo("Image exceed size limit, vehicle information is saved with default profile picture");
        }else if(this.responseText == 'upload'){
          popupSuccess("PUV successfully registered");
          document.getElementById('actual-pic').src = "../vehicle_images/vehicleImage.png";
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



function saveVehiclePDF(){
  var element_1 = document.getElementById('vehicle-for-print');
  html2pdf(element_1, {
    filename: parameter + '.pdf'
  });
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
      tempName = tempName + name[i];
    }
  }
  return finalName.trim();
}

function exit(){
  window.location.replace('../admin_out.php');
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

function resetImage(){
  document.getElementById('actual-pic').src = '../vehicle_images/vehicleImage.png';
  choosenFile.value = '';
}
