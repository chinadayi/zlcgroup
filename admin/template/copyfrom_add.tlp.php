<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(9,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>稿件来源管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script type="text/javascript" src="admin/template/js/admin.js"></script>
<script language="javascript" src="admin/template/js/css.js"></script>
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
			<li><a href="?file=copyfrom&action=manage"><?php echo $lang['COPYFROM-LANG-1'];?></a></li>
			<li><a href="javascript:void(0);" class="on"><?php echo $lang['COPYFROM-LANG-2'];?></a></li>			
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		1：稿件来源不能为空； 2：URL请以http://开头； 3：来源排序应为数字。
	</fieldset>
	<form action="" method="post" name="myform">
	<input type="hidden" name="do_submit" value="1" />
	<table cellspacing="0" class="sub">
		<tr>
			<td colspan="2"><div id="tip"></div></td>
		</tr>
		<tr>
			<td width="80" align="right">来源名称：</td>
			<td>
			<input type="text" name="info[name]" datatype="limit" min="1" max="80" class="input" size="20" />
			</td>
		</tr>
		<tr>
			<td width="80" align="right">来源URL：</td>
			<td>
			<input type="text" name="info[url]"  value="http://" class="input" size="35" />
			</td>
		</tr>
		<tr>
			<td align="right">来源排序：</td>
			<td>
			<input type="text" size="6" value="0" name="info[orderby]" class="input" />
			</td>
		</tr>
		<tr class="bg2"><td></td><td><input type="button" class="button" onclick="doSubmit(this);" value="保存来源" /> <input type="button" class="button" onclick="window.location.href='<?php echo ADMIN_FILE;?>?file=copyfrom&action=manage'" value="取消返回" /></td></tr>
	</table>
	</form>

	</div>
</div>
</body>
</html>
