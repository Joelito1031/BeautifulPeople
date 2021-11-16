<?php
try{
  $profile_dir = "./dispatcher_profile/";
  $profile_pic = $profile_dir . basename($_FILES["profile-pic"]["name"]);
  $filetype = strtolower(pathinfo($profile_pic, PATHINFO_EXTENSION));
  $file_rename = $profile_dir . $_POST['fname'] . $_POST['mname'] . $_POST['lname'] . $_POST['suffix'] . time() . "." . $filetype;
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
    require "./db_connection.php";
    $save_profile_directory = $connection->prepare("UPDATE dispatchers SET Profile = :profile WHERE FirstName = :fname AND MiddleName = :mname AND LastName = :lname AND Suffix = :suffix");
    $save_profile_directory->bindParam(":profile", $file_rename);
    $save_profile_directory->bindParam(":fname", $_POST['fname']);
    $save_profile_directory->bindParam(":mname", $_POST['mname']);
    $save_profile_directory->bindParam(":lname", $_POST['lname']);
    $save_profile_directory->bindParam(":suffix", $_POST['suffix']);
    $save_profile_directory->execute();
    if($save_profile_directory->rowCount() > 0){
      if(move_uploaded_file($_FILES["profile-pic"]["tmp_name"], $file_rename)){
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
