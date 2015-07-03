<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('workbox',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);

	$action=empty($action)?'tools':trim($action);
	require substr(dirname(__FILE__),0,-6).'/include/workbox.class.php';
	$workbox=new workbox();
	switch($action)
	{
		/*
			工具类型操作
		*/
		case 'workbox':
			if(isset($do_submit)) 
			{
				if($workbox->edit_workbox($name))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$result=$workbox->workboxlist();
			include admin_tlp('workbox','workbox');	
			break;
		/*
			工具选项操作
		*/
		case 'tools':
			if(isset($do_submit)) 
			{
				if($workbox->tools_editname($name,$url,$id))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$result=$workbox->toolslist($boxid);
			include admin_tlp('tools','workbox');	
			break;
		case 'tools_add':
			if(isset($do_submit)) 
			{
				if($workbox->tools_add($info))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			require RETENG_ROOT.'include/form.class.php';	
			$form=new form('info');
			include admin_tlp('tools_add','workbox');	
			break;
		case 'tools_edit':
			if(isset($do_submit)) 
			{
				if($workbox->tools_edit($info,$id))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			require RETENG_ROOT.'include/form.class.php';	
			$form=new form('info');

			$toolsinfo=$workbox->toolsinfo($id);
			include admin_tlp('tools_edit','workbox');	
			break;
		case 'tools_delete':
			if($workbox->tools_delete($id))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'inlink':
			if($workbox->inlink($id,$inlink))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		/*
			模板调用
		*/
		case 'tag':
			$boxinfo=$workbox->workboxlist();
			include admin_tlp('tag','workbox');	
			break;
	}
?>
