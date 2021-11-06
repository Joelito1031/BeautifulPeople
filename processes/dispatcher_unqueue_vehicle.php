<?php
require './db_connection.php';
$vehicle_to_unqueue = json_decode(file_get_contents("php://input"));
$data = $vehicle_to_unqueue->data;
$proceed = true;
try{
  $delete_passenger_query = $connection->prepare("DELETE FROM loaded_passengers WHERE Vehicle = :vehicle");
  $delete_passenger_query->bindParam(":vehicle", $data);
  $delete_passenger_query->execute();
}catch(Exception $e){
  $proceed = false;
}
if($proceed){
  $queuing_vehicles_list = json_decode(file_get_contents('../vehicles/queuing_vehicles.json'));
  $count_1 = 0;
  $count_2 = 0;
  $count_3 = 0;
  if(sizeof($queuing_vehicles_list) > 0){
    foreach($queuing_vehicles_list as $vehicle){
      if($vehicle->vehicle === $data){
        array_splice($queuing_vehicles_list, $count_1, 1);
        $vehicles_list = json_decode(file_get_contents('../vehicles/vehicles.json'));
        foreach($vehicles_list as $list_of_vehicles){
          if($list_of_vehicles->vehicle === $data && $list_of_vehicles->queuing === true){
            $puv_passengers = $list_of_vehicles->route . "_" . $list_of_vehicles->vehicle . ".json";
            $vehicles_list[$count_2]->queuing = false;
            date_default_timezone_set('Asia/Manila');
            $format="%d-%m-%Y_%H:%M:%S";
            $strf=strftime($format);
            $route = $list_of_vehicles->route;
            $directory = "../logs/" . $strf . "_" . $route . "_" . $list_of_vehicles->vehicle . ".txt";
            if(!copy("../vehicles/" . $puv_passengers, $directory)){
              echo json_encode("error");
            }
            else{
              try{
                $passenger_count = 0;
                $passenger_list_array = json_decode(file_get_contents("../vehicles/" . $puv_passengers));
                foreach($passenger_list_array as $passenger_name){
                  if($passenger_name->Name != "" && $passenger_name->Companion != ""){
                    $passenger_list_array[$count_3]->Name = "";
                    $passenger_list_array[$count_3]->Companion = "";
                    $passenger_count += 1;
                  }
                  $count_3 += 1;
                }
                $passengers = $passenger_count . "/" . $count_3;
                $save_log_directory = $connection->prepare("INSERT INTO logs(Directory, Vehicle, Passengers, Route, LogTime, LogDate) VALUES(:directory, :vehicle, :passengers, :route, now(), now())");
                $save_log_directory->bindParam(':directory', $directory);
                $save_log_directory->bindParam(':vehicle', $data);
                $save_log_directory->bindParam(':passengers', $passengers);
                $save_log_directory->bindParam(':route', $route);
                $save_log_directory->execute();
                $queuing_vehicles_file = fopen('../vehicles/queuing_vehicles.json', 'w');
                $all_vehicle_file = fopen('../vehicles/vehicles.json', 'w');
                $passenger_list_file = fopen("../vehicles/" . $puv_passengers, 'w');
                fwrite($queuing_vehicles_file, json_encode($queuing_vehicles_list));
                fwrite($all_vehicle_file, json_encode($vehicles_list));
                fwrite($passenger_list_file, json_encode($passenger_list_array));
                fclose($queuing_vehicles_file);
                fclose($all_vehicle_file);
                fclose($passenger_list_file);
                echo json_encode(json_encode($queuing_vehicles_list));
                break;
              }catch(Exception $e){
                echo json_encode("error");
              }
            }
          }
          $count_2 += 1;
        }
        break;
      }
      $count_1 += 1;
    }
  }
}
else{
  echo json_encode("error");
}
