<?php

$vehicle_capacity = array();

for($count = 1; $count <= 20; $count++){
  array_push($vehicle_capacity, '');
}

print_r(json_encode($vehicle_capacity));
// print_r(json_decode($data));
?>
