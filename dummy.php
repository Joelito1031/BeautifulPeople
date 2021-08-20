<?php

$server = 'localhost';
$username = 'root';
$password = '';
$dbname = 'OCQMS';

$plateno = "HVM-601";
$route = "Valencia";
$capacity = 10;

try{
  $conn = new PDO("mysql:host=$server;dbname=OCQMS", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "INSERT INTO registered_vehicles(PlateNo, Route, Capacity) VALUES('$plateno', '$route', '$capacity')";
  $conn->exec($sql);
  echo "Connection successful";
}
catch(PDOException $e){
  echo "Connection failed: " . $e->getMessage();
}
