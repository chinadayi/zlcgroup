<?php
	require substr(dirname(__FILE__),0,-5).'/include/common.inc.php';
	if($module->module_disabled('link'))
	{
		show404('该模块已被管理员禁用!');
	}
	$langdir=$childsite['site_dir']?$childsite['site_dir']:'zh-cn';
	$langfile=RETENG_ROOT.'link/data/lang/'.$langdir.'/lang.inc.php';
	if(!file_exists($langfile))
	{
		$langfile=RETENG_ROOT.'link/data/lang/zh-cn/lang.inc.php';
	}

	include_once $langfile;

	session_start();
	$action=isset($action)?$action:'index';
	switch($action)
	{
		case 'apply':
			if(isset($dosubmit) && $dosubmit)
			{
				if($_SESSION['checkcode']!=strtolower($_POST['checkcode']))
				{
					showmsg($lang['CHECKCODE_ERR']);
				}
				include dirname(__FILE__).'/include/flink.class.php';
				$flink=new flink();
				if($flink->add($info))
				{
					showmsg($linklang['post-success']);
				}
				else
				{
					showmsg($linklang['post-err']);
				}
			}
			include template('apply','link');
			break;
		default:
			include template('index','link');
			break;
	}
?>
