<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('link',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);

	$action=empty($action)?'type':trim($action);
	require substr(dirname(__FILE__),0,-6).'/include/flink.class.php';
	$flink=new flink();
	switch($action)
	{
		/*
			友链类型操作
		*/
		case 'cache':
			$flink->link_cache();
			showmsg($lang['RETURN_SUCEESS']);
			break;
		case 'type':
			if(isset($do_submit)) 
			{
				if($flink->type_editname($name,$orderby))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$result=$flink->typelist();
			include admin_tlp('type_manage','link');	
			break;
		case 'type_add':
			if(isset($do_submit)) 
			{
				if($flink->type_add($info))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			include admin_tlp('type_add','link');			
			break;
		case 'type_edit':
			if(isset($do_submit)) 
			{
				if($flink->type_edit($info,$id))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$info=$flink->type_info($id);
			include admin_tlp('type_edit','link');			
			break;
		case 'type_disabled':
			if($flink->type_disabled($disabled,$id))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'type_delete':
			if($flink->type_delete($id))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		/*
			友链操作
		*/
		case 'manage':
			if(isset($do_submit)) 
			{
				if($flink->editname($name,$url,$orderby))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$result=$flink->linklist($typeid);
			include admin_tlp('manage','link');	
			break;
		case 'add':
			if(isset($do_submit)) 
			{
				if($flink->add($info))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			require RETENG_ROOT.'/include/form.class.php';
			$form=new form();
			include admin_tlp('add','link');			
			break;
		case 'edit':
			if(isset($do_submit)) 
			{
				if($flink->edit($info,$id))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			require RETENG_ROOT.'/include/form.class.php';
			$form=new form();
			$info=$flink->info($id);
			include admin_tlp('edit','link');			
			break;
		case 'disabled':
			if($flink->disabled($disabled,$id))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'isindex':
			if($flink->isindex($isindex,$id))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'delete':
			if($flink->delete($id))
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
			$typeinfo=cache_read('linktype.cache.php',RETENG_ROOT.'data/cache_module/');
			include admin_tlp('tag','link');
			break;
	}
?>
