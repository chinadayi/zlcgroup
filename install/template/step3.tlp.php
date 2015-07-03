<?php
	!defined('RETENG_INSTALL') && exit('Access Denied!');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="template/images/style.css" />
<title><?php echo RETENG_VERSION;?> 安装向导</title>
<script language="JavaScript" src="../images/js/jquery.min.js"></script>
</head>
<body>
<div class="main">
	<div class="sidebar">
		<div class="logo" title="<?php echo RETENG_VERSION;?> 安装向导"><a href="http://cms.reteng.org/" target="_blank"></a></div>
		<div class="step">
			<ul class="done">
				<li class="statusdot"></li>
				<li class="name">1、软件使用授权许可协议</li>
			</ul>
			<ul class="done">
				<li class="statusdot"></li>
				<li class="name">2、环境以及文件目录权限检查</li>
			</ul>
			<ul class="current">
				<li class="statusdot"></li>
				<li class="name">3、数据库连接参数设置</li>
			</ul>
			<ul>
				<li class="statusdot"></li>
				<li class="name">4、执行数据库安装</li>
			</ul>
			<ul>
				<li class="statusdot"></li>
				<li class="name">5、完成安装</li>
			</ul>
		</div>
	</div>
	<div class="main">
		<div class="version">程序版本：<?php echo RETENG_VERSION,'&nbsp;',RETENG_RELEASE;?></div>
		<div class="bg_center">
			<div class="bg_left">
				<div class="bg_right">
					<div class="content">
					<br />
					<form id="install" action="index.php?" method="post">
					<input type="hidden" name="step" value="4">
					<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;数据库信息</strong>
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="150" align="right" height="35">数据库服务器：</td>
							<td><input type="text" name="config[db_host]" id="db_host" class="input" maxlength="50" size="25" value="<?php echo DB_HOST;?>" /></td>
							<td>一般为localhost</td>
						</tr>
						<tr>
							<td align="right" height="35">数据库名称：</td>
							<td colspan="2"><input type="text" name="config[db_name]" id="db_name" class="input" maxlength="20" size="25" value="<?php echo DB_NAME;?>" /></td>
						</tr>
						<tr>
							<td align="right" height="35">数据库用户名：</td>
							<td colspan="2"><input type="text" name="config[db_user]" id="db_user" class="input" maxlength="20" size="25" /></td>
						</tr>
						<tr>
							<td align="right" height="35">数据库密码：</td>
							<td colspan="2"><input type="text" name="config[db_psw]" id="db_psw" class="input" maxlength="20" size="25" value="<?php echo DB_PSW;?>" /></td>
						</tr>
						<tr>
							<td align="right" height="35">数据表前缀：</td>
							<td><input type="text" name="config[db_pre]" id="db_pre" class="input" maxlength="20" size="25" value="<?php echo DB_PRE;?>" /></td>
							<td>建议使用默认，同一数据库安装多个ReTengCMS时需修改</td>
						</tr>
						<tr>
							<td align="right" height="35">启用持久连接：</td>
							<td colspan="2">
								<label><input name="config[db_pconnect]"  type="radio" value="1" />启用</label>
								<label><input name="config[db_pconnect]" checked="checked" type="radio" value="0" />不启用
								<input name="" type="hidden" value="" />
								</label>
                                </td>
						</tr>
 						<tr>
							<td align="right" height="35">安装类型：</td>
							<td colspan="2">
<input name="withdata"  checked="checked"  type="radio" value="0" />	
全新安装
                          </td>
						</tr>
					</table>
					<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;创始人信息</strong>
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="150" align="right" height="35">管理员帐号：</td>
							<td align="left" colspan="2"><input type="text" name="username" id="username" class="input" maxlength="20" size="25" value="admin" /></td>
						</tr>
						<tr>
							<td align="right" height="35">密码：</td>
							<td colspan="2"><input type="text" name="password" id="password" class="input" maxlength="20" size="25" /></td>
						</tr>
						<tr>
							<td align="right" height="35">重复密码：</td>
							<td colspan="2"><input type="text" name="pwdconfirm" id="pwdconfirm" class="input" maxlength="20" size="25"/></td>
						</tr>
						<tr>
							<td align="right" height="35">E-mail：</td>
							<td colspan="2"><input type="text" name="email" value="master@reteng.org" id="email" class="input" maxlength="20" size="25"/></td>
						</tr>
						<tr>
							<td align="right" height="35">密码加固密钥：</td>
							<td><input type="text" name="password_key" class="input" value="<?php echo PASSWORD_KEY;?>" maxlength="20" size="25"/></td>
							<td>建议使用默认，如果是数据搬家请与搬家前保持一致</td>
						</tr>
					</table>
					<table width="100%"><tr>
					<td width="80" height="80">&nbsp;</td>
					<td align="right"><input type="button" onClick="javascript:history.back(-1);" value="上一步" class="btn" /></td>
					<td align="left"><input type="button" onClick="return checkform();" value="下一步" class="btn" /></td>
					<td width="80">&nbsp;</td>
					</tr></table>
					</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="foot">&copy; 2014 ReTengCMS 热腾网 </div>
</body>
</html>
<script language="JavaScript" type="text/javascript">
<!--
var errmsg = new Array();
errmsg[0] = '您已经安装过ReTengCMS，系统会自动删除老数据！是否继续安装？';
errmsg[2] = '无法连接数据库服务器，请联系空间商获取数据库参数或登录http://cms.reteng.org寻求帮助！';
errmsg[3] = '成功连接数据库，但是指定的数据库不存在并且无法自动创建，请联系空间商获取数据库参数或登录http://cms.reteng.org寻求帮助！';
errmsg[6] = '数据库版本低于Mysql 5.0，无法安装ReTengCMS，请升级数据库版本或登录http://cms.reteng.org寻求帮助！';

function checkform() 
{
	if($('#username').val().length<2 || $('#username').val().length>30)
	{
		alert('管理员帐号不能少于2个字符或者大于20个字符');
		$('#username').focus();
		return false;
	}
	if($('#password').val().length<6 || $('#username').val().length>30)
	{
		alert('管理员密码不能少于6个字符或者大于20个字符');
		$('#password').focus();
		return false;
	}
	if($('#password').val()!=$('#pwdconfirm').val())
	{
		alert('两次输入密码不一致！');
		$('#pwdconfirm').val()='';
		$('#pwdconfirm').focus();
		return false;
	}
	if($('#email').val()=='')
	{
		alert('请输入E-mail！');
		$('#email').focus();
		return false;
	}
	else
	{
		var emailPattern = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
		if (emailPattern.test($('#email').val())==false)
		{
			alert('请填写正确的E-mail！');
			$('#email').val()='';
			$('#email').focus();
			return false;
		}
	}

	var url = '?step=checkdb&dbhost='+$('#db_host').val()+'&dbuser='+$('#db_user').val()+'&dbpw='+$('#db_psw').val()+'&dbname='+$('#db_name').val()+'&tablepre='+$('#db_pre').val()+'&sid='+Math.random()*5;
    $.get(url, function(data){
		if(isNaN(data))
		{
			if(confirm("ReTengCMS安装出现异常,可能是空间或者环境问题导致！\n\n您也可以继续选择强制安装，点击【确定】强制安装"))
			{
				$('#install').submit();
			}
			else
			{
				return false;
			}
		}
		
		if(data > 1)
		{
			alert(errmsg[data]);
			return false;
		}
		else if(data == 1 || (data == 0 && confirm(errmsg[0])))
		{
			$('#install').submit();
		}
	});
    return false;
}
//-->
</script>
