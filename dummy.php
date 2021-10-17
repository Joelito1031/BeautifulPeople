<?php
$str = "<h1>Hello World</h1>";
print_r(filter_var($str, FILTER_SANITIZE_STRING));
?>
