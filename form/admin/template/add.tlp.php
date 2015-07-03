<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('form',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>表单管理</title>
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
			<li><a href="?mod=form&file=form&action=manage">自定义表单</a></li>
			<li><a href="javascript:void(0);" class="on">添加表单</a></li>		
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		1：表单名称不能为空; 2：数据表表名由2-32个a-z,A-Z,0-9组成!
	</fieldset>
	<form action="" method="post" name="myform">
	<input type="hidden" name="do_submit" value="1" />
	<table cellspacing="0" class="sub" width="100%">
		<tr>
			<td width="191" align="right">自定义表单名称：</td>
			<td width="1120">
			<input type="text" name="info[name]" datatype="limit" min="1" max="80" class="input" size="20" />
		  </td>
		</tr>
		<tr>
			<td width="191" align="right">数据表：</td>
			<td>
			<?php echo DB_PRE;?> <input type="text" name="info[table]"  id="table_name" onblur="$.post('<?php echo ADMIN_FILE;?>?mod=form&file=form&action=chktable',{data:this.value},function(data){if(data=='yes'){alert('该数据表名已经存在，请更换!');$('#table_name').val('');$('#table_name').focus();}});" datatype="table" class="input" size="11" />
			</td>
		</tr>
		<tr class="bg2"><td></td><td><input type="button" class="button" onclick="doSubmit(this);" value="添加自定义表单" /> <input type="button" class="button" onclick="window.location.href='<?php echo ADMIN_FILE;?>?mod=form&file=form&action=manage'" value="取消返回" /></td></tr>
	</table>
	</form>

	</div>
</div>
</body>
</html>
