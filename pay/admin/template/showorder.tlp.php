<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('pay',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>订单管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script src="images/js/check.func.js"></script>
<script language="javascript" src="admin/template/js/css.js"></script>
<style type="text/css">
.paddding td{padding:5px}
</style>
</head>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="?mod=pay&file=pay&action=order">订单管理</a></li>
			<li><a href="javascript:void(0);" class="on">查看订单</a></li>			
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend>操作提示</legend>
		暂无提示
	</fieldset>
	<table cellspacing="1" cellpadding="1" bgcolor="#cccccc" align="center" width="95%" class="paddding">
		<tr>
		<td bgcolor="#ffffff" colspan="2" align="center">
		<b>订单信息</b>
		</td>
		</tr>
		<tr>
			<td bgcolor="#ffffff" width="13%" align="right">订单号：</td>
			<td width="87%" bgcolor="#ffffff">
			<?php echo $orderinfo['sn'];?>			</td>
		</tr>
		<tr>
			<td bgcolor="#ffffff" width="13%" align="right">产品名称：</td>
			<td bgcolor="#ffffff">
			<?php echo $orderinfo['product'];?>
			</td>
		</tr>
		<tr>
			<td bgcolor="#ffffff" width="13%" align="right">订购数量：</td>
			<td bgcolor="#ffffff">
			<?php echo $orderinfo['number'];?> 件
			</td>
		</tr>
		<tr>
			<td bgcolor="#ffffff" width="13%" align="right">订购金额：</td>
			<td bgcolor="#ffffff">
			<?php echo $orderinfo['amount'];?> 元
			</td>
		</tr>
		<tr>
			<td bgcolor="#ffffff" width="13%" align="right">支付方式：</td>
			<td bgcolor="#ffffff">
			<?php echo $pay->paymentname($orderinfo['payment']);?>
			</td>
		</tr>
		<tr>
			<td bgcolor="#ffffff" width="13%" align="right">送货方式：</td>
			<td bgcolor="#ffffff">
			<?php echo $pay->shipmentinfo($orderinfo['shipment'],'name');?>
			手续费：<?php echo $pay->shipmentinfo($orderinfo['shipment'],'fee');?>元
			</td>
		</tr>
		<tr>
			<td bgcolor="#ffffff" width="13%" align="right">支付状态：</td>
			<td bgcolor="#ffffff">
			<?php 
			if($orderinfo['status']==0)
			{
				echo '未付款';
			}
			elseif($orderinfo['status']==1)
			{
				echo '已付款';
			}
			elseif($orderinfo['status']==2)
			{
				echo '未发货';
			}
			elseif($orderinfo['status']==3)
			{
				echo '已发货';
			}
			elseif($orderinfo['status']==4)
			{
				echo '交易完成';
			}
			elseif($orderinfo['status']==99)
			{
				echo '取消交易';
			}
			?>
			</td>
		</tr>
		<tr>
			<td bgcolor="#ffffff" width="13%" align="right">下单时间：</td>
			<td bgcolor="#ffffff">
			<?php echo date('Y-m-d H:i:s',$orderinfo['datetime']);?>
			</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff" colspan="2" align="center">
		<b>订购人信息</b>
		</td>
		</tr>
		<tr>
			<td bgcolor="#ffffff" width="13%" align="right">真实姓名：</td>
			<td bgcolor="#ffffff">
			<?php echo $orderinfo['buyuser'];?>
			</td>
		</tr>
		<tr>
			<td bgcolor="#ffffff" width="13%" align="right">联系方式：</td>
			<td bgcolor="#ffffff">
			<?php echo $orderinfo['buyphone'];?>
			</td>
		</tr>
		<tr>
			<td bgcolor="#ffffff" width="13%" align="right">详细地址：</td>
			<td bgcolor="#ffffff">
			<?php echo $orderinfo['buyaddress'];?>
			</td>
		</tr>
		<tr>
			<td bgcolor="#ffffff" width="13%" align="right">所在IP：</td>
			<td bgcolor="#ffffff">
			<?php echo $orderinfo['ip'];?>
			</td>
		</tr>
		<tr>
			<td bgcolor="#ffffff" width="13%" align="right">简要留言：</td>
			<td bgcolor="#ffffff">
			<?php echo $orderinfo['buymessage'];?>
			</td>
		</tr>
		<tr>
		<td bgcolor="#ffffff" colspan="2" align="center">
		<b>收货人信息</b>
		</td>
		</tr>
		<tr>
			<td bgcolor="#ffffff" width="13%" align="right">真实姓名：</td>
			<td bgcolor="#ffffff">
			<?php echo $orderinfo['receiveuser'];?>
			</td>
		</tr>
		<tr>
			<td bgcolor="#ffffff" width="13%" align="right">联系方式：</td>
			<td bgcolor="#ffffff">
			<?php echo $orderinfo['receivephone'];?>
			</td>
		</tr>
		<tr>
			<td bgcolor="#ffffff" width="13%" align="right">详细地址：</td>
			<td bgcolor="#ffffff">
			<?php echo $orderinfo['receiveaddress'];?>
			</td>
		</tr>
		<tr><td colspan="2" bgcolor="#ffffff" align="center"><input type="button" class="button" onclick="window.location.href='<?php echo ADMIN_FILE;?>?mod=pay&file=pay&action=order'" value="取消返回" /></td></tr>
	</table>
	</div>
</div>
</body>
</html>
