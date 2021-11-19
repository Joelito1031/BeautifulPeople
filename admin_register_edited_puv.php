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
try{
  $queuing_vehicles = json_decode(file_get_contents("./vehicles/queuing_vehicles.json"));
  $plateno = $_POST['plateno'];
  $proceed = true;
  foreach($queuing_vehicles as $vehicle){
    if($vehicle->vehicle == $plateno){
      $proceed = false;
      break;
    }
  }
  if($proceed){
    require "./db_connection.php";
    $route = $_POST['route'];
    $capacity = $_POST['capacity'];
    $firstname = $_POST['fname'];
    $middlename = $_POST['mname'];
    $lastname = $_POST['lname'];
    $suffix = $_POST['suffix'];
    $contact = $_POST['cnum'];
    $update_puv_info = $connection->prepare("UPDATE registered_vehicles SET Route = :route, Capacity = :capacity, FirstName = :firstname, MiddleName = :middlename, LastName = :lastname, Suffix = :suffix, Contact = :contact WHERE PlateNo = :plateno");
    $update_puv_info->bindParam(":route", $route);
    $update_puv_info->bindParam(":capacity", $capacity);
    $update_puv_info->bindParam(":firstname", $firstname);
    $update_puv_info->bindParam(":middlename", $middlename);
    $update_puv_info->bindParam(":lastname", $lastname);
    $update_puv_info->bindParam(":suffix", $suffix);
    $update_puv_info->bindParam(":contact", $contact);
    $update_puv_info->bindParam(":plateno", $plateno);
    $update_puv_info->execute();
    if($update_puv_info->rowCount() > 0){
      $puv = json_decode(file_get_contents("./vehicles/vehicles.json"));
      foreach($puv as $vehicle){
        if($vehicle->vehicle == $plateno){
          $vehicle->operator = $firstname . " " . $middlename . " " . $lastname . " " . $suffix;
          $vehicle->contact_num = $contact;
          $vehicle->route = $route;
          $vehicle->capacity = $capacity;
          break;
        }
      }
      $file = fopen("./vehicles/vehicles.json", "w");
      fwrite($file, json_encode($puv));
      fclose($file);
      echo "success";
    }else{
      echo "nochanges";
    }
  }else{
    echo "notallowed";
  }
}catch(Exception $e){
  echo "error";
}
?>
