<?php
$data = json_decode(file_get_contents('php://input'));
if(!empty(trim($data->fullname)) && !empty(trim($data->contact)) && !empty(trim($data->qr))){
  require './db_connection.php';
  $fullname = $data->fullname;
  $contact = $data->contact;
  $qr = $data->qr;
  try{
    $check_redundancy = $connection->prepare("SELECT * FROM ormoc_commuters WHERE QR = :qr");
    $check_redundancy->bindParam(":qr", $qr);
    $check_redundancy->execute();
    $passenger = $check_redundancy->fetchColumn();
    if($passenger > 0){
      echo json_encode('registered');
    }else{
      $register_passenger = $connection->prepare("INSERT INTO ormoc_commuters(QR, Name, Contact) VALUES(:qr, :fullname, :contact)");
      $register_passenger->bindParam(":qr", $qr);
      $register_passenger->bindParam(":fullname", $fullname);
      $register_passenger->bindParam(":contact", $contact);
      $register_passenger->execute();
      echo json_encode('success');
    }
  }catch(Exception $e){
    echo json_encode('error');
  }
}else{
  echo json_encode('error');
}
?>
