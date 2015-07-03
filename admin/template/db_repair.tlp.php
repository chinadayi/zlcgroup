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
</head>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="?file=db&action=export"><?php echo $lang['LEFT-SYSTEM-12'];?></a></li>
			<li><a href="?file=db&action=import"><?php echo $lang['LEFT-SYSTEM-13'];?></a></li>	
			<li><a href="javascript:void(0);" class="on"><?php echo $lang['LEFT-SYSTEM-14'];?></a></li>	
			<li><a href="?file=db&action=sql">执行SQL</a></li>
		</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		如需对某数据表进行修复，别忘了选择该数据表。
		</fieldset>
		<table cellspacing="0" class="datalist" id="list">
		<tr>
			<th width="40" class="firstcol"><input type="checkbox" name="chkall1" checked="checked" value="1" class="checkbox" onclick="check_all_byname(this)" /></th>
			<th width="120">数据库表</th>
			<th width="80">记录条数</th>
			<th width="80">使用空间</th>
			<th width="60">表类型</th>
			<th width="150">记录更新时间</th>
		</tr>
		<form action="" method="post" name="myform">
		<input type="hidden" name="do_submit" value="1" />
		<?php if($result){foreach($result as $val){?>
		<tr>
			<td width="40" align="center"><input type="checkbox" name="name[]" class="checkbox" checked="checked" value="<?php echo $val['Name'];?>" /></td>
			<td width="120"><?php echo $val['Name'];?></td>
			<td width="80" align="center"><?php echo $val['Rows'];?></td>
			<td width="80" align="center"><?php echo round($val['Data_length']/1024,2);?> K </td>
			<td width="60" align="center"><?php echo $val['Engine'];?></td>
			<td width="150" align="center"><?php echo $val['Update_time'];?></td>
		</tr>
		<?php }?>
		<tr>
			<td width="40" align="center">
			<input type="checkbox" name="chkall2" value="1" class="checkbox" checked="checked" onclick="check_all_byname(this)" /></td>
			<td colspan="5" align="left">
			<label for="chkall">全选</label>
			<input type="radio" name="operation" class="radio" value="optimize" checked="checked" />优化表
			<input type="radio" name="operation" class="radio" value="repair" />修复表 
			<input type="button" onclick="this.form.submit();" class="submit" value="执行操作" />
			<input type="button" class="button" onclick="window.location.href='<?php echo ADMIN_FILE;?>?file=db&action=export'" value="取消返回" />
			</td>
		</tr>
		</form>
		<?php }else{?>
		<tr><td colspan="5">数据库内未发现任何数据表...</td></tr>	
		<?php }?>
		</table>
	</div>
</div>
</body>
</html>
