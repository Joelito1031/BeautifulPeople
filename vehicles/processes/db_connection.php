<?php
$server = 'localhost';
$username = 'jcube';
$password = '94z&Vk9A4X5K';
$dbname = 'ocqms';

try{
  $connection = new PDO("mysql:host=$server;dbname=$dbname", $username, $password);
  $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
  echo "error";
  exit();
}
