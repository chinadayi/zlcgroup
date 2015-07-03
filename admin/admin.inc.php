<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	$action=empty($action)?'manage':trim($action);
	require RETENG_ROOT.'include/admin/admin.class.php';
	$admobj=new admin();
	switch($action)
	{
		/*
			管理角色
		*/
		case 'role':
			if(!$check_admin->roleid_check(3,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);

			if(isset($do_submit)) 
			{
				if($admobj->role_edit($orderby,$name))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$result=$admobj->rolelist();
			include admin_tlp('admin_role');			
			break;
		case 'role_add':
			if(!$check_admin->roleid_check(3,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);

			if(isset($do_submit)) 
			{
				if($admobj->role_add($newrole))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			include admin_tlp('role_add');			
			break;
		case 'role_lock':
			if(!$check_admin->roleid_check(3,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);

			if($admobj->role_lock($disabled,$id))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'role_delete':
			if(!$check_admin->roleid_check(3,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);

			if($admobj->role_delete($id))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'auth':
			if($_roleid!=1)showmsg_nourl($lang['RETURN_NOPRI']);

			if(isset($do_submit)) 
			{
				if($admobj->set_role_auth($roleid))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			include admin_tlp('role_auth');	
			break;

		/*
			管理员
		*/
		case 'manage':
			if(!$check_admin->roleid_check(3,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);

			$roleid=isset($roleid)?abs(intval($roleid)):0;
			$result=$admobj->adminlist($roleid);
			include admin_tlp('admin_manage');			
			break;
		case 'checkusername':
			exit($admobj->name_exists($data));
			break;
		case 'add':
			if(!$check_admin->roleid_check(3,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);

			if(isset($do_submit)) 
			{
				if($admobj->add($newadmin))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			require RETENG_ROOT.'/include/options.class.php';
			$options=new options();
			include admin_tlp('admin_add');
			break;
		case 'edit':
			if(isset($do_submit)) 
			{
				if($admobj->edit($admin,$id))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$id=isset($id)?$id:$_userid;
			$info=$admobj->get_byid($id);
			$roleinfo=$admobj->rolelist();
			$roleauth=$admobj->get_catauth($id);
			require RETENG_ROOT.'/include/options.class.php';
			$options=new options();
			include admin_tlp('admin_edit');
			break;
		case 'delete':
			if(!$check_admin->roleid_check(3,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);

			if($id==$_userid)
			{
				showmsg($lang['ADMIN_LOGINNING']);
			}

			if($admobj->delete($id))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'lock':
			if(!$check_admin->roleid_check(3,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);

			if($id==$_userid)
			{
				showmsg($lang['ADMIN_LOGINNING']);
			}

			if($id==ADMIN_FOUNDERS)
			{
				showmsg($lang['ADMIN_ADMIN_FOUNDERS']);
			}

			if($admobj->lock($id,$disabled))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'allowmultilogin':
			if(!$check_admin->roleid_check(3,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);

			if($admobj->allowmultilogin($id,$allowmultilogin))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;

		/*
			管理日志
		*/
		case 'log':
			if(isset($do_submit)) 
			{
				if($admobj->log_clear())
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$result=$admobj->loglist();
			include admin_tlp('admin_log');
			break;	
	}
?>
