<?php
require substr(dirname(__FILE__), 0, -7).'include/common.inc.php';
include RETENG.'pay/include/global.func.php';
$pay_code = 'alipay';

$plugin_file = RETENG_ROOT.'pay/api/'.$pay_code.'.php';
if (is_file($plugin_file))
{
	include_once( $plugin_file );
	$payment = new $pay_code();
	$result = $payment->respond();
	if ($result)
	{
		exit("success");
	}
	else if($payment->err)
	{
		exit("fail");
	}
	else
	{
		exit("fail");
	}
}
else
{
	exit("fail");
}
?>
