<?php
	define('MEMBER_CENTER',true);
	include dirname(__FILE__).'/include/common.inc.php';

	$file=isset($file) && $file?$file:'index';
	$action=isset($action) && $action?$action:'';
	$mod=isset($mod)?preg_replace('/[^a-z]/i','',$mod):'dc';
	
	$langdir=$childsite['site_dir']?$childsite['site_dir']:'zh-cn';
	$langfile=RETENG_ROOT.'member/data/lang/'.$langdir.'/lang.inc.php';
	if(!file_exists($langfile))
	{
		$langfile=RETENG_ROOT.'member/data/lang/zh-cn/lang.inc.php';
	}

	if($mod=='dc')
	{
		(!preg_match('/^[0-9a-z_]+$/i',$file) || !file_exists(dirname(__FILE__).'/'.$file.'.inc.php')) && exit($lang['FILE_NOFIND']); 
	}
	else
	{
		(!preg_match('/^[0-9a-z_]+$/i',$file) || !file_exists(RETENG_ROOT.$mod.'/member/'.$file.'.inc.php')) && exit($lang['FILE_NOFIND']); 
		$modlangfile=RETENG_ROOT.$mod.'/member/data/lang/'.$langdir.'/lang.inc.php';
		if(!file_exists($modlangfile))
		{
			$modlangfile=RETENG_ROOT.$mod.'/member/data/lang/zh-cn/lang.inc.php';
		}
	}
	
	if(file_exists($langfile))
	{
		include $langfile;
	}

	if(file_exists($modlangfile))
	{
		include $modlangfile;
	}

	if(!$_userid && $file!='login')
	{
		showmsg($memlang['no-login'],'?file=login&action=login');
	}

	/*
		获取左侧栏目列表
	*/
	$leftcatmenu=array();
	$r=cache_read('cat_parent0.cache.php',RETENG_ROOT.'data/cache_category/');
	if($r)foreach($r as $_r)
	{
		if($member->catpostcheck($_r['id'],$_groupid,$_gradeid) && $_r['ispost'] && $_r['type']==1 && $_r['siteid']==SITEID)
		{
			$leftcatmenu[]=$_r;
		}
	}

	/*
		获取用户等级名称
	*/

	$r=cache_read('membergrade'.$_gradeid.'.cache.php',RETENG_ROOT.'data/cache_module/');
	$_gradename=$r && isset($r['name'])?$r['name']:$memlang['grade-10'];

	/*
		获取用户可用的模块
	*/
	$leftmodmenu=array();
	$r=cache_read('module.cache.php',RETENG_ROOT.'data/c/');

	
	if($r)foreach($r as $key => $_r)
	{
		if($member->modcheck($_r['id'],$_gradeid) && in_array($_modelid,explode(',',$_r['modelid'])) && !$_r['disabled'] && !$_r['adminonly'] && trim($_r['menu_member']))
		{
			$leftmodmenu[$key]=$_r;
		}
	}

	if($mod=='dc')
	{
		include dirname(__FILE__).'/'.$file.'.inc.php';
	}
	else
	{
		include RETENG_ROOT.$mod.'/member/'.$file.'.inc.php';
	}
?>
