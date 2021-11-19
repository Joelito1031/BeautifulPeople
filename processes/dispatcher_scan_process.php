<?php
require "./db_connection.php";
$data = json_decode(file_get_contents('php://input'));
$qr = $data->data;
$destination = $data->destination;
try{
  $find_passenger = $connection->prepare("SELECT COUNT(*) as Count FROM ormoc_commuters WHERE QR = :qr");
  $find_passenger->bindParam(":qr", $qr);
  $find_passenger->execute();
  $passenger = $find_passenger->fetch();
  if($passenger['Count'] > 0){
    $passenger_loaded = $connection->prepare("SELECT Vehicle, COUNT(*) as Count FROM loaded_passengers WHERE QR = :qr");
    $passenger_loaded->bindParam(":qr", $qr);
    $passenger_loaded->execute();
    $is_loaded = $passenger_loaded->fetch();
    if($is_loaded['Count'] > 0){
      echo json_encode($is_loaded['Vehicle']); //passenger is loaded ------------------------------------------------------------------------------------------------
    }else{
      $passenger_waiting = $connection->prepare("SELECT COUNT(*) as Count FROM waiting_passengers WHERE QR = :qr");
      $passenger_waiting->bindParam(":qr", $qr);
      $passenger_waiting->execute();
      $is_waiting = $passenger_waiting->fetch();
      if($is_waiting['Count'] > 0){
        echo json_encode("waiting"); //passenger is waiting --------------------------------------------------------------------------------------------
      }
      else{
        echo json_encode("clear"); //passenger is clear ------------------------------------------------------------------------------------------------
      }
    }
  }else{
    echo json_encode("notregistered"); //passenger is not registered -----------------------------------------------------------------------------------
  }
}catch(Exception $e){
  echo json_encode("error");
}
?>
