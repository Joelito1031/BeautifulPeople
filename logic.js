'use strict';

let span = document.querySelector('.a');
let span_value = getComputedStyle(span);

function checkSize(){
  if(window.innerWidth <= '609'){
    span.style.width = '50px';
    document.getElementById('show-btn').style.display = 'none';
    document.getElementById('ttl').style.display = 'none';
    document.getElementById('ttl-pic').style.display = 'inline-block';
  }
  else{
    span.style.width = '200px';
    document.getElementById('show-btn').style.display = 'inline-block';
    document.getElementById('ttl').style.display = 'inline';
    document.getElementById('ttl-pic').style.display = 'none';
  }
}

window.addEventListener('resize', checkSize);

function showNav(){
  if(span_value.width == '200px'){
    span.style.width = '50px';
    document.getElementById('ttl').style.display = 'none';
    document.getElementById('ttl-pic').style.display = 'inline-block';
  }
  else{
    span.style.width = '200px';
    document.getElementById('ttl').style.display = 'inline';
    document.getElementById('ttl-pic').style.display = 'none';
  }
}

function savePDF(){
  var element = document.getElementById('for-print');
  html2pdf(element, {
    filename: parameter + '.pdf'
  });
}

const urlString = window.location.search;
const urlParams = new URLSearchParams(urlString);
const parameter = urlParams.get('qr');

document.getElementById('plateno').innerHTML = parameter;
parameter == null ? document.getElementById('qrimage').src = './qrs/loading.gif' : document.getElementById('qrimage').src = './qrs/' + parameter + '.png';
