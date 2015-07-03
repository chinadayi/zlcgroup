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
	<?php if($moduleinfo)foreach($moduleinfo as $key =>$val){?>
	<?php if(isset($val['folder']) && !empty($val['folder']) && $module->roleid_check($val['folder'],$_roleid)){?>
    <div class="div_bigmenu">
        <div class="div_bigmenu_nav_down" id="nav_<?php echo $key+1;?>" onclick="javascript:lefttoggle(<?php echo $key+1;?>);"><?php echo $val['name'];?></div>
            <ul id="ul_<?php echo $key+1;?>">
				<?php
					$modulemenu=$module->get_menu($val['folder']);
					
					if(isset($modulemenu) && $modulemenu)foreach($modulemenu as $_modulemenu)
					{
						$v=explode("|",$_modulemenu);
				?>
				<li> <a href="<?php echo $v[0];?>" target='main'><?php echo $v[1];?></a></li>
				<?php
					}
				?>
			</ul>
        </div>
    </div>
	 <?php }}?>
</body>
</html>

