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
	<?php if($check_admin->roleid_check(2,$_roleid)){?>
	<div class="div_bigmenu">
	<div class="div_bigmenu_nav_down" id="nav_1" onclick="javascript:lefttoggle(1);"><?php echo $lang['LEFT-SYSTEM-1'];?></div>
		<ul id="ul_1">
			<li> <a href="<?php echo ADMIN_FILE;?>?file=config&action=config&tab=1" target='main'><?php echo $lang['LEFT-SYSTEM-2'];?></a></li>
			<li> <a href="<?php echo ADMIN_FILE;?>?file=config&action=config&tab=2" target='main'><?php echo $lang['LEFT-SYSTEM-3'];?></a></li>
			<li> <a href="<?php echo ADMIN_FILE;?>?file=config&action=config&tab=3" target='main'><?php echo $lang['LEFT-SYSTEM-4'];?></a></li>
			<?php if($install['member']){?><li> <a href="<?php echo ADMIN_FILE;?>?file=config&action=config&tab=5" target='main'><?php echo $lang['LEFT-SYSTEM-5'];?></a></li><?php }?>
			<li> <a href="<?php echo ADMIN_FILE;?>?file=config&action=config&tab=6" target='main'><?php echo $lang['LEFT-SYSTEM-6'];?></a></li>
			<li> <a href="<?php echo ADMIN_FILE;?>?file=config&action=config&tab=7" target='main'><?php echo $lang['LEFT-SYSTEM-7'];?></a></li>
			<li> <a href="<?php echo ADMIN_FILE;?>?file=config&action=config_add" target='main'><?php echo $lang['LEFT-SYSTEM-19'];?></a></li>
		</ul>
	</div>
    <?php }?>
	<div class="div_bigmenu">
	<div class="div_bigmenu_nav_down" id="nav_2" onclick="javascript:lefttoggle(2);"><?php echo $lang['LEFT-SYSTEM-8'];?></div>
		<ul id="ul_2">
			<?php if($check_admin->roleid_check(3,$_roleid)){?><li> <a href="<?php echo ADMIN_FILE;?>?file=admin&action=role" target='main'><?php echo $lang['LEFT-SYSTEM-9'];?></a></li><?php }?>
			<li> <a href="<?php echo ADMIN_FILE;?>?file=admin&action=manage" target='main'><?php echo $lang['LEFT-SYSTEM-10'];?></a></li>
			<li> <a href="<?php echo ADMIN_FILE;?>?file=admin&action=log" target='main'><?php echo $lang['LEFT-SYSTEM-11'];?></a></li>
		</ul>
	</div>
	<div class="div_bigmenu">
	<div class="div_bigmenu_nav_down" id="nav_3" onclick="javascript:lefttoggle(3);"><?php echo $lang['LEFT-INDEX-6'];?></div>
		<ul id="ul_3">
			<li> <a href="<?php echo ADMIN_FILE;?>?file=admin&action=edit" target='main'><?php echo $lang['LEFT-INDEX-7'];?></a></li>
				<?php if($check_admin->roleid_check(3,$_roleid)){?><li> <a href="<?php echo ADMIN_FILE;?>?file=admin&action=log" target='main'><?php echo $lang['LEFT-INDEX-8'];?></a></li><?php }?>
			<li> <a href="javascript:void(0);" onClick="self.top.location.href='<?php echo ADMIN_FILE;?>?file=login&action=logout'"><?php echo $lang['ADMIN_LOGOUT'];?></a></li>
		</ul>
	</div>
</body>
</html>

