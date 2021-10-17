<?php

$data = file_get_contents('../vehicles/queuing_vehicles.json');
echo json_encode($data);

?>
