<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('gather',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Ԥ</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script src="images/js/jquery.min.js" charset=utf-8></script>
</head>
<body>
<div id="wrap">
	<div class="tab">
	<ul>
		<li><a href="?mod=gather&file=gather&action=content">ʱ</a></li>
		<li><a href="javascript:void(0);" class="on">Ԥ</a></li>
	</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		Ԥ
		</fieldset>
		<table width="100%">
		<tr><td>
			<table class="sub" width="98%" cellpadding="0" cellspacing="0">
				<?php foreach($fields as $field){ if(!$field['disabled']){?>
				<tr>
					<td width="152" align="right" valign="top" style="color:#999999"><?php echo $field['name'];?></td>
					<td width="1129"><?php echo $gather->getcon($id,$field['form']);?> <?php echo $field['unit'];?>&nbsp;</td>
				</tr>
				<?php }}?>
			</table>
			</td>
		</tr>
		<tr>
			<td align="center">
			<input type="button" onfocus="blur();" name="3" value="ȡ" class="button" onclick="javascript:history.back();" style="margin-left:10px" />
			</td>
		</tr>
	</table>
	</div>
</div>
</body>
</html>
