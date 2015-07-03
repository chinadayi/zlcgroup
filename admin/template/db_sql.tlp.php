<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(4,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>数据库管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script language="javascript" src="admin/template/js/css.js"></script>
</head>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="?file=db&action=export"><?php echo $lang['LEFT-SYSTEM-12'];?></a></li>
			<li><a href="?file=db&action=import"><?php echo $lang['LEFT-SYSTEM-13'];?></a></li>
			<li><a href="?file=db&action=repair"><?php echo $lang['LEFT-SYSTEM-14'];?></a></li>
			<li><a href="javascript:void(0);" class="on">执行SQL</a></li>			
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		1：SQL语句不能为空
	</fieldset>
	<form action="" method="post" name="myform">
	<input type="hidden" name="do_submit" value="1" />
	<table cellspacing="0" class="sub">
		<tr>
			<td width="80" align="right">SQL语句：</td>
			<td>
			<textarea name="sqls" id="sqls" cols="50" rows="6"></textarea>
			</td>
		</tr>
		<tr class="bg2"><td></td><td><input type="button" class="button" onclick="if(confirm('确实要执行SQL？\n'+$('#sqls').val())){this.form.submit()}" value="执行SQL" /> <input type="button" class="button" onclick="window.location.href='<?php echo ADMIN_FILE;?>?file=db&action=export'" value="取消返回" /></td></tr>
	</table>
	</form>

	</div>
</div>
</body>
</html>
