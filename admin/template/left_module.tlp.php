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

<body >

	<?php if($check_admin->roleid_check(14,$_roleid) && isset($path) && !empty($path) && $module->roleid_check($path,$_roleid)){?>
    <div class="div_bigmenu">
        <div class="div_bigmenu_nav_down" id="nav_1" onclick="javascript:lefttoggle(1);"><?php echo $modulename;?></div>
        <ul id="ul_1">
				<?php
					if(isset($modulemenu) && $modulemenu)foreach($modulemenu as $_modulemenu)
					{
						$v=explode("|",$_modulemenu);
				?>
				<?php
					if((trim($v[2]) && in_array($_roleid,explode(',',$v[2]))) || !trim($v[2]))
					{
				?>
				<li> <a href="<?php echo $v[0];?>" target='main'><?php echo $v[1];?></a></li>
				<?php
					}
					}
				?>
		</ul>
        </div>
    </div>
	 <?php }else{ ?>
	<?php if($check_admin->roleid_check(14,$_roleid)){?>
	<div class="div_bigmenu">
        <div class="div_bigmenu_nav_down" id="nav_2" onclick="javascript:lefttoggle(2);"><?php echo $lang['LEFT-MODULE-5'];?></div>
        <ul id="ul_2">
			<li> <a href="<?php echo ADMIN_FILE;?>?file=module&action=manage" target='main'><?php echo $lang['LEFT-MODULE-6'];?></a></li>
			<li> <a href="<?php echo ADMIN_FILE;?>?file=module&action=import" target='main'><?php echo $lang['LEFT-MODULE-8'];?></a></li>
			<li> <a href="<?php echo ADMIN_FILE;?>?file=module&action=guide" target='main'><?php echo $lang['LEFT-MODULE-7'];?></a></li>
		</ul>
        </div>
    </div>
	 <?php }?>
	 <?php if($check_admin->roleid_check(16,$_roleid)){?>
	 <div class="div_bigmenu">
        <div class="div_bigmenu_nav_down" id="nav_3" onclick="javascript:lefttoggle(3);"><?php echo $lang['LEFT-MODULE-1'];?></div>
        <ul id="ul_3">
			<li> <a href="<?php echo ADMIN_FILE;?>?file=model&action=manage" target='main'><?php echo $lang['LEFT-MODULE-2'];?></a></li>
				<li> <a href="<?php echo ADMIN_FILE;?>?file=model&action=install" target='main'><?php echo $lang['LEFT-MODULE-3'];?></a></li>
				<li> <a href="<?php echo ADMIN_FILE;?>?file=model&action=import" target='main'><?php echo $lang['LEFT-MODULE-4'];?></a></li>
		</ul>
        </div>
    </div>
    <?php }?>
	<?php if($check_admin->roleid_check(15,$_roleid)){?>
	<div class="div_bigmenu">
        <div class="div_bigmenu_nav_down" id="nav_4" onclick="javascript:lefttoggle(4);"><?php echo $lang['LEFT-MODULE-9'];?></div>
        <ul id="ul_4">
			<li> <a href="<?php echo ADMIN_FILE;?>?file=plugins&action=manage&actived=0" target='main'><?php echo $lang['LEFT-MODULE-10'];?></a></li>
			<li> <a href="<?php echo ADMIN_FILE;?>?file=plugins&action=manage&actived=1" target='main'><?php echo $lang['LEFT-MODULE-11'];?></a></li>
		</ul>
        </div>
    </div>
	 <?php }}?>

</body>
</html>

