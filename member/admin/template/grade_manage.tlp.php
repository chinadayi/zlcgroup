<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('member',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>会员级别管理</title>
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
			<li><a href="javascript:void(0);" class="on">级别管理</a></li>
			<li><a href="?mod=member&file=member&action=grade_add">添加级别</a></li>			
		</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend>操作提示</legend>
		1：排序，默认资金，默认积分只能是数字； 2：会员级别名称不能留空。
		</fieldset>
		<table cellspacing="0" class="datalist" id="list" width="98%">
		<tr>
			<th width="128">等级值</th>
			<th width="224">级别名称</th>
			<th width="130">包月价格</th>
			<th width="117">包月积分</th>
			<th width="160">状态</th>
			<th width="370">服务介绍</th>
			<th width="146">操作</th>
		</tr>
		<form action="" method="post" name="myform">
		<input type="hidden" name="do_submit" value="1" />
		<?php if($result){foreach($result as $val){?>
		<tr>
		  <td width="128" align="center"><input type="text" <?php echo $val['issystem']?' readonly="1" onclick="alert(\'该系统等级值不能修改!\');"':''?> size="6" name="grade[<?php echo $val['id'];?>]" value="<?php echo $val['grade'];?>" /></td>
		  <td width="224" align="center"><input type="text" size="20" name="name[<?php echo $val['id'];?>]" value="<?php echo $val['name'];?>" /></td>
		  <td width="130" align="center"><input type="text" size="6" name="amount[<?php echo $val['id'];?>]" value="<?php echo $val['amount'];?>" /></td>
		  <td width="117" align="center"><input type="text" size="6" name="point[<?php echo $val['id'];?>]" value="<?php echo $val['point'];?>" /></td>
			<td width="160" align="center"><?php if($val['issystem']){echo '已启用 <u>禁用</u>';}else{?><?php echo !$val['disabled']?'已启用 <a href="'.ADMIN_FILE.'?mod=member&file=member&action=grade_disabled&isdisabled=1&id='.$val['id'].'"><u>禁用</u></a>':'<font color="#666666">已禁用</font> <a href="'.ADMIN_FILE.'?mod=member&file=member&action=grade_disabled&isdisabled=0&id='.$val['id'].'"><u>启用</u></a>';?> <?php }?></td>
			<td width="370" align="center"><textarea cols="30" rows="3" name="info[<?php echo $val['id'];?>]"><?php echo $val['info'];?></textarea></td>
			<td width="146" align="center"><?php if($val['issystem']){echo '<u>删除</u>';}else{?><a href="<?php echo ADMIN_FILE;?>?mod=member&file=member&action=grade_delete&id=<?php echo $val['id'];?>"><u>删除</u></a><?php }?> | <a href="<?php echo ADMIN_FILE;?>?mod=member&file=member&action=grade_edit&id=<?php echo $val['id'];?>"><u>编辑</u></a></td>
		</tr>
		<?php }?>
		<tr>
			<td colspan="7" align="left">
			&nbsp;<input type="button" onclick="this.form.submit();" class="submit" value="批量修改" />
			</td>
		</tr>
		</form>
		<?php }else{?>
		<tr><td colspan="7">目前尚未添加任何会员级别...</td></tr>	
		<?php }?>
		</table>
	</div>
</div>
</body>
</html>
