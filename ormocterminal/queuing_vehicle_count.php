<?php
session_start();
if(isset($_SESSION['loggedin'])){
  if(!$_SESSION['loggedin']){
    echo "data is restricted";
  }else{
    try{
      $queuing_vehicles = json_decode(file_get_contents('../vehicles/queuing_vehicles.json'));
      if(sizeof($queuing_vehicles) > 0){
        $count = 0;
        foreach($queuing_vehicles as $vehicle){
           $count++;
        }
        echo "<h3>" . $count . "</h3>";
      }else{
        echo "<h3>0</h3>";
      }
    }catch(Exception $e){
      echo "<h3>error</h3>";
    }
  }
}else{
  echo "<h3>data is restricted</h3>";
}
?>
