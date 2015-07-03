<?php
/*
*版本所有：热腾CMS内容管理系统
*/
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(9,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
	$action=empty($action)?'manage':trim($action);
	require RETENG_ROOT.'include/admin/author.class.php';
	$author=new author();
	switch($action)
	{
		case 'manage':
			if(isset($do_submit)) 
			{
				if(!isset($id) || !$id)showmsg($lang['RETURN_NOSELECT'],ADMIN_FILE.'?file=author&action=manage');
				switch($do)
				{
					case 'delete':
						if($author->delete($id))
						{
							showmsg($lang['RETURN_SUCEESS'],ADMIN_FILE.'?file=author&action=manage');
						}
						else
						{
							showmsg($lang['RETURN_ERROR'],ADMIN_FILE.'?file=author&action=manage');
						}
						break;
					default:
						if($author->update($name,$orderby,$id))
						{
							showmsg($lang['RETURN_SUCEESS'],ADMIN_FILE.'?file=author&action=manage');
						}
						else
						{
							showmsg($lang['RETURN_ERROR'],ADMIN_FILE.'?file=author&action=manage');
						}
						break;
				}
				
			}
			$result=$author->datalist();
			include admin_tlp('author_manage');			
			break;
		case 'add':
			if(isset($do_submit)) 
			{
				if($author->add($info))
				{
					showmsg($lang['RETURN_SUCEESS'],ADMIN_FILE.'?file=author&action=add');
				}
				else
				{
					showmsg($lang['RETURN_ERROR'],ADMIN_FILE.'?file=author&action=add');
				}
			}
			include admin_tlp('author_add');
			break;
		case 'delete':
			if($author->delete($id))
			{
				showmsg($lang['RETURN_SUCEESS'],ADMIN_FILE.'?file=author&action=manage');
			}
			else
			{
				showmsg($lang['RETURN_ERROR'],ADMIN_FILE.'?file=author&action=manage');
			}
			break;
	}
?>