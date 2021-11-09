<?php
require "./db_connection.php";
$uname = sha1("admin");
$password = sha1("admin");
$check_if_admin = $connection->prepare("SELECT Uname, Password FROM admin WHERE Uname = :uname AND Password = :password");
$check_if_admin->bindParam(":uname", $uname);
$check_if_admin->bindParam(":password", $password);
$check_if_admin->execute();
$is_admin = $check_if_admin->fetchColumn();
if($is_admin > 0){
  $connection = null;
  header("Location: ./signin");
}
