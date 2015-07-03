<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('vote',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>投票管理</title>
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
			<li><a href="javascript:void(0);" class="on">投票管理</a></li>
			<li><a href="?mod=vote&file=vote&action=vote_add">添加投票</a></li>			
		</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend>操作提示</legend>
		1：投票名称不能为空
		</fieldset>
		<table cellspacing="0" class="datalist" id="list">
		<tr>			
			<th width="21%" class="firstcol">投票ID：名称</th>
			<th width="13%">开始时间</th>
			<th width="12%">结束时间</th>
			<th width="32%">投票调用</th>
			<th width="9%">投票总数</th>
			<th width="13%">管理</th>
		</tr>
		<form action="" method="post" name="myform">
		<input type="hidden" name="do_submit" value="1" />
		<?php if($result){foreach($result as $_r){?>
		<tr>
			<td width="21%" align="center"><?php echo $_r['id'];?>：<input type="text" size="25" name="votename[<?php echo $_r['id'];?>]" value="<?php echo $_r['votename'];?>"  /></td>
			<td width="13%" align="center"><input type="text" size="12" name="starttime[<?php echo $_r['id'];?>]"  value="<?php echo date('Y-m-d',$_r['starttime']);?>"  /></td>
			<td width="12%" align="center"><input type="text" <?php if($_r['endtime']<TIME)echo ' style="color:#FF0000"';?> size="12" name="endtime[<?php echo $_r['id'];?>]"  value="<?php echo date('Y-m-d',$_r['endtime']);?>"  /></td>
			<td width="32%" align="center" title="复制到模板显示投票的位置"><input type="text" size="45" readonly="1"  value='{reteng:vote id="<?php echo $_r['id'];?>"}{field:votename}{/reteng:vote}'  /></td>
			<td width="9%" align="center"><input type="text" size="5" name="totalcount[<?php echo $_r['id'];?>]" value='<?php echo $_r['totalcount'];?>'  /></td>
			<td width="13%" align="center"><a href="<?php echo ADMIN_FILE;?>?mod=vote&file=vote&action=vote_view&id=<?php echo $_r['id'];?>"><u>查看</u></a> <a href="<?php echo ADMIN_FILE;?>?mod=vote&file=vote&action=vote_edit&id=<?php echo $_r['id'];?>"><u>编辑</u></a> <a href="<?php echo ADMIN_FILE;?>?mod=vote&file=vote&action=vote_delete&id=<?php echo $_r['id'];?>" onclick="if(!confirm('确实要删除该投票吗?')){return false;}"><u>删除</u></a></td>
		</tr>
		<?php }?>
		<tr>
			<td colspan="6">
			&nbsp;<input type="button" onclick="this.form.submit();" class="submit" value="批量修改" />
			</td>
		</tr>
		</form>
		<?php }else{?>
		<tr><td colspan="7">目前尚未添加任何投票...</td></tr>	
		<?php }?>
		</table>
	</div>
</div>
</body>
</html>
