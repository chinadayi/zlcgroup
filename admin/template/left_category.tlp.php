<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link href="admin/template/css/left.css" type="text/css" rel="stylesheet" />
<title>左侧菜单</title>
<script src="images/js/jquery.min.js"></script>
<script language="javascript" type="text/javascript" charset="utf-8" src="admin/template/js/admin.js"></script>
</head>

<body oncontextmenu="return false" ondragstart="return false" onSelectStart="return false">

<?php if($check_admin->roleid_check(6,$_roleid)){?>
<div class="div_bigmenu">
	<div class="div_bigmenu_nav_down" id="nav_2" onclick="javascript:lefttoggle(2);"><?php echo $lang['LEFT-CATEGORY-1'];?></div>
	<ul id="ul_2">
		<li><a href="<?php echo ADMIN_FILE;?>?file=category&action=manage" target='main'><?php echo $lang['LEFT-CATEGORY-2'];?></a></li>
		<li><a href="<?php echo ADMIN_FILE;?>?file=category&action=add" target='main'><?php echo $lang['LEFT-CATEGORY-3'];?></a></li>
		<li><a href="<?php echo ADMIN_FILE;?>?file=category&action=adds" target='main'><?php echo $lang['LEFT-CATEGORY-4'];?></a></li>
		
	</ul>
</div>
<?php }?>
<?php if($check_admin->roleid_check(5,$_roleid)){?>
<div class="div_bigmenu">
	<div class="div_bigmenu_nav_down" id="nav_1" onclick="javascript:lefttoggle(1);"><?php echo $lang['LEFT-CATEGORY-8'];?></div>
	<ul id="ul_1">
		<li><a href="<?php echo ADMIN_FILE;?>?file=stepselect&action=manage" target='main'><?php echo $lang['LEFT-CATEGORY-9'];?></a></li>
		<li><a href="<?php echo ADMIN_FILE;?>?file=stepselect&action=add" target='main'><?php echo $lang['LEFT-CATEGORY-10'];?></a></li>
	</ul>
</div>
<?php }?>
</body>
</html>