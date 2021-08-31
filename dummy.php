<?php

try{
  fopen('./queuing/bato.json', 'x+');
}catch(Exception $e){
  echo 'This is the ERROR: ' . $e; 
}
