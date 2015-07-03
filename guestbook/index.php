<?php
	require substr(dirname(__FILE__),0,-10).'/include/common.inc.php';
	if($module->module_disabled('guestbook'))
	{
		show404('该模块已被管理员禁用!');
	}

	require dirname(__FILE__).'/include/guestbook.class.php';
	$action=isset($action)?$action:'index';
	$guestbook=new guestbook();
	require RETENG_ROOT.'/include/form.class.php';
	$form=new form();
	$fckeditor=$form->fckeditor('content','','Basic');
	if($action=='post')
	{
		if(isset($do_submit))
		{
			session_start();
			if($chkcode!=$_SESSION['checkcode'])showmsg($lang['CHECKCODE_ERR']);
			if($guestbook->add($info))
			{
				showmsg('留言发布成功, 可能需要管理员审核后才能显示!');
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
		}
		include template('post','guestbook');
	}
	else
	{	
		$data=$guestbook->datalist(1);
		$reteng_page=$guestbook->pagestring;
		include template('index','guestbook');
	}
?>
