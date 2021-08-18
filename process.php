<?php
include('./phpqrcode/qrlib.php');

if((isset($_POST['fname']) && !empty(trim($_POST['fname']))) && (isset($_POST['mname']) && !empty(trim($_POST['mname'])))
  && (isset($_POST['lname']) && !empty(trim($_POST['lname']))) && (isset($_POST['cnum']) && !empty(trim($_POST['cnum'])))
  && (isset($_POST['plateno']) && !empty(trim($_POST['plateno']))) && (isset($_POST['route']) && !empty(trim($_POST['route'])))
  && (isset($_POST['capacity']) && !empty(trim($_POST['capacity'])))){

  ob_start();
  $name = $_POST['fname'] . ' ' . $_POST['mname'] . ' ' . $_POST['lname'];
  $capacity = (int) $_POST['capacity'];
  $data = array($_POST['plateno'] => array("operator" => $_POST['fname'] . " " . $_POST['mname'] . " " . $_POST['lname'],
          "contact_num" => $_POST['cnum'], "route" => $_POST['route'], "capacity" => $capacity, "passengers" => 0, "queuing" => false));
  $vehicles_json = file_get_contents('./vehicles/vehicles.json');
  $vehicles_data = json_decode($vehicles_json, true);
  array_push($vehicles_data, $data);
  $data_json = json_encode($vehicles_data);
  $vehicles_file = fopen('./vehicles/vehicles.json', 'w');
  fwrite($vehicles_file, $data_json);
  fclose($vehicles_file);
  QRcode::png($_POST['plateno'], './qrs/' . $_POST['plateno'] . '.png', QR_ECLEVEL_L, 4);
  ob_end_clean();
  header('Location: ./index.html?qr=' . $_POST['plateno']);
}
else{
  echo "Please fill all the fields";
}
