<?php
	!defined('MEMBER_CENTER') && exit('Access Denied!');	
	$action=isset($action)?$action:'inbox';
	include dirname(__FILE__).'/include/msg.class.php';
	$msg=new msg();
	switch($action)
	{
		case 'inbox':
			$result=$msg->msglist('inbox');
			include member_tlp('msg_inbox');
			break;
		case 'outbox':
			$result=$msg->msglist('outbox');
			include member_tlp('msg_outbox');
			break;
		case 'delete':
			if(!isset($id) || !$id)showmsg($lang['RETURN_NOSELECT']);
			if($msg->delete($id))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'send':
			if(isset($do_submit)) 
			{
				$err=$msg->send($msgs);
				if($err===true)
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else if($err==-1)
				{
					showmsg($memlang['send-err1']);
				}
				else if($err==-2)
				{
					showmsg($memlang['send-err2']);
				}
				else
				{	
					showmsg($lang['RETURN_ERROR']);
				}
			}
			require RETENG_ROOT.'include/form.class.php';	
			$form=new form('msgs');
			include member_tlp('msg_send');
			break;
		case 'read':
			require RETENG_ROOT.'include/form.class.php';	
			$form=new form('msgs');
			$info=$msg->msginfo($id);
			$msg->readed($id);
			include member_tlp('msg_read');
			break;
		default:
			show404($memlang['err-404']);
			break;
	}
?>
