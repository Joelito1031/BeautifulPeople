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
if(isset($_POST['data'])){
  $data = $_POST['data'];
}
try{
  $plateno = $_POST['data'];
  $queuing_vehicles = json_decode(file_get_contents("./vehicles/queuing_vehicles.json"));
  $proceed = true;
  foreach($queuing_vehicles as $queued_vehicle){
    if($queued_vehicle->vehicle == $plateno){
      $proceed = false;
      break;
    }
  }

  if($proceed){
    require './db_connection.php';
    $data = $_POST['data'];
    $vehicle_is_queuing = false;
    $count_one = 0;
    $count_two = 0;
    require './db_connection.php';
    $vehicles = json_decode(file_get_contents('./vehicles/vehicles.json'));
    foreach($vehicles as $vehicle){
      if($vehicle->vehicle == $data){
        $vehicle_name = $vehicle->vehicle;
        $route = $vehicle->route;
        array_splice($vehicles, $count_one, 1);
        $queuing_vehicles = json_decode(file_get_contents('./vehicles/queuing_vehicles.json'));
        foreach($queuing_vehicles as $queuing_puvs){
          if($queuing_puvs->vehicle == $data){
            $vehicle_is_queuing = true;
            array_splice($queuing_vehicles, $count_two, 1);
            $delete_vehicle = $connection->prepare("DELETE FROM registered_vehicles WHERE PlateNo = :platenumber");
            $delete_vehicle->bindParam(":platenumber", $data);
            try{
              if(!unlink("./vehicles/" . $route . "_" . $vehicle_name . ".json")){
                echo "error";
              }else{
                if(!unlink("./qrs/" . $vehicle_name . ".png")){
                  echo "error";
                }
                else{
                  $delete_vehicle->execute();
                  $vehicles_file = fopen('./vehicles/vehicles.json', 'w');
                  $vehicles_to_save = json_encode($vehicles);
                  fwrite($vehicles_file, $vehicles_to_save);
                  fclose($vehicles_file);
                  $queuing_vehicles_file = fopen('./vehicles/queuing_vehicles.json', 'w');
                  $queuing_vehicles_to_save = json_encode($queuing_vehicles);
                  fwrite($queuing_vehicles_file, $queuing_vehicles_to_save);
                  fclose($queuing_vehicles_file);
                  echo "success";
                }
              }
            }catch(Exception $e){
              echo "error";
            }
            break;
          }
          $count_two += 1;
        }
        if(!$vehicle_is_queuing){
          $delete_vehicle = $connection->prepare("DELETE FROM registered_vehicles WHERE PlateNo = :platenumber");
          $delete_vehicle->bindParam(":platenumber", $data);
          try{
            if(!unlink("./vehicles/" . $route . "_" . $vehicle_name . ".json")){
              echo "error";
            }else{
              if(!unlink("./qrs/" . $vehicle_name . ".png")){
                echo "error";
              }
              else{
                $select_profile = $connection->prepare("SELECT VehicleProfile FROM registered_vehicles WHERE PlateNo = :platenumber");
                $select_profile->bindParam(":platenumber", $data);
                $select_profile->execute();
                $profile_dir = $select_profile->fetchColumn();
                if($profile_dir != ""){
                  if(!unlink($profile_dir)){
                    echo "error";
                  }else{
                    $delete_vehicle->execute();
                    $vehicles_file = fopen('./vehicles/vehicles.json', 'w');
                    $vehicles_to_save = json_encode($vehicles);
                    fwrite($vehicles_file, $vehicles_to_save);
                    fclose($vehicles_file);
                    echo "success";
                  }
                }else{
                  $delete_vehicle->execute();
                  $vehicles_file = fopen('./vehicles/vehicles.json', 'w');
                  $vehicles_to_save = json_encode($vehicles);
                  fwrite($vehicles_file, $vehicles_to_save);
                  fclose($vehicles_file);
                  echo "success";
                }
              }
            }
          }catch(Exception $e){
            echo "error";
          }
        }
        break;
      }
      $count_one += 1;
    }
  }else{
    echo "notallowed";
  }
}catch(Exception $e){
  echo "error";
}
?>
