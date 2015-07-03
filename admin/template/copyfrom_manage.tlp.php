<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(9,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>稿件来源管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
			<li><a href="javascript:void(0);" class="on"><?php echo $lang['COPYFROM-LANG-1'];?></a></li>
			<li><a href="?file=copyfrom&action=add"><?php echo $lang['COPYFROM-LANG-2'];?></a></li>			
		</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		如需对稿件来源进行操作，别忘了选择该稿件来源。
		</fieldset>
		<table cellspacing="0" class="datalist" id="list">
		<tr>
			<th width="40" class="firstcol"><input type="checkbox" checked="checked" name="chkall1" value="1" class="checkbox" onclick="check_all(this)" /></th>
			<th width="80">排序</th>
			<th width="80">唯一标识</th>
			<th width="120">稿件来源</th>
			<th width="200">来源URL</th>
			<th width="60">操作</th>
		</tr>
		<form action="" method="post" name="myform">
		<input type="hidden" name="do_submit" value="1" />
		<?php if($result){foreach($result as $val){?>
		<tr>
			<td width="40" align="center"><input type="checkbox" checked="checked" name="id[]" value="<?php echo $val['id'];?>" class="checkbox" /></td>
			<td width="80" align="center"><input type="text" size="6" name="orderby[<?php echo $val['id'];?>]" value="<?php echo $val['orderby'];?>"/></td>
			<td width="80" align="center"><?php echo $val['id'];?></td>
			<td width="120" align="center"><input type="text" size="25" name="name[<?php echo $val['id'];?>]" value="<?php echo $val['name'];?>" /></td>
			<td width="200" align="center"><input type="text" size="35" name="url[<?php echo $val['id'];?>]" value="<?php echo $val['url'];?>" /></td>
			<td width="60" align="center"><a href="<?php echo ADMIN_FILE;?>?file=copyfrom&action=delete&id=<?php echo $val['id'];?>"><u>删除</u></a></td>
		</tr>
		<?php }?>
		<tr>
			<td width="40" align="center">
			<input type="checkbox" name="chkall2" value="1" checked="checked" class="checkbox" onclick="check_all(this)" /></td>
			<td colspan="5" align="left">
			<label for="chkall">全选</label>
			<input type="radio" name="do" value="edit" class="radio" checked="checked" /><label for="delete">修改</label>
			<input type="radio" name="do" value="delete" class="radio" /><label for="delete">删除</label>
			<input type="button" onclick="this.form.submit();" class="submit" value="执行操作" />
			</td>
		</tr>
		</form>
		<?php }else{?>
		<tr><td colspan="6">目前尚未添加任何稿件来源...</td></tr>	
		<?php }?>
		<tr>
			<td colspan="6"><?php echo $copyfrom->pagestring;?></td>
		</tr>
		</table>
	</div>
</div>
</body>
</html>
