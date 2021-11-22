<?php
require "../db_connection.php";
try{
  $name_and_photo = $connection->prepare("SELECT Uname, Profile FROM admin");
  $name_and_photo->execute();
  $result = $name_and_photo->fetchAll();
  if(sizeof($result) > 0){
    foreach($result as $data){
      echo json_encode(array("name" => $data['Uname'], "profile" => $data['Profile']));
    }
  }else{
    echo "error";
  }
}catch(Exception $e){
  echo "error";
}
?>
