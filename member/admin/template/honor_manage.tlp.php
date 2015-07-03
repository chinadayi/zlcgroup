<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('member',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>会员头衔管理</title>
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
			<li><a href="javascript:void(0);" class="on">头衔管理</a></li>
			<li><a href="?mod=member&file=member&action=honor_add">添加头衔</a></li>			
		</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend>操作提示</legend>
		1：积分，图标数只能是数字； 2：会员头衔名称不能留空。
		</fieldset>
		<table cellspacing="0" class="datalist" id="list">
		<tr>
			<th width="80">等级值</th>
			<th width="81">积分大于</th>
			<th width="73">图标数</th>
			<th width="100">状态</th>
			<th width="60">操作</th>
		</tr>
		<form action="" method="post" name="myform">
		<input type="hidden" name="do_submit" value="1" />
		<?php if($result){foreach($result as $val){?>
		<tr>
			<input type="hidden" name="id[]" value="<?php echo $val['id'];?>" />
			<td width="80" align="center"><input type="text" size="20" name="name[<?php echo $val['id'];?>]" value="<?php echo $val['name'];?>" /></td>
		  <td width="81" align="center"><input type="text" size="6" name="point[<?php echo $val['id'];?>]" value="<?php echo $val['point'];?>" /></td>
		  <td width="73" align="center"><input type="text" size="6" name="ico[<?php echo $val['id'];?>]" value="<?php echo $val['ico'];?>" /></td>
			<td width="100" align="center"><?php echo !$val['disabled']?'已启用 <a href="'.ADMIN_FILE.'?mod=member&file=member&action=honor_disabled&disabled=1&id='.$val['id'].'"><u>禁用</u></a>':'<font color="#666666">已禁用</font> <a href="'.ADMIN_FILE.'?mod=member&file=member&action=honor_disabled&disabled=0&id='.$val['id'].'"><u>启用</u></a>';?></td>
			<td width="60" align="center"><a href="<?php echo ADMIN_FILE;?>?mod=member&file=member&action=honor_delete&id=<?php echo $val['id'];?>"><u>删除</u></a></td>
		</tr>
		<?php }?>
		<tr>
			<td colspan="5" align="left">
			&nbsp;<input type="button" onclick="this.form.submit();" class="submit" value="批量修改" />
			</td>
		</tr>
		</form>
		<?php }else{?>
		<tr><td colspan="5">目前尚未添加任何会员头衔...</td></tr>	
		<?php }?>
		</table>
	</div>
</div>
</body>
</html>
