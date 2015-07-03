<?php
	!defined('MEMBER_CENTER') && exit('Access Denied!');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $memlang['member-center'];?></title>
<base href="<?php echo $RETENG['site_url'];?>" />
<script src="images/js/jquery.min.js"></script>
<link href="member/template/images/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="warp">
<?php include 'header.tlp.php';?>
<div class="container clearfix">
<?php include 'sidebar.tlp.php';?>

<div id="content">
<div id="here">
	<h2 class="title"><?php echo $memlang['member-info'];?></h2>
</div>
<div class="tabs_header">
<ul class="tabs clearfix">
	<li class="active"><a href="member/index.php?file=user&action=editphoto"><?php echo $memlang['photo-upload'];?></a></li>
	<li><a href="member/index.php?file=user&action=edit"><?php echo $memlang['base-info'];?></a></li>
	<li><a href="member/index.php?file=user&action=editpsw"><?php echo $memlang['pwd-info'];?></a></li>
	<li><a href="member/index.php?file=user&action=upgrade"><?php echo $memlang['upgrade-info'];?></a></li>
</ul>
</div>
<div class="display">
<form action="" method="post" name="myform" enctype="multipart/form-data">
<input type="hidden" name="do_submit" value="1" />
<input type="hidden" name="file" value="<?php echo $file;?>"> 
<input type="hidden" name="action" value="<?php echo $action;?>">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td align="center" valign="top" style="width:122px; overflow:hidden; height:122px; padding:0px; background-image:url(template/images/facebg.gif)"><a href="<?php echo $_facephoto;?>" target="_blank" title="<?php echo $memlang['picture-big'];?>"><img src="<?php echo $_facephoto;?>" width="100" id="showface"></a></td><td align="left" valign="top" style="padding-left:10px">1：<label><input type="radio" name="uptype" value="0"  checked="checked" onclick="document.getElementById('showface').src='<?php echo RETENG_PATH;?>'+$('#facephoto').val()" /> <?php echo $memlang['select-by-list'];?></label>
<select name="info[facephoto]" id="facephoto" onchange="document.getElementById('showface').src='<?php echo RETENG_PATH;?>'+this.value">
<?php 
if($photolist)foreach($photolist as $filename)
{
	if(in_array(get_fileext($filename),array('gif','jpg','jpeg','bmp','png')))
	{	
		$isselected=basename($filename)==basename($_facephoto)?'selected="selected"':'';
		echo '<option value="member/images/face/'.basename($filename).'" '.$isselected.'>'.basename($filename).'</option>';
	}
}
?>
</select>

<br><br><br>
2：<label><input type="radio" name="uptype" value="1"  onclick="document.getElementById('showface').src=$('#image_api_image').val()"/> <?php echo $memlang['select-by-server'];?> <?php echo $form->image('image',isset($_facephoto)?$_facephoto:'');?><br /> <span style="color:#FF0000">* <?php echo $memlang['photo-tips'];?></span></label>
<br><br><br><br>
<input type="submit" name="doupload" value="<?php echo $memlang['do-modify'];?>" class="input_sub">
</td></tr>
</table>
</form>
</div>
</div>


</div>
<?php include 'footer.tlp.php';?>
</div>
</body>
</html>
