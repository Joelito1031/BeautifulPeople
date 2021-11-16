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
     try{
       require './db_connection.php';
       $pin = $_POST['dis_pin'];
       $changepin = $_POST['changepin'];
       $check_pin = $connection->prepare("SELECT PIN FROM dispatchers WHERE PIN = :pin");
       $check_pin->bindParam(":pin", $pin);
       $check_pin->execute();
       $count = $check_pin->fetchColumn();
       if($count > 0 && $changepin == "true"){
        echo "pinexist";
       }else{
         $fname = $_POST['dis_fname'];
         $mname = $_POST['dis_mname'];
         $lname = $_POST['dis_lname'];
         $suffix = $_POST['dis_suffix'];
         $contact = $_POST['dis_cnum'];
         $id = $_POST['id'];
         $update_dispatcher = $connection->prepare("UPDATE dispatchers SET FirstName = :fname, MiddleName = :mname, LastName = :lname, Suffix = :suffix, PIN = :pin, Contact = :contact WHERE ID = :id");
         $update_dispatcher->bindParam(':fname', $fname);
         $update_dispatcher->bindParam(':mname', $mname);
         $update_dispatcher->bindParam(':lname', $lname);
         $update_dispatcher->bindParam(':suffix', $suffix);
         $update_dispatcher->bindParam(':pin', $pin);
         $update_dispatcher->bindParam(':contact', $contact);
         $update_dispatcher->bindParam(':id', $id);
         $update_dispatcher->execute();
         if($update_dispatcher->rowCount() > 0){
           echo "success";
         }else{
           echo "nochanges";
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
