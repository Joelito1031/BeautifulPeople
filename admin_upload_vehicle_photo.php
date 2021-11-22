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
  $profile_dir = "./vehicle_images/";
  $profile_pic = $profile_dir . basename($_FILES["profile-pic"]["name"]);
  $filetype = strtolower(pathinfo($profile_pic, PATHINFO_EXTENSION));
  $file_rename = $profile_dir . $_POST['plateno'] . "." . $filetype;
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
    if(move_uploaded_file($_FILES["profile-pic"]["tmp_name"], $file_rename)){
      require "./db_connection.php";
      $save_profile_directory = $connection->prepare("UPDATE registered_vehicles SET VehicleProfile = :vehicleprofile WHERE PlateNo = :plateno");
      $save_profile_directory->bindParam(":vehicleprofile", $file_rename);
      $save_profile_directory->bindParam(":plateno", $_POST['plateno']);
      $save_profile_directory->execute();
      if($save_profile_directory->rowCount() > 0){
        echo $status;
      }else{
        echo "error";
      }
    }else{
      echo "error";
    }
  }
}catch(Exception $e){
  echo "error";
}
?>
