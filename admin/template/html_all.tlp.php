<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(8,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>一键更新</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script src="images/js/check.func.js"></script>
</head>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="javascript:void(0);" class="on"><?php echo $lang['LEFT-HTML-7'];?></a></li>
			<li><a href="?file=html&action=cache"><?php echo $lang['LEFT-HTML-1'];?></a></li>
			<li><a href="?file=html&action=category"><?php echo $lang['LEFT-HTML-9'];?></a></li>
			<li><a href="?file=html&action=content"><?php echo $lang['LEFT-HTML-10'];?></a></li>		
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		一键更新会依次更新系统缓存，网站首页，网站栏目，网站地图以及所有文档。
	</fieldset>
	<form action="" method="post" name="myform">
	<input type="hidden" name="do_submit" value="1" />
	<table cellspacing="0" class="sub">
		<tr class="bg2"><td></td><td><input type="button" class="button" onclick="this.form.submit();" value="开始更新" /></td></tr>
	</table>
	</form>

	</div>
</div>
</body>
</html>
