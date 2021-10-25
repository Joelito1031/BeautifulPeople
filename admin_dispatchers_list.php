<?php
session_start();
if(isset($_SESSION['loggedin'])){
  if(!$_SESSION['loggedin']){
    header('Location: ./');
  }
}
else{
  header('Location: ./');
}
require './db_connection.php';

$retrieve_dispatcher_list = $connection->prepare("SELECT Name, Contact, PIN, OnDuty FROM dispatchers ORDER BY Name");
try{
  $retrieve_dispatcher_list->execute();
  $dispatchers = $retrieve_dispatcher_list->fetchAll();
  echo "<tr>";
  echo "<th>Name</th>";
  echo "<th>Contact</th>";
  echo "<th>PIN</th>";
  echo "<th>Duty</th>";
  echo "<th>Remove</th>";
  echo "</tr>";
  foreach($dispatchers as $dispatcher){
    $name = '"' . $dispatcher['Name'] . '"';
    echo "<tr>";
    echo "<td>" . $dispatcher['Name'] . "</td>";
    echo "<td>" . $dispatcher['Contact'] . "</td>";
    echo "<td>" . $dispatcher['PIN'] . "</td>";
    echo "<td>";
    if ($dispatcher['OnDuty'] == 1) {
      echo "<button style='background-color: #f1c40f; height: 20px; width: 20px; border-radius: 50px; border: none; margin-top: 3px;' onclick='dutyChange(" . $name . ")'></button>";
    }else {
      echo "<button style='background-color: #2c3e50; height: 20px; width: 20px; border-radius: 50px; border: none; margin-top: 3px;' onclick='dutyChange(" . $name . ")'></button>";
    }
    echo "</td>";
    echo "<td>";
    echo "<button type='button' onclick='deleteDispatcher(" . $name . ")' style='width: 20px; height: 20px; padding: 0; border: none; border-radius: 50px; margin-top: 3px;'><img src='./images/xbox.png' style='width: 20px; height; 20px'></button>";
    echo "</tr>";
  }
  $connection = null;
}catch(Exception $e){
  echo "<tr><td colspan='4'>Something went wrong</td></tr>";
}
