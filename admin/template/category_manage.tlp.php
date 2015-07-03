<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(6,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>栏目管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script type="text/javascript" src="admin/template/js/admin.js"></script>
<script language="javascript" src="admin/template/js/css.js"></script>
</head>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="javascript:void(0);" class="on"><?php echo $lang['LEFT-CATEGORY-2'];?></a></li>
			<li><a href="?file=category&action=add"><?php echo $lang['LEFT-CATEGORY-3'];?></a></li>
			<li><a href="?file=category&action=adds"><?php echo $lang['LEFT-CATEGORY-4'];?></a></li>
		</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		栏目排序必须为数字型
		</fieldset>
		<table cellspacing="0" class="datalist" id="list" width="100%">
		<tr>
			<th width="63" class="firstcol">排序</th>
			<th width="45">栏目ID</th>
			<th width="233">栏目名称</th>
			<th width="168">前台投稿</th>
			<th width="144">导航菜单</th>
			<th width="74">访问</th>
			<th width="232">管理</th>
		</tr>
		<form action="" method="post" name="myform">
		<input type="hidden" name="do_submit" value="1" />
		<?php $category ->datalist();?>
		<tr>
			<td colspan="7" align="left">
			<input type="button" onclick="this.form.action='?file=category&action=manage';this.form.submit();" class="submit" value="更新排序" />
			<input type="button" onclick="this.form.action='?file=html&action=category';this.form.submit();" class="submit" value="更新栏目" />
			</td>
		</tr>
		</form>
		</table>
	</div>
</div>


</body>
</html>
