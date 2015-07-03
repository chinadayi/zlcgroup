<?php
/*
版权所有,ReTengCMS
*/
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(15,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
	$action=empty($action)?'manage':trim($action);

	switch($action)
	{
		case 'manage':
			if(isset($do_submit)) 
			{
				if(!isset($names) || !$names)showmsg($lang['RETURN_NOSELECT']);
				switch($do)
				{
					case 'active':
						foreach($names as $name)
						{
							$plugins->active_plugins($name,1);
						}
						showmsg($lang['RETURN_SUCEESS']);
						break;
					case 'unactive':
						foreach($names as $name)
						{
							$plugins->active_plugins($name,0);
						}
						showmsg($lang['RETURN_SUCEESS']);
						break;
				}
				
			}
			$result=$plugins->get_all_plugins($actived);
			include admin_tlp('plugins_manage');			
			break;
		case 'install':
			if($plugins->install_plugins($plugin))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'uninstall':
			if($plugins->uninstall_plugins($plugin))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
	}
?>