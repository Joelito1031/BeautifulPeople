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
if(isset($_SESSION['authentication'])){
  if($_SESSION['authentication']){
    unset($_SESSION['authentication']);
    try{
      require "./db_connection.php";
      $proceed = true;
      $profile_dir = "./auth_process/images/";
      $profile_pic = $profile_dir . basename($_FILES["profile-pic"]["name"]);
      $filetype = strtolower(pathinfo($profile_pic, PATHINFO_EXTENSION));
      $file = $profile_dir . $_POST['name'] . time() . "." . $filetype;
      $file_rename = "images/" . $_POST['name'] . time() . "." . $filetype;
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
        $retrieve_old_file = $connection->prepare("SELECT Profile FROM admin");
        $retrieve_old_file->execute();
        $profile = $retrieve_old_file->fetchColumn();
        if($profile != ''){
          if($profile == "images/adminUserProfile.png"){
            $proceed = true;
          }elseif(file_exists("./auth_process/" . $profile)){
            if(!unlink("./auth_process/" . $profile)){
              $proceed = false;
            }
          }else{
            $proceed = false;
          }
        }
        if($proceed){
          if(move_uploaded_file($_FILES["profile-pic"]["tmp_name"], $file)){
            $save_profile_directory = $connection->prepare("UPDATE admin SET Profile = :profile");
            $save_profile_directory->bindParam(":profile", $file_rename);
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

  }else{
    echo "notauthorized";
  }
}else{
  echo "notauthorized";
}
?>
