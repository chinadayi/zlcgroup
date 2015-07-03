<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('ads',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);

	$action=empty($action)?'adspos':trim($action);
	require substr(dirname(__FILE__),0,-6).'/include/ads.class.php';
	$ads=new ads();
	switch($action)
	{
		/*
			广告位操作
		*/
		case 'cache':
			$ads->ads_cache();
			showmsg($lang['RETURN_SUCEESS']);
			break;
		case 'adspos':
			if(isset($do_submit)) 
			{
				if($ads->adspos_editname($name))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$result=$ads->adsposlist();
			include admin_tlp('adspos_manage','adv');			
			break;
		case 'adspos_add':
			if(isset($do_submit)) 
			{
				if($ads->adspos_add($info))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$template=glob(RETENG_ROOT.'template/'.TLP_NAME.'/adv/*.htm');
			include admin_tlp('adspos_add','adv');			
			break;
		case 'adspos_edit':
			if(isset($do_submit)) 
			{
				if($ads->adspos_edit($info,$id))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$template=glob(RETENG_ROOT.'template/'.TLP_NAME.'/adv/*.htm');
			$info=$ads->adspos_info($id);
			include admin_tlp('adspos_edit','adv');			
			break;
		case 'adspos_lock':
			if($ads->adspos_lock($ispassed,$id))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'adspos_delete':
			if($ads->adspos_delete($id))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		/*
			广告操作
		*/

		case 'manage':
			if(isset($do_submit)) 
			{
				if($ads->ads_editname($name,$fromdate,$todate))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$result=$ads->adslist($adsposid);
			include admin_tlp('ads_manage','adv');			
			break;
		case 'ads_add':
			if(isset($do_submit)) 
			{
				if($ads->ads_add($info))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			include admin_tlp('ads_add','adv');			
			break;
		case 'ads_lock':
			if($ads->ads_lock($ispassed,$id))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'ads_delete':
			if($ads->ads_delete($id))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'ads_edit':
			if(isset($do_submit)) 
			{
				if($ads->ads_edit($info,$id))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$info=$ads->ads_info($id);
			include admin_tlp('ads_edit','adv');			
			break;
	}
?>
