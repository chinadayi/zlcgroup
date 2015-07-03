<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(12,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $lang['LEFT-TEMPLATE-3'];?></title>
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
function insertText(text)
{	
	document.getElementById("content").focus();
    var str = document.selection.createRange();
	str.text = text;
}
</script>
</head>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="?file=template&action=project"><?php echo $lang['LEFT-TEMPLATE-1'];?></a></li>
			<li><a href="?file=template&action=manage&project=<?php echo $project;?>"><?php echo $lang['LEFT-TEMPLATE-2'];?></a></li>
			<li><a href="javascript:void(0);" class="on"><?php echo $lang['LEFT-TEMPLATE-3'];?></a></li>			
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		1：模板名称不能为空； 2：文件名称由2-30个英文，数字，下划线组成。
	</fieldset>
	<form action="" method="post" name="myform">
	<input type="hidden" name="do_submit" value="1" />
	<input type="hidden" name="info[project]" value="<?php echo $project;?>">
	<table cellspacing="0" class="sub">
		<tr>
			<td width="8%" align="left" style="padding-left:10px">模板名称：</td>
			<td width="92%">
			<input type="text" name="info[name]" datatype="limit" min="2" max="100" size="20" />
		  </td>
		</tr>
		<tr>
			<td width="8%" align="left" style="padding-left:10px">文件名称：</td>
			<td width="92%">
			<input type="text" name="info[template]"  id="template" onblur="$.get('<?php echo ADMIN_FILE;?>?file=template&project=<?php echo $project;?>&action=check',{data:this.value},function(data){if(data=='yes'){if(!confirm('该模板已经存在, 保存的话将会覆盖原有文件, 继续?')){$('#template').val('');$('#template').focus();}}});" datatype="english" size="16" />
			.htm</td>
		</tr>
		<tr>
			<td colspan="2">
			<p style="margin:8px">
				<input type="button" value="loop循环" class="button" onClick="javascript:if(this.value != '') insertText('{loop $data $key $val}\n{$key}:{$val}\n{/loop}\n')" />
				<input type="button" value="if 分支" class="button" onClick="javascript:if(this.value != '') insertText('{if $var1 == $var2}\n\n{/if}\n')" />
				<input type="button" value="elseif" class="button" onClick="javascript:if(this.value != '') insertText('{elseif $a == $b}\n')" />
				<input type="button" value="else" class="button" onClick="javascript:if(this.value != '') insertText('{else}\n')" />
				<input type="button" value="template" class="button" onClick="javascript:if(this.value != '') insertText('{tlp \'模板文件名\'}\n')" />
				<input type="button" value="include" class="button" onClick="javascript:if(this.value != '') insertText('{include RETENG_ROOT.\'php文件名\'}\n')" />
			</p>
			<textarea name='info[content]' id="content" style="width:96%;height:450px; margin:8px; font-family:'宋体'"></textarea>
			</td>
		</tr>
		<tr class="bg2"><td colspan="2" align="center"><input type="button" class="button" onclick="doSubmit(this);" value="保存模板" /> <input type="button" class="button" onclick="window.location.href='?file=template&action=manage&project=<?php echo $project;?>'" value="取消返回" /></td></tr>
	</table>
	</form>

	</div>
</div>
</body>
</html>
