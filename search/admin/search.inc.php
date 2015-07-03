<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('search',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);

	$action=empty($action)?'keywords':trim($action);
	require substr(dirname(__FILE__),0,-6).'/include/keywords.class.php';
	$keyobj=new keywords();
	switch($action)
	{
		case 'keywords':
			if(isset($do_submit)) 
			{
				if(!isset($id) || !$id)showmsg($lang['RETURN_NOSELECT']);
				switch($do)
				{
					case 'delete':
						if($keyobj->delete($id))
						{
							showmsg($lang['RETURN_SUCEESS']);
						}
						else
						{
							showmsg($lang['RETURN_ERROR']);
						}
						break;
					default:
						if($keyobj->update($keywords,$counts,$weight,$id))
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
			$result=$keyobj->keywordslist();
			include admin_tlp('keywords_manage','search');	
			break;
	}
?>
