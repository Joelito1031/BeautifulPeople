<?php
include('./phpqrcode/qrlib.php');

if((isset($_POST['fname']) && !empty(trim($_POST['fname']))) && (isset($_POST['mname']) && !empty(trim($_POST['mname'])))
  && (isset($_POST['lname']) && !empty(trim($_POST['lname']))) && (isset($_POST['cnum']) && !empty(trim($_POST['cnum'])))
  && (isset($_POST['plateno']) && !empty(trim($_POST['plateno']))) && (isset($_POST['route']) && !empty(trim($_POST['route'])))
  && (isset($_POST['capacity']) && !empty(trim($_POST['capacity'])))){

  $server = 'localhost';
  $username = 'root';
  $password = '';
  $dbname = 'OCQMS';
  $plateno = $_POST['plateno'];
  $route = $_POST['route'];
  $capacity = (int)$_POST['capacity'];

  try{
    $connection = new PDO("mysql:host=$server;dbname=$dbname", $username, $password);

    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $select_query = "SELECT * FROM registered_vehicles WHERE PlateNo = '$plateno'";
    $num_row = $connection->query($select_query);
    $row_count = $num_row->fetchColumn();

    if($row_count > 0){
      echo "Vehicle already registered";
    }
    else{
      $insert_query = "INSERT INTO registered_vehicles(PlateNo, Route, Capacity) VALUES('$plateno', '$route', '$capacity')";

      $connection->exec($insert_query);
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
      QRcode::png($_POST['plateno'], './qrs/' . $_POST['plateno'] . '.png', QR_ECLEVEL_L, 4, 10);
      ob_end_clean();
      header('Location: ./index.html?qr=' . $_POST['plateno']);
      echo "Vehicle registered";
    }
  }catch(PDOException $e){
    echo 'Error:' . ' ' . $e->getMessage();
  }
  $connection = null;
}
else{
  echo "Please fill all the fields";
}
