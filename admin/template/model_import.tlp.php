<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(16,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>模型管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
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
			<li><li><a href="?file=model&action=manage"><?php echo $lang['LEFT-MODULE-2'];?></a></li>
			<li><a href="?file=model&action=install"><?php echo $lang['LEFT-MODULE-3'];?></a></li>	
			<li><a href="javascript:void(0);" class="on"><?php echo $lang['LEFT-MODULE-4'];?></a></li>		
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		1：请输入正确的模型导入码
	</fieldset>
	<form action="" method="post" name="myform" enctype="multipart/form-data">
	<input type="hidden" name="do_submit" value="1" />
	<table cellspacing="0" class="sub">
		<tr>
			<td width="80" align="right">模型导入码：</td>
			<td>
			<textarea name="content" cols="70" datatype="min" min="1" rows="6"></textarea>
			</td>
		</tr>
		<tr class="bg2"><td></td><td><input type="button" onclick="doSubmit(this);" class="button" value="导入模型" /> <input type="button" class="button" onclick="window.location.href='<?php echo ADMIN_FILE;?>?file=model&action=manage'" value="取消返回" /></td></tr>
	</table>
	</form>

	</div>
</div>
</body>
</html>
