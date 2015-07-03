<?php
	define('RETENGCMS_FLAG',true);
	require dirname(__FILE__).'/include/common.inc.php';
	header("Cache-Control: no-cache, must-revalidate");
	require RETENG_ROOT.'/data/version.php';
	require RETENG_ROOT.'/include/admin/global.func.php';
	require RETENG_ROOT.'/include/admin/permission.class.php';
	$check_admin=new permission();

	require RETENG_ROOT.'/include/c.class.php';
	$c=new c(); // 常规缓存对象

	$file=isset($file) && $file?$file:'index';
	$action=isset($action) && $action?$action:'';
	$mod=isset($mod) && $mod?$mod.'/':'';
	
	$_userid=$_roleid=0; // 初始化
	(!preg_match('/^[0-9a-z_]+$/i',$file) || !preg_match('/^[0-9a-z_\/]*$/i',$mod) || !file_exists(RETENG_ROOT.$mod.'admin/'.$file.'.inc.php')) && exit($lang['FILE_NOFIND']); 
	session_start();
	if(isset($_SESSION['is_admin']) && $_SESSION['is_admin'] && $action!='logout')
	{
		$_userid=intval($_SESSION['admin_id']);
		if(!$r=$check_admin->admin_check($_userid))exit('Access Denied!');
		extract($r,EXTR_PREFIX_ALL,'');
		$file=($file=='login' && $action!='logout')?'index':$file;
	}
	else if($file!='login')
	{
		exit('<script language="javascript">{self.top.location.href="'.ADMIN_FILE.'?file=login";}</script>');
	}

	if($file!='left' && !LOG_DISABLED)
	{
		require RETENG_ROOT.'/include/admin/adminlog.class.php';
		$adminlog=new adminlog();
		$adminlog->add();
	}
	include RETENG_ROOT.$mod.'admin/'.$file.'.inc.php';
?>
