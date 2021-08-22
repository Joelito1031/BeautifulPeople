<?php
$server = 'localhost';
$username = 'root';
$password = '';
$dbname = 'OCQMS';
$plateno = 'HVM-601';
$route = 'valencia';
$capacity = 20;

try{
  $connection = new PDO("mysql:host=$server;dbname=$dbname", $username, $password);
  $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $insert_query = "INSERT INTO registered_vehicles(PlateNo, Route, Capacity) VALUES('$plateno', '$route', '$capacity')";
  $select_query = "SELECT * FROM registered_vehicles WHERE PlateNo = '$plateno'";

  $num_row = $connection->query($select_query);
  $row_count = $num_row->fetchColumn();

  if($row_count > 0){
    echo "Count is greater than 1";
  }
  else{
    echo "Count is is 0";
  }
  }catch(PDOException $e){
    echo 'Error:' . ' ' . $e->getMessage();
  }
