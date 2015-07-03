<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('pay',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>点卡管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
			<li><a href="?mod=pay&file=pay&action=card">点卡管理</a></li>
			<li><a href="javascript:void(0);" class="on">生成点卡</a></li>			
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend>操作提示</legend>
		1：点卡类型名称不能为空； 2：卡号前缀为数字；3：卡号长度排序应为不要小于15的数字。
	</fieldset>
	<form action="" method="post" name="myform">
	<input type="hidden" name="do_submit" value="1" />
	<table cellspacing="0" class="sub">
		<tr>
			<td width="80" align="right">生成数量：</td>
			<td>
			<input type="text" name="info[number]" value="20"  datatype="integer" size="6" /> 张
			</td>
		</tr>
		<tr>
			<td width="80" align="right">点卡类型：</td>
			<td>
			<select name="info[typeid]">
			<?php 
				if($cardtype)foreach($cardtype as $_r)
				{
					echo '<option value="'.$_r['id'].'">'.$_r['name'].'</option>';
				}
			?>
			</select>
			</td>
		</tr>
		<tr>
			<td width="80" align="right">卡号前缀：</td>
			<td>
			<input type="text" size="10" name="info[pre]" value="<?php echo date('Y');?>" datatype="max" max="4" /> 
			</td>
		</tr>
		<tr>
			<td align="right">卡号长度：</td>
			<td>
			<input type="text" size="6" value="15" datatype="integer" name="info[len]" />
			<span>不要小于15的数字</span>
			</td>
		</tr>
		<tr>
			<td align="right">有效期限：</td>
			<td>
			<input type="text" size="6" value="30" datatype="integer" name="info[todate]" /> 天
			</td>
		</tr>
		<tr class="bg2"><td></td><td><input type="button" class="button" onclick="doSubmit(this);" value="生成点卡" /> <input type="button" class="button" onclick="window.location.href='<?php echo ADMIN_FILE;?>?mod=pay&file=pay&action=card'" value="取消返回" /></td></tr>
	</table>
	</form>

	</div>
</div>
</body>
</html>
