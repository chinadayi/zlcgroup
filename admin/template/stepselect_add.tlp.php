<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(5,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>级联菜单管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script language="javascript" src="admin/template/js/css.js"></script>
<script type="text/javascript" src="admin/template/js/admin.js"></script>
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
			<li><a href="?file=stepselect&action=manage"><?php echo $lang['LEFT-CATEGORY-9'];?></a></li>
			<li><a href="javascript:void(0);" class="on"><?php echo $lang['LEFT-CATEGORY-10'];?></a></li>			
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		1：级联菜单名称不能为空； 2：缓存组名必须为英文或数字组合!
	</fieldset>
	<form action="" method="post" name="myform">
	<input type="hidden" name="do_submit" value="1" />
	<table cellspacing="0" class="sub">
		<tr>
			<td colspan="2"><div id="tip"></div></td>
		</tr>
		<tr>
			<td width="80" align="right">菜单名称：</td>
			<td>
			<input type="text" name="info[name]" datatype="limit" min="1" max="80" class="input" size="20" />
			</td>
		</tr>
		<tr>
			<td width="80" align="right">缓存组名：</td>
			<td>
			<input type="text" name="info[table]" class="input" datatype="table" size="20" />
			</td>
		</tr>
		<tr class="bg2"><td></td><td><input type="button" class="button" onclick="doSubmit(this);" value="保存菜单" /> <input type="button" class="button" onclick="window.location.href='<?php echo ADMIN_FILE;?>?file=stepselect&action=manage'" value="取消返回" /></td></tr>
	</table>
	</form>

	</div>
</div>
</body>
</html>
