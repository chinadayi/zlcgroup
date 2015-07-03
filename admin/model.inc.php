<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(16,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
	$action=empty($action)?'manage':trim($action);
	require RETENG_ROOT.'include/admin/model.class.php';
	$model=new model();
	switch($action)
	{
		/*
			模型操作
		*/
		
		case 'manage':
			$result=$model->datalist();
			include admin_tlp('model_manage');
			break;
		case 'disabled':
			if($model->disabled($id,$disabled))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'delete':
			if($model->delete($id))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'export':
			if($model->export($id))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'import':
			if(isset($do_submit)) 
			{
				$err=$model->import($content);
				if($err===true)
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['MODEL_ERR'.$err]);
				}
			}
			include admin_tlp('model_import');
			break;
		case 'install':
			if(isset($do_submit)) 
			{
				if($model->install($info))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			include admin_tlp('model_install');
			break;
		case 'chkmodel':
			exit($model->chkmodeltable($data)?'yes':'no');
			break;
		case 'preview':
			$forms=$model->getform($id);
			include admin_tlp('model_preview');
			break;
		case 'searchform':
			if(isset($do_submit) && $do_submit==1) 
			{
				$fields=isset($fields)?$fields:array();
				$htmlcode=$model->searchform($modelid,$fields);
			}
			else if(isset($do_submit) && $do_submit==2) 
			{
				exit(stripslashes($html));
			}
			else
			{
				$modelinfo=$model->modelinfo($id);
				$r=cache_read('model'.$id.'_fields.cache.php',RETENG_ROOT.'data/c/');			
			}
			include admin_tlp('model_searchform');
			break;

		/*
			字段操作
		*/

		case 'fields':
			if(isset($do_submit)) 
			{
				if($model->fields_manage_edit($ids,$orderby,$name,$css,$unit))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$id=intval($id);
			$result=$model->fieldsdatalist($id);
			include admin_tlp('model_fields');
			break;
		case 'fields_delete':
			if($model->fields_delete($id))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'fields_disabled':
			if($model->fields_disabled($id,$disabled))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'fields_add':
			if(isset($do_submit)) 
			{
				if($model->fields_add($info))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$selectmenu=cache_read('stepselect.cache.php',RETENG_ROOT.'data/c/');
			include admin_tlp('model_fields_add');
			break;
		case 'chkfieldname':
			exit($model->chkfieldname($modelid,$data)?'yes':'no');
			break;
		case 'fields_edit':
			if(isset($do_submit)) 
			{
				if($model->fields_edit($id,$info))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$id=intval($id);
			$r=$model->fieldsinfo($id);
			$selectmenu=cache_read('stepselect.cache.php',RETENG_ROOT.'data/c/');

			include admin_tlp('model_fields_edit');
			break;
	}
?>
