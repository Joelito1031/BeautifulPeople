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
    <div class="wrapper">

      <!-- Preloader -->
      <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__wobble" src="images/logoQrmoc.png" alt="Q R M O C" height="150" width="150">
      </div>

      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="./dashboard" class="nav-link">Home</a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">

        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            Settings
            <i class="fas fa-cog"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">Settings</span>
            <div class="dropdown-divider"></div>
            <a href="#" onclick="exit()" class="dropdown-item">
              <i class="fas fa-sign-out-alt mr-2"></i> LOGOUT
              <span class="float-right text-muted text-sm"></span>
            </a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="" class="brand-link">
          <img src="images/logoQrmoc.png" alt="Q R M O C" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light">Q r m o c</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar ">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img src="images/adminUserProfile.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
              <a href="./dashboard" class="d-block">Administrator</a>
            </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                  <a href="./dashboard" class="nav-link">
                    <i class="nav-icon fas fa-home"></i>
                    <p class="cfont-size">
                      Dashboard
                    </p>
                  </a>
                </li>
                <li class="nav-header" style="color: white;">QR CODE</li>
                <!-- <li class="nav-item">
                  <a href="#" onclick="showB()" class="nav-link">
                    <i class="nav-icon fas fa-qrcode"></i>
                    <p class="cfont-size">
                      Register Passenger QR
                    </p>
                  </a>
                </li> -->
                <li class="nav-item">
                  <a href="./registerpuv" class="nav-link">
                    <i class="nav-icon fas fa-truck"></i>
                    <p class="cfont-size">
                      Generate PUV QR
                    </p>
                  </a>
                </li>
                <li class="nav-header" style="color: white;">TERMINAL</li>
                <li class="nav-item">
                  <a href="./queuingpuv" class="nav-link">
                    <i class="nav-icon fas fa-swatchbook"></i>
                    <p class="cfont-size font-weight-normal">
                      Queueing PUVs
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="./waitingpassengers" class="nav-link">
                    <i class="nav-icon" data-feather="clock"></i>
                    <p class="cfont-size font-weight-normal">
                      Waiting Passengers
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="./returningpuv" class="nav-link">
                    <i class="nav-icon" data-feather="corner-down-left"></i>
                    <p class="cfont-size font-weight-normal">
                      Returning PUVs
                    </p>
                  </a>
                </li>

                <li class="nav-header" style="color: white;">DISPATCHER</li>
                <li class="nav-item">
                  <a href="./registerdispatcher" class="nav-link">
                    <i class="nav-icon fas fa-user-plus"></i>
                    <p class="cfont-size">
                      Add & Manage Account
                    </p>
                  </a>
                </li>

                <li class="nav-header" style="color: white;">REPORTS</li>

                <li class="nav-item">
                  <a href="./logs" class="nav-link">
                    <i class="nav-icon fas fa-clipboard-list"></i>
                    <p class="cfont-size">
                      Logs
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-stream"></i>
                    <p class="cfont-size">
                      History
                    </p>
                  </a>
                </li>

                <li class="nav-header" style="color: white;">PROFILES</li>
                <li class="nav-item menu-open">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p class="cfont-size">
                      Profiles
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="./dispatcherprofile" class="nav-link">
                      <!-- <i class="far fa-circle nav-icon"></i> -->
                      <i class="nav-icon" data-feather="user"></i>
                        <p class="cfont-size">
                          Dispatcher Profile
                        </p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="./vehicleprofile" class="nav-link">
                        <i class="nav-icon" data-feather="truck"></i>
                        <p class="cfont-size">
                          Vehicle Profile
                        </p>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </aside>
      <section class="content">
        <div class="container-fluid">
          <div class="content-wrapper">
            <div class="content-header">
              <div class="container-fluid">
                <div class="row mb-2">
                  <div class="col-sm-6">
                    <h1 class="m-0 sub-text-2">Returning PUVs</h1>
                  </div><!-- /.col -->
                  <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="./dashboard">Home</a></li>
                      <li class="breadcrumb-item active">Administrator</li>
                    </ol>
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
      <script type="text/javascript" src="./returning_puv_logic.js" ></script>
    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
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
