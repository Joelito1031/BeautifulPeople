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

echo "<tr class='dispatchers-table-headers'>";
echo "<th>Name</th>";
echo "<th>Mobile #</th>";
echo "<th>PIN</th>";
echo "<th>Duty</th>";
echo "</tr>";

try{
  $retrieve_dispatcher_list = $connection->prepare("SELECT ID, FirstName, MiddleName, LastName, Suffix, Contact, PIN, OnDuty FROM dispatchers ORDER BY FirstName");
  $retrieve_dispatcher_list->execute();
  if($retrieve_dispatcher_list->rowCount() > 0){
    $dispatchers = $retrieve_dispatcher_list->fetchAll();
    foreach($dispatchers as $dispatcher){
      $id = '"' . $dispatcher['ID'] . '"';
      echo "<tr>";
      echo "<td>" . $dispatcher['FirstName'] . " " . $dispatcher['MiddleName'] . " " . $dispatcher['LastName'] . " " . $dispatcher['Suffix'] . "</td>";
      echo "<td>" . $dispatcher['Contact'] . "</td>";
      echo "<td>" . $dispatcher['PIN'] . "</td>";
      echo "<td>";
      if ($dispatcher['OnDuty'] == 1) {
        echo "<button style='background-color: #f1c40f; height: 20px; width: 20px; border-radius: 50px; border: none; margin-top: 3px; box-shadow: -2px 2px 5px black;' onclick='dutyChange(" . $id . ")'></button>";
      }else {
        echo "<button style='background-color: #2c3e50; height: 20px; width: 20px; border-radius: 50px; border: none; margin-top: 3px; box-shadow: -2px 2px 5px black;' onclick='dutyChange(" . $id . ")'></button>";
      }
      echo "</td>";
      echo "</tr>";
    }
  }else{
    echo "<tr><td colspan='4'>No registered dispatchers</td></tr>";
  }
  $connection = null;
}catch(Exception $e){
  echo "<tr><td colspan='4'>Something went wrong</td></tr>";
}
