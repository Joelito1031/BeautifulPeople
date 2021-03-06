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
  $id = $_POST["id"];
  $profile_dir = "./dispatcher_profile/";
  $profile_pic = $profile_dir . basename($_FILES["profile-pic"]["name"]);
  $filetype = strtolower(pathinfo($profile_pic, PATHINFO_EXTENSION));
  $file_rename = $profile_dir . $_POST['name'] . time() . "." . $filetype;
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
    $retrieve_old_file = $connection->prepare("SELECT Profile FROM dispatchers WHERE ID = :id");
    $retrieve_old_file->bindParam(":id", $id);
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
        $save_profile_directory = $connection->prepare("UPDATE dispatchers SET Profile = :profile WHERE ID = :id");
        $save_profile_directory->bindParam(":profile", $file_rename);
        $save_profile_directory->bindParam(":id", $_POST['id']);
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
