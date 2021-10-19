<?php
$server = 'localhost';
$username = 'root';
$password = '';
$dbname = 'ocqms';

try{
  $connection = new PDO("mysql:host=$server;dbname=$dbname", $username, $password);
  $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
  echo "error_connection";
  exit();
}
