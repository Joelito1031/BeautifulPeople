<?php

include('./phpqrcode/qrlib.php');

if((isset($_GET['fname']) && !empty(trim($_GET['fname']))) && (isset($_GET['mname']) && !empty(trim($_GET['mname'])))
  && (isset($_GET['lname']) && !empty(trim($_GET['lname']))) && (isset($_GET['cnum']) && !empty(trim($_GET['cnum'])))
  && (isset($_GET['dst']) && !empty(trim($_GET['dst'])))){
    $passenger_info = (object) array("name" => $_GET['fname'] . ' ' . $_GET['mname'] . ' ' . $_GET['lname'], "cnum" => $_GET['cnum'], "destination" => $_GET['dst']);
    $info = json_encode($passenger_info);
    QRcode::png($info);
  }
else{
  echo "Please fill all the fields.";
}
