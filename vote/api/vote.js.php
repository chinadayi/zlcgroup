<?php
	include str_replace("\\", '/',substr(dirname(__FILE__),0,-9)).'/include/common.inc.php';
	if($module->module_disabled('vote'))
	{
		exit('document.write("该模块已被管理员禁用!")');
	}
	include substr(dirname(__FILE__),0,-4).'/include/template.func.php';

	$id=intval($id);
	if(!$id)
	{
		exit('document.write("无此投票或者投票已过期!")');
	}
	$data=vote_options($id);
	if(!$data)
	{
		exit('document.write("无此投票或者投票已过期!")');
	}
	extract($data);
	foreach($options as $option)
	{
		echo 'document.write(\'<li><label>'.$option['form'].''.$option['name'].'</label></li>\');';
	}
	exit();
?>
