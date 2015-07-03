<?php
/*
*版本所有：热腾CMS内容管理系统
*/
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(9,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
	$action=empty($action)?'manage':trim($action);
	switch($action)
	{
		case 'manage':
			$result=$module->datalist();
			include admin_tlp('module_manage');			
			break;
		case 'guide':
			require RETENG_ROOT.'include/admin/admin.class.php';
			$admobj=new admin();
			if(isset($do_submit)) 
			{
				//if(file_exists(RETENG_ROOT.$info['folder']))showmsg($lang['MODULE_FOLDER_EXISTS']);
				if($module->install($info))
				{
					showmsg($lang['RETURN_SUCEESS'].'<script language="javascript">self.top.document.frames("topFrame").location.reload();</script>');
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			
			$roleidarray=$admobj->rolelist();
			$modelidarray=cache_read('model.cache.php',RETENG_ROOT.'data/cache_module/');
			include admin_tlp('module_guide');	
			break;
		case 'set':
			require RETENG_ROOT.'include/admin/admin.class.php';
			$admobj=new admin();
			if(isset($do_submit)) 
			{
				if($module->set($info,$id))
				{
					showmsg($lang['RETURN_SUCEESS'].'<script language="javascript">self.top.document.frames("topFrame").location.reload();</script>');
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$info=$module->get($id,'*','id');
			$roleidarray=$admobj->rolelist();

			$modelidarray=cache_read('model.cache.php',RETENG_ROOT.'data/cache_module/');
			include admin_tlp('module_set');	
			break;
		case 'setorderby':
			if($module->setorderby($orderby))
			{
				showmsg($lang['RETURN_SUCEESS'].'<script language="javascript">self.top.document.frames("topFrame").location.reload();</script>');
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'undisabled':
			if(!isset($id) || !$id)showmsg($lang['RETURN_NOSELECT']);
			if($module->disabled($id,0))
			{
				showmsg($lang['RETURN_SUCEESS'].'<script language="javascript">self.top.document.frames("topFrame").location.reload();</script>');
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'disabled':
			if(!isset($id) || !$id)showmsg($lang['RETURN_NOSELECT']);
			if($module->disabled($id,1))
			{
				showmsg($lang['RETURN_SUCEESS'].'<script language="javascript">self.top.document.frames("topFrame").location.reload();</script>');
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'adminmenu':
			if(!isset($id) || !$id)showmsg($lang['RETURN_NOSELECT']);
			if($module->adminmenu($id,$adminmenu))
			{
				showmsg($lang['RETURN_SUCEESS'].'<script language="javascript">self.top.document.frames("topFrame").location.reload();</script>');
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'delete':
			if(!isset($id) || !$id)showmsg($lang['RETURN_NOSELECT']);
			if($module->delete($id))
			{
				showmsg($lang['RETURN_SUCEESS'].'<script language="javascript">self.top.document.frames("topFrame").location.reload();</script>');
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'import':
			if(isset($do_submit)) 
			{
				if($module->import())
				{
					showmsg($lang['RETURN_SUCEESS'].'<script language="javascript">self.top.document.frames("topFrame").location.reload();</script>');
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			include admin_tlp('module_import');			
			break;
		case 'export':
			if(!isset($id) || !$id)showmsg($lang['RETURN_NOSELECT']);
			$module->export($id);
			break;
	}
?>