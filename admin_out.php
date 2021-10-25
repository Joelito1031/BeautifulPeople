<?php
session_start();
if(isset($_SESSION['loggedin'])){
  if(!$_SESSION['loggedin']){
    header('Location: ./');
  }else{
    session_destroy();
    header('Location: ./');
  }
}
else{
  header('Location: ./');
}
?>
?>
