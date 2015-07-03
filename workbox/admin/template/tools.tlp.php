<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('workbox',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>工具管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script type="text/javascript" src="admin/template/js/admin.js"></script>
<script language="javascript" src="admin/template/js/css.js"></script>
</head>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="?mod=workbox&file=workbox&action=workbox">工具管理</a></li>
			<li><a href="javascript:void(0);" class="on">选项管理</a></li>
			<li><a href="?mod=workbox&file=workbox&action=tag">模板调用</a></li>
		</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		选项名称不能为空!
		</fieldset>
		<table cellspacing="0" class="datalist" id="list" width="98%">
		<tr>			
			<th width="8%" class="firstcol">ID</th>
			<th width="25%">选项名称</th>
			<th width="51%">选项URL</th>
			<th width="16%">管理</th>
		</tr>
		<form action="" method="post" name="myform">
		<input type="hidden" name="do_submit" value="1" />
		<?php if($result){foreach($result as $val){?>
		<tr>
		  <td width="8%" align="center"><?php echo $val['id'];?></td>
		  <td width="25%">&nbsp;&nbsp;
	      <input type="text" style="color:<?php echo $val['style'];?>" name="name[<?php echo $val['id'];?>]" value="<?php echo $val['name'];?>" size="30" /></a></td>
		  <td width="51%">&nbsp;&nbsp;
	      <input type="text" name="url[<?php echo $val['id'];?>]" value="<?php echo $val['url'];?>" size="40" /></a></td>
		  <td width="16%" align="center"><a href="?mod=workbox&file=workbox&action=tools_edit&id=<?php echo $val['id'];?>">修改</a> | <a href="?mod=workbox&file=workbox&action=tools_delete&id=<?php echo $val['id'];?>" onclick="if(!confirm('确实要删除该选项吗?点击确定继续!'))return false">删除</a></td>
		</tr>
		<?php }}?>
		<tr>
			<td colspan="4">
			&nbsp;&nbsp;
			<input type="button" onclick="this.form.submit();" class="submit" value="提交修改" />
			</td>
		</tr>
		</form>
		</table>
	</div>
</div>
</body>
</html>
