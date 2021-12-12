<?php
session_start();
if(isset($_SESSION['loggedin'])){
  if(!$_SESSION['loggedin']){
    header('Location: ./');
  }
}
else{
  header('Location: ./');
}
require './db_connection.php';

$passenger_count = $connection->prepare("SELECT COUNT(*) as count FROM waiting_passengers WHERE Destination = :destination");
$destination_one = "valencia";
$passenger_count->bindParam(':destination', $destination_one);
try{
  $passenger_count->execute();
  $count_one = $passenger_count->fetchColumn();
}catch(Exception $e){
  echo "Error";
}
echo "<div class='main-div'><div class='dest-div'>Valencia</div><div class='waiting-div'>" . $count_one . "</div></div>";
$destination_two = "albuera";
$passenger_count->bindParam(':destination', $destination_two);
try{
  $passenger_count->execute();
  $count_two = $passenger_count->fetchColumn();
}catch(Exception $e){
  echo "Error";
}
echo "<div class='main-div'><div class='dest-div'>Albuera</div><div class='waiting-div'>" . $count_two . "</div></div>";
$destination_three = 'sabangbao';
$passenger_count->bindParam(':destination', $destination_three);
try{
  $passenger_count->execute();
  $count_three = $passenger_count->fetchColumn();
}catch(Exception $e){
  echo "Error";
}
echo "<div class='main-div'><div class='dest-div'>Sabang-Bao</div><div class='waiting-div'>" . $count_three . "</div></div>";
$destination_four = 'puertobello';
$passenger_count->bindParam(':destination', $destination_four);
try{
  $passenger_count->execute();
  $count_four = $passenger_count->fetchColumn();
}catch(Exception $e){
  echo "Error";
}
echo "<div class='main-div'><div class='dest-div'>Puertobello</div><div class='waiting-div'>" . $count_four . "</div></div>";

$connection = null;
?>
