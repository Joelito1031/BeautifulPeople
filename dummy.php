<?php
function decryptor($cipheredtext){
  $key = "udWH+XfEbKB44oqM";
  $c = base64_decode($cipheredtext);
  $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
  $iv = substr($c, 0, $ivlen);
  $hmac = substr($c, $ivlen, $sha2len=32);
  $cipheredtext_raw = substr($c, $ivlen+$sha2len);
  $plain_string = openssl_decrypt($cipheredtext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
  $calcmac = hash_hmac('sha256', $cipheredtext_raw, $key, $as_binary=true);
  if (hash_equals($hmac, $calcmac))
  {
      return $plain_string;
  }

}

echo decryptor('7AuF/pIbbo0xSn3FZayiEbGur9eZVM5pK0UHhaRPuyCwnI5bZCwUuCG728FGjiaGrj+2xf0a6NBXpYm21MAYevDSQtBX0N/wd3gsSWIP4BS2v6cdc/5W3jscthgJe4x8yLtTwy1F1rbUwAbHlUTkDO3pmpTjCumyTSUpLcG+swyFDU0ju5nX1FsK+rP4WSNP7Xm9mUJASczZs338ElfO6Q==');
