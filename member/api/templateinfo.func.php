<?php
function memberinfo($userid, $fields = '*' ,$more=false,$iscache=true)
{
	global $cache,$db;
	$data=array();
	
	$data=$cache->get($sql);
	if(!$iscache || !$data)
	{
		$userid = intval($userid);
		$baseinfo=$db->fetch_one("SELECT {$fields} FROM `".DB_PRE."member` WHERE `".DB_PRE."member`.`id`=".$userid);
		if(!$baseinfo) 
		{
			$baseinfo=$db->fetch_one("SELECT {$fields} FROM `".DB_PRE."member` WHERE `".DB_PRE."member`.`id`=".$userid);
		}
		
		if(!$more || !$baseinfo || !$baseinfo['modelid'])
		{	
			$data=$baseinfo;
		}
		else
		{
			$modelinfo=cache_read('model'.$baseinfo['modelid'].'.cache.php',RETENG_ROOT.'data/cache_module/');
			$moreinfo=$db->fetch_one("SELECT * FROM `".DB_NAME."`.`".DB_PRE.$modelinfo['table']."` WHERE `".DB_NAME."`.`".DB_PRE.$modelinfo['table']."`.`userid`=".intval($userid));
			$data= array_merge($baseinfo,$moreinfo);
		}
		if($data)
		{
			$cache->set($sql,$data);
		}
	}
	return $data;
}

// 2012-05-25 0:37
function memberstatistics($modelid=0,$today=false)
{
	if(!$modelid)
	{
		if(!$today)
		{
			return get_cache_counts("SELECT COUNT(*) AS count FROM `".DB_PRE."member` WHERE 1");
		}
		else
		{
			return get_cache_counts("SELECT COUNT(*) AS count FROM `".DB_PRE."member` WHERE `".DB_PRE."member`.`regtime`>=".strtotime(date('Y-m-d 00:00:00',TIME)));
		}
	}
	else
	{
		if(!$today)
		{
			return get_cache_counts("SELECT COUNT(*) AS count FROM `".DB_PRE."member` WHERE `".DB_PRE."member`.`modelid`=".intval($modelid));
		}
		else
		{
			return get_cache_counts("SELECT COUNT(*) AS count FROM `".DB_PRE."member` WHERE `".DB_PRE."member`.`modelid`=".intval($modelid)." AND `".DB_PRE."member`.`regtime`>=".strtotime(date('Y-m-d 00:00:00',TIME)));
		}
	}
}
?>
