<?php
	$_GET['siteid']=isset($_GET['siteid']) && intval($_GET['siteid'])?intval($_GET['siteid']):1;
	require substr(dirname(__FILE__),0,-8).'/include/common.inc.php';
	include RETENG_ROOT.'adv/include/ads.class.php';
	$ads=new ads();
	$ads->ads_show(intval($id));
?>
