<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('member',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>预览模型</title>
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
			<li><a href="?mod=member&file=member&action=model"><?php echo $lang['MODEL-LANG-1'];?></a></li>
			<li><a href="?mod=member&file=member&action=model_install"><?php echo $lang['MODEL-LANG-2'];?></a></li>
			<li><a href="javascript:void(0);" class="on"><?php echo $lang['MODEL-LANG-4'];?></a></li>			
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend>操作提示</legend>
		模型预览不能进行任何操作。
	</fieldset>
	<form name="myform">
	<table cellspacing="0" class="sub" width="98%">
		<?php if($forms)foreach($forms as $val){ ?>
		<tr>
			<td width="150" align="right" valign="top"><?php echo $val['name'];?>：</td>
			<td>
			<?php echo $val['form'];?> <?php echo $val['unit']?$val['unit']:'';?>
			<span><?php echo $val['tips'];?></span>
			</td>
		</tr>
		<?php }?>
		<tr class="bg2"><td></td><td><input type="button" class="button" onclick="alert('预览状态不能操作!');" value="注册会员" /> <input type="button" class="button" onclick="window.location.href='<?php echo ADMIN_FILE;?>?mod=member&file=member&action=model'" value="取消返回" /></td></tr>
	</table>
	</form>
	</div>
</div>
</body>
</html>
