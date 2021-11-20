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
  require "./db_connection.php";
  $proceed = true;
  $plateno = $_POST["plateno"];
  $profile_dir = "./vehicle_images/";
  $profile_pic = $profile_dir . basename($_FILES["profile-pic"]["name"]);
  $filetype = strtolower(pathinfo($profile_pic, PATHINFO_EXTENSION));
  $file_rename = $profile_dir . $plateno . "." . $filetype;
  $uploadok = 0;
  $check = getimagesize($_FILES["profile-pic"]["tmp_name"]);
  if($check !== false){
    $uploadok = 1;
    $status = "upload";
  }else{
    $uploadok = 0;
    $status = "notapic";
  }
  if(file_exists($profile_pic)){
    $uploadok = 0;
    $status = "fileexist";
  }
  if($_FILES["profile-pic"]["size"] > 500000){
    $uploadok = 0;
    $status = "sizelimit";
  }
  if($uploadok == 0){
    echo $status;
  }else{
    $retrieve_old_file = $connection->prepare("SELECT VehicleProfile FROM registered_vehicles WHERE PlateNo = :plateno");
    $retrieve_old_file->bindParam(":plateno", $plateno);
    $retrieve_old_file->execute();
    $profile = $retrieve_old_file->fetchColumn();
    if($profile != ''){
      if(file_exists($profile)){
        if(!unlink($profile)){
          $proceed = false;
        }
      }else{
        $proceed = false;
      }
    }
    if($proceed){
      if(move_uploaded_file($_FILES["profile-pic"]["tmp_name"], $file_rename)){
        $save_profile_directory = $connection->prepare("UPDATE registered_vehicles SET VehicleProfile = :profile WHERE PlateNo = :plateno");
        $save_profile_directory->bindParam(":profile", $file_rename);
        $save_profile_directory->bindParam(":plateno", $plateno);
        $save_profile_directory->execute();
        if($save_profile_directory->rowCount() > 0){
          echo $status;
        }else{
          echo "error";
        }
      }else{
        echo "error";
      }
    }else{
      echo "notallowed";
    }
  }
}catch(Exception $e){
  echo "error";
}
?>
