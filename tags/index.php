<?php
	require substr(dirname(__FILE__),0,-4).'/include/common.inc.php';
	
	if($module->module_disabled('link'))
	{
		show404('该模块已被管理员禁用!');
	}
	@extract($catinfo ,EXTR_SKIP);
	@extract($catinfo['setting'] ,EXTR_SKIP);
	@extract($catinfo['expand'] ,EXTR_PREFIX_ALL,'');
	include_once RETENG_ROOT.'tags/include/tags.class.php';
	$tags= new tags();
	
	if($tag)
	{
		include template('list','tags');
	}
	else
	{
		include template('index','tags');
	}
?>
