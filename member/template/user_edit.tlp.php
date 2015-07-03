<?php
	!defined('MEMBER_CENTER') && exit('Access Denied!');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $memlang['member-center'];?></title>
<base href="<?php echo $RETENG['site_url'];?>" />
<link href="member/template/images/style.css" rel="stylesheet" type="text/css" />
<script src="images/js/jquery.min.js"></script>
<script src="images/js/check.func.js"></script>
<script language="javascript" type="text/javascript">
$(document).ready(function(){checkForm(0);});
$(document).ready(function(){$("#info_areaid_").val(<?php echo $_areaid;?>);});
</script>
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
	<li><a href="member/index.php?file=user&action=editphoto"><?php echo $memlang['photo-upload'];?></a></li>
	<li class="active"><a href="member/index.php?file=user&action=edit"><?php echo $memlang['base-info'];?></a></li>
	<li><a href="member/index.php?file=user&action=editpsw"><?php echo $memlang['pwd-info'];?></a></li>
	<li><a href="member/index.php?file=user&action=upgrade"><?php echo $memlang['upgrade-info'];?></a></li>
</ul>
</div>
<div class="display">
<form action="" method="post" name="myform" >
<input type="hidden" name="do_submit" value="1" />
<input type="hidden" name="file" value="<?php echo $file;?>"> 
<input type="hidden" name="action" value="<?php echo $action;?>">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td width="25%" align="left"><strong><?php echo $memlang['member-username'];?></strong>：</td><td align="left" valign="top" style="padding-left:10px"><?php echo $_username;?></td></tr>
<tr><td width="25%" align="left"><strong><?php echo $memlang['member-email'];?></strong>：</td><td align="left" valign="top" style="padding-left:10px"><input type="text" name="info[email]" id="email" value="<?php echo $_email;?>" datatype="email" /></td></tr>
<?php if($forms)foreach($forms as $val){ ?>
<tr>
	<td width="25%" align="left" valign="top"><strong><?php echo $val['name'];?></strong>：</td>
	<td align="left" valign="top" style="padding-left:10px">
	<?php echo $val['form'];?> <?php echo $val['unit']?$val['unit']:'';?>
	<span><?php echo $val['tips'];?></span>
	</td>
</tr>
<?php }?>
<tr><td align="center" colspan="2"><input type="button" value="<?php echo $memlang['do-edit'];?>" name="dosubmit" onClick="doSubmit(this);" class="input_sub" />
		&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="<?php echo $memlang['do-reset'];?>" name="doreset" class="input_sub" /></td></tr>&nbsp;&nbsp;&nbsp;&nbsp;
</table>
</form>
</div>
</div>


</div>
<?php include 'footer.tlp.php';?>
</div>
</body>
</html>
