<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if($_roleid!=1)showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $lang['LEFT-SYSTEM-9'];?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script type="text/javascript" src="admin/template/js/admin.js"></script>
<script type="text/javascript" src="admin/template/js/css.js"></script>
</head>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="?file=admin&action=role"><?php echo $lang['LEFT-SYSTEM-9'];?></a></li>
			<li><a href="?file=admin&action=role_add"><?php echo $lang['LEFT-SYSTEM-15'];?></a></li>	
			<li><a href="javascript:void(0);" class="on"><?php echo $lang['LEFT-SYSTEM-18'];?></a></li>			
		</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		您可以通过模块配置完成后台的各种权限组合。 
		</fieldset>
		<table cellspacing="0" class="datalist" id="list" width="98%">
		<tr>
			<th width="21%" colspan="2">模块名称</th>
			<th width="79%">管理权限配置</th>
		</tr>
		<form action="" method="post" name="myform">
		<input type="hidden" name="do_submit" value="1" />
		<?php $admobj->authlist();?>
		<tr>
			<td width="50">&nbsp;</td>
			<td colspan="2" align="left">
			&nbsp;<input type="button" onclick="this.form.submit();" class="submit" value="提交配置" />
			</td>
		</tr>
		</form>
		</table>
	</div>
</div>
</body>
</html>
