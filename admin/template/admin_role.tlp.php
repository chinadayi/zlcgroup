<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(3,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $lang['LEFT-SYSTEM-9'];?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script type="text/javascript" src="admin/template/js/admin.js"></script>
<script type="text/javascript" src="admin/template/js/css.js"></script>
</head>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="javascript:void(0);" class="on"><?php echo $lang['LEFT-SYSTEM-9'];?></a></li>
			<li><a href="?file=admin&action=role_add"><?php echo $lang['LEFT-SYSTEM-15'];?></a></li>			
		</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		1：排序只能是数字； 2：角色名称不能留空。
		</fieldset>
		<table cellspacing="0" class="datalist" id="list" width="98%">
		<tr>
			<th width="10%">排序</th>
			<th width="8%">ID</th>
			<th width="28%">角色名称</th>
			<th width="17%">状态</th>
			<th width="9%">类型</th>
			<th width="28%">操作</th>
		</tr>
		<form action="" method="post" name="myform">
		<input type="hidden" name="do_submit" value="1" />
		<?php if($result){foreach($result as $val){?>
		<tr>
			<td align="center"><input type="text" size="6" name="orderby[<?php echo $val['id'];?>]" value="<?php echo $val['orderby'];?>" /></td>
			<td align="center"><?php echo $val['id'];?></td>
			<td align="center"><input type="text" size="20" name="name[<?php echo $val['id'];?>]" value="<?php echo $val['name'];?>" /></td>
			<td align="center"><?php echo $val['disabled']?'<font color="#666666">已禁用</font> &nbsp;&nbsp;<a href="'.ADMIN_FILE.'?file=admin&action=role_lock&disabled=0&id='.$val['id'].'"><u>启用</u></a>':'已启用&nbsp;&nbsp; <a href="'.ADMIN_FILE.'?file=admin&action=role_lock&disabled=1&id='.$val['id'].'"><u>禁用</u></a>';?></td>
			<td align="center"><?php echo $val['issystem']?'系统':'自定义';?></td>
			<td align="center">
			<?php if($val['issystem']){echo '<font color="#cccccc">删除</font>';}else{?><a href="<?php echo ADMIN_FILE;?>?file=admin&action=role_delete&id=<?php echo $val['id'];?>" onclick="if(!confirm('确实要删除管理角色以及该角色下的所有成员吗?'))return false;">删除角色</a><?php }?> 
			&nbsp;&nbsp;
			<a href="<?php echo ADMIN_FILE;?>?file=admin&action=manage&roleid=<?php echo $val['id'];?>">管理成员</a> 
			&nbsp;&nbsp;
			<?php if($_roleid==1){?><a href="<?php echo ADMIN_FILE;?>?file=admin&action=auth">设置权限</a><?php }?></td>
		</tr>
		<?php }?>
		<tr>
			<td colspan="6" align="left">
			&nbsp;<input type="button" onclick="this.form.submit();" class="submit" value="批量修改" />
			</td>
		</tr>
		</form>
		<?php }else{?>
		<tr><td colspan="6">目前尚未添加任何角色...</td></tr>	
		<?php }?>
		</table>
	</div>
</div>
</body>
</html>
