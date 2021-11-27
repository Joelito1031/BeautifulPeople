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
    $retrieve_logs = $connection->prepare("SELECT logs.LogId, logs.Directory, logs.Vehicle, logs.Passengers, logs.Route, logs.LogDate, logs.LogTime,
                                           registered_vehicles.FirstName, registered_vehicles.MiddleName, registered_vehicles.LastName, registered_vehicles.Suffix, registered_vehicles.Contact,
                                           registered_vehicles.Address, registered_vehicles.DFirstName, registered_vehicles.DMiddleName, registered_vehicles.DLastName, registered_vehicles.DSuffix,
                                           registered_vehicles.DContact, registered_vehicles.DAddress FROM logs INNER JOIN registered_vehicles ON logs.Vehicle = registered_vehicles.PlateNo ORDER BY LogId DESC");
  }elseif($_POST['data'] == 'oldest'){
    $retrieve_logs = $connection->prepare("SELECT logs.LogId, logs.Directory, logs.Vehicle, logs.Passengers, logs.Route, logs.LogDate, logs.LogTime,
                                           registered_vehicles.FirstName, registered_vehicles.MiddleName, registered_vehicles.LastName, registered_vehicles.Suffix, registered_vehicles.Contact,
                                           registered_vehicles.Address, registered_vehicles.DFirstName, registered_vehicles.DMiddleName, registered_vehicles.DLastName, registered_vehicles.DSuffix,
                                           registered_vehicles.DContact, registered_vehicles.DAddress FROM logs INNER JOIN registered_vehicles ON logs.Vehicle = registered_vehicles.PlateNo ORDER BY LogId ASC");
  }elseif($_POST['data'] == 'alphabetically'){
    $retrieve_logs = $connection->prepare("SELECT logs.LogId, logs.Directory, logs.Vehicle, logs.Passengers, logs.Route, logs.LogDate, logs.LogTime,
                                           registered_vehicles.FirstName, registered_vehicles.MiddleName, registered_vehicles.LastName, registered_vehicles.Suffix, registered_vehicles.Contact,
                                           registered_vehicles.Address, registered_vehicles.DFirstName, registered_vehicles.DMiddleName, registered_vehicles.DLastName, registered_vehicles.DSuffix,
                                           registered_vehicles.DContact, registered_vehicles.DAddress FROM logs INNER JOIN registered_vehicles ON logs.Vehicle = registered_vehicles.PlateNo ORDER BY logs.Vehicle ASC");
  }
}elseif(isset($_POST['startdate']) && isset($_POST['enddate'])){
  $start_date = $_POST['startdate'];
  $end_date = $_POST['enddate'];
  $retrieve_logs = $connection->prepare("SELECT logs.LogId, logs.Directory, logs.Vehicle, logs.Passengers, logs.Route, logs.LogDate, logs.LogTime,
                                         registered_vehicles.FirstName, registered_vehicles.MiddleName, registered_vehicles.LastName, registered_vehicles.Suffix, registered_vehicles.Contact,
                                         registered_vehicles.Address, registered_vehicles.DFirstName, registered_vehicles.DMiddleName, registered_vehicles.DLastName, registered_vehicles.DSuffix,
                                         registered_vehicles.DContact, registered_vehicles.DAddress FROM logs INNER JOIN registered_vehicles ON logs.Vehicle = registered_vehicles.PlateNo WHERE logs.LogDate BETWEEN :startdate AND :endate");
  $retrieve_logs->bindParam(":startdate", $start_date);
  $retrieve_logs->bindParam(":endate", $end_date);
}else{
  $retrieve_logs = $connection->prepare("SELECT logs.LogId, logs.Directory, logs.Vehicle, logs.Passengers, logs.Route, logs.LogDate, logs.LogTime,
                                         registered_vehicles.FirstName, registered_vehicles.MiddleName, registered_vehicles.LastName, registered_vehicles.Suffix, registered_vehicles.Contact,
                                         registered_vehicles.Address, registered_vehicles.DFirstName, registered_vehicles.DMiddleName, registered_vehicles.DLastName, registered_vehicles.DSuffix,
                                         registered_vehicles.DContact, registered_vehicles.DAddress FROM logs INNER JOIN registered_vehicles ON logs.Vehicle = registered_vehicles.PlateNo");
}
try{
  $retrieve_logs->execute();
  $logs = $retrieve_logs->fetchAll();
  if(sizeof($logs) > 0){
    foreach($logs as $log){
      echo "<div id='vehicle-logs-container' style='margin-bottom: 3px;'>";
      echo "<div>";
      echo "<div class='card-header' id='" . $log['LogId'] . "'>";
      echo "<h5 class='mb-0'>";
      echo "<button style='width: 100%;' class='btn btn-link collapsed' data-toggle='collapse' data-target='#" . $log['Vehicle'] . "_" . $log['LogId'] . "' aria-expanded='true' aria-controls='collapseOne'>";
      echo "<div style='display: flex; align-items: center; justify-content: space-between; width: 100%;'>";
      echo "<div style='display: flex; align-items: center;'>";
      echo "<div style='padding-right: 5px'><i class='fas fa-chevron-right'></i></div>";
      echo "<i class='fas fa-file' style='font-size: 35px;'></i>";
      echo "<div style='width: 100px; padding: 5px;' id='" . $log['Route'] . "_" . $log['LogId'] . "'>" . $log['Vehicle'] . "</div>";
      echo "</div>";
      echo "<div" . $log['LogId'] . "_" . $log['LogId'] . "'>Created at: " . $log['LogDate'] . "_" . $log['LogTime'] . "</div>";
      echo "</div>";
      echo "</button>";
      echo "</h5>";
      echo "</div>";
      echo "<div id='" . $log['Vehicle'] . "_" . $log['LogId'] . "' style='text-align: center;' class='collapse' aria-labelledby='" . $log['LogId'] . "' data-parent='#vehicle-logs-container'>";
      $vehicle_name = '"' . $log['Route'] . "_" . $log['LogId'] . '"';
      $vh_timestamp = '"' . $log['LogId'] . "_" . $log['LogId'] . '"';
      $area_to_print = '"' . basename($log['Directory']) . '"';
      echo "<div display='flex' style='margin: 10px 0 10px 0'><button class='btn btn-primary' onclick='saveLogPDF(" . $vehicle_name . "," . $vh_timestamp . "," . $area_to_print . ")'>SAVE AS PDF</button></div>";
      echo "<div id='" . basename($log['Directory']) . "' class='card-body'>";
      echo "<div style='text-align: center'>";
      echo "<img style='width: 100px; height: 100px;' src='./images/logoQrmoc.png'>";
      echo "<div style='font-size: 14px; font-family: Times New Roman; padding: 5px 0 3px 0; font-weight: bold'>";
      echo "Authentic Log of " . $log['Vehicle'] . " Operated by " . $log['FirstName'] . " " . $log['MiddleName'] . " " . $log['LastName'] . " " . $log['Suffix'] . " going to "
            . strtoupper($log['Route']) . " droven by " . $log['DFirstName'] . " " . $log['DMiddleName'] . " " . $log['DLastName'] . " " . $log['DSuffix'] ."</div>";
      echo "<div style='font-size: 14px; font-family: Times New Roman; padding: 2px 0 20px 0; font-weight: bold'>Generated by Q R M O C - Queuing Passenger Assistance System</div>";
      echo "</div>";
      $log_content = json_decode(file_get_contents($log['Directory']));
      echo "<table style='width: 100%'>";
      echo "<tr><th>No</th><th>Passenger</th><th>Companion</th></tr>";
      $count = 0;
      foreach($log_content as $info){
        if(isset($info->queuetime) && isset($info->leavetime)){
          echo "<table style='width: 100%'>";
          echo "<tr><th>Time Queued</th><th>Time Departed</th></tr>";
          echo "<tr><td>" . $info->queuetime . "</td><td>" . $info->leavetime . "</td></tr>";
          echo "</table>";
        }else{
          $count += 1;
          echo "<tr>";
          echo "<td>" . $count . "</td>";
          echo "<td>";
          if($info->Name == ""){
            echo "N/A";
          }else{
            echo $info->Name;
          }
          echo "</td>";
          echo "<td>";
          if($info->Companion == 'true'){
            echo "<i class='fas fa-check'></i>";
          }else{
            echo "<i class='fas fa-times'></i>";
          }
          echo "</td>";
          echo "</tr>";
        }
      }
      echo "</table>";
      echo "<div style='padding: 5px 0 0 0; display: flex; justify-content: space-between;'>";
      echo "<div style='font-family: Times New Roman; font-size: 14px'>Number of Passengers: " . $log['Passengers'] . "</div>";
      echo "<div style='font-family: Times New Roman; font-size: 14px'>Made possible by J<sup>3</sup></div>";
      echo "</div>";
      echo "</div>";
      echo "</div>";
      echo "</div>";
      echo "</div>";
    }
  }else{
    echo "<div class='container border' style='text-align: center; padding: 10px;'>No logs found</div>";
  }
}catch(Exception $e){
      echo "<div class='container border' style='text-align: center; padding: 10px;'>Something went wrong</div>";
}
echo "</table>";
?>
