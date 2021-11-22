<?php
session_start();
if(isset($_SESSION['loggedin'])){
  if(!$_SESSION['loggedin']){
    header('Location: ../signin');
  }
}
else{
  header('Location: ../signin');
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Q R M O C | Administrator</title>
    <script src="./plugins/js-simple-loader-main/loader.js"></script>
    <link rel="stylesheet" href="./plugins/js-simple-loader-main/loader.css" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href="style.css" type="text/css" rel="stylesheet" >
    <link href="dist/css/adminlte.min.css" type="text/css" rel="stylesheet" >
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.min.css">
    <link rel="icon" href="images/logoQrmoc.png">
    <style>
     .cfont-size {
       font-size: 14.6px;
     }

     .white-text{
       color: white;
     }

     body {
      font-family: 'Roboto', sans-serif;
      overflow-x: hidden;
     }
  </style>

  </head>
  <body class="hold-transition sidebar-mini layout-fixed">
    <?php require "sidebar.html"; ?>
      <section class="content">
        <div class="container-fluid">
          <div class="content-wrapper">
            <div class="content-header">
              <div class="container-fluid">
                <div class="row mb-2">
                  <div class="col-sm-6">
                    <h1 class="m-0 sub-text-2">Manage PUVs</h1>
                  </div><!-- /.col -->
                </div><!-- /.row -->
              </div><!-- /.container-fluid -->
            </div>

            <div class="modal fade" id="popupEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle" style="color: #5DADE2"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="form-group">
                      <span data-toggle="puv-tooltip" title="Choose the proper route of the PUV." class="fas fa-info-circle" style="color: #9edbff;"></span>
                      <label for="route">Route</label>
                      <select name="route" id="rt" class="form-control">
                        <option value="">Select route</option>
                        <option value="albuera">Ormoc - Albuera</option>
                        <option value="puertobello">Ormoc - Puertobello</option>
                        <option value="sabangbao">Ormoc - Sabang-Bao</option>
                        <option value="valencia">Ormoc - Valencia</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <span data-toggle="puv-tooltip" title="Enter the right PUV capacity (allowed input is 1 to 2 digits only, not exceeding the value of 50)" class="fas fa-info-circle" style="color: #9edbff;"></span>
                      <label for="puv">PUV Capacity</label>
                      <input type="number" max="50" id="cpcty" class="form-control" placeholder="Enter PUV capacity" pattern="[0-9]{10}">
                    </div>
                    <div class="container" style="border: 1px solid #D5D8DC; border-radius: 5px; background-color: #F8F9F9;">
                      <br>
                    <label><sup>Operator's Information</sup></label>
                    <div class="form-group">
                      <span data-toggle="puv-tooltip" title="Numbers and special characters are not accepted." class="fas fa-info-circle" style="color: #9edbff;"></span>
                      <label for="first_name">First Name</label>
                      <input type="text" class="form-control" name="fname" id="f_name" placeholder="First name" maxlength="40" onfocusout="this.value = makeItCorrect(this.value)">
                    </div>
                    <div class="form-group">
                      <span data-toggle="puv-tooltip" title="Numbers and special characters are not accepted." class="fas fa-info-circle" style="color: #9edbff;"></span>
                      <label for="middle_name">Middle Name</label>
                      <input type="text" class="form-control" name="mname" id="m_name" placeholder="Middle name" maxlength="40" onfocusout="this.value = makeItCorrect(this.value)">
                    </div>
                    <div class="form-group">
                      <span data-toggle="puv-tooltip" title="Numbers and special characters are not accepted." class="fas fa-info-circle" style="color: #9edbff;"></span>
                      <label for="last_name">Last Name</label>
                      <input type="text" class="form-control" name="lname" id="l_name" placeholder="Last name" maxlength="40" onfocusout="this.value = makeItCorrect(this.value)">
                    </div>
                    <div class="form-group">
                        <span data-toggle="puv-tooltip" title="Choose a suffix, choose None if operator has no suffix." class="fas fa-info-circle" style="color: #9edbff;"></span>
                        <label for="suffix">Suffix</label>
                        <select id="suffix" class="form-control">
                          <option selected value="">None</option>
                          <option value="Jr">Jr</option>
                          <option value="Sr">Sr</option>
                          <option value="I">I</option>
                          <option value="II">II</option>
                          <option value="III">III</option>
                          <option value="IV">IV</option>
                          <option value="V">V</option>
                        </select>
                    </div>
                    <div class="form-group">
                      <span data-toggle="puv-tooltip" title="Just append the last 10 digits of mobile number." class="fas fa-info-circle" style="color: #9edbff;"></span>
                      <label for="contact_number">Mobile Number</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-phone"></i> &ensp;+63</span>
                        </div>
                        <input type="tel" class="form-control" name="cnum" id="c_num" placeholder="Contact #" maxlength="10" pattern="[0-9]{10}">
                      </div>
                    </div>
                    <div class="form-group">
                      <span data-toggle="puv-tooltip" title="Select operator's address." class="fas fa-info-circle" style="color: #9edbff;"></span>
                      <label for="contact_number">Address</label>
                      <select id="address" class="form-control">
                        <option value="">Barangays</option>
                        <option value="0">Non-Resident</option>
                        <option value="Brgy. Airport">Airport</option>
                        <option value="Brgy. Alegria">Alegria</option>
                        <option value="Brgy. Alta Vista">Alta Vista</option>
                        <option value="Brgy. Bagong">Bagong</option>
                        <option value="Brgy. Bagong Buhay">Bagong Buhay</option>
                        <option value="Bantigue">Bantigue</option>
                        <option value="Barangay District 1">Barangay District 1</option>
                        <option value="Barangay District 10">Barangay District 10 </option>
                        <option value="Barangay District 11">Barangay District 11 </option>
                        <option value="Barangay District 12">Barangay District 12 </option>
                        <option value="Barangay District 13">Barangay District 13 </option>
                        <option value="Barangay District 14">Barangay District 14 </option>
                        <option value="Barangay District 15">Barangay District 15 </option>
                        <option value="Barangay District 16">Barangay District 16 </option>
                        <option value="Barangay District 17">Barangay District 17 </option>
                        <option value="Barangay District 18">Barangay District 18 </option>
                        <option value="Barangay District 19">Barangay District 19 </option>
                        <option value="Barangay District 2">Barangay District 2 </option>
                        <option value="Barangay District 20">Barangay District 20 </option>
                        <option value="Barangay District 21">Barangay District 21 </option>
                        <option value="Barangay District 22">Barangay District 22 </option>
                        <option value="Barangay District 23">Barangay District 23 </option>
                        <option value="Barangay District 24">Barangay District 24 </option>
                        <option value="Barangay District 25 (Malbasag)">Barangay District 25 (Malbasag) </option>
                        <option value="Barangay District 26 (Isla Verde)">Barangay District 26 (Isla Verde)</option>
                        <option value="Barangay District 27">Barangay District 27 </option>
                        <option value="Barangay District 28">Barangay District 28 </option>
                        <option value="Barangay District 29 (Nadongholan)">Barangay District 29 (Nadongholan) </option>
                        <option value="Barangay District 3">Barangay District 3 </option>
                        <option value="Barangay District 4">Barangay District 4 </option>
                        <option value="Barangay District 5">Barangay District 5 </option>
                        <option value="Barangay District 6">Barangay District 6 </option>
                        <option value="Barangay District 7">Barangay District 7 </option>
                        <option value="Barangay District 8">Barangay District 8 </option>
                        <option value="Barangay District 9">Barangay District 9 </option>
                        <option value="Brgy. Batuan">Batuan</option>
                        <option value="Brgy. Bayog">Bayog</option>
                        <option value="Brgy. Biliboy">Biliboy</option>
                        <option value="Brgy. Cabaon-an">Cabaon-an</option>
                        <option value="Brgy. Cabingtan">Cabingtan</option>
                        <option value="Brgy. Cabulihan">Cabulihan</option>
                        <option value="Brgy. Cagbuhangin">Cagbuhangin</option>
                        <option value="Brgy. Camp Downes">Camp Downes</option>
                        <option value="Brgy. Can-adieng">Can-adieng</option>
                        <option value="Brgy. Can-untog">Can-untog</option>
                        <option value="Brgy. Catmon">Catmon</option>
                        <option value="Brgy. Cogon Combado">Cogon Combado</option>
                        <option value="Brgy. Concepcion">Concepcion</option>
                        <option value="Brgy. Curva">Curva</option>
                        <option value="Brgy. Danhug (Lili-on)">Danhug (Lili-on)</option>
                        <option value="Brgy. Dayhagan">Dayhagan</option>
                        <option value="Brgy. Dolores">Dolores</option>
                        <option value="Brgy. Domonar">Domonar</option>
                        <option value="Brgy. Don Carlos B. Rivilla Sr. (Boroc)">Don Carlos B. Rivilla Sr. (Boroc)</option>
                        <option value="Brgy. Don Felipe Larrazabal">Don Felipe Larrazabal</option>
                        <option value="Brgy. Don Potenciano Larrazabal">Don Potenciano Larrazabal</option>
                        <option value="Brgy. Doña Feliza Z. Mejia">Doña Feliza Z. Mejia</option>
                        <option value="Brgy. Donghol">Donghol</option>
                        <option value="Brgy. Esperanza">Esperanza</option>
                        <option value="Brgy. Gaas">Gaas</option>
                        <option value="Brgy. Green Valley">Green Valley</option>
                        <option value="Brgy. Guintigui-an">Guintigui-an</option>
                        <option value="Brgy. Hibunawon">Hibunawon</option>
                        <option value="Brgy. Hugpa">Hugpa</option>
                        <option value="Brgy. Ipil">Ipil</option>
                        <option value="Brgy. Juaton">Juaton</option>
                        <option value="Brgy. Kadaohan">Kadaohan</option>
                        <option value="Brgy. Labrador (Balion)">Labrador (Balion)</option>
                        <option value="Brgy. Lake Danao">Lake Danao</option>
                        <option value="Brgy. Lao">Lao</option>
                        <option value="Brgy. Leondoni">Leondoni</option>
                        <option value="Brgy. Libertad">Libertad</option>
                        <option value="Brgy. Liberty">Liberty</option>
                        <option value="Brgy. Licuma">Licuma</option>
                        <option value="Brgy. Liloan">Liloan</option>
                        <option value="Brgy. Linao">Linao</option>
                        <option value="Brgy. Luna">Luna</option>
                        <option value="Brgy. Mabato">Mabato</option>
                        <option value="Brgy. Mabini">Mabini</option>
                        <option value="Brgy. Macabug">Macabug</option>
                        <option value="Brgy. Magaswi">Magaswi</option>
                        <option value="Brgy. Mahayag">Mahayag</option>
                        <option value="Brgy. Mahayahay">Mahayahay</option>
                        <option value="Brgy. Manlilinao">Manlilinao</option>
                        <option value="Brgy. Margen">Margen</option>
                        <option value="Brgy. Mas-in">Mas-in</option>
                        <option value="Brgy. Matica-a">Matica-a</option>
                        <option value="Brgy. Milagro">Milagro</option>
                        <option value="Brgy. Monterico">Monterico</option>
                        <option value="Brgy. Nasunogan">Nasunogan</option>
                        <option value="Brgy. Naungan">Naungan</option>
                        <option value="Brgy. Nueva Sociedad">Nueva Sociedad</option>
                        <option value="Brgy. Nueva Vista">Nueva Vista</option>
                        <option value="Brgy. Patag">Patag</option>
                        <option value="Brgy. Punta">Punta</option>
                        <option value="Brgy. Quezon, Jr.">Quezon, Jr.</option>
                        <option value="Brgy. Rufina M. Tan (Rawis)">Rufina M. Tan (Rawis)</option>
                        <option value="Brgy. Sabang Bao">Sabang Bao</option>
                        <option value="Brgy. Salvacion">Salvacion</option>
                        <option value="Brgy. San Antonio">San Antonio</option>
                        <option value="Brgy. San Isidro">San Isidro</option>
                        <option value="Brgy. San Jose">San Jose</option>
                        <option value="Brgy. San Juan">San Juan</option>
                        <option value="Brgy. San Pablo (Simangan)">San Pablo (Simangan)</option>
                        <option value="Brgy. San Vicente">San Vicente</option>
                        <option value="Brgy. Santo Niño">Santo Niño</option>
                        <option value="Brgy. Sumangga">Sumangga</option>
                        <option value="Brgy. Tambulilid">Tambulilid</option>
                        <option value="Brgy. Tongonan">Tongonan</option>
                        <option value="Brgy. Valencia">Valencia</option>
                      </select>
                    </div>
                  </div>
                  <br>










                  <div class="container" style="border: 1px solid #D5D8DC; border-radius: 5px; background-color: #F8F9F9;">
                    <br>
                    <label><sup>Driver's Information</sup></label>
                    <div class="form-group">
                      <span data-toggle="puv-tooltip" title="Numbers and special characters are not accepted." class="fas fa-info-circle" style="color: #9edbff;"></span>
                      <label for="first_name">First Name</label>
                      <input type="text" class="form-control" name="fname" id="df_name" placeholder="First name" maxlength="40" onfocusout="this.value = makeItCorrect(this.value)">
                    </div>
                    <div class="form-group">
                      <span data-toggle="puv-tooltip" title="Numbers and special characters are not accepted." class="fas fa-info-circle" style="color: #9edbff;"></span>
                      <label for="middle_name">Middle Name</label>
                      <input type="text" class="form-control" name="mname" id="dm_name" placeholder="Middle name" maxlength="40" onfocusout="this.value = makeItCorrect(this.value)">
                    </div>
                    <div class="form-group">
                      <span data-toggle="puv-tooltip" title="Numbers and special characters are not accepted." class="fas fa-info-circle" style="color: #9edbff;"></span>
                      <label for="last_name">Last Name</label>
                      <input type="text" class="form-control" name="lname" id="dl_name" placeholder="Last name" maxlength="40" onfocusout="this.value = makeItCorrect(this.value)">
                    </div>
                    <div class="form-group">
                        <span data-toggle="puv-tooltip" title="Choose a suffix, choose None if operator has no suffix." class="fas fa-info-circle" style="color: #9edbff;"></span>
                        <label for="suffix">Suffix</label>
                        <select id="dsuffix" class="form-control">
                          <option selected value="">None</option>
                          <option value="Jr">Jr</option>
                          <option value="Sr">Sr</option>
                          <option value="I">I</option>
                          <option value="II">II</option>
                          <option value="III">III</option>
                          <option value="IV">IV</option>
                          <option value="V">V</option>
                        </select>
                    </div>
                    <div class="form-group">
                      <span data-toggle="puv-tooltip" title="Just append the last 10 digits of mobile number." class="fas fa-info-circle" style="color: #9edbff;"></span>
                      <label for="contact_number">Mobile Number</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-phone"></i> &ensp;+63</span>
                        </div>
                        <input type="tel" class="form-control" name="cnum" id="dc_num" placeholder="Contact #" maxlength="10" pattern="[0-9]{10}">
                      </div>
                    </div>
                    <div class="form-group">
                      <span data-toggle="puv-tooltip" title="Select driver's address." class="fas fa-info-circle" style="color: #9edbff;"></span>
                      <label for="contact_number">Address</label>
                      <select id="daddress" class="form-control">
                        <option value="">Barangays</option>
                        <option value="0">Non-Resident</option>
                        <option value="Brgy. Airport">Airport</option>
                        <option value="Brgy. Alegria">Alegria</option>
                        <option value="Brgy. Alta Vista">Alta Vista</option>
                        <option value="Brgy. Bagong">Bagong</option>
                        <option value="Brgy. Bagong Buhay">Bagong Buhay</option>
                        <option value="Bantigue">Bantigue</option>
                        <option value="Barangay District 1">Barangay District 1</option>
                        <option value="Barangay District 10">Barangay District 10 </option>
                        <option value="Barangay District 11">Barangay District 11 </option>
                        <option value="Barangay District 12">Barangay District 12 </option>
                        <option value="Barangay District 13">Barangay District 13 </option>
                        <option value="Barangay District 14">Barangay District 14 </option>
                        <option value="Barangay District 15">Barangay District 15 </option>
                        <option value="Barangay District 16">Barangay District 16 </option>
                        <option value="Barangay District 17">Barangay District 17 </option>
                        <option value="Barangay District 18">Barangay District 18 </option>
                        <option value="Barangay District 19">Barangay District 19 </option>
                        <option value="Barangay District 2">Barangay District 2 </option>
                        <option value="Barangay District 20">Barangay District 20 </option>
                        <option value="Barangay District 21">Barangay District 21 </option>
                        <option value="Barangay District 22">Barangay District 22 </option>
                        <option value="Barangay District 23">Barangay District 23 </option>
                        <option value="Barangay District 24">Barangay District 24 </option>
                        <option value="Barangay District 25 (Malbasag)">Barangay District 25 (Malbasag) </option>
                        <option value="Barangay District 26 (Isla Verde)">Barangay District 26 (Isla Verde)</option>
                        <option value="Barangay District 27">Barangay District 27 </option>
                        <option value="Barangay District 28">Barangay District 28 </option>
                        <option value="Barangay District 29 (Nadongholan)">Barangay District 29 (Nadongholan) </option>
                        <option value="Barangay District 3">Barangay District 3 </option>
                        <option value="Barangay District 4">Barangay District 4 </option>
                        <option value="Barangay District 5">Barangay District 5 </option>
                        <option value="Barangay District 6">Barangay District 6 </option>
                        <option value="Barangay District 7">Barangay District 7 </option>
                        <option value="Barangay District 8">Barangay District 8 </option>
                        <option value="Barangay District 9">Barangay District 9 </option>
                        <option value="Brgy. Batuan">Batuan</option>
                        <option value="Brgy. Bayog">Bayog</option>
                        <option value="Brgy. Biliboy">Biliboy</option>
                        <option value="Brgy. Cabaon-an">Cabaon-an</option>
                        <option value="Brgy. Cabingtan">Cabingtan</option>
                        <option value="Brgy. Cabulihan">Cabulihan</option>
                        <option value="Brgy. Cagbuhangin">Cagbuhangin</option>
                        <option value="Brgy. Camp Downes">Camp Downes</option>
                        <option value="Brgy. Can-adieng">Can-adieng</option>
                        <option value="Brgy. Can-untog">Can-untog</option>
                        <option value="Brgy. Catmon">Catmon</option>
                        <option value="Brgy. Cogon Combado">Cogon Combado</option>
                        <option value="Brgy. Concepcion">Concepcion</option>
                        <option value="Brgy. Curva">Curva</option>
                        <option value="Brgy. Danhug (Lili-on)">Danhug (Lili-on)</option>
                        <option value="Brgy. Dayhagan">Dayhagan</option>
                        <option value="Brgy. Dolores">Dolores</option>
                        <option value="Brgy. Domonar">Domonar</option>
                        <option value="Brgy. Don Carlos B. Rivilla Sr. (Boroc)">Don Carlos B. Rivilla Sr. (Boroc)</option>
                        <option value="Brgy. Don Felipe Larrazabal">Don Felipe Larrazabal</option>
                        <option value="Brgy. Don Potenciano Larrazabal">Don Potenciano Larrazabal</option>
                        <option value="Brgy. Doña Feliza Z. Mejia">Doña Feliza Z. Mejia</option>
                        <option value="Brgy. Donghol">Donghol</option>
                        <option value="Brgy. Esperanza">Esperanza</option>
                        <option value="Brgy. Gaas">Gaas</option>
                        <option value="Brgy. Green Valley">Green Valley</option>
                        <option value="Brgy. Guintigui-an">Guintigui-an</option>
                        <option value="Brgy. Hibunawon">Hibunawon</option>
                        <option value="Brgy. Hugpa">Hugpa</option>
                        <option value="Brgy. Ipil">Ipil</option>
                        <option value="Brgy. Juaton">Juaton</option>
                        <option value="Brgy. Kadaohan">Kadaohan</option>
                        <option value="Brgy. Labrador (Balion)">Labrador (Balion)</option>
                        <option value="Brgy. Lake Danao">Lake Danao</option>
                        <option value="Brgy. Lao">Lao</option>
                        <option value="Brgy. Leondoni">Leondoni</option>
                        <option value="Brgy. Libertad">Libertad</option>
                        <option value="Brgy. Liberty">Liberty</option>
                        <option value="Brgy. Licuma">Licuma</option>
                        <option value="Brgy. Liloan">Liloan</option>
                        <option value="Brgy. Linao">Linao</option>
                        <option value="Brgy. Luna">Luna</option>
                        <option value="Brgy. Mabato">Mabato</option>
                        <option value="Brgy. Mabini">Mabini</option>
                        <option value="Brgy. Macabug">Macabug</option>
                        <option value="Brgy. Magaswi">Magaswi</option>
                        <option value="Brgy. Mahayag">Mahayag</option>
                        <option value="Brgy. Mahayahay">Mahayahay</option>
                        <option value="Brgy. Manlilinao">Manlilinao</option>
                        <option value="Brgy. Margen">Margen</option>
                        <option value="Brgy. Mas-in">Mas-in</option>
                        <option value="Brgy. Matica-a">Matica-a</option>
                        <option value="Brgy. Milagro">Milagro</option>
                        <option value="Brgy. Monterico">Monterico</option>
                        <option value="Brgy. Nasunogan">Nasunogan</option>
                        <option value="Brgy. Naungan">Naungan</option>
                        <option value="Brgy. Nueva Sociedad">Nueva Sociedad</option>
                        <option value="Brgy. Nueva Vista">Nueva Vista</option>
                        <option value="Brgy. Patag">Patag</option>
                        <option value="Brgy. Punta">Punta</option>
                        <option value="Brgy. Quezon, Jr.">Quezon, Jr.</option>
                        <option value="Brgy. Rufina M. Tan (Rawis)">Rufina M. Tan (Rawis)</option>
                        <option value="Brgy. Sabang Bao">Sabang Bao</option>
                        <option value="Brgy. Salvacion">Salvacion</option>
                        <option value="Brgy. San Antonio">San Antonio</option>
                        <option value="Brgy. San Isidro">San Isidro</option>
                        <option value="Brgy. San Jose">San Jose</option>
                        <option value="Brgy. San Juan">San Juan</option>
                        <option value="Brgy. San Pablo (Simangan)">San Pablo (Simangan)</option>
                        <option value="Brgy. San Vicente">San Vicente</option>
                        <option value="Brgy. Santo Niño">Santo Niño</option>
                        <option value="Brgy. Sumangga">Sumangga</option>
                        <option value="Brgy. Tambulilid">Tambulilid</option>
                        <option value="Brgy. Tongonan">Tongonan</option>
                        <option value="Brgy. Valencia">Valencia</option>
                      </select>
                    </div>
                  </div>
                  <br>
                  <div style="display: flex; flex-direction: column; align-items: center;">
                    <div>
                      <span data-toggle="puv-tooltip" title="Vehicle image is optional, you can leave it empty and the vehicle will have the default vehicle image." class="fas fa-info-circle" style="color: #9edbff;"></span>
                      <label>Vehicle image <span style="color: red">(Optional)</span></label>
                    </div>
                    <div class="vehicle-prof-container">
                      <div>
                        <img id="actual-pic" src="../vehicle_images/vehicleImage.png">
                        <div class="vehicle-front-word" onclick="openFile()" title="Upload vehicle image">
                          <span class="fas fa-pencil-alt"></span>
                        </div>
                        <div class="back-element">
                          <input id="profile-pic" type="file" accept="image/*">
                        </div>
                      </div>
                    </div>
                  </div>
                  </div>
                  <div class="modal-footer">
                    <button id="save-button" type="button" class="btn btn-primary" onclick="saveEditedData(this.value)">Save changes</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 container-fluid">
                <div class="card container-fluid card-danger card-outline">
                  <div class="card-header">
                      <h3 class="card-title">Public Utility Vehicles</h3>
                      <div class="card-tools">
                          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                          </button>
                      </div>
                  </div>
                  <div class="card-body">
                    <div class="form-inline" style="width: 400px;">
                      <input id="search-input" class="form-control form-control-sm mr-3 w-75" type="text" placeholder="Search PUV plate number" aria-label="Search" onkeyup="searchVehicle(this.value)" maxlength="7">
                      <i id="search-ico" class="fas fa-search" aria-hidden="true"></i>
                      <i id="loading-ico" class="fas fa-spinner fa-spin" aria-hidden="true" style="display: none;"></i>
                    </div>
                    <div class="puvs-table">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <footer class="main-footer">
        <strong>Copyright &copy; <a href="#">Qrmoc - Queueing Passenger Assistance App</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
          <b>Ormoc City Terminal</b>
        </div>
      </footer>
    </div>
    <script type="text/javascript" src="html2pdf.bundle.min.js" ></script>
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
    <script type="text/javascript" src="./vehicle_profile_logic.js" ></script>
    <script>
    $(function () {
      $('[data-toggle="puv-tooltip"]').tooltip()
    })
    </script>
    <script>
      $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="dist/js/pages/dashboard.js"></script>
    <script src="plugins/feather_icons/feather.min.js"></script>
    <script>feather.replace()</script>
    <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
  </body>
</html>
