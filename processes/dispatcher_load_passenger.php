<?php
require "./db_connection.php";
$data = json_decode(file_get_contents("php://input"));
$qr = $data->data;
try{
  $find_passenger = $connection->prepare("SELECT Contact, Name, COUNT(*) as Count FROM ormoc_commuters WHERE QR = :qr");
  $find_passenger->bindParam(":qr", $qr);
  $find_passenger->execute();
  $passenger = $find_passenger->fetch();
  if($passenger['Count'] > 0){
    $passenger_name = $passenger['Name'];
    $contact_num = $passenger['Contact'];
      $destination = $data->destination;
      $companion = $data->companion;
      $vehicle_available = false;
      $vehicle_not_full = false;
      $queuing_vehicles = json_decode(file_get_contents("../vehicles/queuing_vehicles.json"));
      foreach($queuing_vehicles as $vehicle){
        if($vehicle->route == $destination){
          $vehicle_available = true;
          if($vehicle->passengers < $vehicle->capacity){
            $vehicle_not_full = true;
            $check_if_waiting = $connection->prepare("SELECT Count(*) as Count FROM waiting_passengers WHERE QR = :qr");
            $check_if_waiting->bindParam(":qr", $qr);
            $check_if_waiting->execute();
            $is_waiting = $check_if_waiting->fetch();
            if($is_waiting['Count'] > 0){
              $remove_passenger = $connection->prepare("DELETE FROM waiting_passengers WHERE QR = :qr");
              $remove_passenger->bindParam(":qr", $qr);
              $remove_passenger->execute();
            }
            $vehicle->passengers += 1;
            $store_passenger = $connection->prepare("INSERT INTO loaded_passengers(Vehicle, Passenger, QR) VALUES(:vehicle, :passenger, :qr)");
            $store_passenger->bindParam(":vehicle", $vehicle->vehicle);
            $store_passenger->bindParam(":passenger", $passenger_name);
            $store_passenger->bindParam(":qr", $qr);
            $store_passenger->execute();
            $vehicle_filename = $vehicle->route . "_" . $vehicle->vehicle . ".json";
            $vehicle_manifest = json_decode(file_get_contents("../vehicles/" . $vehicle_filename));
            foreach($vehicle_manifest as $vehicle_passenger){
              if($vehicle_passenger->Name == "" && $vehicle_passenger->Companion == "" && $vehicle_passenger->Number == ""){
                $vehicle_passenger->Name = $passenger_name;
                $vehicle_passenger->Companion = $companion; //You stopped here -> 1 CORINTHIANS 10:31
                $vehicle_passenger->Number = $contact_num;
                break;
              }
            }
            $file_increment_vehicle = fopen("../vehicles/queuing_vehicles.json", "w");
            fwrite($file_increment_vehicle, json_encode($queuing_vehicles));
            fclose($file_increment_vehicle);
            $file_add_passenger = fopen("../vehicles/" . $vehicle_filename, "w");
            fwrite($file_add_passenger, json_encode($vehicle_manifest));
            fclose($file_add_passenger);
            echo json_encode($vehicle->vehicle);
            break;
          }
        }
      }
      if(!$vehicle_available || !$vehicle_not_full){
        $check_if_waiting = $connection->prepare("SELECT Count(*) as Count FROM waiting_passengers WHERE QR = :qr");
        $check_if_waiting->bindParam(":qr", $qr);
        $check_if_waiting->execute();
        $is_waiting = $check_if_waiting->fetch();
        if($is_waiting['Count'] > 0){
          $remove_passenger = $connection->prepare("DELETE FROM waiting_passengers WHERE QR = :qr");
          $remove_passenger->bindParam(":qr", $qr);
          $remove_passenger->execute();
        }
        $load_to_waiting = $connection->prepare("INSERT INTO waiting_passengers(Destination, Passenger, QR) VALUES(:destination, :passenger, :qr)");
        $load_to_waiting->bindParam(":destination", $destination);
        $load_to_waiting->bindParam(":passenger", $passenger_name);
        $load_to_waiting->bindParam(":qr", $qr);
        $load_to_waiting->execute();
        echo json_encode("waitinglist");
      }
  }
}catch(Exception $e){
  echo json_encode("error");
}
?>
