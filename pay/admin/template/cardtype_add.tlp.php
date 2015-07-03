<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('pay',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>点卡类型管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script src="images/js/check.func.js"></script>
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
			<li><a href="?mod=pay&file=pay&action=cardtype">点卡类型</a></li>
			<li><a href="javascript:void(0);" class="on">添加类型</a></li>			
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend>操作提示</legend>
		1：点卡类型名称不能为空； 2：点卡类型排序应为数字。
	</fieldset>
	<form action="" method="post" name="myform">
	<input type="hidden" name="do_submit" value="1" />
	<table cellspacing="0" class="sub">
		<tr>
			<td width="80" align="right">类型名称：</td>
			<td>
			<input type="text" name="info[name]" datatype="limit" min="1" max="80" size="20" />
			</td>
		</tr>
		<tr>
			<td width="80" align="right">包含钱数：</td>
			<td>
			<input type="text" size="6" value="100" datatype="number"name="info[amount]" /> 元
			</td>
		</tr>
		<tr>
			<td width="80" align="right">点卡价格：</td>
			<td>
			<input type="text" size="6" value="10" datatype="number"name="info[price]"/> 元
			</td>
		</tr>
		<tr>
			<td align="right">排序权值：</td>
			<td>
			<input type="text" size="6" value="0" datatype="integer" name="info[orderby]" />
			</td>
		</tr>
		<tr class="bg2"><td></td><td><input type="button" class="button" onclick="doSubmit(this);" value="保存点卡类型" /> <input type="button" class="button" onclick="window.location.href='<?php echo ADMIN_FILE;?>?mod=pay&file=pay&action=cardtype'" value="取消返回" /></td></tr>
	</table>
	</form>

	</div>
</div>
</body>
</html>
