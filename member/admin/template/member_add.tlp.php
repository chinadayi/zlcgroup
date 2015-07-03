<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('member',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>添加会员</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<?php include 'ueditor.js.php';?>
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
			<li><a href="?mod=member&file=member&action=manage&level=1">已审会员</a></li>
			<li><a href="?mod=member&file=member&action=manage&level=0">待审会员</a></li>	
			<li><a href="?mod=member&file=member&action=member_add" class="on">添加会员</a></li>			
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend>操作提示</legend>
		1：用户名由1-30位中文，数字，字母，下划线组成 ；2：密码由3-20位之间的数字，字母，下划线组成 
	</fieldset>
	<form action="" method="post" name="myform">
	<input type="hidden" name="do_submit" value="1" />
	<table cellspacing="0" class="sub">
		<tr>
			<td width="80" align="right">会员模型：</td>
			<td>
			<select name="info[modelid]">
			<?php
				if($modelinfo)foreach($modelinfo as $_r)
				{
					echo '<option value="'.$_r['id'].'">'.$_r['name'].'</option>';
				}
			?>
			</select>
			</td>
		</tr>
		<tr>
			<td width="80" align="right">会 员 名：</td>
			<td>
			<input type="text"  size="25" name="info[username]" datatype="userName" />
			</td>
		</tr>
		<tr>
			<td width="80" align="right">会员密码：</td>
			<td>
			<input type="password" size="25"  name="info[password]" datatype="usePsw" />
			</td>
		</tr>
		<tr>
			<td width="80" align="right">电子邮箱：</td>
			<td>
			<input type="text" datatype="email" size="25" name="info[email]" />
			</td>
		</tr>
		<tr class="bg2"><td></td><td><input type="button" class="button" onclick="doSubmit(this);" value="保存用户" /> <input type="button" class="button" onclick="window.location.href='<?php echo ADMIN_FILE;?>?mod=member&file=member&action=manage&ispassed=0'" value="取消返回" /></td></tr>
	</table>
	</form>

	</div>
</div>
</body>
</html>
