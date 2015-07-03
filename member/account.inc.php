<?php
	!defined('MEMBER_CENTER') && exit('Access Denied!');	
	$action=isset($action)?$action:'buypoint';
	include dirname(__FILE__).'/include/account.class.php';
	$account=new account();
	switch($action)
	{
		case 'buypoint':
			if(isset($do_submit)) 
			{
				if(strtolower($inputcheckcode)!=$_SESSION['checkcode'])
				{
					showmsg($memlang['err-checkcode']);
				}
				if($account->buypoint($point))
				{
					showmsg($memlang['point-buy-ok']);
				}
				else
				{
					showmsg($memlang['point-buy-err1']);
				}
			}
			include member_tlp('account_buypoint');
			break;
		default:
			show404($memlang['err-404']);
			break;
	}
?>
