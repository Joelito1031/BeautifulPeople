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
    if((isset($_POST['fname']) && !empty(trim($_POST['fname']))) && (isset($_POST['mname']) && !empty(trim($_POST['mname'])))
      && (isset($_POST['lname']) && !empty(trim($_POST['lname']))) && (isset($_POST['cnum']) && !empty(trim($_POST['cnum'])))
      && (isset($_POST['route']) && !empty(trim($_POST['route']))) && (isset($_POST['capacity']) && !empty(trim($_POST['capacity'])))
      && (isset($_POST['dfname']) && !empty(trim($_POST['dfname']))) && (isset($_POST['dmname']) && !empty(trim($_POST['dmname'])))
      && (isset($_POST['dlname']) && !empty(trim($_POST['dlname']))) && (isset($_POST['dcnum']) && !empty(trim($_POST['dcnum'])))
      && (isset($_POST['address']) && trim($_POST['address']) != "")
      && (isset($_POST['daddress']) && trim($_POST['daddress']) != "")){
        require "./db_connection.php";
        $route = $_POST['route'];
        $capacity = $_POST['capacity'];
        $firstname = $_POST['fname'];
        $middlename = $_POST['mname'];
        $lastname = $_POST['lname'];
        $suffix = $_POST['suffix'];
        $contact = $_POST['cnum'];
        $dfname = $_POST['dfname'];
        $dmname = $_POST['dmname'];
        $dlname = $_POST['dlname'];
        $dsuffix = $_POST['dsuffix'];
        $dcnum = $_POST['dcnum'];
        $daddress = $_POST['daddress'];
        $address = $_POST['address'];
        $plateno = $_POST['plateno'];
        $update_puv_info = $connection->prepare("UPDATE registered_vehicles SET Route = :route, Capacity = :capacity, FirstName = :firstname,
                                                 MiddleName = :middlename, LastName = :lastname, Suffix = :suffix, Contact = :contact,
                                                 Address = :address, DFirstName = :dfname, DMiddleName = :dmname, DLastName = :dlname,
                                                 DSuffix = :dsuffix, DContact = :dcontact, DAddress = :daddress WHERE PlateNo = :plateno");
        $update_puv_info->bindParam(":route", $route);
        $update_puv_info->bindParam(":capacity", $capacity);
        $update_puv_info->bindParam(":firstname", $firstname);
        $update_puv_info->bindParam(":middlename", $middlename);
        $update_puv_info->bindParam(":lastname", $lastname);
        $update_puv_info->bindParam(":suffix", $suffix);
        $update_puv_info->bindParam(":contact", $contact);
        $update_puv_info->bindParam(":address", $address);
        $update_puv_info->bindParam(":dfname", $dfname);
        $update_puv_info->bindParam(":dmname", $dmname);
        $update_puv_info->bindParam(":dlname", $dlname);
        $update_puv_info->bindParam(":dsuffix", $dsuffix);
        $update_puv_info->bindParam(":dcontact", $dcnum);
        $update_puv_info->bindParam(":daddress", $daddress);
        $update_puv_info->bindParam(":plateno", $plateno);
        $update_puv_info->execute();
        if($update_puv_info->rowCount() > 0){
          $puv = json_decode(file_get_contents("./vehicles/vehicles.json"));
          foreach($puv as $vehicle){
            if($vehicle->vehicle == $plateno){
              $vehicle->operator = $firstname . " " . $middlename . " " . $lastname . " " . $suffix;
              $vehicle->driver = $dfname . " " . $dmname . " " . $dlname . " " . $dsuffix;
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
      echo "incomplete";
    }
  }else{
    echo "notallowed";
  }
}catch(Exception $e){
  echo $e;
}
?>
