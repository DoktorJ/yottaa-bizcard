<?php
require_once("qrlib.php");
$qr = QRCode::getMinimumQRCode("QR...", QR_ERROR_CORRECT_LEVEL_M);
$im = $qr->createImage(6, 9);
header("Content-type: image/png");
imagepng($im);
imagedestroy($im);
?>
