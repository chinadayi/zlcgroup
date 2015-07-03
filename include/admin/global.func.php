<?php
/**
* 后台公用函数
*/

function admin_tlp($tlp,$module='')
{
	$tlpfile=empty($module)?RETENG_ROOT.'admin/template/'.$tlp.'.tlp.php':RETENG_ROOT.$module.'/admin/template/'.$tlp.'.tlp.php';
	!file_exists($tlpfile) && show404('模板文件'.$tlpfile.'不存在!');
	return $tlpfile;
}

function admin_cache($flag=false)
{
	global $db;
	$status = $db->get_one_table_status(DB_PRE.'admin_cache');
	if($status['Rows'] == 0 || $flag)
	{
		@set_time_limit(0);
		$db->query("REPLACE INTO `".DB_PRE."admin_cache` SELECT * FROM `".DB_PRE."admin`");
		return true;
	}
	return false;
}

// 获取主机IP
function get_hostip()
{
	return $_SERVER['SERVER_ADDR']?$_SERVER['SERVER_ADDR']:gethostbyname($_SERVER['SERVER_NAME']); 
}

function gethosturlname()
{
	$port=$_SERVER["SERVER_PORT"]=='80'?'':':'.$_SERVER["SERVER_PORT"];
	$ServerName = strtolower($_SERVER['SERVER_NAME']?$_SERVER['SERVER_NAME']:$_SERVER['HTTP_HOST']); 
	if(strpos($ServerName,'http://'))
	{   
		$ServerName=str_replace('http://','',$ServerName);
	}  
	return strpos($ServerName,':')?'http://'.$ServerName:'http://'.$ServerName.$port;
}

function set_config($config,$cache=true)
{
	global $RETENG,$db;
	if(!is_array($config)) return false;
	$configfile = RETENG_ROOT.'data/config.inc.php';
	if(!is_writable($configfile)) fatal_error('Please chmod ./data/config.inc.php to 0777 !');

	if($db && is_object($db) && $cache && is_file(RETENG_ROOT.'data/retengcms.lock'))
	{
		$r=$db->fetch_all("SELECT * FROM `".DB_PRE."config` WHERE `".DB_PRE."config`.`siteid`=".SITEID);
		if($r)
		{
			foreach($r as $_r)
			{
				unset($RETENG[$_r['varname']]);
			}
		}
	}

	$pattern = $replacement = array();
	foreach($config as $k=>$v)
	{
		$v=in_array($k,array('statistics_online'))?str_replace("\'",'',$v):strip_tags(str_replace("\'",'',$v));
		$pattern[$k] = "/define\(\s*['\"]".strtoupper($k)."['\"]\s*,\s*([']?)[^']*([']?)\s*\)/is";
        $replacement[$k] = "define('".strtoupper($k)."', \${1}".$v."\${2})";
	}
	$str = file_get_contents($configfile);
	$str = preg_replace($pattern, $replacement, $str);
	
	foreach($config as $_k => $_v)
	{
		$_config[strtolower($_k)]=$_v;
	}
	
	$_tconfig=n_array_diff($RETENG,$_config);
	
	foreach($_tconfig as $key=>$value)
	{
		$_config[$key]=$value;
	}
	
	cache_config('common.cache.php',array_map('stripcslashes',$_config));
	return file_put_contents($configfile, $str);
}
?>
