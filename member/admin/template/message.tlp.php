<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('member',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>系统信息</title>
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
			<li><a href="javascript:void(0);" class="on">发送信息</a></li>			
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend>操作提示</legend>
		1：信息主题不能为空； 2：信息内容不能为空。
	</fieldset>
	<form action="" method="post" name="myform">
	<input type="hidden" name="do_submit" value="1" />
	<input type="hidden" name="info[folder]" value="inbox" />
	<input type="hidden" name="info[hasread]" value="0" />
	<input type="hidden" name="info[message_time]" value="<?php echo TIME;?>" />
	<input type="hidden" name="info[send_to_user]" value="#system#" />
	<input type="hidden" name="info[send_from_user]" value="<?php echo $RETENG['site_name'];?>" />
	<table cellspacing="0" class="sub">
		<tr>
			<td width="80" align="right">信息主题：</td>
			<td>
			<input type="text" name="info[subject]" size="55" datatype="limit" min="2" max="25"/>
			</td>
		</tr>
		<tr>
			<td align="right">信息内容：</td>
			<td>
			<?php echo $form->baidueditor('content');?>
			</td>
		</tr>
		<tr class="bg2"><td></td><td><input type="button" class="button" onclick="doSubmit(this);" value="发送信息" /> <input type="button" class="button" onclick="window.location.href='<?php echo ADMIN_FILE;?>?mod=member&file=member&action=manage'" value="取消返回" /></td></tr>
	</table>
	</form>

	</div>
</div>
</body>
</html>
