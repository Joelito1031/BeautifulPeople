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
   && (isset($_POST['dis_pin']) && !empty(trim($_POST['dis_pin']))) && (isset($_POST['address']) && trim($_POST['address']) != "")){
     try{
       require './db_connection.php';
       $fname = $_POST['dis_fname'];
       $mname = $_POST['dis_mname'];
       $lname = $_POST['dis_lname'];
       $suffix = $_POST['dis_suffix'];
       $address = $_POST['address'];
       $verify_dispatcher = $connection->prepare("SELECT * FROM dispatchers WHERE FirstName = :fname AND MiddleName = :mname AND LastName = :lname AND Suffix = :suffix");
       $verify_dispatcher->bindParam(':fname', $fname);
       $verify_dispatcher->bindParam(':mname', $mname);
       $verify_dispatcher->bindParam(':lname', $lname);
       $verify_dispatcher->bindParam(':suffix', $suffix);
       $verify_dispatcher->execute();
       $count = $verify_dispatcher->fetchColumn();
       if($count > 0){
        echo "registered";
       }else{
         $pin = $_POST['dis_pin'];
         $check_pin = $connection->prepare("SELECT PIN FROM dispatchers WHERE PIN = :pin");
         $check_pin->bindParam(":pin", $pin);
         $check_pin->execute();
         $count = $check_pin->fetchColumn();
         if($count > 0){
           echo "pinexist";
         }else{
           $contact = $_POST['dis_cnum'];
           $register_dispatcher = $connection->prepare("INSERT INTO dispatchers(FirstName, MiddleName, LastName, Suffix, OnDuty, PIN, Contact, Address) VALUES(:fname, :mname, :lname, :suffix, FALSE, :pin, :contact, :address)");
           $register_dispatcher->bindParam(':fname', $fname);
           $register_dispatcher->bindParam(':mname', $mname);
           $register_dispatcher->bindParam(':lname', $lname);
           $register_dispatcher->bindParam(':suffix', $suffix);
           $register_dispatcher->bindParam(':pin', $pin);
           $register_dispatcher->bindParam(':contact', $contact);
           $register_dispatcher->bindParam(':address', $address);
           $register_dispatcher->execute();
           echo "success";
         }
       }
     }catch(Exception $e){
       echo "error";
     }
}else{
  echo "incomplete";
}
$connection = null;
?>
