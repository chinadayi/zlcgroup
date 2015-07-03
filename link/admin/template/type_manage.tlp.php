<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('link',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>友情链接管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script language="javascript" src="admin/template/js/css.js"></script>
<script type="text/javascript" src="admin/template/js/admin.js"></script>
<script src="images/js/menu.js"></script>
</head>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="javascript:void(0);" class="on">链接类型管理</a></li>
			<li><a href="?mod=link&file=link&action=type_add">添加链接类型</a></li>			
		</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend>操作提示</legend>
		1：类型名称不能为空； 2：排序应为数字；
		</fieldset>
		<table cellspacing="0" class="datalist" id="list" width="98%">
		<tr>		
			<th width="11%" class="firstcol">ID</th>	
			<th width="11%">排序</th>
			<th width="25%">名称</th>
			<th width="30%">状态</th>
			<th width="23%">管理</th>
		</tr>
		<form action="" method="post" name="myform">
		<input type="hidden" name="do_submit" value="1" />
		<?php if($result){foreach($result as $val){?>
		<tr>
			<td width="11%" align="center"><?php echo $val['id'];?></td>
		  <td width="11%" align="center"><input type="text" size="4" name="orderby[<?php echo $val['id'];?>]" value="<?php echo $val['orderby'];?>"  /></td>
	  	  <td width="25%" align="center"><input type="text" size="25" name="name[<?php echo $val['id'];?>]" value="<?php echo $val['name'];?>"  /></td>
			<td width="30%" align="center"><?php echo !$val['disabled']?'已启用 <a href="'.ADMIN_FILE.'?mod=link&file=link&action=type_disabled&disabled=1&id='.$val['id'].'"><u>禁用</u></a>':'未启用 <a href="'.ADMIN_FILE.'?mod=link&file=link&action=type_disabled&disabled=0&id='.$val['id'].'"><u>启用</u></a>';?> </td>
			<td width="23%" align="center"><a href="<?php echo ADMIN_FILE;?>?mod=link&file=link&action=type_edit&id=<?php echo $val['id'];?>"><u>编辑</u></a> &nbsp;|&nbsp; <a href="<?php echo ADMIN_FILE;?>?mod=link&file=link&action=type_delete&id=<?php echo $val['id'];?>" onclick="if(!confirm('确定删除?点击确定继续!'))return false;"><u>删除</u></a> &nbsp;|&nbsp; <a href="<?php echo ADMIN_FILE;?>?mod=link&file=link&action=manage&typeid=<?php echo $val['id'];?>"><u>友链管理</u></a></td>
		</tr>
		<?php }?>
		<tr>
			<td colspan="5">
			&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" onclick="this.form.submit();" class="submit" value="批量修改" />
			</td>
		</tr>
		</form>
		<?php }else{?>
		<tr><td colspan="5">目前尚未添加任何链接类型...</td></tr>	
		<?php }?>
		<tr><td colspan="5"><?php echo $flink->pagestring;?></td></tr>
		</table>
	</div>
</div>
</body>
</html>
