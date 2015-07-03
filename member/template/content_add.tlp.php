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
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script src="images/js/check.func.js"></script>
<script language="javascript" type="text/javascript">
	$(document).ready(function(){
		checkForm(1);
	});
</script>
</head>
<body>
<div id="warp">
<?php include 'header.tlp.php';?>
<div class="container clearfix">
<?php include 'sidebar.tlp.php';?>

<div id="content">
<div id="here">
<h2 class="title"><?php echo $memlang['content-manage'];?></h2>
</div>
<div class="tabs_header">
<div id="search_user">
<form action="member/index.php?" method="get" name="search">
<input type="hidden" name="file" value="content"> 
<input type="hidden" name="action" value="manage">
<input type="hidden" name="catid" value="<?php echo $catid;?>">
<input name="k" type="text" value="<?php echo isset($k)?htmlspecialchars(stripslashes($k)):'';?>" class="input_text"  style="width:100px"/>
<input type="submit" name="Submit2" value="<?php echo $memlang['search-btn'];?>" class="input_sub" />
</form>
</div>
</div>
<div class="display">

<form action="member/index.php?" method="post" name="myform">
<input type="hidden" name="do_submit" value="1" />
<input type="hidden" name="info[catid]" value="<?php echo $catid;?>" />
<input type="hidden" name="file" value="<?php echo $file;?>"> 
<input type="hidden" name="action" value="<?php echo $action;?>">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<?php if($forms)foreach($forms as $val){ ?>
	<tr>
		<td width="20%" align="right"><?php echo $val['name'];?>：</td>
		<td align="left" valign="top" style="padding-left:10px">
		<?php echo $val['form'];?> <?php echo $val['unit']?$val['unit']:'';?>
		<span><?php echo $val['tips'];?></span>
		</td>
	</tr>
	<?php }?>
	<tr><td align="center" colspan="2"><input type="button" value="<?php echo $memlang['do-post'];?>" name="dosubmit" onClick="doSubmit(this);" class="input_sub" />
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
