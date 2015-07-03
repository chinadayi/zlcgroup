<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('member',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>级别管理</title>
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
			<li><a href="?mod=member&file=member&action=grade">级别管理</a></li>
			<li><a href="javascript:void(0);" class="on">添加级别</a></li>			
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend>操作提示</legend>
		1：会员级别名称不能为空； 2：排序，默认资金，默认积分只能是数字。
	</fieldset>
	<form action="" method="post" name="myform">
	<input type="hidden" name="do_submit" value="1" />
	<table cellspacing="0" class="sub" width="98%">
		<tr>
			<td width="200" align="right">级别名称：</td>
			<td width="1068">
			<input type="text" name="info[name]" datatype="limit" min="1" max="80" size="20" />
		  </td>
		</tr>
		<tr>
			<td align="right">等 级 值：</td>
			<td>
			<input type="text" size="6" value="20" datatype="integer" name="info[grade]" />
			</td>
		</tr>
		<tr>
			<td align="right">包月价格：</td>
			<td>
			<input type="text" size="6" value="0" datatype="integer" name="info[amount]" /> 元/月
			</td>
		</tr>
		<tr>
			<td align="right">包月积分：</td>
			<td>
			<input type="text" size="6" value="100" datatype="integer" name="info[point]" /> 分/月
			</td>
		</tr>
		
		<tr>
			<td align="right">是否启用：</td>
			<td>
			<input type="radio" value="0" class="radio" checked="checked" name="info[disabled]" />启用 
			<input type="radio" value="1" class="radio" name="info[disabled]" />禁用
			</td>
		</tr>
		<tr>
			<td width="200" align="right" valign="top">栏目投稿权限：</td>
			<td>
			<select name="info[postcatid][]" multiple="multiple" size="10" style="width:135px">
				<option value="0" selected="selected">所有栏目</option>
				<?php $options->catoptions(0,array(0));?>
			</select>
			<span>按着 Ctrl 可以多选,不用选择即拥有全部权限!</span>
			</td>
		</tr>
		<tr>
			<td width="200" align="right" valign="top">栏目查看权限：</td>
			<td>
			<select name="info[viewcatid][]" multiple="multiple" size="10" style="width:135px">
				<option value="0" selected="selected">所有栏目</option>
				<?php $options->catoptions(0,array(0));?>
			</select>
			<span>按着 Ctrl 可以多选,不用选择即拥有全部权限!</span>
			</td>
		</tr>
		<tr>
			<td width="200" align="right" valign="top">模块使用权限：</td>
			<td>
			<select name="info[module][]" multiple="multiple" size="10" style="width:135px">
				<?php 
					if($modulearray)foreach($modulearray as $modval)
					{
						if($modval['folder']!='member' && !$modval['adminonly'])
						{
							echo '<option value="'.$modval['id'].'" selected="selected">'.$modval['name'].'</option>';
						}
					}				
				?>
			</select>
			<span>按着 Ctrl 可以多选,不用选择即拥有全部权限!</span>
			</td>
		</tr>
		<tr>
			<td align="right">服务介绍：</td>
			<td>
			<textarea datatype="limit" min="1" max="255" cols="80" rows="5" name="info[info]"></textarea>
			</td>
		</tr>
		<tr class="bg2"><td></td><td><input type="button" class="button" onclick="doSubmit(this);" value="保存级别" /> <input type="button" class="button" onclick="window.location.href='<?php echo ADMIN_FILE;?>?mod=member&file=member&action=grade'" value="取消返回" /></td></tr>
	</table>
	</form>

	</div>
</div>
</body>
</html>
