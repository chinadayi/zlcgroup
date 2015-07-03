<?php
	header("Content-type: image/png");
	include '../../include/common.inc.php';
	$str=isset($str)?preg_replace('/[^a-z0-9\-_@\.\(\)\+]/i','',$str):'';
	$str=urldecode(base64_decode(trim($str)));
	$filename=TIME.mt_rand(100,999).'.png';
	$im = imagecreate(strlen($str)*12,20);
	$bgcolor = imagecolorallocate($im, 255, 255, 255);
	imagefill($im, 0, 0, $bgcolor);
	$colorBlack = imagecolorallocate($im, 0, 0, 0);
	imagestring($im, 4, 10, 5, $str, $colorBlack);
	imagepng($im);
	imagedestroy($im);
?>