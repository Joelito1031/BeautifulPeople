<?php
require './db_connection.php';
try{
  $data = json_decode(file_get_contents('php://input'));
  $select_query = $connection->prepare("SELECT OnDuty FROM dispatchers WHERE PIN = :pin");
  $select_query->bindParam(":pin", $data->pin);
  $select_query->execute();
  $data_result = $select_query->fetchColumn();
  if($data_result > 0){
    $status = "registered";
    if($data_result == 1){
      $status = "onduty";
    }
  }
  else{
    $status = "unregistered";
  }
}catch(Exception $e){
  $status = "error";
}
echo json_encode($status);
?>
