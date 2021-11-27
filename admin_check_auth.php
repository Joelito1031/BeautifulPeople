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
if(isset($_SESSION['authentication'])){
  if($_SESSION['authentication']){
    echo "authorized";
  }else{
    echo "notauthorized";
  }
}else{
  echo "notauthorized";
}
?>
