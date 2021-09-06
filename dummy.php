<?php

include('./phpqrcode/qrlib.php');

$key = "udWH+XfEbKB44oqM";

function decryptor($ciphertext){
  $c = base64_decode($ciphertext);
  $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
  $iv = substr($c, 0, $ivlen);
  $hmac = substr($c, $ivlen, $sha2len=32);
  $ciphertext_raw = substr($c, $ivlen+$sha2len);
  $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $GLOBALS['key'], $options=OPENSSL_RAW_DATA, $iv);
  $calcmac = hash_hmac('sha256', $ciphertext_raw, $GLOBALS['key'], $as_binary=true);
  if (hash_equals($hmac, $calcmac))// timing attack safe comparison
  {
      echo $original_plaintext."\n";
  }
}

// $plaintext = '{"type":"passenger","name":"Joelito Quiapo Caorte","cnum":"09306319380","destination":"bato"}';
//
// $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
// $iv = openssl_random_pseudo_bytes($ivlen);
// $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
// $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
// $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );

             // F3LNrvKR0plufn+pOSFypow3+NbmWrFvgysyQO+4E/gx1kuWdqznjxVbmnQw6/Kq0ExOfmUbDx3FjLo6W2PQAh5JfL2QIYAL8Igt3pPEKsv0G9Is/42eWSigJn+z7AyT
// $ciphered = "wioPacHFxTchfKR0RJPPGGCseRZBmX8DdRMsJpO512SrnxnSGH3BIZy9fHYdsb+rJ0oBcB8eFM++zuuB+4bQPt7/6zG2oGzmp9lTxg6SIiDeHJjezGuAQwcQ0z4LDPucFD6y2mbXNE3AnuRZs0YgHMJ9ZWr+gI9kxd4JZ866Yf7ZInnTsOjHegxRnK82N15r";
decryptor("U+Yn62c+wcvNj2gc12e2LMZEUWNNU8aslldZvFw7NqbijIrLt6OmvxGjXSUgDGihC3usXSB8ZdLxHo0bhNSMiwqg9Nmth3LKAXo+VnPj7Dc7rALdB643KRACFxOmSZKgw2kH42+16WxbbIlrJvtu9v9heJL2KJrBqw/GxY9kH9n0tX3TzjjC6A5t7w9zi2OX");

// QRcode::png($ciphertext, './dummy/dummy.png', QR_ECLEVEL_L, 4);

?>
