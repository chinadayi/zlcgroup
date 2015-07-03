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
			<li><a href="javascript:void(0);" class="on"><?php echo $lang['LEFT-CATEGORY-11'];?></a></li>
			<li><a href="?file=stepselect&selectid=<?php echo $id;?>&action=add_enum"><?php echo $lang['LEFT-CATEGORY-12'];?></a></li>			
		</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		枚举名不能为空!
		</fieldset>
		<table cellspacing="0" class="datalist" id="list">
		<tr>
			<th width="11%" class="firstcol">反选</th>
			<th width="27%">枚举名</th>
			<th width="18%">排序</th>
			<th width="33%">枚举值</th>
			<th width="11%">操作</th>
		</tr>
		<form action="" method="post" name="myform">
		<input type="hidden" name="do_submit" value="1" />
		<?php if($result){foreach($result as $val){?>
		<tr>
			<td align="center"><input type="checkbox" name="checkedid[]" value="<?php echo $val['id'];?>" class="checkbox" /></td>
          	<td>
			<?php 
			if(floatval($val['evalue'])%500==0)
			{
				echo '';
			}
			else if(!strpos($val['evalue'],'.'))
			{
				echo '&nbsp;&nbsp;└'.str_repeat('─',0);
			}
			else
			{
				echo '&nbsp;&nbsp;&nbsp;&nbsp;└'.str_repeat('─',1);
			}
			?>
			<input type="text" size="8" name="name[<?php echo $val['id'];?>]" value="<?php echo $val['name'];?>" />
			</td>
			<td align="center"><input type="text" size="5" name="orderby[<?php echo $val['id'];?>]" value="<?php echo $val['orderby'];?>" /></td>
		  	<td align="center"><?php echo $val['id'];?></td>
			<td align="center"><a href="<?php echo ADMIN_FILE;?>?file=stepselect&action=delete_enum&id=<?php echo $val['id'];?>"><u>删除</u></a></td>
		</tr>
		<?php }?>
		<tr>
			<td align="center">
			<input type="checkbox" name="chkall2" value="1" class="checkbox" onclick="check_all_bycheckedid(this)" /></td>
			<td colspan="4" align="left">
			<input type="radio" name="do" value="edit" class="radio" checked="checked" /><label for="delete">修改</label>
			<input type="radio" name="do" value="delete" class="radio" /><label for="delete">删除</label>
			<input type="button" onclick="this.form.submit();" class="submit" value="执行操作" />
			</td>
		</tr>
		</form>
		<?php }else{?>
		<tr><td colspan="5">目前尚未添加任何枚举...</td></tr>	
		<?php }?>
		<tr>
			<td colspan="5"><?php echo $stepselect->pagestring;?></td>
		</tr>
		</table>
	</div>
</div>
</body>
</html>
