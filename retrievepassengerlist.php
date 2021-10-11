<?php

$request = file_get_contents("php://input");
$data = json_decode($request);
$reply = file_get_contents("./vehicles/" . $data->data);
echo json_encode($reply);

?>
