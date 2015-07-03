<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('gather',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>导出节点</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script src="images/js/jquery.min.js" charset=utf-8></script>
<script language="javascript" src="admin/template/js/css.js"></script>
<script type="text/javascript" src="admin/template/js/admin.js"></script>
</head>
<body>
<div id="wrap">
	<div class="tab">
	<ul>
		<li><a href="javascript:void(0);" class="on">导出节点</a></li>
	</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		以下为规则 [<?php echo $export['name'];?>] 的文本配置，你可以共享给你的朋友：
		</fieldset>
		<table width="100%">
		<tr>
			<td align="center">
			<textarea id="exportarea" readonly="readonly" onselect="javascript:copy($('#exportarea').val());" style='width:95%;height:450px;word-wrap: break-word;word-break:break-all;'><?php echo $export['export'];?></textarea>
			</td>
		</tr>
		<tr>
			<td align="center">
			<input type="button" onfocus="blur();" name="1" value="复制规则" class="button" onclick="javascript:copy($('#exportarea').val());" />
			<input type="button" onfocus="blur();" name="3" value="取消返回" class="button" onclick="javascript:history.back();" style="margin-left:10px" />
			</td>
		</tr>
	</table>
	</form>
	</div>
</div>
</body>
</html>
