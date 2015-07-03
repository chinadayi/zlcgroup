<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('post',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);

	require substr(dirname(__FILE__),0,-6).'/data/config.inc.php';
	$action=empty($action)?'config':trim($action);
	require substr(dirname(__FILE__),0,-6).'/include/post.class.php';
	$post=new post();
	switch($action)
	{
		case 'config':
			if(isset($do_submit)) 
			{
				if($post->setting($info))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			include admin_tlp('config','post');
			break;
	}
?>