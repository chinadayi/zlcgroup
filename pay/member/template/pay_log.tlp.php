<?php
	!defined('MEMBER_CENTER') && exit('Access Denied!');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>会员中心</title>
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
	<li class="active"><a href="member/index.php?mod=pay&file=pay&action=log">财务日志</a></li>
	<li><a href="member/index.php?mod=pay&file=pay&action=order">订单查询</a></li>
</ul>
</div>
<div class="display">

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table_title">
<tr>
<td width="16%" align="center"><b>操作</b></td>
<td width="38%" align="center"><b>支付号</b></td>
<td width="18%"><b>金额</b></td>
<td width="9%" align="center"><b>支付状态</b></td>
<td width="19%" align="center"><b>发生时间</b></td>
</tr>

<?php if(is_array($result))foreach($result as $val){?>
<tr bgcolor="#ffffff">
<td align="center"><?php echo $val['manage']?'收入':'支出';?></td>
<td align="center"><?php echo $val['sn'];?></td>
<td><?php echo $val['amount'];?> 元</td>
<td align="center"><?php echo $val['status']==2?'成功':'<font color="#FF3300">未完成</font>';?></td>
<td align="center"><?php echo date('Y-m-d',$val['time']);?></td>
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
