<?php
/*
*版本所有，热腾CMS内容管理系统
*/
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(10,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
	$template=empty($action)?'tag_content':'tag_'.trim($action);

	require RETENG_ROOT.'/include/options.class.php';
	$options=new options();

	$posid_select='<select id="posid"><option value="0">不限推荐位</option>';
	$r=cache_read('posid.cache.php',RETENG_ROOT.'data/c/');
	if($r)foreach($r as $__r)
	{
		$posid_select.='<option value="'.$__r['id'].'">'.$__r['name'].'</option>';
	}
	$posid_select.='</select>';
	include admin_tlp($template);
?>
