<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(3,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $lang['LEFT-SYSTEM-10'];?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script src="images/js/check.func.js"></script>
<script type="text/javascript" src="admin/template/js/css.js"></script>
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
			<li><a href="?file=admin&action=role"><?php echo $lang['LEFT-SYSTEM-9'];?></a></li>
			<li><a href="?file=admin&action=manage&roleid=<?php echo $roleid;?>"><?php echo $lang['LEFT-SYSTEM-10'];?></a></li>
			<li><a href="javascript:void(0);" class="on"><?php echo $lang['LEFT-SYSTEM-16'];?></a></li>			
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		1：管理员名称不能为空； 2：所属角色必须选择。
	</fieldset>
	<form action="" method="post" name="myform">
	<input type="hidden" name="do_submit" value="1" />
	<input type="hidden" name="newadmin[roleid]" value="<?php echo $roleid;?>" />
	<table cellspacing="0" class="sub">
		<tr>
			<td width="100" align="right">管理账号：</td>
			<td>
			<input type="text" name="newadmin[username]" id="username" datatype="userName"  onblur="$.post('?file=admin&action=checkusername',{data:this.value},function(data){if(data=='yes'){alert('该管理账户已存在或者不可用, 请更换!');$('#username').val('');$('#username').focus();}});"  size="20" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right">管理密码：</td>
			<td>
			<input type="password" name="newadmin[password]" datatype="userPsw" size="20" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right">栏目权限：</td>
			<td>
			<select name="newadmin[category][]" multiple="multiple" size="15">
				<option value="0" selected="selected">所有栏目</option>
				<?php $options->catoptions(0,array(0));?>
			</select>
			<span>按着 Ctrl 可以多选,超级管理员不用选择即拥有全部权限!</span>
			</td>
		</tr>
		<tr>
			<td align="right">安全策略：</td>
			<td>
			<input type="checkbox" class="checkbox" value="1" name="newadmin[allowmultilogin]" checked="checked" />允许多人同时使用此帐号登录
			</td>
		</tr>
		<tr>
			<td align="right">启用帐号：</td>
			<td>
			<input type="radio" value="0" class="radio" checked="checked" name="newadmin[disabled]" />启用 
			<input type="radio" value="1" class="radio" name="newadmin[disabled]" />禁用
			</td>
		</tr>
		<tr class="bg2"><td></td><td><input type="button" class="button" onclick="doSubmit(this);" value="保存管理员" /> <input type="button" class="button" onclick="window.location.href='<?php echo ADMIN_FILE;?>?file=admin&action=manage&roleid=<?php echo $roleid;?>'" value="取消返回" /></td></tr>
	</table>
	</form>

	</div>
</div>
</body>
</html>
