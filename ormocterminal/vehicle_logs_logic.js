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
