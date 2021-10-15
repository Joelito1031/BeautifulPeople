<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>J³</title>
    <link href="style.css" type="text/css" rel="stylesheet" >
  </head>
  <body>
    <script type="text/javascript" src="html2pdf.bundle.min.js" defer></script>
    <script type="text/javascript" src="./logic.js" defer></script>
    <div class="main-container">
      <div class="nav-container">
        <div class="top-nav">
          <span>Ormoc E-Transport</span>
        </div>
      </div>
      <div class="body-container">
        <div class="side-nav">
           <button class="show-btn" onclick="showNav()">
             &#9776;
           </button>
           <div class="a">
             <button onclick="showA()">
               <span class="one-ttl">Register Vehicle</span>
               <img class="ttl-pic-one" src="./car.png">
             </button>
           </div>
           <div class="b">
             <button onclick="showB()">
               <span class="two-ttl">Passenger QR</span>
               <img class="ttl-pic-two" src="./passengers.png">
             </button>
           </div>
           <div class="c">
             <button onclick="showC()">
               <span class="three-ttl">Dispatchers</span>
                <img class="ttl-pic-three" src="./dispatcher.png">
             </button>
           </div>
           <div class="d">
             <button onclick="showD()">
               <span class="four-ttl">Returning Vehicles</span>
                <img class="ttl-pic-four" src="./returning.png">
             </button>
           </div>
           <div class="e">
             <button onclick="showE()">
               <span class="five-ttl">Waiting Passengers</span>
                <img class="ttl-pic-five" src="./queuing.png">
             </button>
           </div>
        </div>
        <div class="fields">
          <div class="subfield-1-1">
            <form method="POST" action="./vehicle_process.php">
              <div class="div-1">
                <div>
                  <label for="f_name">First name:</label>
                  <input type="text" name="fname" id="f_name">
                </div>
                <div>
                  <label for="m_name">Middle name:</label>
                  <input type="text" name="mname" id="m_name">
                </div>
                <div>
                  <label for="l_name">Last name:</label>
                  <input type="text" name="lname" id="l_name">
                </div>
                <div>
                  <label for="c_num">Contact number:</label>
                  <input type="number" name="cnum" id="c_num">
                </div>
                <div>
                  <label for="plate_no">Plate number:</label>
                  <input type="text" name="plateno" id="plate_no" onkeyup="this.value = this.value.toUpperCase();">
                </div>
                <div>
                  <label for="rt">Route:</label>
                  <select name="route" id="rt">
                    <option value="">Select route</option>
                    <option value="albuera">Ormoc - Albuera</option>
                    <option value="puertobello">Ormoc - Puertobello</option>
                    <option value="sabangbao">Ormoc - Sabang-Bao</option>
                    <option value="valencia">Ormoc - Valencia</option>
                  </select>
                </div>
                <div>
                  <label for="cpcty">Capacity:</label>
                  <select name="capacity" id="cpcty">
                    <option value="0">Enter PUV capacity</option>
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
                  <input id="vehicle-submit-button" type="submit" value="Register Vehicle">
                </div>
              </div>
            </form>
          </div>




          <div class="subfield-2-1">
            <form>
              <div class="div-1">
                <div>
                  <label for="fi_name">First name:</label>
                  <input type="text" name="fname" id="fi_name">
                </div>
                <div>
                  <label for="mi_name">Middle name:</label>
                  <input type="text" name="mname" id="mi_name">
                </div>
                <div>
                  <label for="la_name">Last name:</label>
                  <input type="text" name="lname" id="la_name">
                </div>
                <div>
                  <label for="co_num">Contact number:</label>
                  <input type="number" name="cnum" id="co_num">
                </div>
                <div>
                  <label for="dt">Destination:</label>
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
                <img id="vehicle-qrimage" src="">
                <h3 id="vehicle-plateno"></h3>
              </div>
              <button>PRINT</button>
              <button onclick="saveVehiclePDF()">SAVE AS PDF</button>
            </div>
          </div>



            <div class="subfield-2-2">
              <div class="generated-qr">
                <div id="passenger-for-print">
                  <div id="passenger-qrimage">
                    <img id="p-qrimage" src="./qrs/loading.gif">
                  </div>
                  <h3 id="passenger-destination">QR</h3>
                </div>
                <button>PRINT</button>
                <button onclick="savePassengerPDF()">SAVE AS PDF</button>
              </div>
            </div>

            <div class="subfield-3-1">
              <form action="./dispatcher_process.php" method="POST">
                <div class="div-1">
                  <div>
                    <label for="dis_f_name">First name:</label>
                    <input type="text" name="dis_fname" id="dis_f_name">
                  </div>
                  <div>
                    <label for="dis_m_name">Middle name:</label>
                    <input type="text" name="dis_mname" id="dis_m_name">
                  </div>
                  <div>
                    <label for="dis_l_name">Last name:</label>
                    <input type="text" name="dis_lname" id="dis_l_name">
                  </div>
                  <div>
                    <label for="dis_c_num">Contact number:</label>
                    <input type="number" name="dis_cnum" id="dis_c_num">
                  </div>
                  <div>
                    <input id="pin-button" type="button" value="Generate 4 digit PIN" onclick="pinGenerator()">
                  </div>
                  <div class="pin">
                    <label for="gen-pin">PIN:</label>
                    <input id="gen-pin" type="text" placeholder="Generated PIN" name="dis_pin" maxlength="4">
                  </div>
                  <div>
                    <input id="dispatcher-submit-button" type="submit" value="Register Dispatcher">
                  </div>
                </div>
              </form>
            </div>

            <div class="subfield-3-2">
              <table class="dispatchers-table">
                <tr>
                  <th>Name</th>
                  <th>Contact</th>
                  <th>PIN</th>
                  <th>Duty</th>
                </tr>
                <?php
                  require 'dispatchers_list.php';
                ?>
              </table>
            </div>

            <div class="subfield-4-1">
              <table class="dispatchers-table">
                <tr>
                  <th>Vehicle</th>
                  <th>Operator</th>
                  <th>Route</th>
                  <th>Contact #</th>
                  <th>Returning</th>
                </tr>
                <?php require './returning_vehicle_list.php' ?>
              </table>
            </div>

            <div class="subfield-5-1">
              <?php require './passenger_list.php' ?>
              <div class="reload">
                <button type="button" onclick="reloadPassengerList()">
                  <image src="./reload.png">
                </button>
              </div>
            </div>

        </div>
      </div>
    </div>
  </body>
</html>
