<?php
require "./db_connection.php";
$data = json_decode(file_get_contents("php://input"));
$qr = $data->data;
try{
  if($data->status == "loaded"){
    $get_passenger = $connection->prepare("SELECT Name FROM ormoc_commuters WHERE QR = :qr");
    $get_passenger->bindParam(":qr", $qr);
    $get_passenger->execute();
    $passenger = $get_passenger->fetch();
    if($get_passenger->rowCount() > 0){
      $passenger_name = $passenger['Name'];
      $passenger_vehicle = $connection->prepare("SELECT Vehicle FROM loaded_passengers WHERE QR = :qr");
      $passenger_vehicle->bindParam(":qr", $qr);
      $passenger_vehicle->execute();
      $vehicle = $passenger_vehicle->fetch();
      if($passenger_vehicle->rowCount() > 0){
        $vehicle_name = $vehicle['Vehicle'];
        $remove_query = $connection->prepare("DELETE FROM loaded_passengers WHERE QR = :qr");
        $remove_query->bindParam(":qr", $qr);
        $remove_query->execute();
        $queuing_vehicles = json_decode(file_get_contents("../vehicles/queuing_vehicles.json"));
        foreach($queuing_vehicles as $vehicle){
          if($vehicle->vehicle == $vehicle_name){
            $vehicle->passengers = $vehicle->passengers - 1;
            $vehicle_name = $vehicle->route . "_" . $vehicle->vehicle . ".json";
            $vehicle_passenger_list = json_decode(file_get_contents("../vehicles/" . $vehicle_name));
            foreach($vehicle_passenger_list as $passenger){
              if($passenger->Name == $passenger_name){
                $passenger->Name = "";
                $passenger->Companion = "";
                $queuing_vehicles_file = fopen("../vehicles/queuing_vehicles.json", "w");
                fwrite($queuing_vehicles_file, json_encode($queuing_vehicles));
                fclose($queuing_vehicles_file);
                $passengers_file = fopen("../vehicles/" . $vehicle_name, "w");
                fwrite($passengers_file, json_encode($vehicle_passenger_list));
                fclose($passengers_file);
                echo json_encode("success");
                break;
              }
            }
            break;
          }
        }
      }else{
        echo json_encode("error");
      }
    }else{
      echo json_encode("error");
    }
  }else if($data->status == "waiting"){
    $remove_waiting_passenger = $connection->prepare("DELETE FROM waiting_passengers WHERE QR = :qr");
    $remove_waiting_passenger->bindParam(":qr", $qr);
    $remove_waiting_passenger->execute();
    echo json_encode("success");
  }

}catch(Exception $e){
  echo json_encode("error");
}
?>
