<?php
	!defined('MEMBER_CENTER') && exit('Access Denied!');
	$action=isset($action)?$action:'view';
	include substr(dirname(__FILE__),0,-7).'/include/space.class.php';
	$space=new space();
	switch($action)
	{
		case 'view':
			$info=$space->userspaceinfo($_userid);			
			if(!$info)
			{
				showmsg('您尚未开通个人空间, 不能进行此操作, 请先开通!',SITE_URL.'member/index.php?mod=space&file=space&action=info');
			}

			$space->view($info['id']);
			break;
		case 'info':
			if(isset($do_submit)) 
			{
				$err=$space->editinfo($info);
				if($err===true)
				{
					showmsg('空间资料设置成功!');
				}
				else
				{	
					showmsg('空间资料设置失败!');
				}
			}
			require RETENG_ROOT.'include/form.class.php';	
			$form=new form('info');
			$info=$space->userspaceinfo($_userid);
			include member_tlp('space_info','space');
			break;
		case 'template':
			$info=$space->userspaceinfo($_userid);			
			if(!$info)
			{
				showmsg('您尚未开通个人空间, 不能进行此操作, 请先开通!',SITE_URL.'member/index.php?mod=space&file=space&action=info');
			}

			$_template=isset($info['template'])?$info['template']:'default';
			$list=glob(TPL_ROOT.TPL_NAME.'/space/*');
			$files=glob(TPL_ROOT.TPL_NAME.'/space/*.*');
			$dirs=array_diff($list,$files);
			$r=array();
			foreach($dirs as $v)
			{
				$r[]=basename($v);
			}
			include member_tlp('space_template','space');	
			break;
		case 'settemplate':
			$info=$space->userspaceinfo($_userid);			
			if(!$info)
			{
				showmsg('您尚未开通个人空间, 不能进行此操作, 请先开通!',SITE_URL.'member/index.php?mod=space&file=space&action=info');
			}

			if($space->settemplate($template))
			{
				showmsg('空间模板设置成功!');
			}
			else
			{	
				showmsg('空间模板设置失败!');
			}
			break;
		case 'guestbook':
			$info=$space->userspaceinfo($_userid);			
			if(!$info)
			{
				showmsg('您尚未开通个人空间, 不能进行此操作, 请先开通!',SITE_URL.'member/index.php?mod=space&file=space&action=info');
			}

			$result=$space->guestbooklist(20);
			include member_tlp('space_guestbook','space');
			break;
		case 'guestbook_pass':
			$info=$space->userspaceinfo($_userid);			
			if(!$info)
			{
				showmsg('您尚未开通个人空间, 不能进行此操作, 请先开通!',SITE_URL.'member/index.php?mod=space&file=space&action=info');
			}

			if(!isset($id) || !$id)showmsg($lang['RETURN_NOSELECT']);
			if($space->guestbook_pass($id,1))
			{
				showmsg('操作成功!');
			}
			else
			{	
				showmsg('操作失败!');
			}
			break;
		case 'guestbook_unpass':
			$info=$space->userspaceinfo($_userid);			
			if(!$info)
			{
				showmsg('您尚未开通个人空间, 不能进行此操作, 请先开通!',SITE_URL.'member/index.php?mod=space&file=space&action=info');
			}

			if(!isset($id) || !$id)showmsg($lang['RETURN_NOSELECT']);
			if($space->guestbook_pass($id,0))
			{
				showmsg('操作成功!');
			}
			else
			{	
				showmsg('操作失败!');
			}
			break;
		case 'guestbook_delete':
			$info=$space->userspaceinfo($_userid);			
			if(!$info)
			{
				showmsg('您尚未开通个人空间, 不能进行此操作, 请先开通!',SITE_URL.'member/index.php?mod=space&file=space&action=info');
			}

			if(!isset($id) || !$id)showmsg($lang['RETURN_NOSELECT']);
			if($space->guestbook_delete($id))
			{
				showmsg('操作成功!');
			}
			else
			{	
				showmsg('操作失败!');
			}
			break;
	}
?>
