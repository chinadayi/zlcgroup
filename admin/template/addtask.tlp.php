<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('gather',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>节点管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script language="javascript" src="admin/template/js/css.js"></script>
<script type="text/javascript" src="admin/template/js/admin.js"></script>
<script src="images/js/check.func.js"></script>
<script language="javascript" type="text/javascript">
$(document).ready(function(){
	checkForm(0);
});
$(function () {
	$(".tab a").each(function () {
		$(this).click(function () {
			$(".tab a").each(function(){
				$(this).attr('class','');
				$("#tab_" + $(this).attr('id')).css('display','none');
			});
			$(this).attr('class', 'on');
			$("#tab_" + $(this).attr('id')).css('display','block');

		});
	});
});
</script>
</head>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="?mod=gather&file=gather&action=task">服务端任务管理</a></li>
			<li><a href="?mod=gather&file=gather&action=addtask" class="on">添加计划任务</a></li>
	

		</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		<b style="color:#FF0000">注意事项</b>：开启服务端计划任务必须要求服务器的配置是apache,否则会失效。服务端计划任务一旦开启，将一直在服务端运行，可能比较消耗服务器内存，建议vps或者虚拟主机不要使用，
		<br />
		</fieldset>
		<form action="" method="post" name="myform">
	<input type="hidden" name="do_submit" value="1" />
	<table cellspacing="0" class="sub" width="100%">
		<tr>
			<td width="191" align="right">任务名称：</td>
			<td width="1120">
			<input type="text" name="info[name]" datatype="limit" min="1" max="80" class="input" size="20" />
		  </td>
		</tr>
		<tr>
			<td width="191" align="right">执行网址：</td>
			<td><input type="text" name="info[url]"  atatype="limit" min="1" max="80"  class="input" size="50" />
		  </td>
		</tr>
		<tr class="bg2"><td></td><td>
		<input type="button" class="button" onclick="this.form.target='_self';this.form.action='admin.php?mod=gather&file=gather&action=savetask';doSubmit(this);"  value="添加任务" /> 
		<input type="button" class="button" onclick="window.location.href='?mod=gather&file=gather&action=task'" value="取消返回" /></td></tr>
	</table>
	</form>

  </div>
</div>
</body>
</html>
