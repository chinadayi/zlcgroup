<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('member',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>头衔管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<?php include 'ueditor.js.php';?>
<script src="images/js/check.func.js"></script>
<script language="javascript" src="admin/template/js/css.js"></script>
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
			<li><a href="?mod=member&file=member&action=honor">头衔管理</a></li>
			<li><a href="javascript:void(0);" class="on">添加头衔</a></li>		
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend>操作提示</legend>
		1：积分，图标数只能是数字； 2：会员头衔名称不能留空。
	</fieldset>
	<form action="" method="post" name="myform">
	<input type="hidden" name="do_submit" value="1" />
	<table cellspacing="0" class="sub">
		<tr>
			<td width="80" align="right">头衔名称：</td>
			<td>
			<input type="text" name="info[name]" datatype="limit" min="1" max="80" size="20" />
			</td>
		</tr>
		<tr>
			<td align="right">积分大于：</td>
			<td>
			<input type="text" size="6" value="100" datatype="integer" name="info[point]" /> 分
			</td>
		</tr>
		<tr>
			<td align="right">图标个数：</td>
			<td>
			<input type="text" size="6" value="1" datatype="integer" name="info[ico]" /> 个
			</td>
		</tr>
		<tr>
			<td align="right">是否启用：</td>
			<td>
			<input type="radio" value="0" class="radio" checked="checked" name="info[disabled]" />启用 
			<input type="radio" value="1" class="radio" name="info[disabled]" />禁用
			</td>
		</tr>
		<tr class="bg2"><td></td><td><input type="button" class="button" onclick="doSubmit(this);" value="保存头衔" /> <input type="button" class="button" onclick="window.location.href='<?php echo ADMIN_FILE;?>?mod=member&file=member&action=honor'" value="取消返回" /></td></tr>
	</table>
	</form>

	</div>
</div>
</body>
</html>
