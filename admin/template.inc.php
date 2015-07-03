<?php
/*
*版本所有，热腾CMS内容管理系统
*/
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(10,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
	$action=empty($action)?'manage':trim($action);
	require RETENG_ROOT.'include/admin/template.class.php';
	$tempobj=new template();
	switch($action)
	{
		case 'project':
			if(isset($do_submit)) 
			{
				if($tempobj->rename_project($name))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$result=$tempobj->projectlist();
			include admin_tlp('template_project');			
			break;
		case 'delete_project':
			if($tempobj->delete_project($project))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'preview':
			$tempobj->perview($project);
			break;
		case 'manage':
			if(isset($do_submit)) 
			{
				if($tempobj->rename_template($name,$project,$class))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$project=isset($project)?$project:TPL_NAME;
			$class=isset($class)?trim($class):'';
			$page=isset($page)?intval($page):1;
			$k=isset($k)?htmlspecialchars($k):'';
			$result=$tempobj->templatelist($project,$class,$page,$k,30);

			/*
				获取class文件夹
			*/
			$alls=glob(TPL_ROOT.$project.'/*');
			$files=glob(TPL_ROOT.$project.'/*.*');
			$classarray=array_diff($alls,$files);
			include admin_tlp('template_manage');
			break;
		case 'delete':
			$project=isset($project)?$project:TPL_NAME;
			$class=isset($class)?trim($class):'';
			if($tempobj->delete_template($template,$project,$class))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'add':
			if(isset($do_submit)) 
			{
				if($tempobj->add_template($info))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$project=isset($project)?$project:TPL_NAME;
			$class=isset($class)?trim($class):'';
			include admin_tlp('template_add');
			break;
		case 'edit':
			if(isset($do_submit)) 
			{
				if($tempobj->edit_template($info,$template))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$project=isset($project)?$project:TPL_NAME;
			$class=isset($class)?trim($class):'';

			$templateinfo=$tempobj->templateinfo($template,$project,$class);
			include admin_tlp('template_edit');
			break;
		case 'check':
			$project=$project?$project:TPL_NAME;
			exit($tempobj->check_template($data,$project)==true?'yes':'no');
			break;
	}
?>
