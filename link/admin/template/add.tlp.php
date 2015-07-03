<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('link',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>友链管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script src="images/js/check.func.js"></script>
<!--编辑器引用文件-->
<script type="text/javascript" charset=utf-8 src="ueditor/ueditor.config.js" ></script>
<script type="text/javascript" charset=utf-8 src="ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset=utf-8 src="ueditor/lang/zh-cn/zh-cn.js" ></script>

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
			<li><a href="?mod=link&file=link&action=manage&typeid=<?php echo $typeid;?>">友链管理</a></li>
			<li><a href="?mod=link&file=link&action=add&typeid=<?php echo $typeid;?>" class="on">添加友链</a></li>		
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend>操作提示</legend>
		1：友链类型名称不能为空； 2：友链类型排序应为数字；3：链接URL必须以http://开头 。
	</fieldset>
	<form action="" method="post" name="myform" enctype="multipart/form-data">
	<input type="hidden" name="do_submit" value="1" />
	<input type="hidden" name="info[typeid]" value="<?php echo $typeid;?>" />
	<table cellspacing="0" class="sub">
		<tr>
			<td width="80" align="right">链接名称：</td>
			<td>
			<input type="text" name="info[name]" datatype="limit" min="1" max="100" size="25" />
			</td>
		</tr>
		<tr>
			<td width="80" align="right">链接图片：</td>
			<td>
			<?php echo $form->image('logo');?>
			</td>
		</tr>
		<tr>
			<td width="80" align="right">链接地址：</td>
			<td>
			<input type="text" size="45" value="http://" name="info[url]" datatype="url"  />
			</td>
		</tr>
		<tr>
			<td align="right">是否推荐：</td>
			<td>
			<input type="radio" class="radio" value="1" checked="checked" name="info[isindex]" />推荐
			<input type="radio" class="radio" value="0" name="info[isindex]" />普通
			</td>
		</tr>
		<tr>
			<td align="right">是否启用：</td>
			<td>
			<input type="radio" class="radio" value="0" checked="checked" name="info[disabled]" />启用
			<input type="radio" class="radio" value="1" name="info[disabled]" />待审
			</td>
		</tr>
		<tr class="bg2"><td></td><td><input type="button" class="button" onclick="doSubmit(this);" value="保存友链" /> <input type="button" class="button" onclick="window.location.href='?mod=link&file=link&action=manage&typeid=<?php echo $typeid;?>" value="取消返回" /></td></tr>
	</table>
	</form>

	</div>
</div>
</body>
</html>
