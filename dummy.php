<!DOCTYPE html>
<html>
<body>

<?php

$name = array('joelito', 'quiapo', 'caorte');
$count = 0;

function one($name){
  echo '<h1>' . $name . '</h1>';
}

function two($name, $count){
  one($name[$count]);
}

while($count < sizeof($name)){
  two($name, $count);
  $count += 1;
}
?>

</body>
</html>
