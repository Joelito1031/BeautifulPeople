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

try{
  $search = "%" . $_POST['search'] . "%";
  $retrieve_dispatcher_list = $connection->prepare("SELECT * FROM dispatchers WHERE FirstName LIKE :fname OR MiddleName LIKE :mname OR LastName LIKE :lname");
  $retrieve_dispatcher_list->bindParam(":fname", $search);
  $retrieve_dispatcher_list->bindParam(":mname", $search);
  $retrieve_dispatcher_list->bindParam(":lname", $search);
  $retrieve_dispatcher_list->execute();
  $dispatchers = $retrieve_dispatcher_list->fetchAll();
  if($retrieve_dispatcher_list->rowCount() > 0){
    foreach($dispatchers as $dispatcher){
      $fname = '"' . $dispatcher['FirstName'] . '"';
      $mname = '"' . $dispatcher['MiddleName'] . '"';
      $lname = '"' . $dispatcher['LastName'] . '"';
      $suffix = '"' . $dispatcher['Suffix'] . '"';
      $id = '"' . $dispatcher['ID'] . '"';
      $contact = '"' . $dispatcher['Contact'] . '"';
      $profile = '"' . $dispatcher['Profile'] . '"';
      $pin = '"' . $dispatcher['PIN'] . '"';
      $address = '"' . $dispatcher['Address'] . '"';
      $name = '"' . $dispatcher['FirstName'] . " " . $dispatcher['MiddleName'] . " " . $dispatcher['LastName'] . " " . $dispatcher['Suffix'] . '"';
      echo "<div class='container p-3 border' style='display: flex; border-radius: 5px; margin-bottom: 5px;'>";
      echo "<div class='dispatcher-prof-container'>";
      echo "<div>";
      if($dispatcher['Profile'] == ''){
        echo "<img id='actual-pic' src='../dispatcher_profile/adminUserProfile.png'>";
      }else{
        echo "<img id='actual-pic' src='." . $dispatcher['Profile'] . "'>";
      }
      echo "</div>";
      echo "</div>";
      echo "<div style='margin-left: 5px; display: flex; flex-direction: column; justify-content: center'>";
      echo "<div class='p-2' style='color: #5DADE2'>";
      echo "<b>" . $dispatcher['FirstName'] . " " . $dispatcher['MiddleName'] . " " . $dispatcher['LastName'] . " " . $dispatcher['Suffix'] . "</b>";
      echo "</div>";
      echo "<div style='margin-left: 8px; font-size: 13px'>";
      echo $dispatcher['Address'] . ", Ormoc City";
      echo "</div>";
      echo "<div style='margin-left: 8px; font-size: 13px'>";
      echo $dispatcher['Contact'];
      echo "</div>";
      echo "<div class='p-2'>";
      echo "<span style='margin-right: 5px'><button type='button' data-toggle='modal' data-target='#popupEdit' style='font-size: 10px;' class='btn btn-primary' onclick='editDispatcher(" . $id . "," . $fname . "," . $mname . "," . $lname . "," . $suffix . "," . $contact . "," . $profile . "," . $pin . "," . $address . ")'>Edit</button></span>";
      echo "<button style='font-size: 10px;' type='button' class='btn btn-danger' onclick='deleteDispatcher(" . $id . "," . $name . ")'>Unregister</button>";
      echo "</div>";
      echo "</div>";
      echo "</div>";
    }
  }else{
    echo "<div class='container p-3 my-3 border' style='text-align: center'>Nothing was found in your search.</div>";
  }
  $connection = null;
}catch(Exception $e){
  echo "<div class='container p-3 my-3 border' style='text-align: center'>Something went wrong</div>";
}

?>
