<?php
/*
*版本所有：热腾CMS内容管理系统
*/
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(9,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
	$action=empty($action)?'manage':trim($action);
	require RETENG_ROOT.'include/admin/copyfrom.class.php';
	$copyfrom=new copyfrom();
	switch($action)
	{
		case 'manage':
			if(isset($do_submit)) 
			{
				if(!isset($id) || !$id)showmsg($lang['RETURN_NOSELECT'],ADMIN_FILE.'?file=copyfrom&action=manage');
				switch($do)
				{
					case 'delete':
						if($copyfrom->delete($id))
						{
							showmsg($lang['RETURN_SUCEESS'],ADMIN_FILE.'?file=copyfrom&action=manage');
						}
						else
						{
							showmsg($lang['RETURN_ERROR'],ADMIN_FILE.'?file=copyfrom&action=manage');
						}
						break;
					default:
						if($copyfrom->update($name,$url,$orderby,$id))
						{
							showmsg($lang['RETURN_SUCEESS'],ADMIN_FILE.'?file=copyfrom&action=manage');
						}
						else
						{
							showmsg($lang['RETURN_ERROR'],ADMIN_FILE.'?file=copyfrom&action=manage');
						}
						break;
				}
				
			}
			$result=$copyfrom->datalist();
			include admin_tlp('copyfrom_manage');			
			break;
		case 'add':
			if(isset($do_submit)) 
			{
				if($copyfrom->add($info))
				{
					showmsg($lang['RETURN_SUCEESS'],ADMIN_FILE.'?file=copyfrom&action=add');
				}
				else
				{
					showmsg($lang['RETURN_ERROR'],ADMIN_FILE.'?file=copyfrom&action=add');
				}
			}
			include admin_tlp('copyfrom_add');
			break;
		case 'delete':
			if($copyfrom->delete($id))
			{
				showmsg($lang['RETURN_SUCEESS'],ADMIN_FILE.'?file=copyfrom&action=manage');
			}
			else
			{
				showmsg($lang['RETURN_ERROR'],ADMIN_FILE.'?file=copyfrom&action=manage');
			}
			break;
	}
?>