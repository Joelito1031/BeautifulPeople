document.getElementById("eight").classList.add("active");

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

const choosenFile = document.getElementById('profile-pic');

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
  if(document.getElementById('search-input').value == ''){
    document.getElementById('search-ico').style.display = "inline";
    document.getElementById('loading-ico').style.display = "none";
    retrieveRegisteredPUV();
  }else{
    const retrievePUV = new XMLHttpRequest();
    retrievePUV.onreadystatechange = function(){
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
    retrievePUV.open("POST", "../admin_search_puv_profile.php", true);
    retrievePUV.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    retrievePUV.send("search=" + value.toUpperCase());
  }
}

function editData(fname, mname, lname, suffix, capacity, route, plateno, contact, dfname, dmname, dlname, dsuffix, dcontact, daddress, address, image){
  document.getElementById('modalTitle').innerHTML = plateno;
  document.getElementById('rt').value = route;
  document.getElementById('cpcty').value = capacity;
  document.getElementById('f_name').value = fname;
  document.getElementById('m_name').value = mname;
  document.getElementById('l_name').value = lname;
  document.getElementById('suffix').value = suffix;
  document.getElementById('c_num').value = contact.slice(1);
  document.getElementById('save-button').value = plateno;
  document.getElementById('df_name').value = dfname;
  document.getElementById('dm_name').value = dmname;
  document.getElementById('dl_name').value = dlname;
  document.getElementById('dsuffix').value = dsuffix;
  document.getElementById('dc_num').value = dcontact.slice(1);
  document.getElementById('daddress').value = daddress;
  document.getElementById('address').value = address;
  if(image == ''){
    document.getElementById('actual-pic').src = "../vehicle_images/vehicleImage.png";
  }else{
    document.getElementById('actual-pic').src = "." + image;
  }
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
  let dcontactNumber = document.getElementById('dc_num');
  Loader.open();
  if(contactNumber.checkValidity() && dcontactNumber.checkValidity()){
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
        let dsuffix = document.getElementById('dsuffix').value;
        let suffix = document.getElementById('suffix').value;
        let c_num = document.getElementById('c_num').value;
        let dc_num = document.getElementById('dc_num').value;
        let address = document.getElementById('address').value;
        let daddress = document.getElementById('daddress').value;
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
              if(this.responseText == "notallowed"){
                popupInfo('Cannot edit a vehicle that is on queue');
              }else if(this.responseText == 'nochanges'){
                if(choosenFile.value != ''){
                  uploadThePhoto(value);
                }else{
                  Loader.close();
                  popupWarning('No changes are made');
                }
              }else if(this.responseText == "incomplete"){
                popupWarning('Please fill all the fields');
              }
              else if(this.responseText == "error"){
                popupError('Something went wrong');
              }
              else if(this.responseText == "success"){
                uploadThePhoto(value);
              }
              else{
                popupError('Something went wrong');
              }
              console.log(this.responseText);
              $('#popupEdit').modal('hide');
            }
          };
          registerPUV.open("POST", "../admin_register_edited_puv.php", true);
          registerPUV.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          registerPUV.send("fname=" + f_name.trim() + "&mname=" + m_name.trim() + "&lname=" + l_name.trim() + "&suffix=" + suffix
          + "&cnum=0" + c_num + "&plateno=" + value + "&route=" + rt + "&capacity=" + cpcty + "&dfname=" + df_name.trim() + "&dmname="
          + dm_name.trim() + "&dlname=" + dl_name.trim() + "&dsuffix=" + dsuffix + "&dcnum=0" + dc_num + "&daddress=" + daddress + "&address=" + address);
        }
      }
    }
  }else{
    Loader.close();
    popupWarning('Invalid input');
  }
}


const uploadThePhoto = (plateno) => {
  if(choosenFile.value == ''){
    Loader.close();
    popupSuccess('Changes are successfully saved');
    retrieveRegisteredPUV();
  }else{
    const formData = new FormData();
    const file = choosenFile.files[0];
    formData.append('profile-pic', file, file.name);
    formData.append('plateno', plateno);
    const uploadPhoto = new XMLHttpRequest();
    uploadPhoto.open('POST', '../admin_upload_vehicle_edited_photo.php', true);
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
          popupSuccess("Vehicle successfully edited");
        }else if(this.responseText == 'notallowed'){
          popupInfo("All is well except the photo");
        }else if(this.responseText == 'error'){
          popupError("Something went wrong");
        }else{
          popupError("Something went wrong");
        }
        console.log(this.responseText);
        choosenFile.value = "";
        retrieveRegisteredPUV();
      }else{
        Loader.close();
        popupError("Failed to upload the photo");
      }
    };
    uploadPhoto.send(formData);
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

function exit(){
  window.location.replace('../admin_out.php');
}
