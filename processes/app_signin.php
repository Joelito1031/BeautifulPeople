<?php
require './db_connection.php';
try{
  $data = json_decode(file_get_contents('php://input'));
  $select_query = $connection->prepare("SELECT ID, OnDuty, FirstName, LastName, Profile FROM dispatchers WHERE PIN = :pin");
  $select_query->bindParam(":pin", $data->pin);
  $select_query->execute();
  $data_result = $select_query->fetch();
  if($data_result == null){
    $status = "unregistered";
  }elseif(sizeof($data_result) > 0){
    if($data_result['OnDuty'] == 1){
      $status = json_encode(array("id"=>$data_result['ID'], "status" => "onduty", "name" => $data_result['FirstName'] . " " . $data_result['LastName'], "profile" => $data_result['Profile']));
    }else{
      $status = "offduty";
    }
  }
}catch(Exception $e){
  $status = "error";
}
echo json_encode($status);
?>
