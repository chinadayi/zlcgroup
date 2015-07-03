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
			<li><a href="?file=html&action=category"><?php echo $lang['LEFT-HTML-9'];?></a></li>
			<li><a href="javascript:void(0);" class="on"><?php echo $lang['LEFT-HTML-10'];?></a></li>	
		</ul>
	</div>
	<div class="main">
		<fieldset>
			<legend><?php echo $lang['RETURN_TIPS'];?></legend>
			注意：如果想更新某个栏目，必须选中该栏目。
		</fieldset>
		<table cellspacing="0" class="sub" width="98%">
		<td width="27%"><form action="" method="post" name="myform">
		<input type="hidden" name="do_submit" value="1" />
		<input type="hidden" name="type" id="type" value="all" />
		<tr>
			<td align="right" valign="top">选择栏目</td>
			<td width="73%">
		<select name="catid[]" multiple="multiple" size="15" style="width:400px">
			<option value="0" selected="selected">所有栏目</option>
			<?php $options->htmlconoptions(0,array(0),array(1));?>
		</select>
		</td>
		</tr>
		<tr>
			<td align="right" valign="top">每轮更新信息条数：</td>
			<td><input type="text" name="pagesize" size="4" value="50" /> 条 <input type="checkbox" value="1" name="inlink" />同时更新内链</td>
		</tr>
		<tr>
			<td align="right" valign="top">开始更新所有信息：</td>
			<td><input type="button" value="开始更新" name="dosubmit1" onclick="javascript:$('#type').val('all');this.form.submit();" class="button" /></td>
		</tr>
		<tr>
			<td align="right" valign="top">更新最近的 
		  <input type="text" name="number" size="4" value="100" /> 条信息：</th>
		  <td><input type="button" value="开始更新" name="dosubmit2" onclick="javascript:$('#type').val('realate');this.form.submit();" class="button" /></td>
		</tr>
		<tr>
			<td align="right" valign="top">更新内容ID
		  <input type="text" name="fromid" size="4" value="1" /> 到 <input type="text" name="toid" size="4"  value="500" /> 的信息： </td>
			<td> <input type="button" value="开始更新" name="dosubmit3" onclick="javascript:$('#type').val('limit');this.form.submit();" class="button" /></td>
		</tr>
		</table>
	</div>
</div>
</body>
</html>
