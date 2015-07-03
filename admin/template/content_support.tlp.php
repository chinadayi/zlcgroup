<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(9,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>推荐内容</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script language="javascript" src="admin/template/js/css.js"></script>
<script src="images/js/check.func.js"></script>
</head>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="<?php echo $forwardurl;?>"><?php echo $lang['CONTENT-LANG-1'];?></a></li>
			<li><a href="javascript:void(0);" class="on"><?php echo $lang['CONTENT-LANG-5'];?></a></li>			
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		1：如果需要取消推荐位,去掉勾选即可!
	</fieldset>
	<form action="" method="post" name="myform">
	<input type="hidden" name="do_submit" value="2" />
	<input type="hidden" name="ids" value="<?php echo implode(',',$checkedid);?>" />
	<input type="hidden" name="forwardurl" value="<?php echo $forwardurl;?>" />
	<table cellspacing="0" class="sub">
		<tr>
			<td width="80" align="right" valign="top">推荐位：</td>
			<td>
				<ul style="list-style:none; clear:both">
			<?php
				$r=cache_read('posid.cache.php',RETENG_ROOT.'data/c/');
				if($r)foreach($r as $_r)
				{
					echo '<li style="line-height:18px; width:100px; clear:both"><label><input type="checkbox" style="border:0px" name="posid[]" value="'.$_r['id'].'" checked="checked">'.$_r['name'].'</label></li>';
				}
			?>
				<ul>
			</td>
		</tr>
		<tr class="bg2"><td></td><td><input type="button" class="button" onclick="this.form.submit();" value="推送推荐位" /> <input type="button" class="button" onclick="javascript:history.back();" value="取消返回" /></td></tr>
	</table>
	</form>

	</div>
</div>
</body>
</html>
