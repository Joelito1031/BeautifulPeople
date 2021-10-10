<?php

if((isset($_POST['dis_fname']) && !empty(trim($_POST['dis_fname']))) && (isset($_POST['dis_mname']) && !empty(trim($_POST['dis_mname'])))
   && (isset($_POST['dis_lname']) && !empty(trim($_POST['dis_lname']))) && (isset($_POST['dis_cnum']) && !empty(trim($_POST['dis_cnum'])))
   && (isset($_POST['dis_pin']) && !empty(trim($_POST['dis_pin'])))) {

     $name = $_POST['dis_fname'] . " " . $_POST['dis_mname'] . " " . $_POST['dis_lname'];
     $contact = $_POST['dis_cnum'];
     $pin = $_POST['dis_pin'];
     $servername = "localhost";
     $username = "root";
     $password = "";
     $database = "ocqms";

     try {
       $connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);

       $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

       $insert_query = "INSERT INTO dispatchers(Name, OnDuty, PIN, Contact) VALUES('$name', TRUE, '$pin', '$contact')";
       $connection->exec($insert_query);
       echo "Dispatcher is registered";
     }catch(PDOException $e){
       echo "Something went wrong";
     }

}

?>
