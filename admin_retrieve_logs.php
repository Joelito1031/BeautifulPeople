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
$data = "";
require './db_connection.php';
if(isset($_POST['data'])){
  if($_POST['data'] == 'latest'){
    $retrieve_logs = $connection->prepare("SELECT Directory, Vehicle, Passengers, Route, LogDate, LogTime FROM logs ORDER BY LogId ASC");
  }elseif($_POST['data'] == 'oldest'){
    $retrieve_logs = $connection->prepare("SELECT Directory, Vehicle, Passengers, Route, LogDate, LogTime FROM logs ORDER BY LogId DESC");
  }
}elseif(isset($_POST['startdate']) && isset($_POST['enddate'])){
  $start_date = $_POST['startdate'];
  $end_date = $_POST['enddate'];
  $retrieve_logs = $connection->prepare("SELECT Directory, Vehicle, Passengers, Route, LogDate, LogTime FROM logs WHERE LogDate BETWEEN '$start_date' AND '$end_date'");
}else{
  $retrieve_logs = $connection->prepare("SELECT Directory, Vehicle, Passengers, Route, LogDate, LogTime FROM logs");
}
echo "<table class='logs-table'>";
echo "<tr class='rvt'>";
echo "<th>Vehicle</th>";
echo "<th>Route</th>";
echo "<th>Passengers</th>";
echo "<th>Departed</th>";
echo "<th>Log</th>";
echo "</tr>";
try{
  $retrieve_logs->execute();
  $logs = $retrieve_logs->fetchAll();
  if(sizeof($logs) > 0){
    foreach($logs as $log){
      echo "<tr>";
      echo "<td style='padding: 5px 0 5px 0;'>" . $log['Vehicle'] . "</td>";
      echo "<td style='padding: 5px 0 5px 0;'>" . strtoupper($log['Route']) . "</td>";
      echo "<td style='padding: 5px 0 5px 0;'>" . $log['Passengers'] . "</td>";
      echo "<td style='padding: 5px 0 5px 0;'>" . $log['LogDate'] . " - " . $log['LogTime'] . "</td>";
      echo "<td style='padding: 5px 0 5px 0;'><a href=" . "'" . "." . $log['Directory'] . "'" . " download>Download</a></td>";
      echo "</tr>";
    }
  }else{
    echo "<tr><td colspan='5'>No logs found</td></tr>";
  }
}catch(Exception $e){
  echo "error";
}
echo "</table>";
?>
