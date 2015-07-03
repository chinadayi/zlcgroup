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
	<li class="active"><a href="member/index.php?mod=pay&file=pay&action=online">在线充值</a></li>
	<li><a href="member/index.php?mod=pay&file=pay&action=card">点卡充值</a></li>
	<li><a href="member/index.php?mod=pay&file=pay&action=log">财务日志</a></li>
	<li><a href="member/index.php?mod=pay&file=pay&action=order">订单查询</a></li>
</ul>
</div>
<div class="display">
<div class="tdline">
<table border="0" cellpadding="0" cellspacing="0" width="98%">
<tr>
<td colspan="2"><h3>在线充值
</h3></td>
</tr>
<tr>
<td class="left">订单号：</td>
<td id="showbuyfen"> <?php echo $log['sn'];?></td>
</tr>
<tr>
<td class="left">充值金额：</td>
<td id="showbuyfen"> <?php echo $amount;?> 元</td>
</tr>
<?php foreach($paymethod as $_r){?>
<?php if(!$_r['is_online']){?>
<tr>
<td class="left"><?php echo $_r['name'];?>：</td>
<td id="showbuyfen"><?php echo nl2br($_r['desc']);?></td>
</tr>
<?php }?>
<?php }?>
<tr>
<td>&nbsp;</td>
<td><input type="button" value="在线支付" name="dosubmit" onClick="javascript:window.open('<?php echo $payurl;?>');this.value='充值中...';this.disabled='disabled'" class="input_sub"/></td>
</tr>
</table>
</div>
</div>
</div>

</div>
<?php include member_tlp('footer');?>
</div>
</body>
</html>
