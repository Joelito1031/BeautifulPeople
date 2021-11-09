<?php
session_start();
if(isset($_SESSION['loggedin'])){
  if(!$_SESSION['loggedin']){
    header('Location: ../');
  }
}
else{
  header('Location: ../');
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Admin | Dashboard</title>
    <link href="style.css" type="text/css" rel="stylesheet" >
  </head>
  <body>
    <script type="text/javascript" src="html2pdf.bundle.min.js" defer></script>
    <script type="text/javascript" src="./logic.js" defer></script>
    <div class="nav-container">
      <div class="top-nav">
        <span>Ormoc Terminal | Admin Page</span>
      </div>
    </div>
    <div class="main-container">
      <div class="body-container">
        <div class="side-nav">
           <button class="show-btn" onclick="showNav()">
             &#9776;
           </button>
           <div class="a">
             <button class="btns-1" onclick="showA()">
               <span class="one-ttl">Register Vehicle</span>
               <img class="ttl-pic-one" src="./images/car.png">
             </button>
           </div>
           <div class="b">
             <button class="btns-2" onclick="showB()">
               <span class="two-ttl">Generate Passenger QR</span>
               <img class="ttl-pic-two" src="./images/passengers.png">
             </button>
           </div>
           <div class="c">
             <button class="btns-3" onclick="showC()">
               <span class="three-ttl">Register Dispatchers</span>
                <img class="ttl-pic-three" src="./images/dispatcher.png">
             </button>
           </div>
           <div class="d">
             <button class="btns-4" onclick="showD()">
               <span class="four-ttl">Returning Vehicles</span>
                <img class="ttl-pic-four" src="./images/returning.png">
             </button>
           </div>
           <div class="e">
             <button class="btns-5" onclick="showE()">
               <span class="five-ttl">Waiting Passengers</span>
                <img class="ttl-pic-five" src="./images/queuing.png">
             </button>
           </div>
           <div class="f">
             <button class="btns-6" onclick="showF()">
               <span class="six-ttl">Queuing Vehicles</span>
                <img class="ttl-pic-six" src="./images/vehicle.png">
             </button>
           </div>
           <div class="g">
             <button class="btns-7" onclick="showG()">
               <span class="seven-ttl">Logs</span>
                <img class="ttl-pic-seven" src="./images/logs.png">
             </button>
           </div>
           <div class="h">
             <button class="btns-8" onclick="exit()">
               <span class="eight-ttl">Log-out</span>
                <img class="ttl-pic-eight" src="./images/logout.png">
             </button>
           </div>
        </div>
        <div class="fields">
          <div class="dash-warning">
            <div id="admin-dash-warning" class='warning-dashboard'>
            <div class='sub-cont-dashboard'>
              <div id="warning-message">
              </div>
              <div>
                <button id='terminate-warning-button' onclick="closeWarning()">
                  <img src='./images/xbox.png'>
                </button>
              </div>
            </div>
          </div>
          </div>
          <div class="subfield-1-1">
            <form id="form">
              <div class="div-1">
                <div>
                  <input type="text" name="fname" id="f_name" placeholder="First name" maxlength="40">
                </div>
                <div>
                  <input type="text" name="mname" id="m_name" placeholder="Middle name" maxlength="40">
                </div>
                <div>
                  <input type="text" name="lname" id="l_name" placeholder="Last name" maxlength="40">
                </div>
                <div>
                  <input type="tel" name="cnum" id="c_num" placeholder="Contact #" pattern="[0-9]{11}">
                </div>
                <div>
                  <input type="text" name="plateno" id="plate_no" placeholder="Plate #" pattern="[A-Z]{3}-[0-9]{3}" onkeyup="this.value = this.value.toUpperCase();">
                </div>
                <div>
                  <select name="route" id="rt">
                    <option value="">Select route</option>
                    <option value="albuera">Ormoc - Albuera</option>
                    <option value="puertobello">Ormoc - Puertobello</option>
                    <option value="sabangbao">Ormoc - Sabang-Bao</option>
                    <option value="valencia">Ormoc - Valencia</option>
                  </select>
                </div>
                <div>
                  <select name="capacity" id="cpcty">
                    <option value="">Enter PUV capacity</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="19">19</option>
                    <option value="20">20</option>
                    <option value="21">21</option>
                  </select>
                </div>
                <div>
                  <input id="vehicle-submit-button" type="button" value="Register Vehicle" onclick="registerVehicle()">
                </div>
              </div>
            </form>
          </div>
          <div class="subfield-2-1">
            <form>
              <div class="div-1">
                <div>
                  <input type="text" name="fname" id="fi_name" placeholder="First name">
                </div>
                <div>
                  <input type="text" name="mname" id="mi_name" placeholder="Middle name">
                </div>
                <div>
                  <input type="text" name="lname" id="la_name" placeholder="Last name">
                </div>
                <div>
                  <input type="tel" name="cnum" id="co_num" placeholder="Contact #">
                </div>
                <div>
                  <select name="dest" id="dt">
                    <option value="">Select destination</option>
                    <option value="albuera">Albuera</option>
                    <option value="valencia">Valencia</option>
                    <option value="sabangbao">Sabang-Bao</option>
                    <option value="kananga">Kananga</option>
                  </select>
                </div>
                <div>
                  <input id="passenger-submit-button" type="button" value="Generate Passenger QR" onclick="passengerQr()">
                </div>
              </div>
            </form>
          </div>
          <div class="subfield-1-2">
            <div class="generated-qr">
              <div id="vehicle-for-print">
                <img id="vehicle-qrimage" src="./images/loading.gif">
                <h3 id="vehicle-plateno">QR</h3>
              </div>
              <button onclick="saveVehiclePDF()">SAVE</button>
            </div>
          </div>
            <div class="subfield-2-2">
              <div class="generated-qr">
                <div id="passenger-for-print">
                  <div id="passenger-qrimage">
                    <img id="p-qrimage" src="./images/loading.gif">
                  </div>
                  <h3 id="passenger-destination">QR</h3>
                </div>
                <button onclick="savePassengerPDF()">SAVE</button>
              </div>
            </div>
            <div class="subfield-3-1">
              <form>
                <div class="div-1">
                  <div>
                    <input type="text" name="dis_fname" id="dis_f_name" placeholder="First name" maxlength="40">
                  </div>
                  <div>
                    <input type="text" name="dis_mname" id="dis_m_name" placeholder="Middle name" maxlength="40">
                  </div>
                  <div>
                    <input type="text" name="dis_lname" id="dis_l_name" placeholder="Last name" maxlength="40">
                  </div>
                  <div>
                    <input type="tel" maxlength="11" name="dis_cnum" id="dis_c_num" placeholder="Contact #" pattern="[0-9]{11}">
                  </div>
                  <div>
                    <input id="pin-button" type="button" value="Generate 4 digit PIN" placeholder="PIN" onclick="pinGenerator()">
                  </div>
                  <div class="pin">
                    <input id="gen-pin" type="num" maxlength="4" placeholder="Generated PIN" name="dis_pin" pattern="[0-9]{4}">
                  </div>
                  <div>
                    <input id="dispatcher-submit-button" type="button" value="Register Dispatcher" onclick="registerDispatcher()">
                  </div>
                </div>
              </form>
            </div>
            <div class="subfield-3-2">
              <table class="dispatchers-table">
              </table>
            </div>
            <div class="subfield-4-2">
              <select id="searched-returning">
                <option value="">All</option>
                <option value="valencia">Valencia</option>
                <option value="puertobello">Puertobello</option>
                <option value="sabangbao">Sabang-Bao</option>
                <option value="albuera">Albuera</option>
              </select>
            </div>
            <div class="subfield-4-1">
              <div class="subfield-4-1-sub">
              </div>
            </div>
            <div class="subfield-5-1">
            </div>
            <div class="subfield-6-2">
              <select id="searched-destination">
                <option value="">All</option>
                <option value="valencia">Valencia</option>
                <option value="puertobello">Puertobello</option>
                <option value="sabangbao">Sabang-Bao</option>
                <option value="albuera">Albuera</option>
              </select>
            </div>
            <div class="subfield-6-1">
              <div class="subfield-6-1-sub">
              </div>
            </div>
            <div class="subfield-7-2">
              <select id="sort-option" onchange="retrieveLogs(this.value)">
                <option value="latest">Latest</option>
                <option value="oldest">Oldest</option>
                <option value="moreoptions">Time</option>
              </select>
              <div id="moreoptions">
                <label for="start-date">From:</label>
                <input type="date" id="start-date">
                <label for="end-date">To:</label>
                <input type="date" id="end-date">
              </div>
            </div>
            <div class="subfield-7-1">
              <div class="subfield-7-1-sub">
              </div>
            </div>
        </div>
      </div>
    </div>
  </body>
</html>
