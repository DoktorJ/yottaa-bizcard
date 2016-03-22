<?php

function hex2rgb($h = 0) {
  return array('r'=>floor($h/65535),'g'=>floor($h/256)%256,'b'=>$h%256);
}

if (isset($_GET['hex'])) var_dump(hex2rgb(hexdec($_GET['hex'])));
