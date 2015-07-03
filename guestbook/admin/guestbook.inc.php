<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('guestbook',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);

	$action=empty($action)?'manage':trim($action);
	require substr(dirname(__FILE__),0,-6).'/include/guestbook.class.php';
	$guestbook=new guestbook();
	switch($action)
	{
		case 'manage':
			$k=isset($k)?trim($k):'';
			$passed=isset($passed)?intval($passed):1;
			$result=$guestbook->datalist($passed,$k);
			include admin_tlp('guestbook_manage','guestbook');			
			break;
		case 'pass':
			if($guestbook->pass($passed,$id))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'hidden':
			if($guestbook->hidden($hidden,$id))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'delete':
			if(!isset($id) || !$id)showmsg($lang['RETURN_NOSELECT']);
			if($guestbook->delete($id))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'reply':
			if(isset($do_submit)) 
			{
				if($guestbook->reply($info,$id))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			include admin_tlp('guestbook_reply','guestbook');			
			break;
	}
?>
