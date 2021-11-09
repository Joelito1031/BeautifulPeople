var parameter = null;

function registerVehicle(){
  let contactNumber = document.getElementById('c_num');
  let plateNumber = document.getElementById('plate_no');
  if(contactNumber.checkValidity() && plateNumber.checkValidity()){
    let f_name = document.getElementById('f_name').value;
    let m_name = document.getElementById('m_name').value;
    let l_name = document.getElementById('l_name').value;
    let c_num = document.getElementById('c_num').value;
    let plate_no = document.getElementById('plate_no').value;
    let rt = document.getElementById('rt').value;
    let cpcty = document.getElementById('cpcty').value;
    parameter = plate_no + '_' + rt;
    const registerPUV = new XMLHttpRequest();
    registerPUV.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){
        if(this.responseText == "registered"){
          // warnings('#F7DC6F', 'Vehicle already registered');
          warningsRegistered('Vehicle Already Registered!');
        }
        else if(this.responseText == "error"){
          warningsError('Something went wrong');
        }
        else if(this.responseText == "incomplete"){
          warningsIncomplete('Please fill all the fields');
        }
        else if(this.responseText == plate_no){
          document.getElementById('vehicle-qrimage').src = '../qrs/' + this.responseText + '.png'; //used
          document.getElementById('vehicle-plateno').innerHTML = this.responseText;
          warningsSuccess('Vehicle successfully registered');
          let f_name = document.getElementById('f_name').value = '';
          let m_name = document.getElementById('m_name').value = '';
          let l_name = document.getElementById('l_name').value = '';
          let c_num = document.getElementById('c_num').value = '';
          let plate_no = document.getElementById('plate_no').value = '';
          let rt = document.getElementById('rt').value = '';
          let cpcty = document.getElementById('cpcty').value = '';
        }
        else{
          warningsError('Something went wrong');
        }
        console.log(this.responseText);
      }
    };
    registerPUV.open("POST", "../admin_registering_vehicle_process.php", true);
    registerPUV.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    registerPUV.send("fname=" + f_name + "&mname=" + m_name + "&lname=" + l_name + "&cnum=" + c_num + "&plateno=" + plate_no + "&route=" + rt + "&capacity=" + cpcty);
  }else{
    warningsIncomplete('Invalid input');
  }
}

function saveVehiclePDF(){
  var element_1 = document.getElementById('vehicle-for-print');
  html2pdf(element_1, {
    filename: parameter + '.pdf'
  });
} 
