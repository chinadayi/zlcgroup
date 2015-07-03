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
			<li><a href="javascript:void(0);" class="on"><?php echo $lang['LEFT-MODULE-3'];?></a></li>	
			<li><a href="?file=model&action=import"><?php echo $lang['LEFT-MODULE-4'];?></a></li>		
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		1：模型名称不能为空; 2：附加表由2-32个a-z,A-Z,0-9组成!
	</fieldset>
	<form action="" method="post" name="myform" enctype="multipart/form-data">
	<input type="hidden" name="do_submit" value="1" />
	<table cellspacing="0" class="sub">
		<tr>
			<td width="80" align="right">模型名称：</td>
			<td>
			<input type="text" name="info[name]" datatype="limit" min="1" max="80" class="input" size="20" />
			</td>
		</tr>
		<tr>
			<td width="80" align="right">附加表名：</td>
			<td>
			<?php echo DB_PRE;?> <input type="text" name="info[table]"  id="table_name" onblur="$.post('<?php echo ADMIN_FILE;?>?file=model&action=chkmodel',{data:this.value},function(data){if(data=='yes'){alert('该数据表名已经存在，请更换!');$('#table_name').val('');$('#table_name').focus();}});" datatype="table" class="input" size="11" />
			</td>
		</tr>
		<tr class="bg2"><td></td><td><input type="button" class="button" onclick="doSubmit(this);" value="安装模型" /> <input type="button" class="button" onclick="window.location.href='<?php echo ADMIN_FILE;?>?file=model&action=manage'" value="取消返回" /></td></tr>
	</table>
	</form>

	</div>
</div>
</body>
</html>
