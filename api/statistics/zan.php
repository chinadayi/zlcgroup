<?php
	require substr(dirname(__FILE__),0,-15).'/include/common.inc.php';
	require substr(dirname(__FILE__),0,-15).'/include/content.class.php';
	$id=intval($id);
	if($id <= 0)
	{
		show404('指定内容不存在!');
	}
	//一小时数只能一次
	$cookiekey=md5('zan_'.$id.'_'.IP);
	if(!isset($_COOKIE[$cookiekey]))
	{
		
		if($do=='support')
		{
			$db->query("UPDATE `".DB_PRE."content` SET `".DB_PRE."content`.`support`=`".DB_PRE."content`.`support`+1 WHERE `".DB_PRE."content`.`id`={$id}",true);
			setcookie($cookiekey,'dy',TIME+60*60,'/');

		}
		if($do=='oppose')
		{
			$db->query("UPDATE `".DB_PRE."content` SET `".DB_PRE."content`.`oppose`=`".DB_PRE."content`.`oppose`+1 WHERE `".DB_PRE."content`.`id`={$id}",true);
			setcookie($cookiekey,'dy',TIME+60*60,'/');

		}
	}
	$c=new content();
	$r=$c->get($id);

	echo "<span id=support>".$r['support']."</span>";
	echo "<span id=oppose>".$r['oppose']."</span>";



?>

