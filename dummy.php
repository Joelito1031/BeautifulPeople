<?php
$string_text = 'Joelito';
if(in_array('aes-128-gcm', openssl_get_cipher_methods())){
  $ivlen = openssl_cipher_iv_length('aes-128-gcm');
  $iv = openssl_random_pseudo_bytes($ivlen);
  $ciphered = openssl_encrypt($string_text, 'aes-128-gcm', 'j_cube', $options = 0, $iv, $tag);
  $a = $tag;
  echo $ciphered . '<br>';
}
$deciphered = openssl_decrypt($ciphered, 'aes-128-gcm', 'j_cube', $options = 0, $iv, $a);
echo $deciphered . '<br>';
echo $a;
?>
