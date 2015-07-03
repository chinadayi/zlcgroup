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
</script>
</head>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="?mod=vote&file=vote&action=manage">投票管理</a></li>
			<li><a href="?mod=vote&file=vote&action=vote_add">添加投票</a></li>	
			<li><a href="javascript:void(0);" class="on">编辑投票</a></li>		
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend>操作提示</legend>
		1：投票名称不能为空
	</fieldset>
	<form action="" method="post" name="myform">
	<input type="hidden" name="do_submit" value="1" />
	<input type="hidden" name="id" value="<?php echo $id;?>" />
	<table cellspacing="0" class="sub">
		<tr>
			<td width="140" align="right">投票名称：</td>
			<td><input type="text" name="info[votename]" size="35" value="<?php echo $info['votename'];?>" datatype="limit" min="2" max="100" /></td>
		</tr>
		<tr>
			<td width="140" align="right">开始时间：</td>
			<td><input type="text" name="info[starttime]" value="<?php echo date('Y-m-d',$info['starttime']);?>"  size="10" datatype="limit" min="2" max="100" /></td>
		</tr>
		<tr>
			<td width="140" align="right">结束时间：</td>
			<td><input type="text" name="info[endtime]" value="<?php echo date('Y-m-d',$info['endtime']);?>" size="10" datatype="limit" min="2" max="100" /></td>
		</tr>
		<tr>
			<td width="140" align="right">重复投票间隔：</td>
			<td><input type="text" name="info[delay]" value="<?php echo $info['delay'];?>" size="4" datatype="integer" /> 小时</td>
		</tr>
		<tr>
			<td width="140" align="right">是否多选：</td>
			<td>
			<input type="radio" class="radio"  name="info[ismore]" value="1"  <?php echo $info['ismore']?' checked="checked"':'';?>/>是  
			<input type="radio" class="radio"  name="info[ismore]"  <?php echo !$info['ismore']?' checked="checked"':'';?> value="0"/>否</td>
		</tr>
		<tr>
			<td width="140" align="right" valign="top">投 票 项：</td>
			<td>
			<textarea name="info[votenote]" cols="50" rows="8" style="font-family:'宋体'"><?php echo htmlspecialchars($info['votenote']);?></textarea>
			</td>
		</tr>
		<tr class="bg2"><td></td><td><input type="button" class="button" onclick="doSubmit(this);" value="保存投票" /> <input type="button" class="button" onclick="window.location.href='<?php echo ADMIN_FILE;?>?mod=vote&file=vote&action=manage'" value="取消返回" /></td></tr>
	</table>
	</form>

	</div>
</div>
</body>
</html>
