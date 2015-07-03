<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('pay',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);

	$action=empty($action)?'paymethod':trim($action);
	require_once substr(dirname(__FILE__),0,-6).'/include/global.func.php';
	require substr(dirname(__FILE__),0,-6).'/include/pay.class.php';
	$pay=new pay();
	switch($action)
	{
		/*
			支付方式操作
		*/
		case 'paymethod':
			$result=$pay->paymethod();
			include admin_tlp('paymethod','pay');			
			break;
		case 'paymethod_edit':
			if(isset($do_submit))
			{
				$config=isset($config)?$config:array();
				$config=var_export($config,true);
				$info['config']=addslashes($config);

				if($pay->paymethod_edit($info,$id))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$info=$pay->paymethodinfo($id);
			include admin_tlp('paymethod_edit','pay');
			break;
		case 'paymethod_enabled':
			if($pay->paymethod_enabled($id,$enabled))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'paymethod_button':
			if(isset($do_submit))
			{
				$order=array();
				$order['order_sn']='SN'.create_sn();
				$order['order_amount']=max(0.01,floatval($price));
				$payment=$pay->paymethodinfo($payment);
				include_once(RETENG_ROOT.'pay/api/' . $payment['code'] . '.php');
				$pay_obj= new $payment['code'];
				$payurl=$pay_obj->get_code($order,$payment['config']);
				$paybutton='<a href="'.$payurl.'" target="_blank">在线支付</a>';
				include admin_tlp('button','pay');
				exit();
			}
			$result=$pay->paymethod();
			include admin_tlp('paymethod_button','pay');
			break;
		/*
			点卡操作
		*/
		case 'cardtype':
			if(isset($do_submit))
			{
				if($pay->cardtype_edit($name,$orderby,$amount,$price))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$result=$pay->cardtype();
			include admin_tlp('cardtype','pay');			
			break;
		case 'cardtype_add':
			if(isset($do_submit)) 
			{
				if(!$info['name'])
				{
					showmsg('点卡类型名称不能为空!');
				}

				if($pay->cardtype_add($info))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			include admin_tlp('cardtype_add','pay');			
			break;
		case 'cardtype_delete':
			if($pay->cardtype_delete($id))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'card':
			if(isset($do_submit))
			{
				if(!isset($id) || !$id)showmsg($lang['RETURN_NOSELECT']);
				if($pay->delete_card($id))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$enabled=isset($enabled)?intval($enabled):0;
			$k=isset($k)?trim($k):'';
			$result=$pay->card($enabled,$k);
			include admin_tlp('card','pay');			
			break;
		case 'card_add':
			if(isset($do_submit))
			{
				if($pay->create_card($info))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$cardtype=$pay->cardtype();
			include admin_tlp('card_add','pay');			
			break;
		/*
			充值记录
		*/

		case 'log':
			if(isset($do_submit))
			{
				if(!isset($id) || !$id)showmsg($lang['RETURN_NOSELECT']);
				if($pay->log_delete($id))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$username=$sn='';
			if(isset($field))
			{
				if($field=='username')
				{
					$username=$k;
				}
				else
				{
					$sn=$k;
				}
			}
			$status=isset($status)?$status:0;
			$result=$pay->loglist($username,$sn,$status);
			include admin_tlp('paylog','pay');
			break;
		/*
			会员充值
		*/
		case 'member':
			if(isset($do_submit))
			{
				if($pay->member_pay($info))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg('该会员不存在, 充值失败!');
				}
			}
			include admin_tlp('member','pay');
			break;
		/*
			订单查询
		*/
		case 'order':
			if(isset($do_submit))
			{
				if(!isset($id) || !$id)showmsg($lang['RETURN_NOSELECT']);
				if($pay->order_delete($id))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$buyuser=$sn='';
			if(isset($field))
			{
				if($field=='buyuser')
				{
					$buyuser=$k;
				}
				else
				{
					$sn=$k;
				}
			}
			$status=isset($status)?$status:'all';
			$result=$pay->orderlist($buyuser,$sn,$status);
			include admin_tlp('order','pay');
			break;
		case 'orderstatus':
			if($status)
			{
				$pay->order_status($status);
			}
			showmsg($lang['RETURN_SUCEESS']);
			break;
		case 'showorder':
			$orderinfo=$pay->orderinfo($id);
			include admin_tlp('showorder','pay');
			break;
		/*
			送货方式
		*/
		case 'shipment':
			if(isset($do_submit))
			{
				if($pay->shipment_config($name,$fee,$desc,$id))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$result=$pay->shipment();
			include admin_tlp('shipment','pay');
			break;
	}
?>
