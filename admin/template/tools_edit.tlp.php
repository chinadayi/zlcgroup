<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('workbox',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>工具管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script language="javascript" src="admin/template/js/css.js"></script>
<script src="images/js/check.func.js"></script>
<script language="javascript" type="text/javascript">
	$(document).ready(function(){
		checkForm(0);
		$('#style').val("<?php echo $toolsinfo['style'];?>");
	});
</script>
</head>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="?mod=workbox&file=workbox&action=workbox">工具管理</a></li>
			<li><a href="?mod=workbox&file=workbox&action=tools&boxid=<?php echo $info['boxid'];?>">选项管理</a></li>
			<li><a href="javascript:void(0);" class="on">编辑选项</a></li>
			<li><a href="?mod=workbox&file=workbox&action=tag">模板调用</a></li>
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		1：选项名称不能为空； 2：选项排序应为数字。
	</fieldset>
	<form action="" method="post" name="myform">
	<input type="hidden" name="do_submit" value="1" />
	<input type="hidden" name="id" value="<?php echo $id;?>" />
	<table cellspacing="0" class="sub">
		<tr>
			<td width="80" align="right">选项名称：</td>
			<td>
			<input type="text" name="info[name]" datatype="limit" value="<?php echo $toolsinfo['name'];?>" min="1" max="80" size="20" />
			</td>
		</tr>
		<tr>
			<td width="80" align="right">字体颜色：</td>
			<td>
			<select name="info[style]" id="style">
				<option value="">字体颜色</option>
				<option style="background-color:#000000;" value="#000000"></option>
				<option style="background-color:#333333;" value="#333333"></option>
				<option style="background-color:#660033;" value="#660033"></option>
				<option style="background-color:#0000FF;" value="#0000FF"></option>
				<option style="background-color:#FFCC00;" value="#FFCC00"></option>
				<option style="background-color:#0066cc;" value="#0066cc"></option>
				<option style="background-color:#cc0000;" value="#cc0000"></option>
				<option style="background-color:#FFFFFF;" value="#FFFFFF"></option>
				<option style="background-color:#FF0000;" value="#FF0000"></option>
				<option style="background-color:#00FF00;" value="#00FF00"></option>
			</select>
			</td>
		</tr>
		<tr>
			<td width="80" align="right">选项图片：</td>
			<td>
			<?php echo $form->image('image',$toolsinfo['image']);?>
			</td>
		</tr>
		<tr>
			<td align="right">链接地址：</td>
			<td>
			<input type="text" size="36" value="<?php echo $toolsinfo['url'];?>" datatype="url" name="info[url]" />
			</td>
		</tr>
		<tr class="bg2"><td></td><td><input type="button" class="button" onclick="doSubmit(this);" value="保存选项" /> <input type="button" class="button" onclick="window.location.href='?mod=workbox&file=workbox&action=workbox'" value="取消返回" /></td></tr>
	</table>
	</form>

	</div>
</div>
</body>
</html>
