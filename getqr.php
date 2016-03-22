<?php

function errimg($err) {
  $im = imagecreatefrompng('bcerror.png');
  $xc = imagesx($im) / 2;
  $yl = 50;
  $color = imagecolorallocate($im,0x49,0x99,0xCB);
  $msg = implode("\n",$err);
  $box = imagettfbbox(11,0,"Lato-Regular",$msg);
  $w = abs($box[4] - $box[0]);
  $h = abs($box[5] - $box[1]);
  $x = $xc - ($w / 2);
  $y = $yl + $h;
  imagettftext($im,11,0,$x,$y,$color,"Lato-Regular",$msg);
  imagepng($im);
  imagedestroy($im);
  exit();
}

function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct){ 
  $cut = imagecreatetruecolor($src_w, $src_h); 
  imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h); 
  imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h); 
  imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct); 
} 

$p = $_POST;
$err = array();
if (!isset($p['name'])) array_push($err,"- Name");
if (!isset($p['phone'])) array_push($err,"- Phone Number");
if (!isset($p['email'])) array_push($err,"- Email Address");
if (!isset($p['omit'])) {
  if (!isset($p['street'])) array_push($err,"- Street Address");
  if (!isset($p['csz'])) array_push($err,"- City/State/Zip");
}

header("Content-Type: image/png");

if (count($err)) errimg($err);

if (!strlen($p['name'])) array_push($err,"- Name");
if (!strlen($p['phone'])) array_push($err,"- Phone Number");
if (!strlen($p['email'])) array_push($err,"- Email Address");
if ($p['omit'] != 'on' && $p['omit'] != '1') {
  if (!strlen($p['street'])) array_push($err,"- Street Address");
  if (!strlen($p['csz'])) array_push($err,"- City/State/Zip");
  $omit = false;
} else {
  $omit = true;
}

if (count($err)) errimg($err);

$countries = array('United States'=>'+1','Canada'=>'+1','Mexico'=>'+52','United Kingdom'=>'+44',
                   'Ireland'=>'+353','China'=>'+86','Australia'=>'+61','South Korea'=>'+82',
                   'Japan'=>'+81','India'=>'+91','New Zealand'=>'+64','Philippines'=>'+63');
$country = 'United States';
if (isset($p['country'])) {
  if (strlen($p['country'])) {
    $country = $p['country'];
    if (!array_key_exists($country,$countries)) errimg(array("Unrecognized country name"));
  }
}
$url = 'http://www.yottaa.com';
if (isset($p['url'])) {
  if (strlen($p['url'])) {
    if (substr($p['url'],0, 29) == "https://www.linkedin.com/pub/")
      errimg(array("www.linkedin.com/pub/ URLs are not allowed",
        "(user must have www.linkedin.com/in/ URL)"));
    if (substr($p['url'],0, 28) != "https://www.linkedin.com/in/")
      errimg(array("Bad LinkedIn URL"));
    $url = $p['url'];
  }
}

if (isset($p['memo'])) $memo = trim($p['memo']);
if ($memo != "") $memo = "NOTE:${memo};";
$im = imagecreatefrompng('bcblank-print.png');
imagealphablending($im, true);
$blue  = imagecolorallocate($im,0x49,0x99,0xCB);
$white = imagecolorallocate($im,0xFF,0xFF,0xFF);
$black = imagecolorallocate($im,0x00,0x00,0x00);

//imagefill($im, 1, 1, $white);
require_once("qrlib.php");

$center = 1360;
$left = 380;

$name = $p['name'];
if (!$omit) $addr = $p['street'] . ', ' . $p['csz'] . ', ' . $country;
$tel = $countries[$country] . $p['phone'];
$email = $p['email'];
if (!$omit) 
  $mecard = "MECARD:N:${name};TEL:${tel};EMAIL:${email};ADR:${addr};URL:${url};${memo}";
else
  $mecard = "MECARD:N:${name};TEL:${tel};EMAIL:${email};URL:${url};${memo}";

$labelsize = 80;
$unitsize = 32;
$cardline = 2420;
//if (strlen($mecard) > 120) errimg(array("Data is too long!"));
$qr = QRCode::getMinimumQRCode($mecard, QR_ERROR_CORRECT_LEVEL_L);
$qrimg = $qr->createImage($unitsize, $unitsize * 2, 0x0, 0xff, true);
$mw = imagesx($qrimg);
$mh = imagesy($qrimg);
$box = imagettfbbox($labelsize,0,"Lato-Bold","MECARD (Contact Info)");
$tw = abs($box[4] - $box[0]);
$th = abs($box[5] - $box[1]);
$top = $center - ($mh / 2) - $th;
$bottom = $top + $mh;
$ty = $bottom + (($cardline - $bottom) / 2) + ($unitsize * 1.5) - ($th / 2);

if ($mw < 1600) $left += 25;
if ($mw < 1500) $left += 25;
if ($mw < 1400) $left += 25;

imagecopymerge($im, $qrimg, $left, $top, 0, 0, $mw, $mh, 100);
//imagestring($im,4,525,50,"X:${mw} Y:${mh}",$white);

$tx = ($left + ($mw / 2)) - ($tw / 2);
imagettftext($im,$labelsize,0,$tx,$ty,$white,"Lato-Bold","MECARD (Contact Info)");

imagepng($im);
imagedestroy($im);
exit();

?>
