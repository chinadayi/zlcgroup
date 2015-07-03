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
<div class="tdline">
<form action="" method="post" name="myform">
<input type="hidden" name="do_submit" value="1" />
<input type="hidden" name="msg[send_to_user]" value="<?php echo $info['send_from_user'];?>">
<input type="hidden" name="msg[subject]" value="[<?php echo $memlang['msg-reply'];?>]<?php echo $info['subject'];?>">
<input type="hidden" name="msg[folder]" value="outbox">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td class="left"><?php echo $memlang['title'];?>：</td>
<td class="right"><?php echo $info['subject'];?></td>
</tr>
<tr>
<td class="left"><?php echo $memlang['msg-sent-time'];?>：</td>
<td class="right"><?php echo date('Y-m-d H:i:s',$info['message_time']);?></td>
</tr>
<tr>
<td class="left"><?php echo $memlang['msg-content'];?>：</td>
<td class="right"><?php echo $info['content'];?></td>
</tr>
<tr>
<td class="left">&nbsp;</td>
<td class="right">[<a href="javascript:void(0);" onclick="javascript:history.go(-1);"><?php echo $memlang['goback'];?></a>]
[<a href="member/index.php?file=<?php echo $file;?>&action=delete&id=<?php echo $info['id'];?>" onclick="return confirm('<?php echo $memlang['confirm'];?>');"><?php echo $memlang['delete'];?></a>]</td>
</tr>
<?php if($info['folder']=='inbox' && $info['send_to_user']!='#system#' ){?>
<a name="replay"></a>
<tr>
<td class="left"><?php echo $memlang['msg-reply'];?>：</td>
<td class="right"><?php echo $form->fckeditor('content','','Basic');?></td>
</tr>
<tr>
<td colspan="2" align="center"><input type="submit" class="input_sub" value="<?php echo $memlang['do-send'];?>"/> &nbsp;&nbsp;&nbsp;&nbsp;	<input type="button" class="input_sub" value="<?php echo $memlang['goback'];?>" onClick="history.back()" /></td>
</tr>
<?php }?>
</table>
</form>
</div>
</div>
</div>




</div>
<?php include 'footer.tlp.php';?>
</div>
</body>
</html>
