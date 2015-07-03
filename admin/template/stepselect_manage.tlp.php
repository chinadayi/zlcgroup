<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(5,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>级联菜单管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script language="javascript" src="admin/template/js/css.js"></script>
<script type="text/javascript" src="admin/template/js/admin.js"></script>
</head>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="javascript:void(0);" class="on"><?php echo $lang['LEFT-CATEGORY-9'];?></a></li>
			<li><a href="?file=stepselect&action=add"><?php echo $lang['LEFT-CATEGORY-10'];?></a></li>			
		</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		模板下拉单调用方法：<font color="#FF0000">{js_selectmenu(缓存组名)}</font>
		</fieldset>
		<table cellspacing="0" class="datalist" id="list">
		<tr>
			<th width="7%" class="firstcol">反选</th>
			<th width="28%">菜单名称</th>
			<th width="18%">缓存组名</th>
			<th width="18%">系统</th>
			<th width="29%">操作</th>
		</tr>
		<form action="" method="post" name="myform">
		<input type="hidden" name="do_submit" value="1" />
		<?php if($result){foreach($result as $val){?>
		<tr>
			<td align="center"><input type="checkbox" name="id[]" <?php echo $val['issystem']?' disabled="disabled"':'';?> value="<?php echo $val['id'];?>" class="checkbox" /></td>
          	<td><input type="text" size="25" name="name[<?php echo $val['id'];?>]" value="<?php echo $val['name'];?>" /></td>
			<td align="center"><?php echo $val['table'];?></td>
		  	<td align="center"><?php echo $val['issystem']?'是':'否';?></td>
			<td align="center"><?php if($val['issystem']){echo '<font color="#999999">删除</font>';}else{?><a href="<?php echo ADMIN_FILE;?>?file=stepselect&action=delete&id=<?php echo $val['id'];?>"><u>删除</u></a><?php }?> &nbsp;&nbsp;<a href="<?php echo ADMIN_FILE;?>?file=stepselect&action=cache&id=<?php echo $val['id'];?>"><u>更新缓存</u></a> &nbsp;&nbsp;<a href="<?php echo ADMIN_FILE;?>?file=stepselect&action=enum&id=<?php echo $val['id'];?>"><u>查看子分类</u></a> &nbsp;&nbsp;<a href="<?php echo ADMIN_FILE;?>?file=stepselect&action=preview&table=<?php echo $val['table'];?>" target="_blank"><u>预览</u></a></td>
		</tr>
		<?php }?>
		<tr>
			<td align="center">
			<input type="checkbox" name="chkall2" value="1" class="checkbox" onclick="check_all(this)" /></td>
			<td colspan="4" align="left">
			<input type="radio" name="do" value="edit" class="radio" checked="checked" /><label for="delete">修改</label>
			<input type="radio" name="do" value="delete" class="radio" /><label for="delete">删除</label>
			<input type="button" onclick="this.form.submit();" class="submit" value="执行操作" />
			</td>
		</tr>
		</form>
		<?php }else{?>
		<tr><td colspan="5">目前尚未添加任何级联菜单...</td></tr>	
		<?php }?>
		<tr>
			<td colspan="5"><?php echo $stepselect->pagestring;?></td>
		</tr>
		</table>
	</div>
</div>
</body>
</html>
