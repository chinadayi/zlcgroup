<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(3,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $lang['LEFT-SYSTEM-10'];?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
			<li><a href="?file=admin&action=role"><?php echo $lang['LEFT-SYSTEM-9'];?></a></li>
			<li><a href="javascript:void(0);" class="on"><?php echo $lang['LEFT-SYSTEM-10'];?></a></li>
			<?php if($roleid){?><li><a href="?file=admin&action=add&roleid=<?php echo $roleid;?>"><?php echo $lang['LEFT-SYSTEM-16'];?></a></li><?php }?>		
		</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		网站创始人拥有最大权限，不能被撤销或者删除。
		</fieldset>
		<table cellspacing="0" class="datalist" id="list" width="98%">
		<tr>
			<th width="14%" class="firstcol">管理员名称</th>
			<th width="14%">所属角色</th>
			<th width="10%">最后登录IP</th>
			<th width="18%">最后登录时间</th>
			<th width="14%">账号状态</th>
			<th width="15%">同时登陆</th>
			<th width="15%">管理</th>
		</tr>
		<?php if($result){foreach($result as $val){if($val['userid']!=ADMIN_FOUNDERS || $_userid=ADMIN_FOUNDERS){?>
		<tr>
			<td width="14%" align="center"><?php echo $val['username'];?></td>
			<td width="14%" align="center"><?php echo $val['name'];?></td>
			<td width="10%" align="center"><?php echo $val['ip'];?></td>
			<td width="18%" align="center"><?php echo date('Y-m-d H:i:s',$val['logintime']);?></td>
			<td width="14%" align="center"><?php echo $val['disabled']?'<font color="#666666">已禁用</font> <a href="'.ADMIN_FILE.'?file=admin&action=lock&disabled=0&id='.$val['userid'].'"><u>启用</u></a>':'已启用 <a href="'.ADMIN_FILE.'?file=admin&action=lock&disabled=1&id='.$val['userid'].'"><u>禁用</u></a>';?></td>
			<td width="15%" align="center"><?php echo $val['allowmultilogin']?'允许 <a href="'.ADMIN_FILE.'?file=admin&action=allowmultilogin&allowmultilogin=0&id='.$val['userid'].'"><u>禁止</u></a>':'禁止 <a href="'.ADMIN_FILE.'?file=admin&action=allowmultilogin&allowmultilogin=1&id='.$val['userid'].'"><u>允许</u></a>';?></td>
			<td width="15%" align="center"><a href="<?php echo ADMIN_FILE;?>?file=admin&action=edit&id=<?php echo $val['userid'];?>">编辑</a> <a href="<?php echo ADMIN_FILE;?>?file=admin&action=delete&id=<?php echo $val['userid'];?>">撤销</a></td>
		</tr>
		<?php }}?>
		<?php }else{?>
		<tr><td colspan="7">该角色下尚未添加任何管理员...</td></tr>	
		<?php }?>
		</table>
	</div>
</div>
</body>
</html>
