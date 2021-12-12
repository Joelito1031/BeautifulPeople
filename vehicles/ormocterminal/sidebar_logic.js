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

let act = '';

function loadAdminImage(){
  const loadImage = new XMLHttpRequest();
  loadImage.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
      if(this.responseText == 'error'){
        document.getElementById('message').innerHTML = "Something is wrong";
      }else{
        let data = JSON.parse(this.responseText);
        document.getElementById('admin-profile-pic').src = '../auth_process/' + data.profile;
        document.getElementById('profile-image').src = '../auth_process/' + data.profile;
        document.getElementById('replacement-pic').src = '../auth_process/' + data.profile;
        document.getElementById('edit-uname').innerHTML = data.name;
        document.getElementById('uname').innerHTML = data.name;
        document.getElementById('admin-name').innerHTML = data.name;
      }
      console.log(this.responseText);
    }
  }
  loadImage.open("POST", "../auth_process/auth_process_load_image.php", true);
  loadImage.send();
}

loadAdminImage();

function authenticate(){
  let password = document.getElementById('pass_word').value;
  const authenticate = new XMLHttpRequest();
  authenticate.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
      if(this.responseText == 'success'){
        document.getElementById('message').innerHTML = '';
        $('#authentication-modal').modal('hide');
        if(act == 'reset'){
          checkAuthForReset();
        }else if(act == 'edit'){
          $('#editModal').modal('show');
        }
      }else if(this.responseText == 'fail'){
        document.getElementById('message').innerHTML = 'Authentication failed';
      }else{
        document.getElementById('message').innerHTML = 'Something went wrong';
      }
      console.log(this.responseText);
    }
  }
  authenticate.open("POST", "../admin_password_auth.php", true);
  authenticate.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  authenticate.send("pass=" + password);
}

function checkAuth(action){
  const checkAuth = new XMLHttpRequest();
  checkAuth.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
      if(this.responseText == 'authorized'){
        if(action == 'edit'){
          $('#editModal').modal('show');
        }else if(action == 'reset'){
          checkAuthForReset();
        }
      }else if(this.responseText == 'notauthorized'){
        if(action == 'edit'){
          act = 'edit';
        }else if(action == 'reset'){
          act = 'reset';
        }
        $('#authentication-modal').modal('show')
      }
    }
  }
  checkAuth.open("POST", "../admin_check_auth.php", true);
  checkAuth.send();
}

function showPassSignIn(){
 document.getElementById('pass_word').type = 'text';
}

function hidePassSignIn(){
  document.getElementById('pass_word').type = 'password';
}

window.addEventListener('mouseup', function(){
  hidePassSignIn();
})

function openExplorer(){
  document.getElementById('rep-pic').click();
}

const fileChoosen = document.getElementById('rep-pic');

const showChoosenFile = () => {
  const actualPic = document.getElementById('replacement-pic');
  const pic = fileChoosen.files[0];
  if(pic){
    const picReader = new FileReader();
    picReader.readAsDataURL(pic);
    picReader.addEventListener("load", function(){
      actualPic.src = this.result;
    });
  }
}

fileChoosen.addEventListener("change", function(){
  showChoosenFile();
});

document.getElementById('icon').addEventListener('mousedown', function(){
  showPassSignIn();
})

function updateDispatcher(){
  let uname = document.getElementById('admin_u_name').value;
  document.getElementById('pass_word').value = '';
  let profilePicture = document.getElementById('rep-pic').value;
  let oldname = document.getElementById('edit-uname').innerHTML;
  let unset = "true";
  if(uname.trim() == ''){
    if(profilePicture.trim() == ''){
      popupInfo('No changes have been made');
      $('#editModal').modal('hide');
    }else{
      uploadProfileAdmin(oldname);
    }
  }else{
    if(profilePicture.trim() != ''){
      unset = "false";
    }
    const uploadChangedData = new XMLHttpRequest();
    uploadChangedData.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){
        if(this.responseText == 'success'){
          uploadProfileAdmin(uname);
        }else if(this.responseText == 'nochanges'){
          popupInfo("No changes have been made");
          $('#editModal').modal('hide');
        }else if(this.responseText == 'notauthorized'){
          popupWarning("Requirements not meet");
          $('#editModal').modal('hide');
        }else if(this.responseText == 'error'){
          popupError("An error occured updating the profile");
          $('#editModal').modal('hide');
        }else{
          popupError("An error occured updating the profile");
        }
        console.log(this.responseText);
      }
    }
    uploadChangedData.open("POST", "../admin_updating_own_info.php", true);
    uploadChangedData.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    uploadChangedData.send("uname=" + uname + "&unset=" + unset);
  }
}

function uploadProfileAdmin(name){
  if(document.getElementById('rep-pic').value == ''){
    popupSuccess("Changes successfull saved");
    loadAdminImage();
    $('#editModal').modal('hide');
  }else{
    const formData = new FormData();
    const file = fileChoosen.files[0];
    formData.append('profile-pic', file, file.name);
    formData.append('name', name);
    const uploadPhoto = new XMLHttpRequest();
    uploadPhoto.open('POST', '../admin_upload_own_photo.php', true);
    uploadPhoto.onload = function(){
      if(uploadPhoto.status == 200){
        if(this.responseText == 'upload'){
          popupSuccess("Changes successfully saved");
          loadAdminImage();
          $('#editModal').modal('hide');
        }else if(this.responseText == 'notapic'){
          popupWarning("File not supported");
          $('#editModal').modal('hide');
        }else if(this.responseText == 'fileexist'){
          popupWarning("File already exist");
          $('#editModal').modal('hide');
        }else if(this.responseText == "sizelimit"){
          popupWarning("File size exceeds the limit");
          $('#editModal').modal('hide');
        }else if(this.responseText == "error"){
          popupError("Something went wrong");
          $('#editModal').modal('hide');
        }else{
          popupErro("Something went wrong");
          $('#editModal').modal('hide');
        }
      }
    }
    uploadPhoto.send(formData);
  }
}

function checkAuthForReset(){
  Swal.fire({
    title: 'Resetting will load the default admin credentials, you will be logged out in this process.',
    showCancelButton: true,
    confirmButtonText: 'Reset',
  }).then((result) => {
    if (result.isConfirmed) {
      const uploadChangedData = new XMLHttpRequest();
      uploadChangedData.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
          if(this.responseText == 'success'){
            window.location.replace('../admin_out.php');
          }else if(this.responseText == 'fail'){
            popupError("Something went wrong");
          }else if(this.responseText == 'notauthorized'){
            popupWarning("Requirements not meet");
          }else if(this.responseText == 'error'){
            popupError("Something went wrong");
          }else{
            popupError("An error occured updating the profile");
          }
          console.log(this.responseText);
        }
      }
      uploadChangedData.open("POST", "../resett/admin_reset_the_web_app.php", true);
      uploadChangedData.send();
    }else if (result.isDenied) {
      Swal.fire('Nothing has been done.', '', 'info')
    }
  })
}

document.getElementById('pass_word').addEventListener('keyup', function(e){
  if(e.keyCode == '13'){
    authenticate();
  }
})


document.getElementById('admin_u_name').addEventListener('keyup', function(e){
  if(e.keyCode == '13'){
    updateDispatcher();
  }
})
