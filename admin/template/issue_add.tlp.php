<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>发布点管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
			<li><a href="?file=sitecrowd&action=issue">发布点管理</a></li>
			<li><a href="javascript:void(0);" class="on">添加发布点</a></li>			
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		1：主目录由1-30个字母、数字、下划线组成； 2：发布点名称不能为空。
	</fieldset>
	<form action="" method="post" name="myform">
	<input type="hidden" name="do_submit" value="1" />
	<table cellspacing="0" class="sub">
		<tr>
			<td width="200" align="right">发布点名称：</td>
			<td><input type="text"  name="info[issuename]" value="新建发布点" size="25" datatype="limit" min="1" max="80" /></td>
		</tr>
		<tr>
			<td width="200" align="right">启用 SSL 连接： </td>
			<td>
			 <input type="radio" class="radio" name="info[ftpssl]" value="1" /> 开启
			 <input type="radio" class="radio" name="info[ftpssl]" value="0" checked="checked"/> 关闭
			</td>
		</tr>
		<tr>
			<td width="200" align="right">FTP 服务器地址：</td>
			<td><input type="text" name="info[ftphost]" size="30" datatype="limit" min="1" max="32" /> 
			<span>可以是 FTP 服务器的 IP 地址或域名</span></td>
		</tr>
		<tr>
			<td width="200" align="right">FTP 服务器端口：</td>
			<td><input type="text" name="info[ftpport]" value="21" size="6" datatype="integer" /> <span>默认为21，一般不需要改</span></td>
		</tr>
		<tr>
			<td width="200" align="right">FTP 帐号：</td>
			<td>
			<input type="text" name="info[ftpuser]" size="20" datatype="limit" min="1" max="64"/>
			<span>该帐号必需具有以下权限：读取文件、写入文件、删除文件、创建目录、子目录继承</span>
			</td>
		</tr>
		<tr>
			<td width="200" align="right">FTP 密码：</td>
			<td>
			<input type="password" name="info[ftppwd]" size="20" datatype="limit" min="1" max="64"/>
			</td>
		</tr>
		<tr>
			<td width="200" align="right">启用被动模式： </td>
			<td>
			 <input type="radio" class="radio" name="info[ftppasv]" value="1" /> 开启
			 <input type="radio" class="radio" name="info[ftppasv]" value="0" checked="checked" /> 关闭
			</td>
		</tr>
		<tr>
			<td width="200" align="right">主目录：</td>
			<td>
			<input type="text" name="info[ftpdir]" size="8" value="./"   datatype="limit" min="1" max="32"/>
			<span>远程目录的绝对路径或相对于 FTP 主目录的相对路径，结尾不要加斜杠 "/" , ./ 表示FTP根目录</span>
			</td>
		</tr>
		<tr class="bg2"><td></td><td><input type="button" class="button" onclick="doSubmit(this);" value="保存发布点" /> <input type="button" class="button" onclick="window.location.href='<?php echo ADMIN_FILE;?>?file=sitecrowd&action=issue'" value="取消返回" /></td></tr>
	</table>
	</form>

	</div>
</div>
</body>
</html>
