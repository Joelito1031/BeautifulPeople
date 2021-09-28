<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "ocqms";

try{
  $connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
  $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $select_query = "SELECT Name, Contact, PIN, OnDuty FROM dispatchers ORDER BY Name";
  foreach($connection->query($select_query) as $row_data ){
    $name = '"' . $row_data['Name'] . '"';
    echo "<tr>";
    echo "<td>" . $row_data['Name'] . "</td>";
    echo "<td>" . $row_data['Contact'] . "</td>";
    echo "<td>" . $row_data['PIN'] . "</td>";
    echo "<td>";
    if ($row_data['OnDuty'] == 1) {
      echo "<button class='duty-buttton' style='background-color: #f1c40f; height: 20px; width: 20px; border-radius: 50px; border: none; margin-bottom: 5px;' onclick='dutyChange(" . $name . ")'></button>";
    }else {
      echo "<button class='duty-buttton' style='background-color: #2c3e50; height: 20px; width: 20px; border-radius: 50px; border: none; margin-bottom: 5px;' onclick='dutyChange(" . $name . ")'></button>";
    }
    echo "</td>";
    echo "</tr>";
  }
}catch(PDOException $e){
  echo "Cannot load dispatcher's data";
}

$connection = null;
