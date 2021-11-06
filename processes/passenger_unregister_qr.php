<?php
$data = json_decode(file_get_contents('php://input'));
if(!empty(trim($data->qrcode))){
  require './db_connection.php';
  $qrcode = $data->qrcode;
  try{
    $check_existance = $connection->prepare("SELECT * FROM ormoc_commuters WHERE QR = :qr");
    $check_existance->bindParam(":qr", $qrcode);
    $check_existance->execute();
    $passenger = $check_existance->fetchColumn();
    if($passenger > 0){
      $remove_passenger = $connection->prepare("DELETE FROM ormoc_commuters WHERE QR = :qr");
      $remove_passenger->bindParam(":qr", $qrcode);
      $remove_passenger->execute();
      echo json_encode('success');
    }else{
      echo json_encode('notfound');
    }
  }catch(Exception $e){
    echo json_encode('error');
  }
}else{
  echo json_encode('error');
}
?>
