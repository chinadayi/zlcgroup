<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link href="admin/template/css/left.css" type="text/css" rel="stylesheet" />
<title>内容管理</title>
<script src="images/js/jquery.min.js"></script>
<script language="javascript" type="text/javascript" charset="utf-8" src="admin/template/js/left.js"></script>
</head>

<body oncontextmenu="return false" ondragstart="return false" onSelectStart="return false">
	<?php if($check_admin->roleid_check(9,$_roleid)){?>
    <div class="div_cbigmenu">
        <div class="div_bigmenu_nav_down"><?php echo $lang['LEFT-CATEGORY-7'];?></div>
            <ul>
				<?php
					require RETENG_ROOT.'/include/options.class.php';
					$options=new options();
					$options->admincatlist();
				?>
			</ul>
        </div>
    </div>
	<?php }?>
</body>
</html>