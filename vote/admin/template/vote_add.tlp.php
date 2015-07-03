<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('vote',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>投票管理</title>
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
var i = 2;
function option_add()
{
	var data = '<div id="option'+i+'" style="clear:both">'+i+'：<input type="text" name="votenote['+i+']" class="inputtitle" size="35" /> <a href="javascript:void(0);" onclick="option_del('+i+')"><u>删除</u></a></div>';
	$('#option_define').append(data);
	i++;
	return true;
}

function option_del(i)
{
	$('#option'+i).remove();
	return true;
}
</script>
</head>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="?mod=vote&file=vote&action=manage">投票管理</a></li>
			<li><a href="javascript:void(0);" class="on">添加投票</a></li>			
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend>操作提示</legend>
		1：投票名称不能为空
	</fieldset>
	<form action="" method="post" name="myform">
	<input type="hidden" name="do_submit" value="1" />
	<table cellspacing="0" class="sub">
		<tr>
			<td width="140" align="right">投票名称：</td>
			<td><input type="text" name="info[votename]" size="35" datatype="limit" min="2" max="100" /></td>
		</tr>
		<tr>
			<td width="140" align="right">开始时间：</td>
			<td><input type="text" name="info[starttime]" value="<?php echo date('Y-m-d');?>"  size="10" datatype="limit" min="2" max="100" /></td>
		</tr>
		<tr>
			<td width="140" align="right">结束时间：</td>
			<td><input type="text" name="info[endtime]" value="<?php echo date('Y-m-d',time()+3600*24*30);?>" size="10" datatype="limit" min="2" max="100" /></td>
		</tr>
		<tr>
			<td width="140" align="right">重复投票间隔：</td>
			<td><input type="text" name="info[delay]" value="24" size="4" datatype="integer" /> 小时</td>
		</tr>
		<tr>
			<td width="140" align="right">是否多选：</td>
			<td>
			<input type="radio" class="radio"  name="info[ismore]" value="1"/>是  
			<input type="radio" class="radio"  name="info[ismore]" checked="checked" value="0"/>否</td>
		</tr>
		<tr>
			<td width="140" align="right" valign="top">投 票 项：</td>
			<td>
			<input type="button" value="增加投票选项" onclick="option_add()" class="button" />
			<br /><br />
			1：<input type="text" name="votenote[1]" size="35" />
			<span id="option_define"></span>
			</td>
		</tr>
		<tr class="bg2"><td></td><td><input type="button" class="button" onclick="doSubmit(this);" value="保存投票" /> <input type="button" class="button" onclick="window.location.href='<?php echo ADMIN_FILE;?>?mod=vote&file=vote&action=manage'" value="取消返回" /></td></tr>
	</table>
	</form>

	</div>
</div>
</body>
</html>
