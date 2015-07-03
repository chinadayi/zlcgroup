<?php
	require substr(dirname(__FILE__),0,-8).'/include/common.inc.php';
	$db->query("UPDATE `".DB_PRE."ads` SET `".DB_PRE."ads`.`clicks`=`".DB_PRE."ads`.`clicks`+1 WHERE `".DB_PRE."ads`.`id`=".intval($id),true);
	$r=$db->fetch_one("SELECT `".DB_PRE."ads`.`linkurl`,`".DB_PRE."ads`.`text_link` FROM `".DB_PRE."ads` WHERE `".DB_PRE."ads`.`id`=".intval($id));

	$linkurl=$RETENG['site_url'];
	if($r['linkurl']=='' || $r['linkurl']=='http://')
	{
		if($r['text_link'] && $r['text_link']!='http://')
		{
			$linkurl=$r['text_link'];
		}
	}
	else
	{
		$linkurl=$r['linkurl'];
	}
	header("location:".$linkurl);
	exit();
?>
