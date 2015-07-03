<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(8,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $lang['LEFT-HTML-9'];?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script type="text/javascript" src="admin/template/js/admin.js"></script>
</head>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="?file=html&action=cache"><?php echo $lang['LEFT-HTML-1'];?></a></li>
			<li><a href="javascript:void(0);" class="on"><?php echo $lang['LEFT-HTML-9'];?></a></li>
			<li><a href="?file=html&action=content"><?php echo $lang['LEFT-HTML-10'];?></a></li>	
		</ul>
	</div>
	<div class="main">
		<fieldset>
			<legend><?php echo $lang['RETURN_TIPS'];?></legend>
			注意：如果想更新某个栏目，必须选中该栏目。
		</fieldset>
		<table cellspacing="0" class="sub" width="98%">
		<td width="13%"><form action="" method="post" name="myform">
		<input type="hidden" name="do_submit" value="1" />
		<tr>
			<td align="right" valign="top">选择栏目</td>
			<td width="87%">
		<select name="catid[]" multiple="multiple" size="15" style="width:400px">
			<option value="0" selected="selected">所有栏目</option>
			<?php $options->htmlcatoptions(0,array(0),array(1,2));?>
		</select>
		</td>
		</tr>
		
		<tr>
			<td></td>
			<td align="left">
			<input type="submit" class="button" value="开始更新选中栏目" />
			</td>
		</tr>
		</table>
	</div>
</div>
</body>
</html>
