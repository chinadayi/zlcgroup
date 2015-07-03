<?php
	!defined('MEMBER_CENTER') && exit('Access Denied!');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>会员中心 - Powered by ReTengCMS</title>
<base href="<?php echo $RETENG['site_url'];?>" />
<link href="member/template/images/style.css" rel="stylesheet" type="text/css" />
<script src="images/js/jquery.min.js"></script>
</head>
<body>
<div id="warp">
<?php include member_tlp('header');?>
<div class="container clearfix">
<?php include member_tlp('sidebar');?>

<div id="content">
<div id="here">
<h2 class="title">支付中心</h2>
</div>
<div class="tabs_header">
<ul class="tabs clearfix">
	<li><a href="member/index.php?mod=pay&file=pay&action=online">在线充值</a></li>
	<li><a href="member/index.php?mod=pay&file=pay&action=card">点卡充值</a></li>
	<li><a href="member/index.php?mod=pay&file=pay&action=log">财务日志</a></li>
	<li class="active"><a href="member/index.php?mod=pay&file=pay&action=order">订单查询</a></li>
</ul>
</div>
<div class="display">

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table_title">
<tr>
<td width="34%" align="center"><b>产品</b></td>
<td width="18%" align="center"><b>支付号</b></td>
<td width="16%" align="center"><b>金额</b></td>
<td width="11%" align="center"><b>订单状态</b></td>
<td width="21%" align="center"><b>发生时间</b></td>
</tr>

<?php if(is_array($result))foreach($result as $val){?>
<tr bgcolor="#ffffff">
<td align="center"><?php echo $val['product'];?></td>
<td align="center"><?php echo $val['sn'];?></td>
<td align="center"><?php echo $val['amount'];?> 元</td>
<td align="center">
<?php 
if($val['status']==0)
{
	echo '未付款';
}
elseif($val['status']==1)
{
	echo '已付款';
}
elseif($val['status']==2)
{
	echo '未发货';
}
elseif($val['status']==3)
{
	echo '已发货<br /><a href="'.SITE_URL.'member/index.php?mod=pay&file=pay&action=confirmorder&ordersn='.$val['sn'].'"><u>确认收货</u></a>';
}
elseif($val['status']==4)
{
	echo '交易完成';
}
elseif($val['status']==99)
{
	echo '取消交易';
}
?>
</td>
<td align="center"><?php echo date('Y-m-d',$val['datetime']);?></td>
</tr>
<?php }?>	
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table_title">
<tr>
<td><?php echo $pay->pagestring;?></td>
</tr>
</table>
</div>
</div>

</div>
<?php include member_tlp('footer');?>
</div>
</body>
</html>
