<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>站群管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script language="javascript" src="admin/template/js/css.js"></script>
</head>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="javascript:void(0);" class="on">分站管理</a></li>
			<li><a href="?file=sitecrowd&action=add">添加站点</a></li>
		</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		默认站点无法删除!
		</fieldset>
		<table cellspacing="0" class="datalist" id="list" width="98%">
		<tr>
			<th width="8%" class="firstcol">站点ID</th>
			<th width="16%">站点名称</th>
			<th width="23%">站点地址</th>
			<th width="12%">站点目录</th>
			<th width="15%">站点类型</th>
			<th width="26%">管理操作</th>
		</tr>
		<?php if($result){foreach($result as $val){?>
		<tr>
			<td align="center"><?php echo $val['id'];?></td>
			<td align="center"><a href="<?php echo $val['site_url'];?>" target="_blank"><?php echo $val['site_name'];?></a></td>
			<td align="center"><a href="<?php echo $val['site_url'];?>" target="_blank"><?php echo $val['site_url'];?></a></td>
			<td align="center"><?php echo $val['site_dir']?$val['site_dir']:'/';?></td>
			<td align="center"><?php echo $val['system']?'系统站点':'自定义站点';?></td>
			<td align="center"><a href="<?php echo ADMIN_FILE;?>?file=sitecrowd&action=edit&id=<?php echo $val['id'];?>"><u>修改</u></a> | <?php if($val['system']){echo '<u><font color="#666666">删除</font></u>';}else{?><a onclick="if(!confirm('确实要删除站点[ <?php echo $val['site_name'];?> ]？'))return false;" href="<?php echo ADMIN_FILE;?>?file=sitecrowd&action=delete&id=<?php echo $val['id'];?>"><u>删除</u></a><?php }?></td>
		</tr>
		<?php }?>
		<?php }else{?>
		<tr><td colspan="6">目前尚未添加任何站群...</td></tr>	
		<?php }?>
		<tr>
			<td colspan="6"><?php echo $sitecrowdobj->pagestring;?></td>
		</tr>
		</table>
	</div>
</div>
</body>
</html>
