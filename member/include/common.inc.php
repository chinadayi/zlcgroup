<?php
	include substr(dirname(__FILE__),0,-15).'/include/common.inc.php';
	if($module->module_disabled('member'))
	{
		show404('该模块已被管理员禁用!');
	}
	
	session_start();

	include dirname(__FILE__).'/global.func.php';
	include substr(dirname(__FILE__),0,-8).'/data/config.inc.php';

	include dirname(__FILE__).'/member.class.php';
	$member=new member();

	require RETENG_ROOT.'/include/options.class.php';
	$options=new options();

	require RETENG_ROOT.'/include/c.class.php';
	$c=new c();
?>
