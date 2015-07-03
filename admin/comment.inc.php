<?php
/*
*版本所有：热腾CMS内容管理系统
*/
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(9,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
	$action=empty($action)?'manage':trim($action);
	require RETENG_ROOT.'include/comment.class.php';
	$commentobj=new comment();
	switch($action)
	{
		case 'manage':
			$contentid=isset($contentid)?$contentid:0;
			$userid=isset($userid)?$userid:0;
			$ip=isset($ip)?$ip:0;
			$status=isset($status)?$status:0;
			$k=isset($k)?$k:0;

			$result=$commentobj->datalist($contentid,$userid,$ip,$status,$k);
			include admin_tlp('comment_manage');			
			break;
		case 'delete':
			if(!isset($id) || !$id)showmsg($lang['RETURN_NOSELECT']);
			if($commentobj->delete($id))
			{
				showmsg($lang['RETURN_SUCEESS'],$cururl);
			}
			else
			{
				showmsg($lang['RETURN_ERROR'],$cururl);
			}
			break;
		case 'pass':
			if(!isset($id) || !$id)showmsg($lang['RETURN_NOSELECT']);
			if($commentobj->pass($id))
			{
				showmsg($lang['RETURN_SUCEESS'],$cururl);
			}
			else
			{
				showmsg($lang['RETURN_ERROR'],$cururl);
			}
			break;
		case 'unpass':
			if(!isset($id) || !$id)showmsg($lang['RETURN_NOSELECT']);
			if($commentobj->unpass($id))
			{
				showmsg($lang['RETURN_SUCEESS'],$cururl);
			}
			else
			{
				showmsg($lang['RETURN_ERROR'],$cururl);
			}
			break;
	}
?>