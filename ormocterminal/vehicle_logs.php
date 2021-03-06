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
                    <h4 class="m-0 sub-text-2"><span data-toggle="logs-tooltip" title="Choose [Oldest] to sort logs from oldest to latest,
                      Choose [Latest] to sort logs from latest to oldest, Choose [Time] to choose specific date, Choose [Alphabet] to sort alphabetically.
                      Use search field to search PUV." class="fas fa-question-circle" style="color: #9edbff;"></span>&thinsp;View Logs</h4>
                  </div><!-- /.col -->
                </div><!-- /.row -->
              </div><!-- /.container-fluid -->
            </div>
            <div class="row">
              <div class="col-12 container-fluid">
                <div class="card container-fluid card-danger card-outline">
                  <div class="card-body subfield-7-2">
                    <select id="sort-option" class="form-control" onchange="retrieveLogs()">
                      <option value="">Select to show data</option>
                      <option value="latest">Latest</option>
                      <option value="oldest">Oldest</option>
                      <option value="alphabetically">Alphabetically</option>
                      <option value="moreoptions">Time</option>
                    </select>
                      <div id="moreoptions" class="form-control">
                        <label for="start-date">From:</label>
                        <input type="date" id="start-date" onchange="retrieveLogs()">
                        <label for="end-date">To:</label>
                        <input type="date" id="end-date" onchange="retrieveLogs()">
                      </div>
                  </div>
                </div>
              </div>
              <div class="col-12 container-fluid subfield-7-1">
                <div class="card container-fluid card-danger card-outline">
                  <div class="card-body">
                    <div class="form-inline" style="width: 400px;">
                        <input id="search-input" class="form-control form-control-sm mr-3 w-75" type="text" placeholder="Press enter to search for plate number" aria-label="Search" maxlength="7" onkeyup="this.value = makePlateNoCorrect(this.value)" onfocusout="showSorter()">
                      <i id="search-ico" class="fas fa-search" aria-hidden="true"></i>
                    </div>
                    <br>
                    <div class="subfield-7-1-sub">
                    </div>
                  </div><!-- /.card-body -->
                </div> <!-- /.card -->
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- /.content-wrapper -->
      <footer class="main-footer">
        <strong>Copyright &copy; <a href="http://119.92.152.243/QRMOC/">Qrmoc - Queueing Passenger Assistance App</a>.</strong>
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
    <script type="text/javascript" src="./vehicle_logs_logic.js" ></script>
    <script>
    $(function () {
      $('[data-toggle="logs-tooltip"]').tooltip()
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
