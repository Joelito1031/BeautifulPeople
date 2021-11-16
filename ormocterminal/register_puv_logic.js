var parameter = null;

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

function registerVehicle(){
  let contactNumber = document.getElementById('c_num');
  let plateNumber = document.getElementById('plate_no');
  Loader.open();
  if(contactNumber.checkValidity() && plateNumber.checkValidity()){
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
        let plate_no = document.getElementById('plate_no').value;
        let rt = document.getElementById('rt').value;
        let cpcty = document.getElementById('cpcty').value;
        if(cpcty > 50){
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
                document.getElementById('vehicle-qrimage').src = '../qrs/' + this.responseText + '.png'; //used
                document.getElementById('vehicle-plateno').innerHTML = this.responseText;
                popupSuccess('Vehicle successfully registered');
                let f_name = document.getElementById('f_name').value = '';
                let m_name = document.getElementById('m_name').value = '';
                let l_name = document.getElementById('l_name').value = '';
                let c_num = document.getElementById('c_num').value = '';
                let plate_no = document.getElementById('plate_no').value = '';
                let rt = document.getElementById('rt').value = '';
                let cpcty = document.getElementById('cpcty').value = '';
              }
              else{
                popupError('Something went wrong');
              }
              console.log(this.responseText);
            }
          };
          registerPUV.open("POST", "../admin_registering_vehicle_process.php", true);
          registerPUV.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          registerPUV.send("fname=" + f_name + "&mname=" + m_name + "&lname=" + l_name + "&suffix=" + suffix + "&cnum=" + c_num + "&plateno=" + plate_no + "&route=" + rt + "&capacity=" + cpcty);
        }
      }
    }
  }else{
    popupWarning('Invalid input');
  }
}

function saveVehiclePDF(){
  var element_1 = document.getElementById('vehicle-for-print');
  html2pdf(element_1, {
    filename: parameter + '.pdf'
  });
}

const makeItCorrect = (value) => {
  const input = value.toLowerCase();
  if(input.charAt(0) == ' '){
    return '';
  }else{
    const finalValue = input.charAt(0).toUpperCase() + input.slice(1);
    return finalValue;
  }
}
