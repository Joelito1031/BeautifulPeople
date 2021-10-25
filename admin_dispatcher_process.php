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
if((isset($_POST['dis_fname']) && !empty(trim($_POST['dis_fname']))) && (isset($_POST['dis_mname']) && !empty(trim($_POST['dis_mname'])))
   && (isset($_POST['dis_lname']) && !empty(trim($_POST['dis_lname']))) && (isset($_POST['dis_cnum']) && !empty(trim($_POST['dis_cnum'])))
   && (isset($_POST['dis_pin']) && !empty(trim($_POST['dis_pin'])))) {
     $name = trim($_POST['dis_fname']) . " " . trim($_POST['dis_mname']) . " " . trim($_POST['dis_lname']);
     $contact = $_POST['dis_cnum'];
     $pin = $_POST['dis_pin'];
     require './db_connection.php';
     $verify_dispatcher = $connection->prepare("SELECT COUNT(*) FROM dispatchers WHERE Name = :name");
     $verify_dispatcher->bindParam(':name', $name);
     $verify_dispatcher->execute();
     $count = $verify_dispatcher->fetchColumn();
     if($count > 0){
       echo "registered";
     }
     else{
       $register_dispatcher = $connection->prepare("INSERT INTO dispatchers(Name, OnDuty, PIN, Contact) VALUES(:name, TRUE, :pin, :contact)");
       $register_dispatcher->bindParam(':name', $name);
       $register_dispatcher->bindParam(':pin', $pin);
       $register_dispatcher->bindParam(':contact', $contact);
       try{
         $register_dispatcher->execute();
         $connection = null;
         echo "success";
       }catch(Exception $e){
         $connection = null;
         echo "error";
       }
     }
}else{
  echo "incomplete";
}

?>
