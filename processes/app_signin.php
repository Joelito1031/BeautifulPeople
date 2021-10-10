<?php

//Database variables
$servername = "localhost";
$username = "root";
$password = "";
$database = "ocqms";
$halt_operation = false;

try{

  $connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
  $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}catch(PDOException $e){

  $halt_operation = true;

}

if($halt_operation){
  $status = "HALTED";
}
else{
  $data = json_decode(file_get_contents('php://input'));
  $select_query = $connection->prepare("SELECT COUNT(*) AS count, OnDuty FROM dispatchers WHERE Name = '$data->name' AND PIN = '$data->pin'");
  $select_query->execute();
  $data_result = $select_query->fetchall();

  if($data_result[0]['count'] > 0){
    $status = "REGISTERED";
    if($data_result[0]['OnDuty'] == 1){
      $status = "ONDUTY";
    }
  }
  else{
    $status = "UNREGISTERED";
  }
}

echo json_encode($status);

?>
