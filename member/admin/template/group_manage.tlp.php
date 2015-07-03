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
<script type="text/javascript" src="admin/template/js/admin.js"></script>
<script language="javascript" src="admin/template/js/css.js"></script>
</head>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="javascript:void(0);" class="on">会员组管理</a></li>
			<li><a href="?mod=member&file=member&action=group_add">添加会员组</a></li>			
		</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend>操作提示</legend>
		1：排序只能是数字； 2：会员组名称不能留空。
		</fieldset>
		<table cellspacing="0" class="datalist" id="list" width="98%">
		<tr>
			<th width="9%">排序</th>
			<th width="5%">ID</th>
			<th width="21%">会员组名称</th>
			<th width="25%">状态</th>
			<th width="11%">类型</th>
			<th width="29%">操作</th>
		</tr>
		<form action="" method="post" name="myform">
		<input type="hidden" name="do_submit" value="1" />
		<?php if($result){foreach($result as $val){?>
		<tr>
		  <td width="9%" align="center"><input type="text" size="6" name="orderby[<?php echo $val['id'];?>]" value="<?php echo $val['orderby'];?>" /></td>
			<td width="5%" align="center"><?php echo $val['id'];?></td>
		  <td width="21%" align="center"><input type="text" size="20" name="name[<?php echo $val['id'];?>]" value="<?php echo $val['name'];?>" /></td>
			<td width="25%" align="center"><?php echo $val['disabled']?'<font color="#666666">已禁用</font> <a href="'.ADMIN_FILE.'?mod=member&file=member&action=group_disabled&disabled=0&id='.$val['id'].'"><u>启用</u></a>':'已启用 <a href="'.ADMIN_FILE.'?mod=member&file=member&action=group_disabled&disabled=1&id='.$val['id'].'"><u>禁用</u></a>';?></td>
			<td width="11%" align="center"><?php echo $val['issystem']?'系统':'用户';?></td>
			<td width="29%" align="center"><?php if($val['issystem']){echo '<font color="#999999"><u>删除</u></font> ';}else{?><a href="<?php echo ADMIN_FILE;?>?mod=member&file=member&action=group_delete&id=<?php echo $val['id'];?>"><u>删除</u></a><?php }?> | <a href="<?php echo ADMIN_FILE;?>?mod=member&file=member&action=group_edit&id=<?php echo $val['id'];?>"><u>修改</u></a></td>
		</tr>
		<?php }?>
		<tr>
			<td colspan="6" align="left">
			&nbsp;<input type="button" onclick="this.form.submit();" class="submit" value="批量修改" />
			</td>
		</tr>
		</form>
		<?php }else{?>
		<tr><td colspan="6">目前尚未添加任何会员组...</td></tr>	
		<?php }?>
		</table>
	</div>
</div>
</body>
</html>
