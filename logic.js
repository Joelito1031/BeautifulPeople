'use strict';

var ws = new WebSocket('ws://192.168.1.31:8082');

let a_one = document.querySelector('.subfield-1-1');
let a_two = document.querySelector('.subfield-1-2');
let b_one = document.querySelector('.subfield-2-1');
let b_two = document.querySelector('.subfield-2-2');
let c_one = document.querySelector('.subfield-3-1');
let c_two = document.querySelector('.subfield-3-2');
let d_one = document.querySelector('.subfield-4-1');
let e_one = document.querySelector('.subfield-5-1');
let span_a = document.querySelector('.a');
let span_b = document.querySelector('.b');
let span_c = document.querySelector('.c');
let span_d = document.querySelector('.d');
let span_e = document.querySelector('.e');
let span_value_a = getComputedStyle(span_a);
let span_value_b = getComputedStyle(span_b);
let span_value_c = getComputedStyle(span_c);
let span_value_d = getComputedStyle(span_d);
let span_value_e = getComputedStyle(span_e);
var parameter_passenger = null;

function checkSize(){
  if(window.innerWidth <= '609'){
    span_a.style.width = '50px';
    span_b.style.width = '50px';
    span_c.style.width = '50px';
    span_d.style.width = '50px';
    span_e.style.width = '50px';
    document.querySelector('.show-btn').style.display = 'none';
    document.querySelector('.one-ttl').style.display = 'none';
    document.querySelector('.two-ttl').style.display = 'none';
    document.querySelector('.three-ttl').style.display = 'none';
    document.querySelector('.four-ttl').style.display = 'none';
    document.querySelector('.five-ttl').style.display = 'none';
    document.querySelector('.ttl-pic-one').style.display = 'inline-block';
    document.querySelector('.ttl-pic-two').style.display = 'inline-block';
    document.querySelector('.ttl-pic-three').style.display = 'inline-block';
    document.querySelector('.ttl-pic-four').style.display = 'inline-block';
    document.querySelector('.ttl-pic-five').style.display = 'inline-block';
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
    document.querySelector('.one-ttl').style.display = 'none';
    document.querySelector('.two-ttl').style.display = 'none';
    document.querySelector('.three-ttl').style.display = 'none';
    document.querySelector('.four-ttl').style.display = 'none';
    document.querySelector('.five-ttl').style.display = 'none';
    document.querySelector('.ttl-pic-one').style.display = 'inline-block';
    document.querySelector('.ttl-pic-two').style.display = 'inline-block';
    document.querySelector('.ttl-pic-three').style.display = 'inline-block';
    document.querySelector('.ttl-pic-four').style.display = 'inline-block';
    document.querySelector('.ttl-pic-five').style.display = 'inline-block';
  }
  else{
    span_a.style.width = '200px';
    span_b.style.width = '200px';
    span_c.style.width = '200px';
    span_d.style.width = '200px';
    span_e.style.width = '200px';
    document.querySelector('.one-ttl').style.display = 'inline';
    document.querySelector('.two-ttl').style.display = 'inline';
    document.querySelector('.three-ttl').style.display = 'inline';
    document.querySelector('.four-ttl').style.display = 'inline';
    document.querySelector('.five-ttl').style.display = 'inline';
    document.querySelector('.ttl-pic-one').style.display = 'none';
    document.querySelector('.ttl-pic-two').style.display = 'none';
    document.querySelector('.ttl-pic-three').style.display = 'none';
    document.querySelector('.ttl-pic-four').style.display = 'none';
    document.querySelector('.ttl-pic-five').style.display = 'none';
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
    let link_1 = './passenger_process.php?fname=' + fname + '&mname=' + mname + '&lname=' + lname;
    let link_2 = '&cnum=' + cnum + '&dst=' + dst;
    document.getElementById('p-qrimage').src = link_1 + link_2;
    document.getElementById('passenger-destination').innerHTML = dst.toUpperCase();
  }
}

function showA(){
  a_one.style.display = 'block';
  a_two.style.display = 'block';
  b_one.style.display = 'none';  //Needs to be changed.
  b_two.style.display = 'none';
  c_one.style.display = 'none';
  c_two.style.display = 'none';
  d_one.style.display = 'none';
  e_one.style.display = 'none';
}

function showB(){
  b_one.style.display = 'block';
  b_two.style.display = 'block';
  a_one.style.display = 'none';  //Needs to be changed.
  a_two.style.display = 'none';
  c_one.style.display = 'none';
  c_two.style.display = 'none';
  d_one.style.display = 'none';
  e_one.style.display = 'none';
}

function showC(){
  c_one.style.display = 'block';
  c_two.style.display = 'block';
  b_one.style.display = 'none';
  b_two.style.display = 'none';
  a_one.style.display = 'none';  //Needs to be changed.
  a_two.style.display = 'none';
  d_one.style.display = 'none';
  e_one.style.display = 'none';
}

function showD(){
  d_one.style.display = 'block';
  c_one.style.display = 'none';
  c_two.style.display = 'none';
  b_one.style.display = 'none';
  b_two.style.display = 'none';
  a_one.style.display = 'none';  //Needs to be changed.
  a_two.style.display = 'none';
  e_one.style.display = 'none';
}

function showE(){
  d_one.style.display = 'none';
  c_one.style.display = 'none';
  c_two.style.display = 'none';
  b_one.style.display = 'none';
  b_two.style.display = 'none';
  a_one.style.display = 'none';  //Needs to be changed.
  a_two.style.display = 'none';
  e_one.style.display = 'flex';
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

const urlString = window.location.search;
const urlParams = new URLSearchParams(urlString);
const parameter = urlParams.get('qr');
const dispatcher_config = urlParams.get('dispatchconfig');
const dispatcher_name = urlParams.get('name');
const dispatcher_duty = urlParams.get('duty');
const vehicle_return = urlParams.get('returnConfig');
const reload_passenger_list = urlParams.get('reload');
const registering_statust = urlParams.get('registering_status');

if(parameter == null){
  document.getElementById('vehicle-plateno').innerHTML = 'QR';
  document.getElementById('vehicle-qrimage').src = './qrs/loading.gif';
}else{
  document.getElementById('vehicle-qrimage').src = './qrs/' + parameter + '.png';
  document.getElementById('vehicle-plateno').innerHTML = parameter;
}

if(vehicle_return == 'true'){
  showD();
}

if(reload_passenger_list == 'passengerReload'){
  showE();
}

ws.onopen = (e) => {
  if(dispatcher_config == 'true' && dispatcher_duty == 'false'){
    ws.send(dispatcher_name.trim());
    showC();
  }
  else if(dispatcher_config == 'true' && dispatcher_duty == 'true'){
    showC();
  }
  else if(dispatcher_config === 'false'){
    showC();
    alert("Failed to switch Dispatcher's status");
  }
}

function dutyChange(data){
  window.location.replace('./dispatching_process.php?data=' + data);
}

function vehicleStatus(data){
  window.location.replace('./vehicle_returning_process.php?data=' + data);
}

function reloadPassengerList(){
  window.location.replace('./index.php?reload=passengerReload');
}
