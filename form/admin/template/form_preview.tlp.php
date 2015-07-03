<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('form',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>预览表单</title>
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
			<li><a href="?mod=form&file=form&action=manage">自定义表单</a></li>
			<li><a href="javascript:void(0);" class="on">预览表单</a></li>			
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend>操作提示</legend>
		表单预览不能进行添加等操作。
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
		<tr class="bg2"><td></td><td><input type="button" class="button" onclick="alert('预览状态不能操作!');" value="保存内容" /> <input type="button" class="button" onclick="window.location.href='<?php echo ADMIN_FILE;?>?mod=form&file=form&action=manage'" value="取消返回" /></td></tr>
	</table>
	</form>
	</div>
</div>
</body>
</html>
