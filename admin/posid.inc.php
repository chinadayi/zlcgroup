<?php
/*
*版本所有，热腾CMS内容管理系统
*/
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(9,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
	$action=empty($action)?'manage':trim($action);
	require RETENG_ROOT.'include/admin/posid.class.php';
	$posid=new posid();
	switch($action)
	{
		case 'manage':
			if(isset($do_submit)) 
			{
				if(!isset($id) || !$id)showmsg($lang['RETURN_NOSELECT'],ADMIN_FILE.'?file=posid&action=manage');
				switch($do)
				{
					case 'delete':
						if($posid->delete($id))
						{
							showmsg($lang['RETURN_SUCEESS'],ADMIN_FILE.'?file=posid&action=manage');
						}
						else
						{
							showmsg($lang['RETURN_ERROR'],ADMIN_FILE.'?file=posid&action=manage');
						}
						break;
					default:
						if($posid->update($name,$orderby,$id))
						{
							showmsg($lang['RETURN_SUCEESS'],ADMIN_FILE.'?file=posid&action=manage');
						}
						else
						{
							showmsg($lang['RETURN_ERROR'],ADMIN_FILE.'?file=posid&action=manage');
						}
						break;
				}
				
			}
			$result=$posid->datalist();
			include admin_tlp('posid_manage');			
			break;
		case 'add':
			if(isset($do_submit)) 
			{
				if($posid->add($info))
				{
					showmsg($lang['RETURN_SUCEESS'],ADMIN_FILE.'?file=posid&action=add');
				}
				else
				{
					showmsg($lang['RETURN_ERROR'],ADMIN_FILE.'?file=posid&action=add');
				}
			}
			include admin_tlp('posid_add');
			break;
		case 'delete':
			if($posid->delete($id))
			{
				showmsg($lang['RETURN_SUCEESS'],ADMIN_FILE.'?file=posid&action=manage');
			}
			else
			{
				showmsg($lang['RETURN_ERROR'],ADMIN_FILE.'?file=posid&action=manage');
			}
			break;
	}
?>