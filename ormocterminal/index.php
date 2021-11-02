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
          <a href="" class="nav-link">Home</a>
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
              <a href="" class="d-block">Administrator</a>
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
                <li class="nav-header" style="color: white;">TERMINAL</li>
                <li class="nav-item">
                  <a href="#" onclick="showF()" class="nav-link">
                    <i class="nav-icon fas fa-swatchbook"></i>
                    <p class="cfont-size font-weight-normal">
                      Queueing PUVs
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

                <li class="nav-header" style="color: white;">DISPATCHER</li>
                <li class="nav-item">
                  <a href="#"  onclick="showC()" class="nav-link">
                    <i class="nav-icon fas fa-user-plus"></i>
                    <p class="cfont-size">
                      Add & Manage Account
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
                
                <li class="nav-header" style="color: white;">PROFILES <span class="right badge badge-danger">Under Construction</span></li>
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
                    <h3>&ensp;</h3>

                    <p>Register PUV</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-android-car"></i>
                  </div>
                  <a href="#" onclick="showA()" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3>&ensp;</h3>

                    <p>Queueing PUVs</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                  </div>
                  <a href="#" onclick="showF()" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3>&ensp;</h3>

                    <p>Dispatcher Registration</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-person-add"></i>
                  </div>
                  <a href="#" onclick="showC()" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h3>&ensp;</h3>

                    <p>Manage Dispatcher</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-person-stalker"></i>
                  </div>
                  <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
            </div>
            <!-- /.row -->

            

            <!-- Main row -->
            <div class="row">
              <div class="col-12 container-fluid subfield-7-2">
                <div class="card container-fluid card-danger card-outline">
                  <div class="card-body">
                    <select id="sort-option" class="form-control" onchange="retrieveLogs(this.value)">
                      <option value="latest">Latest</option>
                      <option value="oldest">Oldest</option>
                      <option value="moreoptions">Time</option>
                    </select>
                    <div id="moreoptions" class="form-control">
                      <label for="start-date">From:</label>
                      <input type="date" id="start-date">
                      <label for="end-date">To:</label>
                      <input type="date" id="end-date">
                    </div>
                  </div>
                </div> <!-- /.card -->
              </div> <!-- /.content-fluid x subfield-7-2 -->

              <div class="col-12 container-fluid subfield-7-1">
                <div class="card container-fluid card-danger card-outline">
                  <div class="card-body">
                    <div class="subfield-7-1-sub">
                    </div>
                  </div><!-- /.card-body -->
                </div> <!-- /.card -->
              </div> <!-- /.content-fluid x subfield-7-1 -->

              <div class="col-12 container-fluid subfield-6-2">
                <div class="card container-fluid card-danger card-outline">
                  <div class="card-body">
                      <select id="searched-destination" class="form-control">
                        <option value="">All</option>
                        <option value="valencia">Valencia</option>
                        <option value="puertobello">Puertobello</option>
                        <option value="sabangbao">Sabang-Bao</option>
                        <option value="albuera">Albuera</option>
                      </select>
                  </div>
                </div> <!-- /.card -->
              </div> <!-- /.content-fluid x subfield-6-2 -->

              <div class="col-12 container-fluid subfield-6-1">
                <div class="card container-fluid card-danger card-outline">
                  <div class="card-body">
                    <div id="example2_wrapper" class="subfield-6-1-sub dataTables_wrapper dt-bootstrap4"></div>
                  </div>
                  <!-- /.card-body -->
                </div> <!-- /.card -->
              </div> <!-- /.content-fluid x subfield-6-1 -->

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
                  <!-- /.card-header -->
                </div> <!-- /.card -->
              </div> <!-- /.content-fluid x subfield-4-2 -->
              
              <div class="col-12 content-fluid subfield-4-1">
                <div class="card container-fluid card-danger card-outline">
                  <div class="card-body">
                    <div class="subfield-4-1-sub"></div>
                  </div>
                  <!-- /.card-body -->
                </div> <!-- /.card -->
              </div> <!-- /.content-fluid x subfield-4-1 -->

              <div class="col-12 content-fluid subfield-5-1">
              </div> <!-- /.content-fluid x subfield-5-1 -->
              
              <!-- Left col -->
              <section class="col-lg-7">
                <div class="content-fluid subfield-1-1">
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
                              <input type="tel" class="form-control" name="cnum" id="c_num" placeholder="Contact #" pattern="[0-9]{10}">
                            </div>
                        </div>
                    </div><!-- /.card-body -->
                    <div class="card-footer">
                        <button class="btn btn-block btn-warning font-weight-bold" id="vehicle-submit-button" type="button" onclick="registerVehicle()">Register Vehicle</button>
                    </div>
                  </div> <!-- /.card -->
                </div> <!-- /.content-fluid x subfield-1-1 -->

                <div class="content-fluid subfield-2-1">
                  <div class="card container-fluid card-danger card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Register Passenger</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                            </button>
                        </div> <!--/.card tools-->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" name="fname" id="fi_name" placeholder="First name" maxlength="40">
                        </div>
                        <div class="form-group">
                            <label for="middle_name">Middle Name</label>
                            <input type="text" class="form-control" name="mname" id="mi_name" placeholder="Middle name" maxlength="40">
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" name="lname" id="la_name" placeholder="Last name" maxlength="40">
                        </div>
                        <div class="form-group">
                            <label for="contact_number">Contact Number</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-phone"></i> &ensp;+63</span>
                              </div>
                              <input type="tel" class="form-control" name="cnum" id="co_num" placeholder="Contact #" pattern="[0-9]{10}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="route">Route</label>
                            <select name="dest" id="dt" class="form-control">
                              <option value="">Select destination</option>
                              <option value="albuera">Albuera</option>
                              <option value="valencia">Valencia</option>
                              <option value="sabangbao">Sabang-Bao</option>
                              <option value="puertobello">Puertobello</option>
                            </select>
                        </div>
                    </div><!-- /.card-body -->
                    <div class="card-footer">
                        <button class="btn btn-block btn-warning font-weight-bold" id="passenger-submit-button" type="button" onclick="passengerQr()">Register Passenger</button>
                    </div>
                  </div> <!-- /.card -->
                </div> <!-- /.content-fluid x subfield-2-1 -->

                <div class="content-fluid subfield-3-2">
                  <div class="card container-fluid card-danger card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Dispatchers</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                            </button>
                        </div> <!--/.card tools-->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      <table class="dispatchers-table">
                      </table>
                    </div><!-- /.card-body -->
                  </div> <!-- /.card -->
                </div> <!-- /.content-fluid x subfield-3-2 -->
                
              </section>
              <!-- /.Left col -->

              <!-- right col (We are only adding the ID to make the widgets sortable)-->
              <section class="col-lg-5">
                <div class="container-fluid subfield-1-2">
                  <div class="card container-fluid card-danger card-outline">
                    <div class="card-header">
                        <h3 class="card-title">PUV QR Code</h3>
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
                                <h4 id="vehicle-plateno">QR</h4>
                              </div>
                              <button class="font-weight-bold" onclick="saveVehiclePDF()">SAVE</button>
                          </div>
                        </div>
                    </div><!-- /.card-body -->
                  </div> <!-- /.card -->
                </div> <!-- /.container-fluid x subfield-1-2-->

                <div class="container-fluid subfield-2-2">
                  <div class="card container-fluid card-danger card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Passenger QR Code</h3>
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
                            <div id="passenger-for-print">
                              <div id="passenger-qrimage">
                                <img id="p-qrimage" src="./images/loading.gif">
                              </div>
                              <h4 id="passenger-destination">QR</h4>
                            </div>
                            <button class="font-weight-bold" onclick="savePassengerPDF()">SAVE</button>
                          </div>
                        </div>
                    </div><!-- /.card-body -->
                  </div> <!-- /.card -->
                </div> <!-- /.container-fluid x subfield-2-2-->

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
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="f_name">First Name</label>
                            <input type="text" class="form-control" name="dis_fname" id="dis_f_name" placeholder="First name" maxlength="40">
                        </div>
                        <div class="form-group">
                            <label for="middle_name">Middle Name</label>
                            <input type="text" class="form-control" name="dis_mname" id="dis_m_name" placeholder="Middle name" maxlength="40">
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" name="dis_lname" id="dis_l_name" placeholder="Last name" maxlength="40">
                        </div>
                        <div class="form-group">
                            <label for="contact_number">Contact Number</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-phone"></i> &ensp;+63</span>
                              </div>
                              <input type="tel" class="form-control" maxlength="11" name="dis_cnum" id="dis_c_num" placeholder="Contact #" pattern="[0-9]{10}">
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-block btn-primary font-weight-bold" id="pin-button" onclick="pinGenerator()">GENERATE PIN</button>
                        </div>
                        <div class="form-group">
                            <label for="pin">Generated PIN</label>
                            <input type="text" class="form-control" id="gen-pin" type="num" maxlength="4" placeholder="PIN" name="dis_pin" pattern="[0-9]{4}" disabled>
                        </div>
                    </div><!-- /.card-body -->
                    <div class="card-footer">
                        <button class="btn btn-block btn-warning font-weight-bold" id="dispatcher-submit-button" onclick="registerDispatcher()">Register Dispatcher</button>
                    </div>
                  </div> <!-- /.card -->
                </div> <!-- /.content-fluid x subfield-3-1 -->
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
    <script src="plugins/feather_icons/feather.min.js"></script>
    <script>feather.replace()</script>
    <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
  </body>
</html>
