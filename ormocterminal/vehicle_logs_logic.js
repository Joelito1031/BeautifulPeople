document.getElementById("nine").classList.add("active");

function hideSorter(){
  document.getElementById('sort-option').style.display = 'none';
}

function showSorter(){
  document.getElementById('sort-option').style.display = 'block';
  document.getElementById('search-input').value = '';
}

document.getElementById('search-input').addEventListener("keyup", function(e){
  if(e.keyCode == "13"){
    retrieveLogs();
  }
});

function retrieveLogs(){
  let search = document.getElementById('search-input').value;
  let data = document.getElementById('sort-option').value;
  if(search != ''){
    const logs = new XMLHttpRequest();
    logs.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){
        document.querySelector('.subfield-7-1-sub').innerHTML = this.responseText;
      }
    }
    logs.open('POST', '../admin_search_logs.php', true);
    logs.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    logs.send("data=" + search);
  }else if(data == 'latest'){
    document.getElementById('moreoptions').style.display = 'none';
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
    document.getElementById('moreoptions').style.display = 'none';
    const logs = new XMLHttpRequest();
    logs.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){
        document.querySelector('.subfield-7-1-sub').innerHTML = this.responseText;
      }
    }
    logs.open('POST', '../admin_retrieve_logs.php', true);
    logs.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    logs.send("data=" + data);
  }else if(data == 'alphabetically'){
    document.getElementById('moreoptions').style.display = 'none';
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
    document.getElementById('moreoptions').style.display = 'block';
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
  }else{
    const logs = new XMLHttpRequest();
    logs.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){
        document.querySelector('.subfield-7-1-sub').innerHTML = this.responseText;
      }
    }
    logs.open('POST', '../admin_retrieve_logs.php', true);
    logs.send();
  }
}

retrieveLogs();

function saveLogPDF(vhname, vhlogdate, doc){
  let areaToPrint = document.getElementById(doc);
  html2pdf(areaToPrint, {
    filename: document.getElementById(vhname).innerHTML + "_" + document.getElementById(vhlogdate).innerHTML + '.pdf'
  });
}

function exit(){
  window.location.replace('../admin_out.php');
}

function makePlateNoCorrect(value){
  let length = value.length;
  let plateNo = value.toUpperCase();
  let finalValue = "";
  let invalid_char = /[\s!"#$%&'()*+,-./:;<=>?@[\]^_`{|}~]/g;
  let invalid_str = /\d/;
  for(i = 0; i < length; i++){
    if(i < 3){
      if(invalid_str.test(plateNo[i]) || invalid_char.test(plateNo[i])){
        finalValue = finalValue + "";
      }else{
        finalValue = finalValue + plateNo[i];
      }
    }else if(i == 3){
      finalValue = finalValue + "-";
    }else if(i > 3){
      if(!invalid_str.test(plateNo[i]) || invalid_char.test(plateNo[i])){
        finalValue = finalValue + "";
      }else{
        finalValue = finalValue + plateNo[i];
      }
    }
  }
  return finalValue;
}

function loadAdminImage(){
  const loadImage = new XMLHttpRequest();
  loadImage.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
      if(this.responseText == 'error'){
        document.getElementById('message').innerHTML = "Something is wrong";
      }else{
        let data = JSON.parse(this.responseText);
        document.getElementById('admin-profile-pic').src = '../auth_process/' + data.profile;
        document.getElementById('admin-name').innerHTML = data.name;
      }
      console.log(this.responseText);
    }
  }
  loadImage.open("POST", "../auth_process/auth_process_load_image.php", true);
  loadImage.send();
}

loadAdminImage();
