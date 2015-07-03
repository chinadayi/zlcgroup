<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('member',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>模型管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<?php include 'ueditor.js.php';?>
<script language="javascript" src="admin/template/js/css.js"></script>
</head>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="javascript:void(0);" class="on"><?php echo $lang['MODEL-LANG-1'];?></a></li>
			<li><a href="?mod=member&file=member&action=model_install"><?php echo $lang['MODEL-LANG-2'];?></a></li>	
		</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		如需对模型进行操作，别忘了选择该模型。
		</fieldset>
		<table width="100%" cellspacing="0" class="datalist" id="list">
		<tr>
		  	<th width="5%" class="firstcol">模型ID</th>
			<th width="18%">名称</th>
			<th width="17%">附加表</th>
			<th width="18%">状态</th>
			<th width="10%">类型</th>
			<th width="32%">操作</th>
		</tr>
		<?php if($result){foreach($result as $val){?>
		<tr>
			<td align="center"><?php echo $val['id'];?></td>
			<td align="center"><?php echo $val['name'];?></td>
			<td align="center"><?php echo DB_PRE.$val['table'];?></td>
			<td align="center"><?php echo $val['disabled']?'<font color="#999999">已禁用</font> <a href="'.ADMIN_FILE.'?mod=member&file=member&action=model_disabled&disabled=0&id='.$val['id'].'"><u>启用</u></a>':'已启用 <a href="'.ADMIN_FILE.'?mod=member&file=member&action=model_disabled&disabled=1&id='.$val['id'].'"><u>禁用</u></a>';?></td>
			<td align="center"><?php echo $val['issystem']?'系统':'自定义';?></td>
			<td align="center">
			<?php if($val['issystem']){echo '<font color="#999999"><u>删除</u></font> ';}else{?><a href="<?php echo ADMIN_FILE;?>?mod=member&file=member&action=model_delete&id=<?php echo $val['id'];?>" onclick="if(!confirm('确实要删除模型 <?php echo $val['name'];?> 吗?')){return false;}"><u>删除</u></a> <?php }?>
			|
			<a href="<?php echo ADMIN_FILE;?>?mod=member&file=member&action=fields_manage&id=<?php echo $val['id'];?>"><u>自定义字段</u></a> 
			|
			<a href="<?php echo ADMIN_FILE;?>?mod=member&file=member&action=model_preview&id=<?php echo $val['id'];?>"><u>预览</u></a></td>
		</tr>
		<?php }?>
		<?php }else{?>
		<tr><td colspan="6">目前尚未添加任何模型...</td></tr>	
		<?php }?>
		<tr>
			<td colspan="6"><?php echo $member->pagestring;?></td>
		</tr>
	  </table>
	</div>
</div>
</body>
</html>
