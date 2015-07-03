<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('pay',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>支付按钮</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script language="javascript" src="admin/template/js/css.js"></script>
<script type="text/javascript" src="admin/template/js/admin.js"></script>
</head>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="?mod=pay&file=pay&action=paymethod">支付配置</a></li>
			<li><a href="javascript:void(0);" class="on">支付按钮</a></li>			
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend>操作提示</legend>
		如果支付测试失败，请保证您的支付参数配置的正确性！
	</fieldset>
	<table cellspacing="0" class="sub">
		<tr>
			<td width="80" align="right">按钮代码：</td>
			<td>
			<textarea cols="100" id="code" rows="8"><?php echo htmlspecialchars($paybutton);?></textarea>
			<span><br /><br />您可以直接将以上代码粘贴到模板中实现在线支付功能!如果支付测试失败, 请保证您的支付参数配置的正确性!</span>
			</td>
		</tr>
		<tr>
			<td width="80" align="right">按钮预览：</td>
			<td>
			<?php echo $paybutton;?>
			</td>
		</tr>
		<tr class="bg2"><td></td><td> <input type="button" class="button" onclick="javascript:copy($('#code').val());" value="复制代码" /> <input type="button" class="button" onclick="window.open('<?php echo $payurl;?>')" value="测试支付按钮" /> <input type="button" class="button" onclick="window.location.href='<?php echo ADMIN_FILE;?>?mod=pay&file=pay&action=paymethod_button'" value="取消返回" /></td></tr>
	</table>

	</div>
</div>
</body>
</html>
