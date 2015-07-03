<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('pay',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>支付按钮</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script src="images/js/check.func.js"></script>
<script language="javascript" src="admin/template/js/css.js"></script>
<script language="javascript" type="text/javascript">
	$(document).ready(function(){
		checkForm(0);
		$('#payment').val(<?php echo $payment;?>);
	});
</script>
</head>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="?mod=pay&file=pay&action=paymethod">支付配置</a></li>
			<li><a href="javascript:void(0);" class="on">支付按钮</a></li>			
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend>操作提示</legend>
		支付金额不能为空!
	</fieldset>
	<form action="" method="post" name="myform">
	<input type="hidden" name="do_submit" value="1" />
	<table cellspacing="0" class="sub">
		<tr>
			<td width="80" align="right">支付方式：</td>
			<td>
			<select name="payment" id="payment">
			<?php foreach($result as $_r){?>
			<?php if($_r['is_online']){?>
			<option value="<?php echo $_r['id'];?>"><?php echo $_r['name'];?></option>
			<?php }?>
			<?php }?>
			</select>
			</td>
		</tr>
		<tr>
			<td width="80" align="right">支付金额：</td>
			<td>
			<input type="text" name="price" value="0.00"  datatype="number" size="6" /> 元
			</td>
		</tr>
		<tr class="bg2"><td></td><td><input type="button" class="button" onclick="doSubmit(this);" value="生成支付按钮" /> <input type="button" class="button" onclick="window.location.href='<?php echo ADMIN_FILE;?>?mod=pay&file=pay&action=paymethod'" value="取消返回" /></td></tr>
	</table>
	</form>

	</div>
</div>
</body>
</html>
