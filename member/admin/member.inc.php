<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('member',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);

	require substr(dirname(__FILE__),0,-6).'/data/config.inc.php';
	$action=empty($action)?'manage':trim($action);
	require substr(dirname(__FILE__),0,-6).'/include/admin/member.class.php';
	$member=new member();
	switch($action)
	{
		/*
			会员操作
		*/
		case 'cache':
			$member->cache_member();
			showmsg($lang['RETURN_SUCEESS']);
			break;
		case 'manage':
			if(isset($do_submit)) 
			{
				if(!isset($id) || !$id)showmsg($lang['RETURN_NOSELECT']);
				switch($do)
				{
					case 'upgrade':
						if($member->member_upgrade($id,$gradeid,$expire))
						{
							showmsg($lang['RETURN_SUCEESS']);
						}
						else
						{
							showmsg($lang['RETURN_ERROR']);
						}
						break;
					case 'lock':
						if($member->member_lock($id,1))
						{
							showmsg($lang['RETURN_SUCEESS']);
						}
						else
						{
							showmsg($lang['RETURN_ERROR']);
						}
					case 'unlock':
						if($member->member_lock($id,0))
						{
							showmsg($lang['RETURN_SUCEESS']);
						}
						else
						{
							showmsg($lang['RETURN_ERROR']);
						}
						break;
					case 'delete':
						if($member->member_delete($id))
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
			$stype=isset($stype)?$stype:'username';
			$k=isset($k)?$k:'';
			$field=isset($field)?$field:'';
			$fieldid=isset($fieldid)?$fieldid:'';
			$level=isset($level)?intval($level):1;
			$orderby=isset($orderby)?$orderby:'id DESC';
			$result=$member->datalist($orderby,$level,$field,$fieldid,$stype,$k);
			$membergrade=cache_read('membergrade.cache.php',RETENG_ROOT.'data/cache_module/');
			include admin_tlp('member_manage','member');	
			break;
		case 'member_add':
			if(isset($do_submit)) 
			{
				include RETENG_ROOT.'include/data.input.class.php';
				$datainput = new data_input($info['modelid'],'member');
				$info=$datainput->filter($info);

				if($member->member_add($info))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$modelinfo=cache_read('model.cache.php',RETENG_ROOT.'data/cache_module/');
			include admin_tlp('member_add','member');
			break;
		case 'member_edit':
			if(isset($do_submit)) 
			{
				include RETENG_ROOT.'include/data.input.class.php';
				$datainput = new data_input($info['modelid'],'member');
				$info=$datainput->filter($info);

				if($member->member_edit($info,$id))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$modelinfo=cache_read('model.cache.php',RETENG_ROOT.'data/cache_module/');
			$info=$member->memberinfo($id,'*',true);
			$forms=$member->getform($info['modelid'],$info);
			include admin_tlp('member_edit','member');
			break;
		case 'setting':
			if(isset($do_submit)) 
			{
				if($member->setting($info))
				{
					file_put_contents(RETENG_ROOT.'member/template/audit_email.html',$audit_email);
					file_put_contents(RETENG_ROOT.'member/template/audit_sms.html',$audit_sms);
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			include admin_tlp('setting','member');
			break;
		/*
			会员头衔
		*/
		case 'honor':
			if(isset($do_submit)) 
			{
				if($member->honor_edit($name,$point,$ico))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$result=$member->honorlist();
			include admin_tlp('honor_manage','member');
			break;
		case 'honor_add':
			if(isset($do_submit)) 
			{
				if($member->honor_add($info))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			include admin_tlp('honor_add','member');
			break;
		case 'honor_delete':
			if($member->honor_delete($id))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'honor_disabled':
			if($member->honor_disabled($id,$disabled))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_SYSTEM']);
			}
			break;
		/*
			会员级别
		*/
		case 'grade':
			if(isset($do_submit)) 
			{
				if($member->grade_edit_name($grade,$name,$amount,$point,$info))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$result=$member->gradelist();
			include admin_tlp('grade_manage','member');
			break;
		case 'grade_add':
			if(isset($do_submit)) 
			{
				if($member->grade_add($info))
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
			
			$modulearray=cache_read('module.cache.php',RETENG_ROOT.'data/c/');
			include admin_tlp('grade_add','member');
			break;
		case 'grade_edit':
			if(isset($do_submit)) 
			{
				if($member->grade_edit($info,$id))
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
			
			$modulearray=cache_read('module.cache.php',RETENG_ROOT.'data/c/');
			$info=$member->gradeinfo($id);
			include admin_tlp('grade_edit','member');
			break;
		case 'grade_delete':
			if($member->grade_delete($id))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'grade_disabled':
			if($member->grade_disabled($id,$disabled))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_SYSTEM']);
			}
			break;
		/*
			会员组
		*/
		case 'group':
			if(isset($do_submit)) 
			{
				if($member->group_edit_name($name,$orderby))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$result=$member->grouplist();
			include admin_tlp('group_manage','member');
			break;
		case 'group_add':
			if(isset($do_submit)) 
			{
				if($member->group_add($info))
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

			include admin_tlp('group_add','member');
			break;
		case 'group_edit':
			if(isset($do_submit)) 
			{
				if($member->group_edit($info,$id))
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
			
			$info=$member->groupinfo($id);
			include admin_tlp('group_edit','member');
			break;
		case 'group_delete':
			if($member->group_delete($id))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'group_disabled':
			if($member->group_disabled($id,$disabled))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_SYSTEM']);
			}
			break;

		/*
			会员模型
		*/
		case 'model':
			$result=$member->modellist();
			include admin_tlp('model_manage','member');
			break;
		case 'model_install':
			if(isset($do_submit)) 
			{
				if($member->model_install($info))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			include admin_tlp('model_install','member');
			break;
		case 'model_delete':
			if($member->model_delete($id))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'model_disabled':
			if($member->model_disabled($id,$disabled))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_SYSTEM']);
			}
			break;
		case 'chkmodel':
			exit($member->chkmodeltable($data)?'yes':'no');
			break;
		case 'model_preview':
			$forms=$member->getform($id);
			include admin_tlp('model_preview','member');
			break;
		/*
			模型字段
		*/
		case 'fields_manage':
			if(isset($do_submit)) 
			{
				if($member->fields_manage_edit($id,$orderby,$name,$css,$unit))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$id=intval($id);
			$result=$member->fieldsdatalist($id);
			include admin_tlp('model_fields','member');
			break;
		case 'fields_add':
			if(isset($do_submit)) 
			{
				if($member->fields_add($info))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$selectmenu=cache_read('stepselect.cache.php',RETENG_ROOT.'data/c/');
			include admin_tlp('model_fields_add','member');
			break;
		case 'fields_delete':
			if($member->fields_delete($id))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'fields_edit':
			if(isset($do_submit)) 
			{
				if($member->fields_edit($id,$info))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$id=intval($id);
			$r=$member->fieldsinfo($id);
			$selectmenu=cache_read('stepselect.cache.php',RETENG_ROOT.'data/c/');

			include admin_tlp('model_fields_edit','member');
			break;
		case 'fields_disabled':
			if($member->fields_disabled($id,$disabled))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'chkfieldname':
			exit($member->chkfieldname($modelid,$data)?'yes':'no');
			break;
		/*
			站内信
		*/
		case 'message':
			if(isset($do_submit)) 
			{
				if($member->message_send($info))
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
			include admin_tlp('message','member');
			break;
	}
?>
