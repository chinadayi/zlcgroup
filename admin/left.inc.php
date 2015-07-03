<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	header("Cache-Control: no-cache, must-revalidate");
	$menu=isset($menu)?$menu:'index';

	if($menu=='module' && isset($path) && !empty($path))
	{
		/*
			获取管理员菜单
		*/
		$modulename=cache_read('module'.$path.'.cache.php',RETENG_ROOT.'data/c/');
		$modulename=$modulename['name'];
		$modulemenu=$module->get_menu($path);
	}

	if($menu=='other')
	{
		$moduleinfo=cache_read('module.cache.php',RETENG_ROOT.'data/c/');
		if($moduleinfo)foreach($moduleinfo as $key => $_moduleinfo)
		{
			if(!$module->roleid_check($_moduleinfo['folder'],$_roleid) || $_moduleinfo['disabled'] || $_moduleinfo['adminmenu'])unset($moduleinfo[$key]);
		}
	}

	include admin_tlp('left_'.$menu);
?>
