<?php	
	!defined('MEMBER_CENTER') && exit('Access Denied!');

	/*
		用户文章10条 ,优先读取缓存
	*/
	$consql="SELECT * FROM `".DB_PRE."content` WHERE `".DB_PRE."content`.`siteid`=".SITEID." AND `".DB_PRE."content`.`userid`=$_userid AND `".DB_PRE."content`.`status`=1 ORDER BY `".DB_PRE."content`.`orderby` ASC,`id` DESC LIMIT 0,10";
	$content=$cache->get($consql);

	if(!$content)
	{
		$content=$db->fetch_all($consql);
		$cache->set($consql,$content);
	}

	/*
		最新文章6条 ,优先读取缓存
	*/
	$newconsql="SELECT * FROM `".DB_PRE."content` WHERE `".DB_PRE."content`.`siteid`=".SITEID." AND `".DB_PRE."content`.`status`=1 ORDER BY `".DB_PRE."content`.`id` DESC LIMIT 0,6";
	$newcontent=$cache->get($newconsql);

	if(!$newcontent)
	{
		$newcontent=$db->fetch_all($newconsql);
		$cache->set($newconsql,$newcontent);
	}
	
	/*
		热门文章6条 ,优先读取缓存
	*/
	$topconsql="SELECT * FROM `".DB_PRE."content` WHERE `".DB_PRE."content`.`siteid`=".SITEID." AND`".DB_PRE."content`.`status`=1 ORDER BY `".DB_PRE."content`.`clicks` ASC LIMIT 0,6";
	$topcontent=$cache->get($topconsql);

	if(!$topcontent)
	{
		$topcontent=$db->fetch_all($topconsql);
		$cache->set($topconsql,$topcontent);
	}
	include member_tlp('index');
?>
