<?php
	!defined('MEMBER_CENTER') && exit('Access Denied!');
	$action=isset($action)?$action:'online';
	include substr(dirname(__FILE__),0,-7).'/include/global.func.php';
	include substr(dirname(__FILE__),0,-7).'/include/pay.class.php';
	$pay=new pay();
	switch($action)
	{
		case 'online':
			$paymethod=$pay->paymethod();
			if(isset($do_submit)) 
			{
				$payment=$pay->paymethodinfo($paymentid);
				include_once(RETENG_ROOT.'pay/api/' . $payment['code'] . '.php');
				$pay_obj= new $payment['code'];

				$order=array();
				$log=array();

				$_SESSION['order_sn']=$log['sn']=$order['order_sn']=create_sn();
				$order['order_amount']=$amount+pay_fee($amount,$payment['fee'].'%');

				/*
					更新财务日志
				*/
				$log['username']=$_username;
				$log['ip']=IP;
				$log['manage']=1;
				$log['type']='amount';
				$log['amount']=floatval($amount);
				$log['payment']=$payment['name'];
				$log['note']=htmlspecialchars($usernote);
				$log['time']=TIME;
				$log['status']=1;
				$pay->set_log($log);

				$payurl=$pay_obj->get_code($order,$payment['config']);
				include member_tlp('pay_status','pay');
			}
			else
			{
				include member_tlp('pay_online','pay');
			}
			break;
		case 'card':
			if(isset($do_submit)) 
			{
				if($_SESSION['checkcode']!=strtolower($inputcheckcode))
				{
					showmsg('验证码不正确!',$forward);
				}

				$msg=$pay->paybycard($cardid);
				if($msg===true)
				{
					showmsg($lang['RETURN_SUCEESS'],SITE_URL.'member/index.php?mod=pay&file=pay&action=log');
				}
				else if($msg==-1)
				{
					showmsg('充值卡不存在!',$forward);
				}
				else if($msg==-2)
				{
					showmsg('该充值卡已使用, 无法重复使用!',$forward);
				}
				else if($msg==-3)
				{
					showmsg('充值卡已过期!',$forward);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			include member_tlp('pay_card','pay');
			break;
		case 'log':
			$result=$pay->loglist($_username);
			include member_tlp('pay_log','pay');
			break;
		case 'order':
			$result=$pay->orderlist('','',0,$_userid);
			include member_tlp('order','pay');
			break;
		case 'confirmorder':
			if($pay->confirmorder($ordersn,$_userid))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
	}
?>
