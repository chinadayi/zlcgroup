<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(9,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
	$action=empty($action)?'manage':trim($action);
	require RETENG_ROOT.'include/admin/category.class.php';
	$category=new category();
	require RETENG_ROOT.'include/content.class.php';
	$content=new content();
	switch($action)
	{
		case 'manage':
			/*
				权限检查
			*/
			$catid=isset($catid)?intval($catid):intval($info['catid']);
			if(!$check_admin->category_permission_check($_userid,$catid))showmsg_nourl($lang['RETURN_NOPRI']);

			if(isset($do_submit))
			{
				if($content->setordeyby($orderby))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$field=isset($field)?$field:'';
			$fieldvalue=isset($fieldvalue)?$fieldvalue:'';
			$stype=isset($stype)?$stype:'title';
			$k=isset($k)?$k:'';
			$result=$content->datalist($catid,$field,$fieldvalue,$stype,$k);

			if($result)foreach($result as $rsk => $rsv)
			{
				$catinfo=$category->catinfo($rsv['catid']);
				$result[$rsk]['catname']=$catinfo['catname'];
			}

			require RETENG_ROOT.'/include/options.class.php';
			$options=new options();
			include admin_tlp('content_manage');			
			break;
		case 'add':
			if(isset($do_submit))
			{
				/*
					权限检查
				*/

				if(!$check_admin->category_permission_check($_userid,$info['catid']))showmsg_nourl($lang['RETURN_NOPRI']);
				$err=$content->add($info);
				if($err===true)
				{
					showmsg($lang['RETURN_SUCEESS'].$r_ping,ADMIN_FILE.'?file=content&action=add&catid='.$info['catid']);
				}
				else
				{
					showmsg($lang['CONTENT_ERR'.$err]);
				}
			}
			$catinfo=$category->catinfo($catid);
			$forms=$content->getform($catinfo['modelid']);
			$template=glob(RETENG_ROOT.'template/'.TLP_NAME.'/*.htm');
			include admin_tlp('content_add');
			break;
		case 'edit':
			if(isset($do_submit))
			{
				/*
					权限检查
				*/
				if(!$check_admin->category_permission_check($_userid,$info['catid']))showmsg_nourl($lang['RETURN_NOPRI']);
				
				$msg=$content->edit($info,$id);
				if($msg===true)
				{
					showmsg($lang['RETURN_SUCEESS'].$r_ping,ADMIN_FILE.'?file=content&action=manage&catid='.$info['catid']);
				}
				else
				{
					showmsg($lang['CONTENT_ERR'.$err]);
				}
			}
			$coninfo=$content->get($id,true,0,$catid);
			$catinfo=$category->catinfo($catid);
			$forms=$content->getform($catinfo['modelid'],$coninfo);
			$template=glob(RETENG_ROOT.'template/'.TLP_NAME.'/*.htm');
			include admin_tlp('content_edit');
			break;
		case 'clear_order':
			if($content->clear_order())
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_NOSELECT']);
			}
			break;
		case 'html':
			if(isset($checkedid) && $content->html($checkedid))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_NOSELECT']);
			}
			break;
		case 'pass':
			if(isset($checkedid) && $content->pass($checkedid))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_NOSELECT']);
			}
			break;
		case 'unpass':
			if(isset($checkedid) && $content->unpass($checkedid))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_NOSELECT']);
			}
			break;
		case 'delete':
			if(isset($checkedid) && $content->delete($checkedid))
			{
				showmsg($lang['RETURN_SUCEESS'],$forwardurl);
			}
			else
			{
				showmsg($lang['RETURN_NOSELECT'],$forwardurl);
			}
			break;
		case 'move':
			if(isset($checkedid))
			{
				$err=$content->move($checkedid,$movetocatid);
				if($err===true)
				{
					showmsg($lang['RETURN_SUCEESS'],$forwardurl);
				}
				else
				{
					showmsg($lang['CONTENT_ERR'.$err],$forwardurl);
				}
			}
			else
			{
				showmsg($lang['RETURN_NOSELECT'],$forwardurl);
			}
			break;
		case 'support':
			if(isset($do_submit) && $do_submit==1)
			{
				include admin_tlp('content_support');
			}
			else if(isset($do_submit) && $do_submit==2)
			{
				$ids=array_map('intval',explode(',',$ids));
				if(isset($ids) && $content->support($ids,$posid))
				{
					showmsg($lang['RETURN_SUCEESS'],$forwardurl);
				}
				else
				{
					showmsg($lang['RETURN_NOSELECT'],$forwardurl);
				}
			}
			else
			{
				 exit('Access Denied!');
			}
			break;
		case 'preview':
			$content->preview($info);
			break;
		case 'url_tag':
			
			global $db;
			$url_tags = $db->fetch_all("SELECT id, keywords, url FROM ". DB_PRE.'content' . " WHERE modelid = 1 AND status = 1 ORDER BY updatetime DESC");
			
			header("Content-type:text/plain");
        	header("Content-Disposition: attachment; filename=url_tag.txt");
			
			foreach ($url_tags AS $k => $v){
				echo "http://".$_SERVER['SERVER_NAME']."/".$v['url'];
				
				$temp = str_replace(' ', ',', $v['keywords']);
				$temp = str_replace('，', ',', $temp);
				
				echo "{".$temp."}";
				echo "\r\n";
			}
			exit();
			
			break;
		case 'tags':
			
			global $db;
			$tags = $db->fetch_all("SELECT keywords FROM ". DB_PRE.'content' . " WHERE modelid = 1 AND status = 1 ORDER BY updatetime DESC");
			
			header("Content-type:text/plain");
        	header("Content-Disposition: attachment; filename=tags.txt");
			
        	$data = array();
			foreach ($tags AS $k => $v){
				$temp = str_replace(',', ' ', trim($v['keywords']));
				$temp = str_replace('，', ' ', trim($temp));
				
				$temp_data = explode(' ', $temp);
				
				$data = array_merge($data, $temp_data);
			}
			echo implode("\r\n", array_unique($data));
			exit();
			
			break;
	}
?>
