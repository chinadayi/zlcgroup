<?php
	include '../../include/common.inc.php';
	include RETENG_ROOT.'include/content.class.php';
	$conobj= new content();
	$result=$conobj->checktitle($title,$id);
	exit($result);
?>
