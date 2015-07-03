<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('form',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);

	$action=empty($action)?'manage':trim($action);
	require substr(dirname(__FILE__),0,-6).'/include/diyform.class.php';
	$formobj=new diyform();
	switch($action)
	{
		/*
			表单操作
		*/
		case 'manage':
			$result=$formobj->datalist();
			include admin_tlp('manage','form');	
			break;
		case 'chktable':
			exit($formobj->chktable($data)?'yes':'no');
			break;
		case 'add':
			if(isset($do_submit)) 
			{
				if($formobj->add($info))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			include admin_tlp('add','form');
			break;
		case 'delete':
			if($formobj->delete($id))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'preview':
			$forms=$formobj->getform($id);
			include admin_tlp('form_preview','form');
			break;
		case 'data':
			$formid=intval($formid);
			$result=$formobj->contentlist($formid);
			$forminfo=$formobj->forminfo($formid);
			$fieldslist=$db->fetch_all("SELECT * FROM ".DB_PRE."form_fields WHERE formid=$formid LIMIT 0,4");
			include admin_tlp('data','form');	
			break;
		case 'delete_data':
			if($formobj->delete_data($formid,$id))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		/*
			字段操作
		*/

		case 'fields':
			if(isset($do_submit)) 
			{
				if($formobj->fields_manage_edit($ids,$orderby,$name,$css,$unit))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$id=intval($id);
			$result=$formobj->fieldsdatalist($id);
			include admin_tlp('form_fields','form');
			break;
		case 'fields_add':
			if(isset($do_submit)) 
			{
				if($formobj->fields_add($info))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$selectmenu=cache_read('stepselect.cache.php',RETENG_ROOT.'data/c/');
			include admin_tlp('form_fields_add','form');
			break;
		case 'fields_edit':
			if(isset($do_submit)) 
			{
				if($formobj->fields_edit($id,$info))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$id=intval($id);
			$r=$formobj->fieldsinfo($id);
			$selectmenu=cache_read('stepselect.cache.php',RETENG_ROOT.'data/c/');

			include admin_tlp('form_fields_edit','form');
			break;
		case 'fields_disabled':
			if($formobj->fields_disabled($id,$disabled))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'fields_delete':
			if($formobj->fields_delete($id))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'chkfieldname':
			exit($formobj->chkfieldname($formid,$data)?'yes':'no');
			break;
	}
?>
