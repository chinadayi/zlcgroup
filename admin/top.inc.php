<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	$domain=parse_url($RETENG['site_url']);
	$domain=getRootDomain($domain['host'])?getRootDomain($domain['host']):$domain['host'];
	include(RETENG_ROOT.'include/admin/admin.class.php');
	$admin=new admin();
	$moduleinfo=cache_read('module.cache.php',RETENG_ROOT.'data/c/');
	if($moduleinfo)foreach($moduleinfo as $key => $_moduleinfo)
	{
		if(!$module->roleid_check($_moduleinfo['folder'],$_roleid) || $_moduleinfo['disabled'] || !$_moduleinfo['adminmenu'])unset($moduleinfo[$key]);
	}
	include admin_tlp('top');
?>