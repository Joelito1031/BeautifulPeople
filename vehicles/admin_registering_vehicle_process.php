<?php
session_start();
if(isset($_SESSION['loggedin'])){
  if(!$_SESSION['loggedin']){
    header('Location: ./');
  }
}
else{
  header('Location: ./');
}
include('./phpqrcode/qrlib.php');

function infoCrypt($plaintext){
  $key = "udWH+XfEbKB44oqM";

  $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
  $iv = openssl_random_pseudo_bytes($ivlen);
  $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
  $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
  $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );

  return $ciphertext;
}

if((isset($_POST['fname']) && !empty(trim($_POST['fname']))) && (isset($_POST['mname']) && !empty(trim($_POST['mname'])))
  && (isset($_POST['lname']) && !empty(trim($_POST['lname']))) && (isset($_POST['cnum']) && !empty(trim($_POST['cnum'])))
  && (isset($_POST['plateno']) && !empty(trim($_POST['plateno']))) && (isset($_POST['route']) && !empty(trim($_POST['route'])))
  && (isset($_POST['capacity']) && !empty(trim($_POST['capacity']))) && (isset($_POST['dfname']) && !empty(trim($_POST['dfname']))) && (isset($_POST['dmname']) && !empty(trim($_POST['dmname'])))
  && (isset($_POST['dlname']) && !empty(trim($_POST['dlname']))) && (isset($_POST['dcnum']) && !empty(trim($_POST['dcnum']))) && (isset($_POST['address']) && trim($_POST['address']) != "")
  && (isset($_POST['daddress']) && trim($_POST['daddress']) != "")){

  $plateno = $_POST['plateno'];
  $route = $_POST['route'];
  $capacity = (int)$_POST['capacity'];

  try{
    require 'db_connection.php';
    $checkplateno = $connection->prepare("SELECT COUNT(*) as Count, Status FROM registered_vehicles WHERE PlateNo = :plateno");
    $checkplateno->bindParam(':plateno', $plateno);
    $checkplateno->execute();
    $row_count = $checkplateno->fetch();

    $contact = $_POST['cnum'];
    $vehicle_info = array("type" => "vehicle", "plateno" => $plateno);
    $vehicle_capacity = array();
    if($row_count['Count'] > 0){
      if($row_count['Status'] == 'Deleted'){
        for($count = 1; $count <= $capacity; $count++){
          array_push($vehicle_capacity, array("Name" => "", "Companion" => ""));
        }
        $full_capacity = json_encode($vehicle_capacity);
        $register_vehicle = $connection->prepare("UPDATE registered_vehicles SET FirstName = :firstname, MiddleName = :middlename, LastName = :lastname, Suffix = :suffix, Address = :address, Route = :route, Capacity = :capacity,
                                                 Contact = :contact, DFirstName = :dfname, DMiddleName = :dmname, DLastName = :dlname, DSuffix = :dsuffix, DContact = :dcontact, DAddress = :daddress, Status = 'Active' WHERE PlateNo = :plateno");
        $register_vehicle->bindParam(':firstname', $_POST['fname']);
        $register_vehicle->bindParam(':middlename', $_POST['mname']);
        $register_vehicle->bindParam(':lastname', $_POST['lname']);
        $register_vehicle->bindParam(':suffix', $_POST['suffix']);
        $register_vehicle->bindParam(':plateno', $plateno);
        $register_vehicle->bindParam(':route', $route);
        $register_vehicle->bindParam(':capacity', $capacity);
        $register_vehicle->bindParam(':contact', $contact);
        $register_vehicle->bindParam(':dfname', $_POST['dfname']);
        $register_vehicle->bindParam(':dmname', $_POST['dmname']);
        $register_vehicle->bindParam(':dlname', $_POST['dlname']);
        $register_vehicle->bindParam(':dsuffix', $_POST['dsuffix']);
        $register_vehicle->bindParam(':dcontact', $_POST['dcnum']);
        $register_vehicle->bindParam(':daddress', $_POST['daddress']);
        $register_vehicle->bindParam(':address', $_POST['address']);
        $register_vehicle->execute();
        $is_success = $register_vehicle->rowCount();
        if($is_success > 0){
          $driver = $_POST['dfname'] . ' ' . $_POST['dmname'] . ' ' . $_POST['dlname'] . ' ' . $_POST['dsuffix'];
          $name = $_POST['fname'] . ' ' . $_POST['mname'] . ' ' . $_POST['lname'] . ' ' . $_POST['suffix'];
          $data = array("vehicle" => $_POST['plateno'], "operator" => $name, "driver" => $driver, "contact_num" => $_POST['cnum'], "route" => $_POST['route'], "capacity" => $capacity, "queuing" => false, "returning" => false);
          $vehicles_json = file_get_contents('./vehicles/vehicles.json');
          $vehicles_data = json_decode($vehicles_json, true);
          array_push($vehicles_data, $data);
          $data_json = json_encode($vehicles_data);
          $vehicles_file = fopen('./vehicles/vehicles.json', 'w');
          $vehicle_name = fopen('./vehicles/' . $route . '_' . $plateno . '.json', 'w');
          fwrite($vehicles_file, $data_json);
          fwrite($vehicle_name, $full_capacity);
          fclose($vehicles_file);
          fclose($vehicle_name);
          QRcode::png(infoCrypt(json_encode($vehicle_info)), './qrs/' . $_POST['plateno'] . '.png', QR_ECLEVEL_L, 4);
          echo $_POST['plateno'];
        }else{
          echo "error";
        }
      }else{
        echo "registered";
      }
    }else{
      for($count = 1; $count <= $capacity; $count++){
        array_push($vehicle_capacity, array("Name" => "", "Companion" => "", "Number" => ""));
      }
      $full_capacity = json_encode($vehicle_capacity);
        $register_vehicle = $connection->prepare("INSERT INTO registered_vehicles(FirstName, MiddleName, LastName, Suffix, Address, PlateNo, Route, Capacity, Contact, DFirstName, DMiddleName, DLastName, DSuffix, DContact, DAddress, Status)
                                                  VALUES(:firstname, :middlename, :lastname, :suffix, :address, :plateno, :route, :capacity, :contact, :dfname, :dmname, :dlname, :dsuffix, :dcontact, :daddress, 'Active')");
        $register_vehicle->bindParam(':firstname', $_POST['fname']);
        $register_vehicle->bindParam(':middlename', $_POST['mname']);
        $register_vehicle->bindParam(':lastname', $_POST['lname']);
        $register_vehicle->bindParam(':suffix', $_POST['suffix']);
        $register_vehicle->bindParam(':plateno', $plateno);
        $register_vehicle->bindParam(':route', $route);
        $register_vehicle->bindParam(':capacity', $capacity);
        $register_vehicle->bindParam(':contact', $contact);
        $register_vehicle->bindParam(':dfname', $_POST['dfname']);
        $register_vehicle->bindParam(':dmname', $_POST['dmname']);
        $register_vehicle->bindParam(':dlname', $_POST['dlname']);
        $register_vehicle->bindParam(':dsuffix', $_POST['dsuffix']);
        $register_vehicle->bindParam(':dcontact', $_POST['dcnum']);
        $register_vehicle->bindParam(':daddress', $_POST['daddress']);
        $register_vehicle->bindParam(':address', $_POST['address']);
        $register_vehicle->execute();
        $driver = $_POST['dfname'] . ' ' . $_POST['dmname'] . ' ' . $_POST['dlname'] . ' ' . $_POST['dsuffix'];
        $name = $_POST['fname'] . ' ' . $_POST['mname'] . ' ' . $_POST['lname'] . ' ' . $_POST['suffix'];
        $data = array("vehicle" => $_POST['plateno'], "operator" => $name, "driver" => $driver, "contact_num" => $_POST['cnum'], "route" => $_POST['route'], "capacity" => $capacity, "queuing" => false, "returning" => false);
        $vehicles_json = file_get_contents('./vehicles/vehicles.json');
        $vehicles_data = json_decode($vehicles_json, true);
        array_push($vehicles_data, $data);
        $data_json = json_encode($vehicles_data);
        $vehicles_file = fopen('./vehicles/vehicles.json', 'w');
        $vehicle_name = fopen('./vehicles/' . $route . '_' . $plateno . '.json', 'w');
        fwrite($vehicles_file, $data_json);
        fwrite($vehicle_name, $full_capacity);
        fclose($vehicles_file);
        fclose($vehicle_name);
        QRcode::png(infoCrypt(json_encode($vehicle_info)), './qrs/' . $_POST['plateno'] . '.png', QR_ECLEVEL_L, 4);
        echo $_POST['plateno'];
    }
  }catch(Exception $e){
    echo $e;
  }
  $connection = null;
}
else{
  echo "incomplete";
}
