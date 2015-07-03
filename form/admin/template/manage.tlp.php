<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('form',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>表单管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script language="javascript" src="admin/template/js/css.js"></script>
</head>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="javascript:void(0);" class="on">自定义表单</a></li>
			<li><a href="?mod=form&file=form&action=add">添加表单</a></li>	
		</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		如需对表单进行操作，别忘了选择该表单。
		</fieldset>
		<table width="100%" cellspacing="0" class="datalist" id="list">
		<tr>
		  	<th width="12%" class="firstcol">表单ID</th>
			<th width="21%">自定义表单名称</th>
			<th width="19%">数据表</th>
			<th width="48%">管理操作</th>
		</tr>
		<?php if($result){foreach($result as $val){?>
		<tr>
			<td align="center"><?php echo $val['id'];?></td>
			<td align="center"><a href="<?php echo ADMIN_FILE;?>?mod=form&file=form&action=fields&id=<?php echo $val['id'];?>"><?php echo $val['name'];?></a></td>
			<td align="center"><a href="<?php echo ADMIN_FILE;?>?mod=form&file=form&action=fields&id=<?php echo $val['id'];?>"><?php echo DB_PRE.$val['table'];?></a></td>
			<td align="center"><a href="<?php echo ADMIN_FILE;?>?mod=form&file=form&action=fields&id=<?php echo $val['id'];?>"><u>字段管理</u></a>&nbsp; | &nbsp;<a href="<?php echo ADMIN_FILE;?>?mod=form&file=form&action=data&formid=<?php echo $val['id'];?>"><u>数据管理</u></a>&nbsp; | &nbsp;<a href="form/index.php?action=list&id=<?php echo $val['id'];?>" target="_blank"><u>表单预览</u></a>&nbsp; | &nbsp;<a href="<?php echo ADMIN_FILE;?>?mod=form&file=form&action=delete&id=<?php echo $val['id'];?>" onclick="if(!confirm('确实要删除表单 <?php echo $val['name'];?> 吗?')){return false;}"><u>删除表单</u></a></td>
		</tr>
		<?php }?>
		<?php }else{?>
		<tr><td colspan="4">目前尚未添加任何自定义表单...</td></tr>	
		<?php }?>
		<tr>
			<td colspan="4"><?php echo $formobj->pagestring;?></td>
		</tr>
	  </table>
	</div>
</div>
</body>
</html>
