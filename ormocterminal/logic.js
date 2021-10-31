'use strict';

var ws = new WebSocket('ws://192.168.1.21:8082');

function warnings(color, message){
  document.getElementById('admin-dash-warning').style.display = 'block';
  document.getElementById('admin-dash-warning').style.backgroundColor = color;
  document.getElementById('terminate-warning-button').style.backgroundColor = color;
  document.getElementById('warning-message').innerHTML = message;
  document.getElementById('warning-message').style.color = 'white';
  document.getElementById('warning-message').style.fontWeight = 'bold';
}

function closeWarning(){
  document.getElementById('admin-dash-warning').style.display = 'none';
}

function showSortOptions(data){
  if(data == 'moreoptions'){
    document.getElementById('moreoptions').style.display = "block";
  }
}

function unqueueVehicle(data){
  if(confirm("Are you sure you want to unqueue " + data + "?")){
    const unqueuePUV = new XMLHttpRequest();
    unqueuePUV.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){
        if(this.responseText == "success"){
          warnings('#82E0AA', 'Vehicle is successfully unqueued');
        }
        else if(this.responseText == "error"){
          warnings('#E74C3C', 'Something went wrong');
        }
        else{
          warnings('#E74C3C', 'Something went wrong');
        }
        console.log(this.responseText);
      }
    };
    unqueuePUV.open("POST", "../admin_unqueue_vehicle.php", true);
    unqueuePUV.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    unqueuePUV.send("data=" + data);
  }
}

function loadQueuingVehicles(){
  if(document.getElementById('searched-destination').value != ''){
    let searchedDestination = document.getElementById('searched-destination').value;
    const queuingVehicles = new XMLHttpRequest();
    queuingVehicles.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){
        document.querySelector('.subfield-6-1-sub').innerHTML = this.responseText;
      }
    };
    queuingVehicles.open("POST", "../admin_queuing_vehicles_list.php", true);
    queuingVehicles.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    queuingVehicles.send("data=" + searchedDestination);
  }else{
    const queuingVehicles = new XMLHttpRequest();
    queuingVehicles.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){
        document.querySelector('.subfield-6-1-sub').innerHTML = this.responseText;
      }
    };
    queuingVehicles.open("POST", "../admin_queuing_vehicles_list.php", true);
    queuingVehicles.send();
  }
}

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

function loadReturningVehicles(){
  if(document.getElementById('searched-returning').value != ''){
    let searchedReturning = document.getElementById('searched-returning').value;
    const returningVehicles = new XMLHttpRequest();
    returningVehicles.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){
        document.querySelector('.subfield-4-1-sub').innerHTML = this.responseText;
      }
    };
    returningVehicles.open("POST", "../admin_returning_vehicle_list.php", true);
    returningVehicles.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    returningVehicles.send("data=" + searchedReturning);
  }else{
    const returningVehicles = new XMLHttpRequest();
    returningVehicles.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){
        document.querySelector('.subfield-4-1-sub').innerHTML = this.responseText;
      }
    };
    returningVehicles.open("POST", "../admin_returning_vehicle_list.php", true);
    returningVehicles.send();
  }
}

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
    const registerPUV = new XMLHttpRequest();
    registerPUV.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){
        if(this.responseText == "registered"){
          warnings('#F7DC6F', 'Vehicle already registered');
        }
        else if(this.responseText == "error"){
          warnings('#E74C3C', 'Something went wrong');
        }
        else if(this.responseText == "incomplete"){
          warnings('#F7DC6F', 'Please fill all the fields');
        }
        else if(this.responseText == plate_no){
          document.getElementById('vehicle-qrimage').src = '../qrs/' + this.responseText + '.png'; //used
          document.getElementById('vehicle-plateno').innerHTML = this.responseText;
          warnings('#82E0AA', 'Vehicle successfully registered');
          let f_name = document.getElementById('f_name').value = '';
          let m_name = document.getElementById('m_name').value = '';
          let l_name = document.getElementById('l_name').value = '';
          let c_num = document.getElementById('c_num').value = '';
          let plate_no = document.getElementById('plate_no').value = '';
          let rt = document.getElementById('rt').value = '';
          let cpcty = document.getElementById('cpcty').value = '';
        }
        else{
          warnings('#E74C3C', 'Something went wrong');
        }
      }
    };
    registerPUV.open("POST", "../admin_registering_vehicle_process.php", true);
    registerPUV.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    registerPUV.send("fname=" + f_name + "&mname=" + m_name + "&lname=" + l_name + "&cnum=" + c_num + "&plateno=" + plate_no + "&route=" + rt + "&capacity=" + cpcty);
  }else{
    warnings('#F7DC6F', 'Invalid input');
  }
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

retrieveRegisteredDispatcher();

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
          warnings('#F7DC6F', 'Dispatcher already registered');
        }
        else if(this.responseText == "success"){
          warnings('#82E0AA', 'Dispatcher successfully registered');
          document.getElementById('dis_f_name').value = "";
          document.getElementById('dis_m_name').value = "";
          document.getElementById('dis_l_name').value = "";
          document.getElementById('dis_c_num').value = "";
          document.getElementById('gen-pin').value = "";
          retrieveRegisteredDispatcher();
        }
        else if(this.responseText == "error"){
          warnings('#E74C3C', 'Something went wrong');
        }
        else if(this.responseText == "incomplete"){
          warnings('#F7DC6F', 'Please fill all the fields');
        }
        else{
          warnings('#E74C3C', 'Something went wrong');
        }
      }
    };
    registerDispatch.open("POST", "../admin_dispatcher_process.php", true);
    registerDispatch.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    registerDispatch.send("dis_fname=" + dis_fname + "&dis_mname=" + dis_mname + "&dis_lname=" + dis_lname + "&dis_cnum=" + dis_cnum + "&dis_pin=" + dis_pin);
  }else{
    warnings('#F7DC6F', 'Invalid input');
  }
}

function retrieveLogs(){
  let data = document.getElementById('sort-option').value;
  if(data == 'latest'){
    const logs = new XMLHttpRequest();
    logs.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){
        document.querySelector('.subfield-7-1-sub').innerHTML = this.responseText;
      }
    }
    logs.open('POST', '../admin_retrieve_logs.php', true);
    logs.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    logs.send("data=" + data);
  }else if(data == 'oldest'){
    const logs = new XMLHttpRequest();
    logs.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){
        document.querySelector('.subfield-7-1-sub').innerHTML = this.responseText;
      }
    }
    logs.open('POST', '../admin_retrieve_logs.php', true);
    logs.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    logs.send("data=" + data);
  }else if(data == 'moreoptions'){
    document.getElementById('moreoptions').style.display = "block";
    let startDate = document.getElementById('start-date').value;
    let endDate = document.getElementById('end-date').value;
    if(startDate != '' && endDate != ''){
      const logs = new XMLHttpRequest();
      logs.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
          document.querySelector('.subfield-7-1-sub').innerHTML = this.responseText;
        }
      }
      logs.open('POST', '../admin_retrieve_logs.php', true);
      logs.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      logs.send("startdate=" + startDate + "&enddate=" + endDate);
    }
  }
}

function exit(){
  window.location.replace('../admin_out.php');
}

setInterval(function(){
  loadQueuingVehicles();
  loadReturningVehicles();
  loadWaitingPassengers();
  retrieveLogs();
}, 1500);


let x_one = document.querySelector('.subfield-0-1');
let a_one = document.querySelector('.subfield-1-1');
let a_two = document.querySelector('.subfield-1-2');
let b_one = document.querySelector('.subfield-2-1');
let b_two = document.querySelector('.subfield-2-2');
let c_one = document.querySelector('.subfield-3-1');
let c_two = document.querySelector('.subfield-3-2');
let d_one = document.querySelector('.subfield-4-1');
let d_two = document.querySelector('.subfield-4-2');
let e_one = document.querySelector('.subfield-5-1');
let f_one = document.querySelector('.subfield-6-1');
let f_two = document.querySelector('.subfield-6-2');
let g_one = document.querySelector('.subfield-7-1');
let g_two = document.querySelector('.subfield-7-2');
let subt1 = document.querySelector('.sub-text-1');
let subt2 = document.querySelector('.sub-text-2');
let subt3 = document.querySelector('.sub-text-3');
let subt4 = document.querySelector('.sub-text-4');
let subt5 = document.querySelector('.sub-text-5');
let subt6 = document.querySelector('.sub-text-6');
let subt7 = document.querySelector('.sub-text-7');
let subt8 = document.querySelector('.sub-text-8');
let span_a = document.querySelector('.a');
let span_b = document.querySelector('.b');
let span_c = document.querySelector('.c');
let span_d = document.querySelector('.d');
let span_e = document.querySelector('.e');
let span_f = document.querySelector('.f');
let span_g = document.querySelector('.g');
let span_h = document.querySelector('.h');
let span_value_a = getComputedStyle(span_a);
let span_value_b = getComputedStyle(span_b);
let span_value_c = getComputedStyle(span_c);
let span_value_d = getComputedStyle(span_d);
let span_value_e = getComputedStyle(span_e);
let span_value_f = getComputedStyle(span_f);
let span_value_g = getComputedStyle(span_g);
let span_value_h = getComputedStyle(span_h);
let btns_1 = document.querySelector('.btns-1');
let btns_2 = document.querySelector('.btns-2');
let btns_3 = document.querySelector('.btns-3');
let btns_4 = document.querySelector('.btns-4');
let btns_5 = document.querySelector('.btns-5');
let btns_6 = document.querySelector('.btns-6');
let btns_7 = document.querySelector('.btns-7');
let btns_8 = document.querySelector('.btns-8');
var parameter_passenger = null;

function checkSize(){
  if(window.innerWidth <= '609'){
    span_a.style.width = '50px';
    span_b.style.width = '50px';
    span_c.style.width = '50px';
    span_d.style.width = '50px';
    span_e.style.width = '50px';
    span_f.style.width = '50px';
    span_g.style.width = '50px';
    span_h.style.width = '50px';
    document.querySelector('.show-btn').style.display = 'none';
    document.querySelector('.one-ttl').style.display = 'none';
    document.querySelector('.two-ttl').style.display = 'none';
    document.querySelector('.three-ttl').style.display = 'none';
    document.querySelector('.four-ttl').style.display = 'none';
    document.querySelector('.five-ttl').style.display = 'none';
    document.querySelector('.six-ttl').style.display = 'none';
    document.querySelector('.seven-ttl').style.display = 'none';
    document.querySelector('.eight-ttl').style.display = 'none';
    document.querySelector('.ttl-pic-one').style.display = 'inline-block';
    document.querySelector('.ttl-pic-two').style.display = 'inline-block';
    document.querySelector('.ttl-pic-three').style.display = 'inline-block';
    document.querySelector('.ttl-pic-four').style.display = 'inline-block';
    document.querySelector('.ttl-pic-five').style.display = 'inline-block';
    document.querySelector('.ttl-pic-six').style.display = 'inline-block';
    document.querySelector('.ttl-pic-seven').style.display = 'inline-block';
    document.querySelector('.ttl-pic-eight').style.display = 'inline-block';
  }
  else{
    document.querySelector('.show-btn').style.display = 'inline-block';
  }
}

window.addEventListener('resize', checkSize);

function showNav(){
  if(span_value_a.width == '200px'){
    span_a.style.width = '50px';
    span_b.style.width = '50px';
    span_c.style.width = '50px';
    span_d.style.width = '50px';
    span_e.style.width = '50px';
    span_f.style.width = '50px';
    span_g.style.width = '50px';
    span_h.style.width = '50px';
    document.querySelector('.one-ttl').style.display = 'none';
    document.querySelector('.two-ttl').style.display = 'none';
    document.querySelector('.three-ttl').style.display = 'none';
    document.querySelector('.four-ttl').style.display = 'none';
    document.querySelector('.five-ttl').style.display = 'none';
    document.querySelector('.six-ttl').style.display = 'none';
    document.querySelector('.seven-ttl').style.display = 'none';
    document.querySelector('.eight-ttl').style.display = 'none';
    document.querySelector('.ttl-pic-one').style.display = 'inline-block';
    document.querySelector('.ttl-pic-two').style.display = 'inline-block';
    document.querySelector('.ttl-pic-three').style.display = 'inline-block';
    document.querySelector('.ttl-pic-four').style.display = 'inline-block';
    document.querySelector('.ttl-pic-five').style.display = 'inline-block';
    document.querySelector('.ttl-pic-six').style.display = 'inline-block';
    document.querySelector('.ttl-pic-seven').style.display = 'inline-block';
    document.querySelector('.ttl-pic-eight').style.display = 'inline-block';
  }
  else{
    span_a.style.width = '200px';
    span_b.style.width = '200px';
    span_c.style.width = '200px';
    span_d.style.width = '200px';
    span_e.style.width = '200px';
    span_f.style.width = '200px';
    span_g.style.width = '200px';
    span_h.style.width = '200px';
    document.querySelector('.one-ttl').style.display = 'inline';
    document.querySelector('.two-ttl').style.display = 'inline';
    document.querySelector('.three-ttl').style.display = 'inline';
    document.querySelector('.four-ttl').style.display = 'inline';
    document.querySelector('.five-ttl').style.display = 'inline';
    document.querySelector('.six-ttl').style.display = 'inline';
    document.querySelector('.seven-ttl').style.display = 'inline';
    document.querySelector('.eight-ttl').style.display = 'inline';
    document.querySelector('.ttl-pic-one').style.display = 'none';
    document.querySelector('.ttl-pic-two').style.display = 'none';
    document.querySelector('.ttl-pic-three').style.display = 'none';
    document.querySelector('.ttl-pic-four').style.display = 'none';
    document.querySelector('.ttl-pic-five').style.display = 'none';
    document.querySelector('.ttl-pic-six').style.display = 'none';
    document.querySelector('.ttl-pic-seven').style.display = 'none';
    document.querySelector('.ttl-pic-eight').style.display = 'none';
  }
}

function passengerQr(){
  let fname = document.getElementById('fi_name').value;
  let mname = document.getElementById('mi_name').value;
  let lname = document.getElementById('la_name').value;
  let cnum = document.getElementById('co_num').value;
  let dst = document.getElementById('dt').value;
  parameter_passenger = fname + '_' + lname + '_' + dst;

  if(fname.trim() !== '' && mname.trim() !== '' && lname.trim() !== '' && cnum.trim() !== '' && dst.trim() !== ''){
    let link_1 = '../admin_passenger_process.php?fname=' + fname + '&mname=' + mname + '&lname=' + lname;
    let link_2 = '&cnum=' + cnum + '&dst=' + dst;
    document.getElementById('p-qrimage').src = link_1 + link_2;
    document.getElementById('passenger-destination').innerHTML = dst.toUpperCase();
  }
  else{
      warnings('#F7DC6F', 'Please fill all the fields');
  }
}

function showXA(){
  subt1.style.display = 'flex';
  subt2.style.display = 'none';
  subt3.style.display = 'none';
  subt4.style.display = 'none';
  subt5.style.display = 'none';
  subt6.style.display = 'none';
  subt7.style.display = 'none';
  subt8.style.display = 'none';
  x_one.style.display = 'flex';
  a_one.style.display = 'none';
  a_two.style.display = 'none';
  b_one.style.display = 'none';  //Needs to be changed.
  b_two.style.display = 'none';
  c_one.style.display = 'none';
  c_two.style.display = 'none';
  d_one.style.display = 'none';
  d_two.style.display = 'none';
  e_one.style.display = 'none';
  f_one.style.display = 'none';
  f_two.style.display = 'none';
  g_one.style.display = 'none';
  g_two.style.display = 'none';
  btns_1.style.border = '2px solid #f1c40f';
  btns_2.style.border = '1px solid #ABB2B9';
  btns_3.style.border = '1px solid #ABB2B9';
  btns_4.style.border = '1px solid #ABB2B9';
  btns_5.style.border = '1px solid #ABB2B9';
  btns_6.style.border = '1px solid #ABB2B9';
  btns_7.style.border = '1px solid #ABB2B9';
}

function showA(){
  subt1.style.display = 'none';
  subt2.style.display = 'flex';
  subt3.style.display = 'none';
  subt4.style.display = 'none';
  subt5.style.display = 'none';
  subt6.style.display = 'none';
  subt7.style.display = 'none';
  subt8.style.display = 'none';
  x_one.style.display = 'none';
  a_one.style.display = 'block';
  a_two.style.display = 'block';
  b_one.style.display = 'none';  //Needs to be changed.
  b_two.style.display = 'none';
  c_one.style.display = 'none';
  c_two.style.display = 'none';
  d_one.style.display = 'none';
  d_two.style.display = 'none';
  e_one.style.display = 'none';
  f_one.style.display = 'none';
  f_two.style.display = 'none';
  g_one.style.display = 'none';
  g_two.style.display = 'none';
  btns_1.style.border = '2px solid #f1c40f';
  btns_2.style.border = '1px solid #ABB2B9';
  btns_3.style.border = '1px solid #ABB2B9';
  btns_4.style.border = '1px solid #ABB2B9';
  btns_5.style.border = '1px solid #ABB2B9';
  btns_6.style.border = '1px solid #ABB2B9';
  btns_7.style.border = '1px solid #ABB2B9';
}

function showB(){
  subt1.style.display = 'none';
  subt2.style.display = 'none';
  subt3.style.display = 'flex';
  subt4.style.display = 'none';
  subt5.style.display = 'none';
  subt6.style.display = 'none';
  subt7.style.display = 'none';
  subt8.style.display = 'none';
  x_one.style.display = 'none';
  b_one.style.display = 'block';
  b_two.style.display = 'block';
  a_one.style.display = 'none';  //Needs to be changed.
  a_two.style.display = 'none';
  c_one.style.display = 'none';
  c_two.style.display = 'none';
  d_one.style.display = 'none';
  d_two.style.display = 'none';
  e_one.style.display = 'none';
  f_one.style.display = 'none';
  f_two.style.display = 'none';
  g_one.style.display = 'none';
  g_two.style.display = 'none';
  btns_1.style.border = '1px solid #ABB2B9';
  btns_2.style.border = '2px solid #f1c40f';
  btns_3.style.border = '1px solid #ABB2B9';
  btns_4.style.border = '1px solid #ABB2B9';
  btns_5.style.border = '1px solid #ABB2B9';
  btns_6.style.border = '1px solid #ABB2B9';
  btns_7.style.border = '1px solid #ABB2B9';
}

function showC(){
  subt1.style.display = 'none';
  subt2.style.display = 'none';
  subt3.style.display = 'none';
  subt4.style.display = 'flex';
  subt5.style.display = 'none';
  subt6.style.display = 'none';
  subt7.style.display = 'none';
  subt8.style.display = 'none';
  x_one.style.display = 'none';
  c_one.style.display = 'flex';
  c_two.style.display = 'block';
  b_one.style.display = 'none';
  b_two.style.display = 'none';
  a_one.style.display = 'none';  //Needs to be changed.
  a_two.style.display = 'none';
  d_one.style.display = 'none';
  d_two.style.display = 'none';
  e_one.style.display = 'none';
  f_one.style.display = 'none';
  f_two.style.display = 'none';
  g_one.style.display = 'none';
  g_two.style.display = 'none';
  btns_1.style.border = '1px solid #ABB2B9';
  btns_2.style.border = '1px solid #ABB2B9';
  btns_3.style.border = '2px solid #f1c40f';
  btns_4.style.border = '1px solid #ABB2B9';
  btns_5.style.border = '1px solid #ABB2B9';
  btns_6.style.border = '1px solid #ABB2B9';
  btns_7.style.border = '1px solid #ABB2B9';
}

function showD(){
  subt1.style.display = 'none';
  subt2.style.display = 'none';
  subt3.style.display = 'none';
  subt4.style.display = 'none';
  subt5.style.display = 'flex';
  subt6.style.display = 'none';
  subt7.style.display = 'none';
  subt8.style.display = 'none';
  x_one.style.display = 'none';
  d_one.style.display = 'flex';
  d_two.style.display = 'flex';
  c_one.style.display = 'none';
  c_two.style.display = 'none';
  b_one.style.display = 'none';
  b_two.style.display = 'none';
  a_one.style.display = 'none';  //Needs to be changed.
  a_two.style.display = 'none';
  e_one.style.display = 'none';
  f_one.style.display = 'none';
  f_two.style.display = 'none';
  g_one.style.display = 'none';
  g_two.style.display = 'none';
  btns_1.style.border = '1px solid #ABB2B9';
  btns_2.style.border = '1px solid #ABB2B9';
  btns_3.style.border = '1px solid #ABB2B9';
  btns_4.style.border = '2px solid #f1c40f';
  btns_5.style.border = '1px solid #ABB2B9';
  btns_6.style.border = '1px solid #ABB2B9';
  btns_7.style.border = '1px solid #ABB2B9';
}

function showE(){
  subt1.style.display = 'none';
  subt2.style.display = 'none';
  subt3.style.display = 'none';
  subt4.style.display = 'none';
  subt5.style.display = 'none';
  subt6.style.display = 'flex';
  subt7.style.display = 'none';
  subt8.style.display = 'none';
  x_one.style.display = 'none';
  d_one.style.display = 'none';
  d_two.style.display = 'none';
  c_one.style.display = 'none';
  c_two.style.display = 'none';
  b_one.style.display = 'none';
  b_two.style.display = 'none';
  a_one.style.display = 'none';  //Needs to be changed.
  a_two.style.display = 'none';
  e_one.style.display = 'flex';
  f_one.style.display = 'none';
  f_two.style.display = 'none';
  g_one.style.display = 'none';
  g_two.style.display = 'none';
  btns_1.style.border = '1px solid #ABB2B9';
  btns_2.style.border = '1px solid #ABB2B9';
  btns_3.style.border = '1px solid #ABB2B9';
  btns_4.style.border = '1px solid #ABB2B9';
  btns_5.style.border = '2px solid #f1c40f';
  btns_6.style.border = '1px solid #ABB2B9';
  btns_7.style.border = '1px solid #ABB2B9';
}

function showF(){
  subt1.style.display = 'none';
  subt2.style.display = 'none';
  subt3.style.display = 'none';
  subt4.style.display = 'none';
  subt5.style.display = 'none';
  subt6.style.display = 'none';
  subt7.style.display = 'flex';
  subt8.style.display = 'none';
  x_one.style.display = 'none';
  d_one.style.display = 'none';
  d_two.style.display = 'none';
  c_one.style.display = 'none';
  c_two.style.display = 'none';
  b_one.style.display = 'none';
  b_two.style.display = 'none';
  a_one.style.display = 'none';  //Needs to be changed.
  a_two.style.display = 'none';
  e_one.style.display = 'none';
  f_one.style.display = 'flex';
  f_two.style.display = 'flex';
  g_one.style.display = 'none';
  g_two.style.display = 'none';
  btns_1.style.border = '1px solid #ABB2B9';
  btns_2.style.border = '1px solid #ABB2B9';
  btns_3.style.border = '1px solid #ABB2B9';
  btns_4.style.border = '1px solid #ABB2B9';
  btns_5.style.border = '1px solid #ABB2B9';
  btns_6.style.border = '2px solid #f1c40f';
  btns_7.style.border = '1px solid #ABB2B9';
}

function showG(){
  subt1.style.display = 'none';
  subt2.style.display = 'none';
  subt3.style.display = 'none';
  subt4.style.display = 'none';
  subt5.style.display = 'none';
  subt6.style.display = 'none';
  subt7.style.display = 'none';
  subt8.style.display = 'flex';
  x_one.style.display = 'none';
  d_one.style.display = 'none';
  d_two.style.display = 'none';
  c_one.style.display = 'none';
  c_two.style.display = 'none';
  b_one.style.display = 'none';
  b_two.style.display = 'none';
  a_one.style.display = 'none';  //Needs to be changed.
  a_two.style.display = 'none';
  e_one.style.display = 'none';
  f_one.style.display = 'none';
  f_two.style.display = 'none';
  g_one.style.display = 'flex';
  g_two.style.display = 'flex';
  btns_1.style.border = '1px solid #ABB2B9';
  btns_2.style.border = '1px solid #ABB2B9';
  btns_3.style.border = '1px solid #ABB2B9';
  btns_4.style.border = '1px solid #ABB2B9';
  btns_5.style.border = '1px solid #ABB2B9';
  btns_6.style.border = '1px solid #ABB2B9';
  btns_7.style.border = '2px solid #f1c40f';
}

function pinGenerator(){
  document.getElementById('gen-pin').value = Math.floor(1000 + Math.random() * 9000);
}

function saveVehiclePDF(){
  var element_1 = document.getElementById('vehicle-for-print');
  html2pdf(element_1, {
    filename: parameter + '.pdf'
  });
}

function savePassengerPDF(){
  var element_2 = document.getElementById('passenger-for-print');
  html2pdf(element_2, {
    filename: parameter_passenger + '.pdf'
  });
}

  // const urlString = window.location.search;
  // const urlParams = new URLSearchParams(urlString);
  // const parameter = urlParams.get('qr');
  // const dispatcher_config = urlParams.get('dispatchconfig');
  // const dispatcher_name = urlParams.get('name');
  // const dispatcher_duty = urlParams.get('duty');
  // const vehicle_return = urlParams.get('returnConfig');
  // const reload_passenger_list = urlParams.get('reload');
  // const registering_status = urlParams.get('registering_status');
  // const unqueue_vehicle_status = urlParams.get('unqueue_vehicle_status');
  // const delete_dispatcher = urlParams.get('delete_dispatcher');
  //
  // if(parameter == null){
  //   document.getElementById('vehicle-plateno').innerHTML = 'QR';   //used
  //   document.getElementById('vehicle-qrimage').src = './images/loading.gif';
  // }else{
  //   window.history.replaceState({info: "Clear reload"}, "Admin | Dashboard", "./");
  // }
  //
  // if(vehicle_return == 'true'){
  //   showD();
  // }
  //
  // if(reload_passenger_list == 'passengerReload'){
  //   showE();
  // }
  //
  // if(registering_status == 'field_incomplete'){
  //   warnings('#F7DC6F', 'Please fill all the fields');
  //   window.history.replaceState({info: "Clear reload"}, "Admin | Dashboard", "./"); //used
  // }
  // else if(registering_status == 'error'){
  //   warnings('#E74C3C', 'Something went wrong');
  //   window.history.replaceState({info: "Clear reload"}, "Admin | Dashboard", "./"); //used
  // }
  // else if(registering_status == 'registered'){
  //   warnings('#F7DC6F', 'Vehicle already registered');
  //   window.history.replaceState({info: "Clear reload"}, "Admin | Dashboard", "./"); //used
  // }
  // else if(registering_status == 'dispatcher_registered'){
  //   warnings('#82E0AA', 'Successfully registered dispatcher');
  //   showC();
  // }
  // else if(registering_status == 'dispatcher_error_registering'){
  //   warnings('#E74C3C', 'Something went wrong');
  //   showC();
  // }
  // else if(registering_status == 'missing_dispatcher_field'){
  //   warnings('#F7DC6F', 'Please fill all the fields');
  //   showC();
  // }
  // else if(registering_status == 'dispatcher_already_registered'){
  //   warnings('#F7DC6F', 'Dispatcher already registered');
  //   showC();
  // }
  //
  // if(unqueue_vehicle_status == 'success'){
  //   warnings('#82E0AA', 'Vehicle successfully unqueued');
  //   showF();
  // }
  // else if(unqueue_vehicle_status == 'halted'){
  //   warnings('#E74C3C', 'Something went wrong');
  //   showF();
  // }
  //
  // if(delete_dispatcher == 'success'){
  //   warnings('#82E0AA', 'Dispatcher removed');
  //   showC();
  // }
  // else if(delete_dispatcher == 'error'){
  //   warnings('#E74C3C', 'Something went wrong');
  //   showC();
  // }

ws.onopen = (e) => {
  console.log("websocket opened");
}

function dutyChange(data){
  const changeDuty = new XMLHttpRequest();
  changeDuty.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
      if(this.responseText == "true"){
        retrieveRegisteredDispatcher()
      }
      else if(this.responseText == "false"){
        retrieveRegisteredDispatcher();
        ws.send(data);
      }
      else if(this.responseText == "error"){
        warnings('#E74C3C', 'Something went wrong');
      }
      else{
        warnings('#E74C3C', 'Something went wrong');
      }
    }
  }
  changeDuty.open("POST", "../admin_dispatching_process.php", true);
  changeDuty.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  changeDuty.send("data=" + data);
}

function vehicleStatus(data){
  const changeVehicleStatus = new XMLHttpRequest();
  changeVehicleStatus.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
      if(this.responseText == "success-on"){
        warnings('#82E0AA', 'Vehicle set to return');
      }
      else if(this.responseText == "success-off"){
        warnings('#82E0AA', 'Vehicle set to not return');
      }
      else{
        warnings('#E74C3C', 'Something went wrong');
      }
    }
  }
  changeVehicleStatus.open("POST", "../admin_vehicle_returning_process.php", true);
  changeVehicleStatus.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  changeVehicleStatus.send("data=" + data);
}

function deleteDispatcher(data){
  if(confirm(data + " will be deleted from the list.")){
    const delDispatcher = new XMLHttpRequest();
    delDispatcher.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){
        if(this.responseText == "success"){
          retrieveRegisteredDispatcher();
          ws.send(data);
        }
        else if(this.responseText == "error"){
          warnings('#E74C3C', 'Something went wrong');
        }
        else{
          warnings('#E74C3C', 'Something went wrong');
        }
        console.log(this.responseText);
      }
    }
    delDispatcher.open("POST", "../admin_delete_dispatcher.php", true);
    delDispatcher.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    delDispatcher.send("data=" + data);
  }
}

function fullyRemoveVehicle(data){
  if(confirm("Are you sure you want to remove " + data)){
    const vehicleToRemove = new XMLHttpRequest();
    vehicleToRemove.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){
        if(this.responseText == "success"){
          warnings('#82E0AA', 'Vehicle was removed successfully');
        }
        else if(this.responseText == "error"){
          warnings('#F7DC6F', 'Something went wrong');
        }
        else{
          warnings('#F7DC6F', 'Something went wrong');
        }
      }
    }
    vehicleToRemove.open("POST", "../admin_drop_vehicle.php", true);
    vehicleToRemove.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    vehicleToRemove.send("data=" + data);
  }
}
