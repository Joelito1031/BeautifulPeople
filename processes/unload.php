<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "ocqms";
$halt_operation = false;

try{

  $connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
  $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}catch(PDOException $e){

  $halt_operation = true;

}

if($halt_operation){
  $status = "Halt";
}
else{
  $data = json_decode(file_get_contents('php://input'));
  $delete_passenger_query = $connection->prepare("DELETE FROM loaded_passengers WHERE Vehicle = '$data->vehicle' AND Passenger = '$data->passenger'");

  $delete_passenger_query->execute();

  if($delete_passenger_query->rowCount() > 0){
    $count = 0;
    $current_passenger_list = json_decode(file_get_contents('../vehicles/' . $data->file));
    foreach($current_passenger_list as $passenger){
      if($passenger === $data->passenger){
        $current_passenger_list[$count] = "";
        $current_passenger_file = fopen('../vehicles/' . $data->file, 'w');
        fwrite($current_passenger_file, json_encode($current_passenger_list));
        fclose($current_passenger_file);
        $current_passenger_number = json_decode(file_get_contents('../vehicles/queuing_vehicles.json'));
        foreach($current_passenger_number as $onload_passenger){
          if($onload_passenger->vehicle === $data->vehicle){
            $onload_passenger->passengers = $onload_passenger->passengers - 1;
            $current_passenger_number_file = fopen('../vehicles/queuing_vehicles.json', 'w');
            fwrite($current_passenger_number_file, json_encode($current_passenger_number));
            fclose($current_passenger_number_file);
            $status = json_encode($current_passenger_list);
            break;
          }
        }
        break;
      }
      $count += 1;
    }
  }
  else{
    $status = "Halt";
  }
}

echo json_encode($status);

?>
