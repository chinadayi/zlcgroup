<?php
/**
	Plugins Name:栏目内容数量统计插件 UTF-8
	Plugins Description:栏目内容数量统计插件。模板调用方法 {catstatistics(栏目ID,$today)} 当 $today=1时，显示今日发帖量，当 $today=0时，为全部信息量。
	Plugins Author:ReTengCMS官方
	Plugins Url:http://www.reteng.org
	Plugins Version:V1.0
**/

function catstatistics($catid=0,$today=false)
{
	if(!$catid)
	{
		if(!$today)
		{
			return get_cache_counts("SELECT COUNT(*) AS count FROM `".DB_PRE."content` WHERE 1");
		}
		else
		{
			return get_cache_counts("SELECT COUNT(*) AS count FROM `".DB_PRE."content` WHERE `".DB_PRE."content`.`updatetime`>=".strtotime(date('Y-m-d 00:00:00',TIME)));
		}
	}
	else
	{
		if(!$today)
		{
			return get_cache_counts("SELECT COUNT(*) AS count FROM `".DB_PRE."content` WHERE `".DB_PRE."content`.`catid`=".intval($catid));
		}
		else
		{
			return get_cache_counts("SELECT COUNT(*) AS count FROM `".DB_PRE."content` WHERE `".DB_PRE."content`.`catid`=".intval($catid)." AND `".DB_PRE."content`.`updatetime`>=".strtotime(date('Y-m-d 00:00:00',TIME)));
		}
	}
}
?>
