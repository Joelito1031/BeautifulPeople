'use strict';

var ws = new WebSocket('ws://192.168.1.31:8082');

let a_one = document.querySelector('.subfield-1-1');
let a_two = document.querySelector('.subfield-1-2');
let b_one = document.querySelector('.subfield-2-1');
let b_two = document.querySelector('.subfield-2-2');
let c_one = document.querySelector('.subfield-3-1');
let c_two = document.querySelector('.subfield-3-2');
let span_a = document.querySelector('.a');
let span_b = document.querySelector('.b');
let span_c = document.querySelector('.c');
let span_value_a = getComputedStyle(span_a);
let span_value_b = getComputedStyle(span_b);
let span_value_c = getComputedStyle(span_c);
var parameter_passenger = null;

function checkSize(){
  if(window.innerWidth <= '609'){
    span_a.style.width = '50px';
    span_b.style.width = '50px';
    span_c.style.width = '50px';
    document.querySelector('.show-btn').style.display = 'none';
    document.querySelector('.one-ttl').style.display = 'none';
    document.querySelector('.two-ttl').style.display = 'none';
    document.querySelector('.three-ttl').style.display = 'none';
    document.querySelector('.ttl-pic-one').style.display = 'inline-block';
    document.querySelector('.ttl-pic-two').style.display = 'inline-block';
    document.querySelector('.ttl-pic-three').style.display = 'inline-block';
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
    document.querySelector('.one-ttl').style.display = 'none';
    document.querySelector('.two-ttl').style.display = 'none';
    document.querySelector('.three-ttl').style.display = 'none';
    document.querySelector('.ttl-pic-one').style.display = 'inline-block';
    document.querySelector('.ttl-pic-two').style.display = 'inline-block';
    document.querySelector('.ttl-pic-three').style.display = 'inline-block';
  }
  else{
    span_a.style.width = '200px';
    span_b.style.width = '200px';
    span_c.style.width = '200px';
    document.querySelector('.one-ttl').style.display = 'inline';
    document.querySelector('.two-ttl').style.display = 'inline';
    document.querySelector('.three-ttl').style.display = 'inline';
    document.querySelector('.ttl-pic-one').style.display = 'none';
    document.querySelector('.ttl-pic-two').style.display = 'none';
    document.querySelector('.ttl-pic-three').style.display = 'none';
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
}

function showB(){
  b_one.style.display = 'block';
  b_two.style.display = 'block';
  a_one.style.display = 'none';  //Needs to be changed.
  a_two.style.display = 'none';
  c_one.style.display = 'none';
  c_two.style.display = 'none';
}

function showC(){
  c_one.style.display = 'block';
  c_two.style.display = 'block';
  b_one.style.display = 'none';
  b_two.style.display = 'none';
  a_one.style.display = 'none';  //Needs to be changed.
  a_two.style.display = 'none';
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

if(parameter == null){
  document.getElementById('vehicle-plateno').innerHTML = 'QR';
  document.getElementById('vehicle-qrimage').src = './qrs/loading.gif';
}else{
  document.getElementById('vehicle-qrimage').src = './qrs/' + parameter + '.png';
  document.getElementById('vehicle-plateno').innerHTML = parameter;
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
