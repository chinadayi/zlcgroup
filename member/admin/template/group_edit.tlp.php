<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('member',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>会员组管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<?php include 'ueditor.js.php';?>
<script src="images/js/check.func.js"></script>
<script language="javascript" src="admin/template/js/css.js"></script>
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
			<li><a href="?mod=member&file=member&action=group">会员组管理</a></li>
			<li><a href="javascript:void(0);" class="on">编辑会员组</a></li>				
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend>操作提示</legend>
		1：会员组名称不能为空； 2：会员组排序应为数字。
	</fieldset>
	<form action="" method="post" name="myform">
	<input type="hidden" name="do_submit" value="1" />
	<input type="hidden" name="id" value="<?php echo $id;?>" />
	<table cellspacing="0" class="sub" width="98%">
		<tr>
			<td width="131" align="right">会员组名称：</td>
			<td width="322">
			<input type="text" name="info[name]" value="<?php echo $info['name'];?>" datatype="limit" min="1" max="30" size="20" />
		  </td>
		</tr>
		<tr>
			<td width="131" align="right" valign="top">栏目投稿权限：</td>
			<td>
			<select name="info[postcatid][]" multiple="multiple" size="10" style="width:135px">
				<option value="0" <?php echo in_array(0,explode(',',$info['postcatid']))?' selected="selected"':'';?>>所有栏目</option>
				<?php $options->catoptions(0,explode(',',$info['postcatid']));?>
			</select>
			<span>按着 Ctrl 可以多选,不用选择即拥有全部权限!</span>
			</td>
		</tr>
		<tr>
			<td width="131" align="right" valign="top">栏目查看权限：</td>
			<td>
			<select name="info[viewcatid][]" multiple="multiple" size="10" style="width:135px">
				<option value="0" <?php echo in_array(0,explode(',',$info['viewcatid']))?' selected="selected"':'';?>>所有栏目</option>
				<?php $options->catoptions(0,explode(',',$info['viewcatid']));?>
			</select>
			<span>按着 Ctrl 可以多选,不用选择即拥有全部权限!</span>
			</td>
		</tr>
		<tr>
			<td align="right">是否启用：</td>
			<td>
			<input type="radio" value="0" class="radio" <?php echo !$info['disabled']?'checked="checked"':'';?> name="info[disabled]" />启用 
			<input type="radio" value="1" class="radio" <?php echo $info['disabled']?'checked="checked"':'';?> name="info[disabled]" />禁用
			</td>
		</tr>
		<tr class="bg2"><td></td><td><input type="button" class="button" onclick="doSubmit(this);" value="保存会员组" /> <input type="button" class="button" onclick="window.location.href='<?php echo ADMIN_FILE;?>?mod=member&file=member&action=group'" value="取消返回" /></td></tr>
	</table>
	</form>

	</div>
</div>
</body>
</html>
