<?php
	require substr(dirname(__FILE__),0,-15).'/include/common.inc.php';
	require substr(dirname(__FILE__),0,-15).'/include/content.class.php';
	$id=intval($id);
	if($id <= 0)
	{
		show404('指定内容不存在!');
	}
	
	/*
		一小时内不重复统计同一IP浏览次数
	*/
	$cookiekey=md5('statistics_'.$id.'_'.IP);
	if(!isset($_COOKIE[$cookiekey]))
	{
		setcookie($cookiekey,'dc',TIME+60*60);
		$db->query("UPDATE `".DB_PRE."content` SET `".DB_PRE."content`.`clicks`=`".DB_PRE."content`.`clicks`+1 WHERE `".DB_PRE."content`.`id`={$id}",true);
	}
	/*$db->query("UPDATE `".DB_PRE."content` SET `".DB_PRE."content`.`clicks`=`".DB_PRE."content`.`clicks`+1 WHERE `".DB_PRE."content`.`id`={$id}",true);*/
	$c=new content();
	$r=$c->get($id);
?>
function killerrors() 
{ 
	return true; 
}
window.onerror = killerrors;
var js_clicks=<?php echo $r['clicks']?>;
var js_comments=<?php echo $r['comments']?>;
