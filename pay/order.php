<?php
include substr(dirname(__FILE__),0,-3).'include/common.inc.php';

if($module->module_disabled('pay'))
{
	show404('该模块已被管理员禁用!');
}
include RETENG_ROOT.'pay/include/global.func.php';
include RETENG_ROOT.'pay/include/pay.class.php';
$payobj=new pay();

$action=isset($action)?$action:'step1';
session_start();

$cookiekey=retengcms_md5('productarray'.IP);
$productarray=string2array(get_cookie($cookiekey));

switch($action)
{			
	case 'step2':
		if(isset($_SESSION['order_refreash']) && $_SESSION['order_refreash'])
		{
			showmsg('请勿重复刷新提交!');
		}
		else
		{
			$_SESSION['order_refreash']=true;
		}

		$resut=$payobj->order_step1($info,$price,$number);
		if($resut===-1)
		{
			$payobj->showmsg('支付方式不存在或者已被禁用!','error');
		}
		else if(is_array($resut))
		{
			$info=$resut;
			$totalnum=0;
			$totalamount=0.0;
			$paymentinfo=$payobj->enabledpaymethod();
			$shipmentinfo=$payobj->shipment();
			$shipmentfee=$payobj->shipmentinfo(intval($info['shipment']),'fee');
			foreach($price as $key =>$val)
			{
				$totalnum=$totalnum+intval($number[$key]);
				$totalamount=$totalamount+intval($number[$key])*floatval($val);
			}
			$totalamount=$totalamount+$shipmentfee;
			include template('step2','pay');
		}
		else
		{
			$payobj->showmsg('订单信息已录入, 我们将尽快与您联系!');
		}
		break;
	case 'step3':
		if($_SESSION['order_sign']!=md5($payment.$orderinfo['order_sn'].$orderinfo['order_amount']))
		{
			$payobj->showmsg('支付校验失败, 请重试!','error');
		}
		$payment=$payobj->paymethodinfo($payment);
		include_once(RETENG_ROOT.'pay/api/' . $payment['code'] . '.php');
		$pay_obj= new $payment['code'];
		$payurl=$pay_obj->get_code($orderinfo,$payment['config']);
		set_cookie('orderurl',$backurl);
		include template('payonline','pay');
		break;
	case 'deletecart':
		$productarray=string2array(get_cookie($cookiekey));
		foreach($productarray as $key =>$val)
		{
			if($productkey==md5($val['product'].$val['producturl'].$val['price'].$val['number']))
			{
				unset($productarray[$key]);
			}
		}
		set_cookie($cookiekey,var_export($productarray,true));
		showmsg('商品成功从购物车下架!',SITE_URL.'pay/order.php');
		break;
	default:
		/*
			获取产品信息（数组）
		*/
		$productarray=array();
		$productarray=string2array(get_cookie($cookiekey));

		if(isset($dopost))
		{
			$product=strip_tags($product)?strip_tags($product):'不祥1';
			$producturl=is_url($producturl)?$producturl:$RETENG['site_url'];
			$price=floatval($price)>=0?floatval($price):1;
			$number=max(1,intval($price));
			$productkey=md5($product.$producturl.$price.$number);
			$productarray[]=array('productkey'=>$productkey,'product'=>$product,'producturl'=>$producturl,'price'=>$price,'number'=>$number);
			$productarray=array_unique($productarray);
			if(sizeof($productarray)>10)
			{
				showmsg('购物车最多添加10种商品!',SITE_URL.'pay/order.php');
			}
			else
			{
				unset($_SESSION['order_refreash']);
				set_cookie($cookiekey,var_export($productarray,true));
			}
		}

		/*
			获取支付方式
		*/
		$payment=$payobj->enabledpaymethod();
		$shipment=$payobj->shipment();
		include template('step1','pay');
		break;
}
?>
