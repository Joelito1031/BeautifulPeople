<?php

  require "./db_connection.php";
  $id = "5";
  $retrieve_old_file = $connection->prepare("SELECT FirstName, Profile FROM dispatchers WHERE ID = :id");
  $retrieve_old_file->bindParam(":id", $id);
  $retrieve_old_file->execute();
  $name = $retrieve_old_file->fetchColumn();
  print_r($name);
?>
