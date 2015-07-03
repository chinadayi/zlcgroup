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
	<div class="div_bigmenu">
		<div class="div_bigmenu_nav_down" id="nav_1" onclick="javascript:lefttoggle(1);"><?php echo $lang['LEFT-INDEX-1'];?></div>
		<ul id="ul_1">
			<?php if($check_admin->roleid_check(2,$_roleid)){?><li><a href="<?php echo ADMIN_FILE;?>?file=config&action=config&tab=1" target='main'><?php echo $lang['LEFT-INDEX-2'];?></a></li><?php }?>
			<?php if($check_admin->roleid_check(6,$_roleid)){?><li><a href="<?php echo ADMIN_FILE;?>?file=category&action=manage" target='main'><?php echo $lang['LEFT-INDEX-3'];?></a></li><?php }?>
			<?php if($check_admin->roleid_check(9,$_roleid)){?><li><a href="<?php echo ADMIN_FILE;?>?file=content&action=manage" target='main'>内容管理</a></li><?php }?>	
			<?php if($check_admin->roleid_check(9,$_roleid)){?><li><a href="<?php echo ADMIN_FILE;?>?file=comment&action=manage" target='main'>评论管理</a></li><?php }?>	
			<?php if($_roleid<=5){?><?php if($install['guestbook']){?><li><a href="<?php echo ADMIN_FILE;?>?mod=guestbook&file=guestbook&action=manage" target='main'>留言管理</a></li><?php }?><?php }?>
		</ul>
	</div>
	<?php if($_roleid<=5){?>
	<div class="div_bigmenu">
		<div class="div_bigmenu_nav_down" onclick="javascript:lefttoggle(2);" id="nav_2">分站管理</div>
		<ul id="ul_2">
			<li><a href="<?php echo ADMIN_FILE;?>?file=sitecrowd&action=manage" target='main'>分站管理</a></li>
			<li><a href="<?php echo ADMIN_FILE;?>?file=sitecrowd&action=issue" target='main'>发布点管理</a></li>
		</ul>
	</div>
	<?php }?>
	<?php if($check_admin->roleid_check(4,$_roleid)){?>
	<div class="div_bigmenu">
		<div class="div_bigmenu_nav_down" onclick="javascript:lefttoggle(3);" id="nav_3"><?php echo $lang['LEFT-SYSTEM-12'];?></div>
		<ul id="ul_3">
			<li> <a href="<?php echo ADMIN_FILE;?>?file=db&action=export" target='main'><?php echo $lang['LEFT-SYSTEM-12'];?></a></li>
			<li> <a href="<?php echo ADMIN_FILE;?>?file=db&action=import" target='main'><?php echo $lang['LEFT-SYSTEM-13'];?></a></li>
			<li> <a href="<?php echo ADMIN_FILE;?>?file=db&action=repair" target='main'><?php echo $lang['LEFT-SYSTEM-14'];?></a></li>
			<li> <a href="<?php echo ADMIN_FILE;?>?file=db&action=sql" target='main'>执行SQL命令</a></li>
		</ul>
	</div>
	<?php }?>
</body>
</html>

