<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('space',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);

	$action=empty($action)?'manage':trim($action);
	require substr(dirname(__FILE__),0,-6).'/include/space.class.php';
	$space=new space();
	switch($action)
	{
		case 'manage':
			$k=isset($k)?trim($k):'';
			$result=$space->datalist($k,15);
			include admin_tlp('space_manage','space');	
			break;
		case 'unlock':
			if(!isset($id) || !$id)showmsg('请选择需要开通的空间!');
			if($space->lock($id,0))
			{
				showmsg('空间成功开通!');
			}
			else
			{
				showmsg('空间开通失败!');
			}
			break;
		case 'lock':
			if(!isset($id) || !$id)showmsg('请选择需要关闭的空间!');
			if($space->lock($id,isset($lock)?intval($lock):1))
			{
				showmsg('空间成功关闭!');
			}
			else
			{
				showmsg('空间关闭失败!');
			}
			break;
		case 'tag':
			include admin_tlp('space_tag','space');
			break;
		case 'tagspace':
			include admin_tlp('space_tagspace','space');
			break;
	}
?>
