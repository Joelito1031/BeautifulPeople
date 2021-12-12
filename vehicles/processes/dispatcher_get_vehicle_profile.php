<?php
require './db_connection.php';
$data = json_decode(file_get_contents("php://input"));
$get_profile = $connection->prepare("SELECT VehicleProfile, FirstName, MiddleName, LastName,
  Suffix, DFirstName, DMiddleName, DLastName, DSuffix FROM registered_vehicles WHERE PlateNo = :plateno");
$get_profile->bindParam(":plateno", $data->data);
$get_profile->execute();
echo json_encode($get_profile->fetch());
?>
