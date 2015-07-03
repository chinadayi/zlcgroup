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
<script src="images/js/check.func.js"></script>
<script language="javascript" type="text/javascript">
$(document).ready(function(){checkForm(0);});
</script>
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
	<li class="active"><a href="member/index.php?mod=pay&file=pay&action=card">点卡充值</a></li>
	<li><a href="member/index.php?mod=pay&file=pay&action=log">财务日志</a></li>
	<li><a href="member/index.php?mod=pay&file=pay&action=order">订单查询</a></li>
</ul>
</div>
<div class="display">
<div class="tdline">
<form action="member/index.php?mod=pay&file=pay&action=card" method="post" name="myform" >
<input type="hidden" name="do_submit" value="1" />
<input type="hidden" name="forward" value="<?php echo getcururl();?>" />
<table border="0" cellpadding="0" cellspacing="0" width="98%">
<tr>
<td colspan="2"><h3>点卡充值
</h3></td>
</tr>
<tr>
<td class="left">点数余额：</td>
<td id="showbuyfen"> <?php echo $_point;?> 点</td>
</tr>
<tr>
<td class="left">资金余额：</td>
<td><?php echo $_amount;?> 元</td>
</tr>
<tr>
<td class="left">点卡卡号：</td>
<td id="showbuyfen"> <input type="text" name="cardid" datatype="number" size="20" /></td>
</tr>
<tr>
<td class="left">验 证 码：</td>
<td id="showbuyfen"> <input type="text" name="inputcheckcode" datatype="checkcode" size="6" /> &nbsp;<img src='<?php echo RETENG_PATH;?>api/imcode/checkcode.php' onClick="this.src='<?php echo RETENG_PATH;?>api/imcode/checkcode.php?M'+Math.random()*5;" title="看不清楚?点击更换验证码!" style="cursor:pointer" align="middle"></img> <span class="errtip" id="checkcodetip" style="color:#FF3300"></span></td>
</tr>
<tr>
<td>&nbsp;</td>
<td><input type="button" value="充 值" name="dosubmit" onClick="doSubmit(this);" class="input_sub"/></td>
</tr>
</table>
</form>
</div>
</div>
</div>

</div>
<?php include member_tlp('footer');?>
</div>
</body>
</html>
