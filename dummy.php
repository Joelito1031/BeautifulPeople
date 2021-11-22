<?php
$data = array("name" => "joelito", "profile" => "../hello");

print_r(json_decode('{"name":"joelito","profile":"..\/hello"}'));
?>
<script>
console.log(JSON.parse('{"name":"joelito","profile":"..\/hello"}'));
</script>
