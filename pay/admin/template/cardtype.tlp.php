<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('pay',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>点卡类型管理</title>
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
			<li><a href="javascript:void(0);" class="on">点卡类型</a></li>
			<li><a href="?mod=pay&file=pay&action=cardtype_add">添加类型</a></li>			
		</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend>操作提示</legend>
		1：点卡类型名称不能为空； 2：点卡类型排序应为数字。 
		</fieldset>
		<table cellspacing="0" class="datalist" id="list">
		<tr>
			<th width="8%" class="firstcol">排序</th>
			<th width="40%">名称</th>
			<th width="25%">包含钱数</th>
			<th width="22%">出售价格</th>
			<th width="5%">删除</th>
		</tr>
		<form action="" method="post" name="myform">
		<input type="hidden" name="do_submit" value="1" />
		<?php if($result){foreach($result as $val){?>
		<tr>
		  <td width="8%" align="center"><input type="text" size="4" name="orderby[<?php echo $val['id'];?>]" value="<?php echo $val['orderby'];?>" /></td>
			<td width="40%" align="center"><input type="text" size="30" name="name[<?php echo $val['id'];?>]" value="<?php echo $val['name'];?>" /></td>
			<td width="25%" align="center"><input type="text" size="8" name="amount[<?php echo $val['id'];?>]" value="<?php echo $val['amount'];?>" />元</td>
			<td width="22%" align="center"><input type="text" size="8" name="price[<?php echo $val['id'];?>]" value="<?php echo $val['price'];?>" />元</td>
			<td width="5%" align="center"><a href="<?php echo ADMIN_FILE;?>?mod=pay&file=pay&action=cardtype_delete&id=<?php echo $val['id'];?>" onclick="if(!confirm('确实要删除该点卡类型?'))return false;"><u>删除</u></a></td>
		</tr>
		<?php }?>
		<tr>
			<td colspan="5">
			&nbsp;<input type="button" onclick="this.form.submit();" class="submit" value="批量修改" />
			</td>
		</tr>
		</form>
		<?php }else{?>
		<tr><td colspan="5">目前尚未添加任何点卡类型...</td></tr>	
		<?php }?>
		</table>
	</div>
</div>
</body>
</html>
