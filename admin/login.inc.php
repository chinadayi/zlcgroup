<?php
/*
*版本所有，热腾CMS内容管理系统
*/
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	$action=empty($action)?'login':trim($action);
	include(RETENG_ROOT.'include/admin/admin.class.php');
	$admin=new admin();
	switch($action)
	{
		case 'login':
			if(isset($do_submit) && $do_submit)
			{
				if(CHECKCODE)
				{
					if($_SESSION['checkcode']!=strtolower($_POST['checkcode']))
					{
						showmsg($lang['CHECKCODE_ERR'],ADMIN_FILE.'?file=login');
					}
				}
				if($r=$admin->login($username,$password))
				{
					showmsg($lang['ADMIN_LOGIN_SUCCESS'],ADMIN_FILE);
				}
				else
				{
					showmsg($lang['ADMIN_LOGIN_ERR'.$admin->msg],ADMIN_FILE.'?file=login');
				}
			}
			if(isset($_SESSION['is_admin']) && $_SESSION['is_admin']===true)showmsg($lang['ADMIN_LOGIN_YET'],ADMIN_FILE);
			include admin_tlp('login');
			break;
		case 'logout':
			$admin->logout();
			showmsg($lang['ADMIN_LOGOUT_SUCCESS'],"/admin.php?file=login");
			break;
	}
?>