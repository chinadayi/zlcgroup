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
		checkForm(0);
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
<h2 class="title"><?php echo $memlang['message-manage'];?></h2>
</div>
<div class="tabs_header">
<ul class="tabs clearfix">
<li><a href="member/index.php?file=msg&action=inbox"><?php echo $memlang['receive-box'];?></a></li>
<li><a href="member/index.php?file=msg&action=outbox"><?php echo $memlang['send-box'];?></a></li>
<li class="active"><a href="member/index.php?file=msg&action=send"><?php echo $memlang['send-msg'];?></a></li>
</ul>
</div>
<div class="display">
<form action="" method="post" name="myform" >
<input type="hidden" name="do_submit" value="1" />
<input type="hidden" name="file" value="<?php echo $file;?>"> 
<input type="hidden" name="action" value="<?php echo $action;?>">
<table width="100%" class="form_table">
<tr><td width="20%" align="left"><strong><?php echo $memlang['msg-receive-user'];?></strong>：</td>
<td width="80%" align="left" valign="top" style="padding-left:10px"><input type="text" name="msgs[send_to_user]"datatype="userName" value="<?php echo isset($sendtouser)?$sendtouser:'';?>" class="text_15x115" /></td></tr>
<tr><td width="20%" align="left"><strong><?php echo $memlang['title'];?></strong>：</td>
<td align="left" valign="top" style="padding-left:10px"><input type="text" name="msgs[subject]" datatype="limit" size="60" min=2 max=100 class="text_url" /></td></tr>
<tr><td width="20%" align="left"><strong><?php echo $memlang['msg-content'];?></strong>：</td>
<td align="left" valign="top" style="padding-left:10px"><?php echo $form->fckeditor('content','','Basic');?></td></tr>
<tr><td align="center" colspan="2"><input type="button" value="<?php echo $memlang['do-send'];?>" name="dosubmit" onClick="doSubmit(this);" class="input_sub" />
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
