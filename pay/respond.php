<?php
include substr(dirname(__FILE__),0,-3).'include/common.inc.php';
include RETENG_ROOT.'pay/include/global.func.php';

$pay_code = trim($code);
if(empty($pay_code) || !in_array($pay_code,array('alipay','bank','chinabank','post','tenpay')))
{
	showmsg('不被支持的支付方式!');
}
else
{
	$plugin_file = RETENG_ROOT.'pay/api/'.$pay_code.'.php';
	if(is_file($plugin_file))
	{
		include_once( $plugin_file );
		$payment = new $pay_code();
		$result = $payment->respond();
		if ($result)
		{
			$orderurl=get_cookie('orderurl');
			$respondurl=$orderurl?$orderurl:$RETENG['site_url'].'member/index.php?mod=pay&file=pay&action=log';
           showmsg('支付成功!',$respondurl);
		}
		else if($payment->err)
		{
			showmsg_nourl($payment->err);
		}
		else
		{
			showmsg('支付失败!');
		}
	}
	else
	{
		showmsg("不被支持的支付方式!");
	}
}
?>

