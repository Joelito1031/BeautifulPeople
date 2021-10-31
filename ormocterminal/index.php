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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href="style.css" type="text/css" rel="stylesheet" >
    <link href="dist/css/adminlte.min.css" type="text/css" rel="stylesheet" >
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

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
        <img class="animation__wobble" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
      </div>

      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="index3.html" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link">Contact</a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
          <a class="nav-link" data-widget="navbar-search" href="#" role="button">
            <i class="fas fa-search"></i>
          </a>
          <div class="navbar-search-block">
            <form class="form-inline">
              <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                  <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                  <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </li>

        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-comments"></i>
            <span class="badge badge-danger navbar-badge">3</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <a href="#" class="dropdown-item">
              <!-- Message Start -->
              <div class="media">
                <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    Brad Diesel
                    <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                  </h3>
                  <p class="text-sm">Call me whenever you can...</p>
                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
              </div>
              <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <!-- Message Start -->
              <div class="media">
                <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    John Pierce
                    <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                  </h3>
                  <p class="text-sm">I got your message bro</p>
                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
              </div>
              <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <!-- Message Start -->
              <div class="media">
                <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    Nora Silvester
                    <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                  </h3>
                  <p class="text-sm">The subject goes here</p>
                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
              </div>
              <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
          </div>
        </li>
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge">15</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">15 Notifications</span>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-envelope mr-2"></i> 4 new messages
              <span class="float-right text-muted text-sm">3 mins</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-users mr-2"></i> 8 friend requests
              <span class="float-right text-muted text-sm">12 hours</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-file mr-2"></i> 3 new reports
              <span class="float-right text-muted text-sm">2 days</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
            <i class="fas fa-th-large"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="#" class="brand-link">
          <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light">Q r m o c</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar ">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
              </div>
              <div class="info">
                <a href="#" class="d-block">Administrator</a>
              </div>
            </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                  <a href="#" onclick="showXA()" class="nav-link">
                    <i class="nav-icon fas fa-home"></i>
                    <p class="cfont-size">
                      Dashboard
                    </p>
                  </a>
                </li>
                <li class="nav-header" style="color: white;">QR CODE</li>
                <li class="nav-item">
                  <a href="#" onclick="showB()" class="nav-link">
                    <i class="nav-icon fas fa-qrcode"></i>
                    <p class="cfont-size">
                      Register Passenger QR
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" onclick="showA()" class="nav-link">
                    <i class="nav-icon fas fa-truck"></i>
                    <p class="cfont-size">
                      Generate PUV QR
                    </p>
                  </a>
                </li>
                <li class="nav-header" style="color: white;">QUEUEING</li>
                <li class="nav-item">
                  <a href="#" onclick="showF()" class="nav-link">
                    <i class="nav-icon fas fa-swatchbook"></i>
                    <p class="cfont-size font-weight-normal">
                      Current Queueing PUVs
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" onclick="showE()" class="nav-link">
                    <i class="nav-icon" data-feather="clock"></i>
                    <p class="cfont-size font-weight-normal">
                      Waiting Passengers
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" onclick="showD()" class="nav-link">
                    <i class="nav-icon" data-feather="corner-down-left"></i>
                    <p class="cfont-size font-weight-normal">
                      Returning PUVs
                    </p>
                  </a>
                </li>

                <li class="nav-header" style="color: white;">TERMINAL <span class="right badge badge-danger">Under Construction</span></li>

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
                      <a href="#" class="nav-link">
                      <!-- <i class="far fa-circle nav-icon"></i> -->
                      <i class="nav-icon" data-feather="user"></i>
                        <p class="cfont-size">
                          Dispatcher Profile
                        </p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <!-- <i class="far fa-circle nav-icon"></i> -->
                        <i class="nav-icon" data-feather="truck"></i>
                        <p class="cfont-size">
                          Vehicle Profile
                        </p>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="nav-header" style="color: white;">DISPATCHER</li>
                <li class="nav-item">
                  <a href="#"  onclick="showC()" class="nav-link">
                    <i class="nav-icon fas fa-user-plus"></i>
                    <p class="cfont-size">
                      Create Account
                    </p>
                  </a>
                </li>
                
                <li class="nav-header" style="color: white;">REPORTS</li>
                
                <li class="nav-item">
                  <a href="#" onclick="showG()" class="nav-link">
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
                      Statistics <span class="right badge badge-danger">Under Construction</span>
                    </p>
                  </a>
                </li>
                
              </ul>
            </nav>
            <!-- /.sidebar-menu -->
          </div>
        </div>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 sub-text-1">Dashboard</h1>
                <h1 class="m-0 sub-text-2">Generate PUV QR</h1>
                <h1 class="m-0 sub-text-3">Register Passenger QR</h1>
                <h1 class="m-0 sub-text-4">Register Dispatcher</h1>
                <h1 class="m-0 sub-text-5">Returning PUVs</h1>
                <h1 class="m-0 sub-text-6">Waiting Passengers</h1>
                <h1 class="m-0 sub-text-7">Queueing Vehicles</h1>
                <h1 class="m-0 sub-text-8">Logs</h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#" onclick="showXA()">Home</a></li>
                  <li class="breadcrumb-item active">Administrator</li>
                </ol>
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row subfield-0-1">
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3>150</h3>

                    <p>New Orders</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bag"></i>
                  </div>
                  <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3>53<sup style="font-size: 20px">%</sup></h3>

                    <p>Bounce Rate</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                  </div>
                  <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3>44</h3>

                    <p>User Registrations</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-person-add"></i>
                  </div>
                  <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h3>65</h3>

                    <p>Unique Visitors</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                  </div>
                  <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
            </div>
            <!-- /.row -->
            <!-- Main row -->
            <div class="row">
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
              <!-- Left col -->
              <section class="col-lg-7 content-fluid subfield-1-1">
                <div class="card container-fluid card-danger card-outline">
                  <div class="card-header">
                      <h3 class="card-title">Register PUV</h3>
                      <div class="card-tools">
                          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                          <i class="fas fa-minus"></i>
                          </button>
                      </div> <!--/.card tools-->
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                      <div class="form-group">
                          <label for="plate_number">Plate Number</label>
                          <input type="text" class="form-control" name="plateno" id="plate_no" placeholder="Plate #" pattern="[A-Z]{3}-[0-9]{3}" onkeyup="this.value = this.value.toUpperCase();">
                      </div>
                      <div class="form-group">
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
                          <label for="puv">PUV</label>
                          <select name="capacity" id="cpcty" class="form-control">
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
                      <br>
                      <label><sup>Operator's Information</sup></label>
                      <div class="form-group">
                          <label for="first_name">First Name</label>
                          <input type="text" class="form-control" name="fname" id="f_name" placeholder="First name" maxlength="40">
                      </div>
                      <div class="form-group">
                          <label for="middle_name">Middle Name</label>
                          <input type="text" class="form-control" name="mname" id="m_name" placeholder="Middle name" maxlength="40">
                      </div>
                      <div class="form-group">
                          <label for="last_name">Last Name</label>
                          <input type="text" class="form-control" name="lname" id="l_name" placeholder="Last name" maxlength="40">
                      </div>
                      <div class="form-group">
                          <label for="contact_number">Contact Number</label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-phone"></i> &ensp;+63</span>
                            </div>
                            <input type="tel" class="form-control" name="cnum" id="c_num" placeholder="Contact #" pattern="[0-9]{11}">
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="exampleInputFile">File input</label>
                          <div class="input-group">
                              <div class="custom-file">
                              <input type="file" class="custom-file-input" id="image">
                              <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                          </div>
                              <div class="input-group-append">
                                  <span class="input-group-text">Upload</span>
                              </div>
                          </div>
                      </div>
                  </div><!-- /.card-body -->
                  <div class="card-footer">
                      <button class="btn btn-block btn-warning"id="vehicle-submit-button" type="button" onclick="registerVehicle()">Register Vehicle</button>
                  </div>
                </div>
              </section>
              <!-- /.Left col -->
              <!-- right col (We are only adding the ID to make the widgets sortable)-->
              <section class="col-lg-5 subfield-1-2">
                <div class="card container-fluid card-danger card-outline">
                  <div class="card-header">
                      <h3 class="card-title">Register PUV</h3>
                      <div class="card-tools">
                          <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                          </button>
                      </div> <!--/.card tools-->
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                      <div class="form-group">
                          <div class="generated-qr">
                            <div id="vehicle-for-print">
                              <img id="vehicle-qrimage" src="./images/loading.gif">
                              <h3 id="vehicle-plateno">QR</h3>
                            </div>
                            <button onclick="saveVehiclePDF()">SAVE</button>
                        </div>
                      </div>
                  </div><!-- /.card-body -->
                  <!-- <div class="card-footer">
                      <button class="btn btn-block btn-warning"id="vehicle-submit-button" type="button" onclick="registerVehicle()">Register Vehicle</button>
                  </div> -->
                </div>
              </section>
              <!-- right col -->
            </div>
            <!-- /.row (main row) -->
          </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
      <footer class="main-footer">
        <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
          <b>Version</b> 3.1.0
        </div>
      </footer>

    </div>
    <!-- ./wrapper -->

    <!-- Custom JS -->
    <script type="text/javascript" src="html2pdf.bundle.min.js" ></script>
    <script type="text/javascript" src="./logic.js" ></script>
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
  </body>
</html>
