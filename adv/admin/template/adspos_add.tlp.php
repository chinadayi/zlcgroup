<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('ads',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>广告位管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
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
			<li><a href="?mod=adv&file=ads&action=adspos">广告位管理</a></li>
			<li><a href="javascript:void(0);" class="on">添加广告位</a></li>			
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend>操作提示</legend>
		1：广告位名称不能为空； 2：广告位价格应为数字；
	</fieldset>
	<form action="" method="post" name="myform">
	<input type="hidden" name="do_submit" value="1" />
	<table cellspacing="0" class="sub" width="98%">
		<tr>
			<td width="193" align="right">广告位名称：</td>
			<td width="1092">
			<input type="text" name="info[name]" datatype="limit" min="1" max="80" size="25"/>
		  </td>
		</tr>
		<tr>
			<td width="193" align="right">广告位模板：</td>
			<td>
			<select name="info[template]">
			 <?php 
			 	foreach($template as $_tlp)
				{
					echo '<option value="'.basename($_tlp,'.htm').'">'.basename($_tlp).'</option>';	
				}
			 ?>
			 </select>
			</td>
		</tr>
		<tr>
			<td align="right">广告位宽度：</td>
			<td>
			<input type="text" size="6" value="100" datatype="integer" name="info[width]" />像素
			</td>
		</tr>
		<tr>
			<td align="right">广告位高度：</td>
			<td>
			<input type="text" size="6" value="50" datatype="integer" name="info[height]" />像素
			</td>
		</tr>
		<tr>
			<td align="right">广告位价格：</td>
			<td>
			<input type="text" size="6" value="100" datatype="number" name="info[price]" />元
			</td>
		</tr>
		<tr>
			<td align="right">多个广告时：</td>
			<td>
			<input type="radio" class="radio" value="1" checked="checked" name="info[option]" />全部列出
			<input type="radio" class="radio" value="0" name="info[option]" />随机列出一个
			</td>
		</tr>
		<tr>
			<td align="right">是否启用：</td>
			<td>
			<input type="radio" class="radio" value="1" checked="checked" name="info[ispassed]" />启用
			<input type="radio" class="radio" value="0" name="info[ispassed]" />待审
			</td>
		</tr>
		<tr>
			<td width="193" align="right">广告位介绍：</td>
			<td>
			<textarea name="info[introduce]" cols="60" rows="5"></textarea> 
			</td>
		</tr>
		<tr class="bg2"><td></td><td><input type="button" class="button" onclick="doSubmit(this);" value="保存广告位" /> <input type="button" class="button" onclick="window.location.href='<?php echo ADMIN_FILE;?>?mod=adv&file=ads&action=adspos'" value="取消返回" /></td></tr>
	</table>
	</form>

	</div>
</div>
</body>
</html>
