
'use strict';
function showNav(){
  var first_view = document.querySelector('.b');
  var second_view = document.querySelector('.a');
  var second_view_prop = window.getComputedStyle(second_view);

  if(second_view_prop.display == 'block'){
    second_view.style.display = 'none';
    first_view.style.display = 'block';
  }
  else{
    second_view.style.display = 'block';
    first_view.style.display = 'none';
  }
}

const urlString = window.location.search;
const urlParams = new URLSearchParams(urlString);
const parameter = urlParams.get('qr');

parameter == null ? document.getElementById('qrimage').src = './qrs/loading.gif' : document.getElementById('qrimage').src = './qrs/' + parameter + '.png';
