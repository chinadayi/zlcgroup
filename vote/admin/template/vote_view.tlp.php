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
<script language="javascript" src="admin/template/js/css.js"></script>
</head>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="?mod=vote&file=vote&action=manage">投票管理</a></li>
			<li><a href="javascript:void(0);" class="on">查看投票</a></li>			
		</ul>
	</div>
	<div class="main">

	<table cellspacing="0" class="sub">
		<tr>
			<td><?php echo $votestr;?></td>
		</tr>
		<tr class="bg2"><td><input type="button" class="button" onclick="window.location.href='<?php echo ADMIN_FILE;?>?mod=vote&file=vote&action=manage'" value="取消返回" /></td></tr>
	</table>

	</div>
</div>
</body>
</html>
