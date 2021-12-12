<?php
require './db_connection.php';
$uname = "admin";
$password = sha1("admin");
$check_if_admin = $connection->prepare("SELECT Uname, Password FROM admin WHERE Uname = 'admin' AND Password = :password");
$check_if_admin->bindParam(":password", $password);
$check_if_admin->execute();
$is_admin = $check_if_admin->rowCount();
if($is_admin > 0){
  header("Location: ./signin");
}
$connection = null;
