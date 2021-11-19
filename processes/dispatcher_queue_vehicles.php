<?php
function decryptor($cipheredtext){
  $key = "udWH+XfEbKB44oqM";
  $c = base64_decode($cipheredtext);
  $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
  $iv = substr($c, 0, $ivlen);
  $hmac = substr($c, $ivlen, $sha2len=32);
  $cipheredtext_raw = substr($c, $ivlen+$sha2len);
  $plain_string = openssl_decrypt($cipheredtext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
  $calcmac = hash_hmac('sha256', $cipheredtext_raw, $key, $as_binary=true);
  if (hash_equals($hmac, $calcmac))
  {
      return $plain_string;
  }
}
$data = json_decode(file_get_contents("php://input"));
try{
  $vehicle_info = json_decode(decryptor($data->data));
  $plate_no = $vehicle_info->plateno;

  $queue_vehicles = json_decode(file_get_contents('../vehicles/vehicles.json'));
  $registered = false;
  foreach($queue_vehicles as $vehicle){
    if($vehicle->vehicle == $plate_no){
      $registered = true;
      if($vehicle->queuing == false){
        $vehicle->queuing = true;
        date_default_timezone_set('Asia/Manila');
        $format="%d-%m-%Y_%H:%M:%S";
        $strf=strftime($format);
        $queuing_list = json_decode(file_get_contents('../vehicles/queuing_vehicles.json'));
        $queuing_info = array("vehicle" => $vehicle->vehicle, "route" => $vehicle->route, "capacity" => $vehicle->capacity, "passengers" => 0, "time_queue" => $strf);
        array_push($queuing_list, $queuing_info);
        $altered_queuing_list = fopen('../vehicles/queuing_vehicles.json', 'w');
        $altered_vehicle_list = fopen('../vehicles/vehicles.json', 'w');
        fwrite($altered_queuing_list, json_encode($queuing_list));
        fwrite($altered_vehicle_list, json_encode($queue_vehicles));
        fclose($altered_queuing_list);
        fclose($altered_vehicle_list);
        echo json_encode("Vehicle is set to queuing");
        break;
      }elseif($vehicle->queuing == true){
        echo json_encode('Vehicle already queuing');
        break;
      }
    }
  }
  if(!$registered){
    echo json_encode("Vehicle is not registered");
  }

}catch(Exception $e){
  echo json_encode("Something went wrong");
}
?>
