<?php
	include '../../include/common.inc.php';
	session_start();
	include '../../include/checkcode.class.php';
	$checkcode= new checkcode();
	$checkcode ->create_image();
	$_SESSION['checkcode']=$checkcode->get_code();
?>