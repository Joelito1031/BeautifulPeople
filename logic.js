'use strict';

let a_one = document.querySelector('.subfield-1-1');
let a_two = document.querySelector('.subfield-1-2');
let b_one = document.querySelector('.subfield-2-1');
let b_two = document.querySelector('.subfield-2-2');
let span_a = document.querySelector('.a');
let span_b = document.querySelector('.b');
let span_value_a = getComputedStyle(span_a);
let span_value_b = getComputedStyle(span_b);
var parameter_passenger = null;

function checkSize(){
  if(window.innerWidth <= '609'){
    span_a.style.width = '50px';
    span_b.style.width = '50px';
    document.querySelector('.show-btn').style.display = 'none';
    document.querySelector('.one-ttl').style.display = 'none';
    document.querySelector('.two-ttl').style.display = 'none';
    document.querySelector('.ttl-pic-one').style.display = 'inline-block';
    document.querySelector('.ttl-pic-two').style.display = 'inline-block';
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
    document.querySelector('.one-ttl').style.display = 'none';
    document.querySelector('.two-ttl').style.display = 'none';
    document.querySelector('.ttl-pic-one').style.display = 'inline-block';
    document.querySelector('.ttl-pic-two').style.display = 'inline-block';
  }
  else{
    span_a.style.width = '200px';
    span_b.style.width = '200px';
    document.querySelector('.one-ttl').style.display = 'inline';
    document.querySelector('.two-ttl').style.display = 'inline';
    document.querySelector('.ttl-pic-one').style.display = 'none';
    document.querySelector('.ttl-pic-two').style.display = 'none';
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
}

function showB(){
  b_one.style.display = 'block';
  b_two.style.display = 'block';
  a_one.style.display = 'none';  //Needs to be changed.
  a_two.style.display = 'none';
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

if(parameter == null){
  document.getElementById('vehicle-plateno').innerHTML = 'QR';
  document.getElementById('vehicle-qrimage').src = './qrs/loading.gif';
}else{
  document.getElementById('vehicle-qrimage').src = './qrs/' + parameter + '.png';
  document.getElementById('vehicle-plateno').innerHTML = parameter;
}
