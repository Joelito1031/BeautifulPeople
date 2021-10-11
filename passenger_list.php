<?php
$server = 'localhost';
$username = 'root';
$password = '';
$dbname = 'ocqms';

$connection = new PDO("mysql:host=$server;dbname=$dbname", $username, $password);
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$select_query = $connection->prepare("SELECT COUNT(*) as count FROM waiting_passengers WHERE Destination=?");
$select_query->execute(['valencia']);
$result_valencia = $select_query->fetch(PDO::FETCH_ASSOC);
echo "<div class='main-div'><div class='dest-div'>Valencia</div><div class='waiting-div'>" . $result_valencia['count'] . "</div></div>";
$select_query->execute(['albuera']);
$result_albuera = $select_query->fetch(PDO::FETCH_ASSOC);
echo "<div class='main-div'><div class='dest-div'>Albuera</div><div class='waiting-div'>" . $result_albuera['count'] . "</div></div>";
$select_query->execute(['sabang-bao']);
$result_sabang_bao = $select_query->fetch(PDO::FETCH_ASSOC);
echo "<div class='main-div'><div class='dest-div'>Sabang-Bao</div><div class='waiting-div'>" . $result_sabang_bao['count'] . "</div></div>";
$select_query->execute(['puertobello']);
$result_puertobello = $select_query->fetch(PDO::FETCH_ASSOC);
echo "<div class='main-div'><div class='dest-div'>Puertobello</div><div class='waiting-div'>" . $result_puertobello['count'] . "</div></div>";

$connection = null;
?>
