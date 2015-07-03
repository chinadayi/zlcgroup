<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $lang['LEFT-SYSTEM-11'];?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script type="text/javascript" src="admin/template/js/admin.js"></script>
<script type="text/javascript" src="admin/template/js/css.js"></script>
</head>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="javascript:void(0);" class="on"><?php echo $lang['LEFT-SYSTEM-11'];?></a></li>
		</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		出于对数据库负载的考虑, 建议定期清空操作日志!
		</fieldset>
		<table cellspacing="0" class="datalist" id="list" width="98%">
		<tr>
			<th width="10%">管理员</th>
			<th width="5%">请求</th>
			<th width="23%">访问页面</th>
			<th width="39%">来源页面</th>
			<th width="9%">操作IP</th>
			<th width="14%">操作日期</th>
		</tr>
		<form action="" method="post" name="myform">
		<input type="hidden" name="do_submit" value="1" />
		<?php if($result){foreach($result as $val){?>
		<tr>
			<td align="center"><?php echo $val['admin'];?></td>
			<td align="center"><?php echo $val['method'];?></td>
			<td><?php echo ADMIN_FILE.'?'.$val['query'];?></td>
			<td><?php echo $val['comeurl'];?></td>
			<td align="center"><a href="http://www.ip138.com/ips138.asp?ip=<?php echo $val['ip'];?>" target="_blank"><?php echo $val['ip'];?></a></td>
			<td align="center"><?php echo date('Y-m-d H:i:s',$val['time']);?></td>
		</tr>
		<?php }?>
		<tr>
			<td colspan="6" align="left">
			&nbsp;<input type="button" onclick="this.form.submit();" class="submit" value="清空日志" />
			</td>
		</tr>
		</form>
		<?php }else{?>
		<tr><td colspan="6">暂时没有操作日志记录...</td></tr>	
		<?php }?>
		</table>
	</div>
</div>
</body>
</html>
