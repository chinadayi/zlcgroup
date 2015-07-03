<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(5,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
	$action=empty($action)?'manage':trim($action);
	require RETENG_ROOT.'include/admin/stepselect.class.php';
	$stepselect=new stepselect();
	switch($action)
	{
		case 'manage':
			if(isset($do_submit)) 
			{
				if(!isset($id) || !$id)showmsg($lang['RETURN_ERROR'],ADMIN_FILE.'?file=stepselect&action=manage');
				switch($do)
				{
					case 'delete':
						if($stepselect->delete($id))
						{
							showmsg($lang['RETURN_SUCEESS'],ADMIN_FILE.'?file=stepselect&action=manage');
						}
						else
						{
							showmsg($lang['RETURN_ERROR'],ADMIN_FILE.'?file=stepselect&action=manage');
						}
						break;
					default:
						if($stepselect->update($name,$id))
						{
							showmsg($lang['RETURN_SUCEESS'],ADMIN_FILE.'?file=stepselect&action=manage');
						}
						else
						{
							showmsg($lang['RETURN_ERROR'],ADMIN_FILE.'?file=stepselect&action=manage');
						}
						break;
				}
				
			}
			$result=$stepselect->datalist();
			include admin_tlp('stepselect_manage');			
			break;
		case 'add':
			if(isset($do_submit)) 
			{
				if($stepselect->add($info))
				{
					showmsg($lang['RETURN_SUCEESS'],ADMIN_FILE.'?file=stepselect&action=add');
				}
				else
				{
					showmsg($lang['RETURN_ERROR'],ADMIN_FILE.'?file=stepselect&action=add');
				}
			}
			include admin_tlp('stepselect_add');			
			break;
		case 'delete':
			if($stepselect->delete($id))
			{
				showmsg($lang['RETURN_SUCEESS'],ADMIN_FILE.'?file=stepselect&action=manage');
			}
			else
			{
				showmsg($lang['RETURN_ERROR'],ADMIN_FILE.'?file=stepselect&action=manage');
			}
			break;
		case 'enum':
			if(isset($do_submit)) 
			{
				if(!isset($checkedid) || !$checkedid)showmsg($lang['RETURN_ERROR']);
				switch($do)
				{
					case 'delete':
						if($stepselect->delete_enum($checkedid))
						{
							showmsg($lang['RETURN_SUCEESS']);
						}
						else
						{
							showmsg($lang['RETURN_ERROR']);
						}
						break;
					default:
						if($stepselect->update_enum($name,$orderby,$checkedid))
						{
							showmsg($lang['RETURN_SUCEESS']);
						}
						else
						{
							showmsg($lang['RETURN_ERROR']);
						}
						break;
				}
				
			}
			$result=$stepselect->enumlist($id);
			include admin_tlp('stepselect_enum');
			break;
		case 'add_enum':
			if(isset($do_submit)) 
			{
				if($stepselect->add_enum($info))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			// 获取下拉菜单
			$enums_select=$stepselect->get_parent_enum($selectid,'info[parentid]');
			include admin_tlp('stepselect_enum_add');			
			break;
		case 'delete_enum':
			if($stepselect->delete_enum($id))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'cache':
			if($stepselect->cache($id))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'preview':
			$stepselect->preview($table);
			break;
	}
?>
