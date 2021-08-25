<?php
include('./phpqrcode/qrlib.php');

$database = "";
$user = "";
$password = "";

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

    $select_query = "SELECT COUNT(*) FROM registered_vehicles WHERE PlateNo = '$plateno'";
    $num_row = $connection->query($select_query);
    $row_count = $num_row->fetchColumn();
    $count = (int) $row_count;
    $operator = $_POST['fname'] . ' ' . $_POST['mname'] . ' ' . $_POST['lname'];
    $contact = $_POST['cnum'];
    $vehicle_capacity = array();

    if($count > 0){
      echo "Vehicle already registered";
    }
    else{
      for($count = 1; $count <= $capacity; $count++){
        array_push($vehicle_capacity, '');
      }
      $full_capacity = json_encode($vehicle_capacity);

      $insert_query = "INSERT INTO registered_vehicles(PlateNo, Route, Capacity, Operator, Contact) VALUES('$plateno', '$route', '$capacity', '$operator', '$contact')";

      $connection->exec($insert_query);

      $name = $_POST['fname'] . ' ' . $_POST['mname'] . ' ' . $_POST['lname'];
      $capacity = (int) $_POST['capacity'];
      $data = array("vehicle" => $_POST['plateno'], "operator" => $_POST['fname'] . " " . $_POST['mname'] . " " . $_POST['lname'],
              "contact_num" => $_POST['cnum'], "route" => $_POST['route'], "capacity" => $capacity, "passengers" => 0, "queuing" => false);
      $vehicles_json = file_get_contents('./vehicles/vehicles.json');
      $vehicles_data = json_decode($vehicles_json, true);

      array_push($vehicles_data, $data);

      $data_json = json_encode($vehicles_data);
      $vehicles_file = fopen('./vehicles/vehicles.json', 'w');
      $vehicle_name = fopen('./vehicles/' . $route . '_' . $plateno . '.json', 'w');

      fwrite($vehicles_file, $data_json);
      fwrite($vehicle_name, $full_capacity);
      fclose($vehicles_file);
      fclose($vehicle_capacity);
      QRcode::png($_POST['plateno'], './qrs/' . $_POST['plateno'] . '.png', QR_ECLEVEL_L, 4, 10);
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
