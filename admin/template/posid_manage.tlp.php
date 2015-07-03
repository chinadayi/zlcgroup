<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(9,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>推荐位管理</title>
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
			<li><a href="javascript:void(0);" class="on"><?php echo $lang['POSID-LANG-1'];?></a></li>
			<li><a href="?file=posid&action=add"><?php echo $lang['POSID-LANG-2'];?></a></li>			
		</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		如需对推荐位进行操作，别忘了选择该推荐位。
		</fieldset>
		<table cellspacing="0" class="datalist" id="list">
		<tr>
			<th width="40" class="firstcol">反选</th>
			<th width="80">排序</th>
			<th width="80">唯一标识</th>
			<th width="120">推荐位名称</th>
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
			<td width="60" align="center"><a href="<?php echo ADMIN_FILE;?>?file=posid&action=delete&id=<?php echo $val['id'];?>"><u>删除</u></a></td>
		</tr>
		<?php }?>
		<tr>
			<td width="40" align="center">
			<input type="checkbox" name="chkall2" value="1" checked="checked" class="checkbox" onclick="check_all(this)" /></td>
			<td colspan="4" align="left">
			<input type="radio" name="do" value="edit" class="radio" checked="checked" /><label for="delete">修改</label>
			<input type="radio" name="do" value="delete" class="radio" /><label for="delete">删除</label>
			<input type="button" onclick="this.form.submit();" class="submit" value="执行操作" />
			</td>
		</tr>
		</form>
		<?php }else{?>
		<tr><td colspan="5">目前尚未添加任何推荐位...</td></tr>	
		<?php }?>
		<tr>
			<td colspan="5"><?php echo $posid->pagestring;?></td>
		</tr>
		</table>
	</div>
</div>
</body>
</html>
