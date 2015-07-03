<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('link',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>广告位管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
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
			<li><a href="?mod=link&file=link&action=type">链接类型管理</a></li>
			<li><a href="?mod=link&file=link&action=type_add">添加链接类型</a></li>		
			<li><a href="javascript:void(0);" class="on">编辑链接类型</a></li>	
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend>操作提示</legend>
		1：类型名称不能为空； 2：排序应为数字；
	</fieldset>
	<form action="" method="post" name="myform">
	<input type="hidden" name="do_submit" value="1" />
	<input type="hidden" name="id" value="<?php echo $id;?>" />
	<table cellspacing="0" class="sub" width="98%">
		<tr>
			<td width="193" align="right">类型名称：</td>
			<td width="1092">
			<input type="text" name="info[name]" value="<?php echo $info['name'];?>" datatype="limit" min="1" max="80" size="25"/>
		  </td>
		</tr>
		<tr>
			<td align="right">是否启用：</td>
			<td>
			<input type="radio" class="radio" value="0" <?php echo !$info['disabled']?'checked="checked"':'';?> name="info[disabled]" />启用
			<input type="radio" class="radio" value="1" <?php echo $info['disabled']?'checked="checked"':'';?> name="info[disabled]" />待审
			</td>
		</tr>
		<tr class="bg2"><td></td><td><input type="button" class="button" onclick="doSubmit(this);" value="保存链接类型" /> <input type="button" class="button" onclick="window.location.href='<?php echo ADMIN_FILE;?>?mod=link&file=link&action=type'" value="取消返回" /></td></tr>
	</table>
	</form>

	</div>
</div>
</body>
</html>
