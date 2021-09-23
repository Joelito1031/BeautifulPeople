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

if($halt_operation){
  $status = "Halt";
}
else{
  $data = json_decode('{"data":"HVM-101"}');
  $vehicles_list = json_decode(file_get_contents('./vehicles/vehicles.json'));
  $queuing_vehicles_list = json_decode(file_get_contents('./vehicles/queuing_vehicles.json'));
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
            $passenger_list_array = json_decode(file_get_contents("./vehicles/" . $list_of_vehicles->route . "_" . $list_of_vehicles->vehicle . ".json"));
            foreach($passenger_list_array as $passenger_name){
              if($passenger_name !== ""){
                $passenger_list_array[$count_3] = "";
              }
              $count_3 += 1;
            }
            $passenger_list_file = fopen("./vehicles/" . $list_of_vehicles->route . "_" . $list_of_vehicles->vehicle . ".json", 'w');
            fwrite($passenger_list_file, json_encode($passenger_list_array));
            fclose($passenger_list_file);
            $delete_passenger_query = "DELETE FROM loaded_passengers WHERE Vehicle = '$data->data'";
            $connection->exec($delete_passenger_query);
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
}

echo json_encode($status);
