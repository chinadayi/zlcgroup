<?php
	!defined('MEMBER_CENTER') && exit('Access Denied!');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>会员中心</title>
<base href="<?php echo $RETENG['site_url'];?>" />
<link href="member/template/images/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="images/js/jquery.min.js" charset="utf-8"></script>
</head>
<body>
<div id="warp">
<?php include member_tlp('header');?>
<div class="container clearfix">
<?php include member_tlp('sidebar');?>

<div id="content">

<div class="tabs_header">
<ul class="tabs clearfix">
<li class="active"><a href="member/index.php?mod=space&file=space&action=template">空间模板</a></li>
</ul>
</div>
<div class="display" style="height:400px">
<div class="table_bg">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td>
<ul style="width:100%; clear:both" class="floatul">
<?php foreach($r as $v){?>
<li><img src="template/<?php echo TLP_NAME;?>/space/<?php echo $v;?>/thumb.gif" width="150px" height="140px" /><br /><?php echo $_template==$v?'<font color="#ff3300">'.$v.'</font>':$v;?><br /><input type="button" value="使 用" name="dosubmit" <?php if($_template==$v){?> disabled="disabled"<? }?> onClick="<?php echo 'self.location.href=\''.$RETENG['site_url'].'member/index.php?mod=space&file=space&action=settemplate&do=1&template='.$v.'\'';?>" class="input_sub" /></li>
<?php }?>
</ul>
<br />
<div style="color:#FF0000; clear:both">提示：红色标记的为当前使用的模板</div>
</td>
</tr>
</table>
</div>
</div></div>


</div>
<?php include member_tlp('footer');?>
</div>
</body>
</html>
