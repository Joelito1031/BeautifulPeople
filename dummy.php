<?php

$data = array();

$datum = json_encode($data);

print_r($datum);

$file = fopen('file.json', 'w');

fwrite($file, $datum);

fclose($file);

$contents = file_get_contents('./file.json');

$dta = json_decode($contents);



?>
