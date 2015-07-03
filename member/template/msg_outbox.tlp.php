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
<li class="active"><a href="member/index.php?file=msg&action=outbox"><?php echo $memlang['send-box'];?></a></li>
<li><a href="member/index.php?file=msg&action=send"><?php echo $memlang['send-msg'];?></a></li>
</ul>
</div>
<div class="display">
<script>
function CheckAll(form)
  {
  for (var i=0;i<form.elements.length;i++)
    {
    var e = form.elements[i];
    if (e.name != 'chkall')
       e.checked = form.chkall.checked;
    }
  }
</script>
<form action="" method="post" id="listmsg"  name="myform">
<input type="hidden" name="do_submit" value="1" />
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table_title">
<tbody>
<tr>
<td class="select"><?php echo $memlang['selectall'];?></td>
<td class="infotitle"><?php echo $memlang['title'];?></td>
<td class="sender"><?php echo $memlang['msg-receive-user'];?></td>
<td class="time"><?php echo $memlang['msg-sent-time'];?></td>
</tr>
</tbody>
</table>

<?php if(is_array($result))foreach($result as $val){?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table_list">
<tbody>
<tr>
<td class="select"><input type="checkbox" name="id[]" value="<?php echo $val['id'];?>" /></td>
<td class="infotitle"><a href="member/index.php?file=<?php echo $file;?>&action=read&id=<?php echo $val['id'];?>"><?php echo $val['subject'];?></a></td>
<td class="sender"><?php echo $val['send_to_user'];?></td>
<td class="time"><?php echo date('Y-m-d H:i:s',$val['message_time']);?></td>
</tr>
</tbody>
</table>
<?php }?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table_title">
<tbody>
<tr>
<td class="select"><input type="checkbox" name="chkall" value="on" onclick="CheckAll(this.form)" class="noborder" /></td>
<td class="infotitle"><INPUT class="input_sub" id="button1" type="button" value="<?php echo $memlang['batch'].$memlang['delete'];?>" onClick="if(confirm('<?php echo $memlang['confirm'];?>')){this.form.action='member/index.php?file=<?php echo $file;?>&action=delete';this.form.submit();}" name="dodelete"></td><td><div align="right">
</div></td>
</tr>
<tr>
<td colspan="3"><?php echo $msg->pagestring;?></td>
</tr>
</tbody>
</table>
</form>
</div>
</div>



</div>
<?php include 'footer.tlp.php';?>
</div>
</body>
</html>
