<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(14,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $lang['LEFT-MODULE-8'];?></title>
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
			<li><a href="?file=module&action=manage"><?php echo $lang['LEFT-MODULE-6'];?></a></li>
			<li><a href="javascript:void(0);" class="on"><?php echo $lang['LEFT-MODULE-8'];?></a></li>
			<li><a href="?file=module&action=guide"><?php echo $lang['LEFT-MODULE-7'];?></a></li>	
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		导入文件为 zip 格式的压缩文件!
	</fieldset>
	<form action="" method="post" name="myform" enctype="multipart/form-data">
	<input type="hidden" name="do_submit" value="1" />
	<table cellspacing="0" class="sub">
		<tr>
			<td width="80" align="right">模块文件：</td>
			<td>
			<input type="file" name="file" />
			</td>
		</tr>
		<tr class="bg2"><td></td><td><input type="submit" class="button" value="开始导入" /> <input type="button" class="button" onclick="window.location.href='<?php echo ADMIN_FILE;?>?file=module&action=manage'" value="取消返回" /></td></tr>
	</table>
	</form>

	</div>
</div>
</body>
</html>
