<?php

if(is_writable('./vehicles/queuing_vehicles.json')){
  $status = json_encode(file_get_contents('./vehicles/queuing_vehicles.json'));
} else {
  $status = json_encode('Halted');
}

echo $status;

?>
