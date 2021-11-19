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
                    <h1 class="m-0 sub-text-2">Add & Change Status</h1>
                  </div><!-- /.col -->
                  <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="./dashboard">Home</a></li>
                      <li class="breadcrumb-item active">Administrator</li>
                    </ol>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <section class="col-lg-6">
                <div class="content-fluid subfield-3-1">
                  <div class="card container-fluid card-danger card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Register Dispatacher</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                            </button>
                        </div> <!--/.card tools-->
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <span data-toggle="dispatcher-tooltip" title="Numbers and special characters are not accepted." class="fas fa-info-circle" style="color: #9edbff;"></span>
                            <label for="f_name">First name</label>
                            <input type="text" class="form-control" id="dis_f_name" placeholder="First name" maxlength="40" onkeyup="this.value = makeItCorrect(this.value)">
                        </div>
                        <div class="form-group">
                            <span data-toggle="dispatcher-tooltip" title="Numbers and special characters are not accepted." class="fas fa-info-circle" style="color: #9edbff;"></span>
                            <label for="middle_name">Middle name</label>
                            <input type="text" class="form-control" id="dis_m_name" placeholder="Middle name" maxlength="40" onkeyup="this.value = makeItCorrect(this.value)">
                        </div>
                        <div class="form-group">
                            <span data-toggle="dispatcher-tooltip" title="Numbers and special characters are not accepted." class="fas fa-info-circle" style="color: #9edbff;"></span>
                            <label for="last_name">Last name</label>
                            <input type="text" class="form-control" id="dis_l_name" placeholder="Last name" maxlength="40" onkeyup="this.value = makeItCorrect(this.value)">
                        </div>
                        <div class="form-group">
                            <span data-toggle="dispatcher-tooltip" title="Choose a suffix, choose None if dispatcher has no suffix." class="fas fa-info-circle" style="color: #9edbff;"></span>
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
                          <span data-toggle="dispatcher-tooltip" title="Just append the last 10 digits of mobile number." class="fas fa-info-circle" style="color: #9edbff;"></span>
                          <label for="contact_number">Mobile number</label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-phone"></i> &ensp;+63</span>
                            </div>
                            <input type="tel" class="form-control" maxlength="10" id="dis_c_num" placeholder="Contact #" pattern="[0-9]{10}">
                          </div>
                        </div>
                        <div class="form-group">
                          <button class="btn btn-block btn-primary font-weight-bold" id="pin-button" onclick="pinGenerator()">GENERATE PIN</button>
                        </div>
                        <div class="form-group">
                          <span data-toggle="dispatcher-tooltip" title="Press the generate PIN button above to generate a PIN." class="fas fa-info-circle" style="color: #9edbff;"></span>
                          <label for="pin">Generated PIN</label>
                          <input class="form-control" id="gen-pin" type="num" maxlength="4" placeholder="PIN" name="dis_pin" pattern="[0-9]{4}" disabled>
                        </div>
                        <div style="display: flex; flex-direction: column; align-items: center;">
                          <div>
                            <span data-toggle="dispatcher-tooltip" title="Profile picture is optional, you can leave it empty and the dispatcher will have the default profile picture." class="fas fa-info-circle" style="color: #9edbff;"></span>
                            <label>Profile picture <span style="color: red">(Optional)</span></label>
                          </div>
                          <div class="dispatcher-prof-container">
                            <div>
                              <img id="actual-pic" src="./images/adminUserProfile.png">
                              <div class="front-word" onclick="openFile()" title="Upload profile picture">
                                <span class="fas fa-pencil-alt"></span>
                              </div>
                              <div class="back-element">
                                <input id="profile-pic" type="file" accept="image/*">
                              </div>
                            </div>
                          </div>
                        </div>
                    </div><!-- /.card-body -->
                    <div class="card-footer">
                        <button class="btn btn-block btn-warning font-weight-bold" id="dispatcher-submit-button" onclick="registerDispatcher()">Register Dispatcher</button>
                    </div>
                  </div> <!-- /.card -->
                </div>
              </section>
              <section class="col-lg-6">
                <div class="content-fluid subfield-3-2">
                   <div class="card container-fluid card-danger card-outline">
                     <div class="card-header">
                       <div class="card-title"><span data-toggle="dispatcher-tooltip" title="By pressing the duty buttons, you can set the status of the dispatchers from on duty to off duty and vice versa. (Yellow=onduty, Black=offduty)" class="fas fa-question-circle" style="color: #9edbff;"></span>  Dispatchers</div>
                       <div class="card-tools">
                          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                          </button>
                        </div>
                     </div>
                     <div class="card-body">
                       <div class="dispatchers-table-container">
                         <table class="dispatchers-table">
                         </table>
                       </div>
                     </div>
                   </div>
                </div>
              </section>
            </div>
          </div>
        </div>
      </section>
      <!-- /.content-wrapper -->
      <footer class="main-footer">
        <strong>Copyright &copy; <a href="#">Qrmoc - Queueing Passenger Assistance App</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
          <b>Ormoc City Terminal</b>
        </div>
      </footer>

    </div>
    <!-- ./wrapper -->

    <!-- Custom JS -->
    <script type="text/javascript" src="html2pdf.bundle.min.js" ></script>
    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
      <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script type="text/javascript" src="./register_dispatcher_logic.js" ></script>
    <script>
    $(function () {
      $('[data-toggle="dispatcher-tooltip"]').tooltip()
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
