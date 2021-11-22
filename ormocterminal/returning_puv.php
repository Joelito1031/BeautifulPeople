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
                    <h4 class="m-0 sub-text-2"><span data-toggle="returning-tooltip" title="The table below lists all the registered PUVs, set PUV to returning mode by pressing the buttons under the Returning column." class="fas fa-question-circle" style="color: #9edbff;"></span>&thinsp;Returning PUVs</h4>
                  </div><!-- /.col -->
                </div><!-- /.row -->
              </div><!-- /.container-fluid -->
            </div>
            <div class="row">
              <div class="col-12 content-fluid subfield-4-2">
                <div class="card container-fluid card-danger card-outline">
                  <div class="card-body">
                    <select id="searched-returning" class="form-control">
                      <option value="">All</option>
                      <option value="valencia">Valencia</option>
                      <option value="puertobello">Puertobello</option>
                      <option value="sabangbao">Sabang-Bao</option>
                      <option value="albuera">Albuera</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-12 content-fluid subfield-4-1">
                <div class="card container-fluid card-danger card-outline">
                  <div class="card-body">
                    <div class="form-inline" style="width: 400px;">
                      <input id="search-input" class="form-control form-control-sm mr-3 w-75" type="text" placeholder="Search vehicle plate number" aria-label="Search" maxlength="7" onkeyup="this.value = makePlateNoCorrect(this.value);">
                      <i id="search-ico" class="fas fa-search" aria-hidden="true"></i>
                    </div>
                    <br>
                    <div class="subfield-4-1-sub"></div>
                  </div>
                </div>
              </div>
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
    <script type="text/javascript" src="./returning_puv_logic.js" ></script>
    <script>
    $(function () {
      $('[data-toggle="returning-tooltip"]').tooltip()
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
