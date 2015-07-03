<?php
	require substr(dirname(__FILE__),0,-5).'/include/common.inc.php';
	if($module->module_disabled('form'))
	{
		show404('该模块已被管理员禁用!');
	}
	$langdir=$childsite['site_dir']?$childsite['site_dir']:'zh-cn';
	$langfile=RETENG_ROOT.'form/data/lang/'.$langdir.'/lang.inc.php';
	if(!file_exists($langfile))
	{
		$langfile=RETENG_ROOT.'form/data/lang/zh-cn/lang.inc.php';
	}

	include_once $langfile;

	session_start();
	$action=isset($action)?$action:'post';

	$id=intval($id);
	if($id<=0)
	{
		exit($formlang['err-bad-para']);
	}
	
	include dirname(__FILE__).'/include/diyform.class.php';
	$formobj=new diyform();
	$forminfo=$formobj->forminfo($id);

	if(!$forminfo)
	{
		show404($formlang['err-nodata']);
	}

	$formid=$id=$forminfo['id'];
	
	switch($action)
	{
		case 'show':
			$contentid=intval($contentid);
			if($contentid<=0)
			{
				exit($formlang['err-bad-para']);
			}

			$datainfo=$db->fetch_one("SELECT * FROM `".DB_PRE.$forminfo['table']."` WHERE `".DB_PRE.$forminfo['table']."`.`id`=".$contentid);
			if(!$datainfo)
			{
				show404($formlang['err-nodata']);
			}

			$forms=$formobj->getfields($id);
			
			include template('show','form');
			break;
		default:
			if(isset($dosubmit))
			{
				if($_SESSION['checkcode']!=strtolower($_POST['checkcode']))
				{
					showmsg($lang['CHECKCODE_ERR']);
				}

				if($db->insert(DB_PRE.$forminfo['table'],batfilterhtml($info)))
				{
					showmsg($formlang['post-success']);
				}
				else
				{
					showmsg($formlang['post-err']);
				}
			}
			$forms=$formobj->getform($id);
			include template('post','form');
			break;
	}
?>
