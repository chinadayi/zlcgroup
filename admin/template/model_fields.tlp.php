<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(16,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>字段管理</title>
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
			<li><a href="javascript:void(0);" class="on"><?php echo $lang['LEFT-MODULE-13'];?></a></li>
			<li><a href="?file=model&action=fields_add&modelid=<?php echo $id;?>"><?php echo $lang['LEFT-MODULE-14'];?></a></li>	
		</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		1：排序只能是数字! 2：至少要保留一个字段不被删除!
		</fieldset>
		<table width="100%" cellspacing="0" class="datalist" id="list">
		<tr>
		  	<th width="4%" class="firstcol">排序</th>
			<th width="18%">字段名</th>
			<th width="19%">别名</th>
			<th width="17%">状态</th>
			<th width="13%">模板CSS</th>
			<th width="13%">计量单位</th>
			<th width="16%">操作</th>
		</tr>
		<form action="" method="post" name="myform">
		<input type="hidden" name="do_submit" value="1" />
		<?php if($result){foreach($result as $val){?>
		<input type="hidden" name="ids[<?php echo $val['id'];?>]" value="<?php echo $val['id'];?>" />
		<tr>
			<td align="center"><input type="text" name="orderby[<?php echo $val['id'];?>]" size="2" value="<?php echo $val['orderby'];?>" /></td>
			<td align="center"><?php echo $val['enname'];?></td>
			<td align="center"><input type="text" name="name[<?php echo $val['id'];?>]" size="15" value="<?php echo $val['name'];?>" /></td>
			<td align="center"><?php echo $val['disabled']?'<font color="#999999">已禁用</font> <a href="'.ADMIN_FILE.'?file=model&action=fields_disabled&disabled=0&id='.$val['id'].'"><u>启用</u></a>':'已启用 <a href="'.ADMIN_FILE.'?file=model&action=fields_disabled&disabled=1&id='.$val['id'].'"><u>禁用</u></a>';?></td>
			<td align="center"><input type="text" name="css[<?php echo $val['id'];?>]" size="15" value="<?php echo $val['css'];?>" /></td>
			<td align="center"><input type="text" name="unit[<?php echo $val['id'];?>]" size="15" value="<?php echo $val['unit'];?>" /></td>
			<td align="center"><?php if($val['cantdelete']){echo '<font color="#999999"><u>删除</u></font> ';}else{?><a href="<?php echo ADMIN_FILE;?>?file=model&action=fields_delete&id=<?php echo $val['id'];?>" onclick="if(!confirm('确实要删除字段 <?php echo $val['name'];?> 吗?')){return false;}"><u>删除</u></a> <?php }?><?php if($val['cantdelete']){echo '<font color="#999999"><u>修改</u></font> ';}else{?><a href="<?php echo ADMIN_FILE;?>?file=model&action=fields_edit&id=<?php echo $val['id'];?>&modelid=<?php echo $val['modelid'];?>"><u>修改</u></a><?php }?></td>
		</tr>
		<?php }?>
		<tr>
			<td colspan="7" align="left">
			<input type="button" onclick="this.form.submit();" class="submit" value="批量修改" />
			</td>
		</tr>
		</form>
		<?php }else{?>
		<tr><td colspan="7">目前该模型尚未添加任何字段...</td></tr>	
		<?php }?>
		<tr>
			<td colspan="7"><?php echo $model->pagestring;?></td>
		</tr>
	  </table>
	</div>
</div>
</body>
</html>
