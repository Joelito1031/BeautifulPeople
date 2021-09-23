<?php


//Database variables
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



$request = file_get_contents('php://input');
$data = json_decode($request);
$vehicles = file_get_contents('./vehicles/vehicles.json');
$vehicles_list = json_decode($vehicles);
$queuing_vehicles = file_get_contents('./vehicles/queuing_vehicles.json');
$queuing_vehicles_list = json_decode($queuing_vehicles);
$count_1 = 0;
$count_2 = 0;
$count_3 = 0;
$status = '';

if(sizeof($queuing_vehicles_list) > 0){
  foreach($queuing_vehicles_list as $vehicle){
    if($vehicle->vehicle === $data->data){
      array_splice($queuing_vehicles_list, $count_1, 1);
      $queuing_vehicles_file = fopen('./vehicles/queuing_vehicles.json', 'w');
      fwrite($queuing_vehicles_file, json_encode($queuing_vehicles_list));
      fclose($queuing_vehicles_file);
      foreach($vehicles_list as $list_of_vehicles){
        if($list_of_vehicles->vehicle === $data->data && $list_of_vehicles->queuing === true){
          $vehicles_list[$count_2]->queuing = false;
          $all_vehicle_file = fopen('./vehicles/vehicles.json', 'w');
          fwrite($all_vehicle_file, json_encode($vehicles_list));
          fclose($all_vehicle_file);
          $queuing_vehicle_name = "./vehicles/" . $list_of_vehicles->route . "_" . $list_of_vehicles->vehicle . ".json";
          $passenger_list = file_get_contents($queuing_vehicle_name);
          $passenger_list_array = json_decode($passenger_list);
          foreach($passenger_list_array as $passenger_name){
            if($passenger_name !== ""){
              $passenger_list_array[$count_3] = "";
            }
            $count_3 += 1;
          }
          $passenger_list_file = fopen($queuing_vehicle_name, 'w');
          fwrite($passenger_list_file, json_encode($passenger_list_array));
          fclose($passenger_list_file);
          $status = json_encode($queuing_vehicles_list); //You need to move this
          break;
        }
        $count_2 += 1;
      }
      break;
    }
    $count_1 += 1;
  }
}

echo json_encode($status);
