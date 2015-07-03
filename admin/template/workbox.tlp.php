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
			<li><a href="javascript:void(0);" class="on">工具管理</a></li>
			<li><a href="?mod=workbox&file=workbox&action=tag">模板调用</a></li>
		</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		工具名称不能为空!
		</fieldset>
		<table cellspacing="0" class="datalist" id="list" width="98%">
		<tr>			
			<th width="6%" class="firstcol">ID</th>
			<th width="45%">工具名称</th>
			<th width="16%">参与内链</th>
			<th width="33%">管理</th>
		</tr>
		<form action="" method="post" name="myform">
		<input type="hidden" name="do_submit" value="1" />
		<?php if($result){foreach($result as $val){?>
		<tr>
		  <td width="6%" align="center"><?php echo $val['id'];?></td>
		  <td width="45%">&nbsp;&nbsp;
	      <input type="text" name="name[<?php echo $val['id'];?>]" value="<?php echo $val['name'];?>" size="20" /></a></td>
		  <td width="16%" align="center"><?php echo $val['inlink']==1?'开启 <a href="'.ADMIN_FILE.'?mod=workbox&file=workbox&action=inlink&inlink=0&id='.$val['id'].'"><u>关闭</u></a>':'关闭 <a href="'.ADMIN_FILE.'?mod=workbox&file=workbox&action=inlink&inlink=1&id='.$val['id'].'"><u>开启</u></a>';?></td>
		  <td width="33%" align="center"><a href="?mod=workbox&file=workbox&action=tools&boxid=<?php echo $val['id'];?>">管理选项</a> | <a href="?mod=workbox&file=workbox&action=tools_add&boxid=<?php echo $val['id'];?>">添加选项</a></td>
		</tr>
		<?php }}?>
		<tr>
		  <td width="6%" align="center"><font color="#FF0000">+</font></td>
		  <td colspan="3">&nbsp;&nbsp;
	      <input type="text" name="name[]" size="20" /></a></td>
		</tr>
		<tr>
			<td colspan="4">
			&nbsp;&nbsp;
			<input type="button" onclick="this.form.action='?mod=workbox&file=workbox&action=workbox&do_submit=1';this.form.submit();" class="submit" value="修改工具" />
			如需删除工具, 把类别名称留空即可!
			</td>
		</tr>
		</form>
		</table>
	</div>
</div>
</body>
</html>
