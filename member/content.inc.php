<?php
	!defined('MEMBER_CENTER') && exit('Access Denied!');	
	$action=isset($action)?$action:'manage';
	require RETENG_ROOT.'include/admin/category.class.php';
	$category=new category();
	include RETENG_ROOT.'/include/content.class.php';
	$conobj=new content();
	
	if(DETAILS_NEEDED)
	{
		$forbidden=true;
		$mempreinfo=$member->getmore($_userid);
		foreach($mempreinfo as $value)
		{
			if(!empty($value))
			{
				$forbidden=false;
				break;
			}
		}

		if($forbidden)
		{
			showmsg($memlang['details_needed'],SITE_URL.'member/index.php?file=user&action=edit');
		}
	}

	switch($action)
	{
		case 'manage':
			$k=isset($k)?$k:'';
			$result=$conobj->userdatalist($catid,$k);
			if($result)foreach($result as $rsk => $rsv)
			{
				$catinfo=$category->catinfo($rsv['catid']);
				$result[$rsk]['catname']=$catinfo['catname'];
			}
			include member_tlp('content_manage');
			break;
		case 'top':
			if($_point < TOPPOINT)
			{	
				showmsg($memlang['top-point-err']);
			}
			if($conobj->top($id))
			{
				$member->set($_userid,array('point'=>$_point-TOPPOINT));
				showmsg($memlang['top-ok']);
			}
			else
			{
				showmsg($memlang['top-err']);
			}
			break;
		case 'add':
			if(isset($do_submit))
			{
				/*
					权限检查
				*/

				if(!$member->catpostcheck($info['catid'],$_groupid,$_gradeid))showmsg_nourl($lang['RETURN_NOPRI']);


				$err=$conobj->add($info);
				if($err===true)
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['CONTENT_ERR'.$err]);
				}
			}
			$userinfo=$member->getmore($_userid);
			extract($userinfo,EXTR_PREFIX_ALL,'');
			$_lianxiren=$_realname?$_realname:$_lianxiren;
			$catid=intval($catid);
			$catinfo=$category->catinfo($catid);
			$forms=$conobj->getform($catinfo['modelid']);
			include member_tlp('content_add');
			break;
		case 'edit':
			if(isset($do_submit))
			{
				/*
					权限检查
				*/

				if(!$member->catpostcheck($info['catid'],$_groupid,$_gradeid))showmsg_nourl($lang['RETURN_NOPRI']);


				$err=$conobj->edit($info,$id);
				if($err===true)
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['CONTENT_ERR'.$err]);
				}
			}
			$catid=intval($catid);
			$coninfo=$conobj->get($id,true,0,$catid);
			$catinfo=$category->catinfo($catid);
			$forms=$conobj->getform($catinfo['modelid'],$coninfo);
			include member_tlp('content_edit');
			break;
		case 'delete':
			if(isset($id) && $conobj->delete($id,'member'))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_NOSELECT']);
			}
			break;
		default:
			show404($memlang['err-404']);
			break;
	}
?>
