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

setInterval(function(){
  retrieveLogs();
}, 1500);
