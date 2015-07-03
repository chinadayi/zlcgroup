<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('pay',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>会员充值</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script src="images/js/check.func.js"></script>
<script language="javascript" src="admin/template/js/css.js"></script>
<script language="javascript" type="text/javascript">
	$(document).ready(function(){
		checkForm(0);
	});
</script>
</head>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="javascript:void(0);" class="on">会员充值</a></li>		
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend>操作提示</legend>
		1：用户名不能为空； 2：充值数量应为数字。
	</fieldset>
	<form action="" method="post" name="myform">
	<input type="hidden" name="do_submit" value="1" />
	<table cellspacing="0" class="sub">
		<tr>
			<td width="80" align="right">操作类型：</td>
			<td>
			<input type="radio" class="radio" name="info[manageid]" value="1" checked="checked" />入款
			&nbsp; 
			<input type="radio" class="radio" name="info[manageid]" value="0" />扣款
			</td>
		</tr>
		<tr>
			<td align="right">充值类型：</td>
			<td>
			<input type="radio" class="radio" name="info[type]" onclick="$('#numberid').html('元')" value="amount" />资金 
			&nbsp; 
			<input type="radio" class="radio" name="info[type]" onclick="$('#numberid').html('点')"value="point" checked="checked" />点数
			</td>
		</tr>
		<tr>
			<td align="right">用 户 名：</td>
			<td>
			<input type="text" name="info[username]"  datatype="userName"  size="20" />
			</td>
		</tr>
		<tr>
			<td align="right">充值数量：</td>
			<td>
			<input type="text" name="info[amount]" value="10" datatype="number" size="8" /> <label id="numberid">点</label>
			</td>
		</tr>
		<tr>
			<td align="right">交易事由：</td>
			<td>
			<textarea name="info[note]" datatype="limit" min="0" max="100" cols="80" rows="5"></textarea>
			</td>
		</tr>
		<tr class="bg2"><td></td><td><input type="button" class="button" onclick="doSubmit(this);" value="会员充值" /> <input type="button" class="button" onclick="window.location.href='<?php echo ADMIN_FILE;?>?mod=member&file=member&action=manage'" value="取消返回" /></td></tr>
	</table>
	</form>

	</div>
</div>
</body>
</html>
