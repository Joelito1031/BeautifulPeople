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
include('./phpqrcode/qrlib.php');

function infoCrypt($plaintext){
  $key = "udWH+XfEbKB44oqM";

  $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
  $iv = openssl_random_pseudo_bytes($ivlen);
  $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
  $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
  $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );

  return $ciphertext;
}

if((isset($_GET['fname']) && !empty(trim($_GET['fname']))) && (isset($_GET['mname']) && !empty(trim($_GET['mname'])))
  && (isset($_GET['lname']) && !empty(trim($_GET['lname']))) && (isset($_GET['cnum']) && !empty(trim($_GET['cnum'])))
  && (isset($_GET['dst']) && !empty(trim($_GET['dst'])))){
    $passenger_info = (object) array("type" => "passenger", "name" => $_GET['fname'] . ' ' . $_GET['mname'] . ' ' . $_GET['lname'], "cnum" => $_GET['cnum'], "destination" => $_GET['dst']);
    $info = json_encode($passenger_info);
    QRcode::png(infoCrypt($info));
  }
else{
  echo "Please fill all the fields.";
}
