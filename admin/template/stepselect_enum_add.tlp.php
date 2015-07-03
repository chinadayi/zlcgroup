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
			<li><a href="?file=stepselect&action=enum&id=<?php echo $selectid;?>"><?php echo $lang['LEFT-CATEGORY-11'];?></a></li>
			<li><a href="javascript:void(0);" class="on"><?php echo $lang['LEFT-CATEGORY-12'];?></a></li>			
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		1：分类名称不能为空； 2：最多支持三级菜单! 3：可以同时添加多个，每个用回车键分割!
	</fieldset>
	<form action="" method="post" name="myform">
	<input type="hidden" name="do_submit" value="1" />
	<input type="hidden" name="info[selectid]" value="<?php echo $selectid;?>" />
	<table cellspacing="0" class="sub">
		<tr>
			<td colspan="2"><div id="tip"></div></td>
		</tr>
		<tr>
			<td width="80" align="right">隶属分类：</td>
			<td>
				<?php echo $enums_select;?>
			</td>
		</tr>
		<tr>
			<td width="80" align="right">分类名称：</td>
			<td>
			<textarea name="info[names]"  datatype="min" min="1" cols="50" rows="5">分类一<?php echo "\r\n";?>分类二</textarea>
			</td>
		</tr>
		<tr class="bg2"><td></td><td><input type="button" class="button" onclick="doSubmit(this);" value="保存分类" /> <input type="button" class="button" onclick="window.location.href='<?php echo ADMIN_FILE;?>?file=stepselect&action=enum&id=<?php echo $selectid;?>'" value="取消返回" /></td></tr>
	</table>
	</form>

	</div>
</div>
</body>
</html>
