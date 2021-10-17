<?php

include('../phpqrcode/qrlib.php');

$data = json_decode(file_get_contents("php://input"));

function infoCrypt($plaintext){
  $key = "udWH+XfEbKB44oqM";

  $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
  $iv = openssl_random_pseudo_bytes($ivlen);
  $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
  $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
  $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );

  return $ciphertext;
}

$passenger_info = (object) array("type" => "passenger", "name" => $data->fullname, "cnum" => $data->contact, "destination" => $data->dest);
$info = json_encode($passenger_info);
echo QRcode::png(infoCrypt($info));


?>
