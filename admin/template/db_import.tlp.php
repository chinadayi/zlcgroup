<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(4,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>数据库管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script type="text/javascript" src="admin/template/js/admin.js"></script>
<script src="images/js/common.js"></script>
</head>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="?file=db&action=export"><?php echo $lang['LEFT-SYSTEM-12'];?></a></li>
			<li><a href="javascript:void(0);" class="on"><?php echo $lang['LEFT-SYSTEM-13'];?></a></li>	
			<li><a href="?file=db&action=repair"><?php echo $lang['LEFT-SYSTEM-14'];?></a></li>
			<li><a href="?file=db&action=sql">执行SQL</a></li>	
		</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		请不要用旧系统的备份文件还原升级后的新系统。程序升级请用官方提供的升级程序。
		</fieldset>
		<table cellspacing="0" class="datalist" id="list">
		<tr>
			<th width="40" class="firstcol"><input type="checkbox" name="chkall1" checked="checked" value="1" class="checkbox" onclick="check_all_byname(this)" /></th>
			<th width="120">备份文件名</th>
			<th width="80">文件大小</th>
			<th width="150">备份时间</th>
			<th width="60">备份卷号</th>
			<th width="80">操作</th>
		</tr>
		<form action="" method="post" name="myform">
		<input type="hidden" name="do_submit" value="1" />
		<?php if($result){foreach($result as $val){?>
		<tr>
			<td width="40" align="center"><input type="checkbox" name="name[]" checked="checked" class="checkbox" value="<?php echo $val['filename'];?>" /></td>
			<td width="120"><?php echo $val['filename'];?></td>
			<td width="80" align="center"><?php echo $val['filesize'];?></td>
			<td width="150" align="center"><?php echo $val['mtime'];?></td>
			<td width="60" align="center"><?php echo $val['volume'];?></td>
			<td width="80" align="center"><a href="javascript:confirmUrl('确定要将数据还原到 <?php echo $val['mtime'];?> 吗？','?file=db&action=import&do_submit=1&filename=<?php echo $val['filename'];?>')">导入</a> | <a href="?file=db&action=down&filename=<?php echo $val['filename'];?>">下载</a></td>
		</tr>
		<?php }?>
		<tr>
			<td width="40" align="center">
			<input type="checkbox" name="chkall2" value="1" class="checkbox" checked="checked" onclick="check_all_byname(this)" /></td>
			<td colspan="5" align="left">
			<label for="chkall">全选</label>
			<input type="button"  onclick="if(confirm('确实要删除所选备份文件?删除后不可恢复!')){this.form.action='?file=<?php echo $file;?>&action=delete';this.form.submit();}" class="submit" value="删除备份" />
			</td>
		</tr>
		</form>
		<?php }else{?>
		<tr><td colspan="5">暂未发现任何备份文件...</td></tr>	
		<?php }?>
		</table>
	</div>
</div>
</body>
</html>
