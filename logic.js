'use strict';

let a_one = document.querySelector('.subfield-1-1');
let a_two = document.querySelector('.subfield-1-2');
let b_one = document.querySelector('.subfield-2-1');
let b_two = document.querySelector('.subfield-2-2');
let span_a = document.querySelector('.a');
let span_b = document.querySelector('.b');
let span_value_a = getComputedStyle(span_a);
let span_value_b = getComputedStyle(span_b);

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
    span_a.style.width = '200px';
    span_b.style.width = '200px';
    document.querySelector('.show-btn').style.display = 'inline-block';
    document.querySelector('.one-ttl').style.display = 'inline';
    document.querySelector('.two-ttl').style.display = 'inline';
    document.querySelector('.ttl-pic-one').style.display = 'none';
    document.querySelector('.ttl-pic-two').style.display = 'none';
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

function showA(){
  a_one.style.display = 'block';
  a_two.style.display = 'block';
  b_one.style.display = 'none';
  b_two.style.display = 'none';
}

function showB(){
  b_one.style.display = 'block';
  b_two.style.display = 'block';
  a_one.style.display = 'none';
  a_two.style.display = 'none';
}

function savePDF(){
  var element = document.getElementById('vehicle-for-print');
  html2pdf(element, {
    filename: parameter + '.pdf'
  });
}

const urlString = window.location.search;
const urlParams = new URLSearchParams(urlString);
const parameter = urlParams.get('qr');
const parameter_passenger = urlParams.get('qr_passenger');

document.getElementById('vehicle-plateno').innerHTML = parameter;
parameter == null ? document.getElementById('vehicle-qrimage').src = './qrs/loading.gif' : document.getElementById('vehicle-qrimage').src = './qrs/' + parameter + '.png';
parameter_passenger == null ? document.getElementById('passenger-qrimage').src = './qrs/loading.gif' : document.getElementById('passenger-qrimage').src = './qrs/' + parameter + '.png';
