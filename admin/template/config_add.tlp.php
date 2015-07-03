<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(2,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>系统设置</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
			<li> <a href="<?php echo ADMIN_FILE;?>?file=config&action=config&tab=1"><?php echo $lang['LEFT-SYSTEM-2'];?></a></li>
			<li> <a href="<?php echo ADMIN_FILE;?>?file=config&action=config&tab=2"><?php echo $lang['LEFT-SYSTEM-3'];?></a></li>
			<li> <a href="<?php echo ADMIN_FILE;?>?file=config&action=config&tab=3"><?php echo $lang['LEFT-SYSTEM-4'];?></a></li>
			<li> <a href="<?php echo ADMIN_FILE;?>?file=config&action=config&tab=6"><?php echo $lang['LEFT-SYSTEM-6'];?></a></li>
			<li> <a href="<?php echo ADMIN_FILE;?>?file=config&action=config&tab=7"><?php echo $lang['LEFT-SYSTEM-7'];?></a></li>
			<li><a href="javascript:void(0);" class="on"><?php echo $lang['LEFT-SYSTEM-19'];?></a></li>			
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		1：变量名称由a-z,0-9以及下划线组成，且不能为空不能重复； 2：变量值支持HTML；3：模板调用方法： {$RETENG['变量名称']} 。
	</fieldset>
	<form action="" method="post" name="myform">
	<input type="hidden" name="do_submit" value="1" />
	<table cellspacing="0" class="sub" width="98%">
		<tr>
			<td width="158" align="right">所属组：</td>
			<td width="1127">
			<select name="info[groupid]">
				<option value="1" selected="selected">基本配置</option>
				<option value="2">上传配置</option>
				<option value="3">邮件配置</option>
				<option value="6">性能选项</option>
				<option value="7">拓展功能</option>
			</select>
		  </td>
		</tr>
		<tr>
			<td width="158" align="right">中文名称：</td>
			<td>
			<input type="text" name="info[desc]" size="20" />
			</td>
		</tr>
		<tr>
			<td width="158" align="right">变量名称：</td>
			<td>
			<input type="text" name="info[varname]" datatype="table" size="20" />
			<span>该项应由2-30个英文，数字，下划线组成</span>
			</td>
		</tr>
		<tr>
			<td align="right">变量类型：</td>
			<td>
		<input name="info[type]" type="radio"  value="string" checked='checked' />
        文本
        <input name="info[type]" type="radio"  value="number" />
        数字
        <input name="info[type]" type="radio" value="bool" />
        布尔(Y/N)
        <input name="info[type]" type="radio"value="bstring" />
        多行文本
		<input name="info[type]" type="radio"value="sueditor" />
        编辑器
		<input name="info[type]" type="radio"value="image" />
        图片上传
			</td>
		</tr>
		<tr>
			<td width="158" align="right">变量说明：</td>
			<td>
			<input type="text" name="info[alt]" size="40" />
			</td>
		</tr>
		<tr>
			<td width="158" align="right">变量值：</td>
			<td>
			<textarea name="info[value]" cols="60" rows="4"></textarea>
			</td>
		</tr>
		<tr class="bg2"><td></td><td><input type="button" class="button" onclick="doSubmit(this);" value="保存变量" /> <input type="button" class="button" onclick="window.location.href='<?php echo ADMIN_FILE;?>?file=config&action=config&tab=1'" value="取消返回" /></td></tr>
	</table>
	</form>

	</div>
</div>
</body>
</html>
