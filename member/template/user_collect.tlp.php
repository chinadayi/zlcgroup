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
<script language="javascript">
function selectAll(formid,isselected)
{
	var form = document.forms[formid];
	for(var i=0;i<form.length;i++)
	{
		if(form[i].type=='checkbox')form[i].checked=isselected;
	}
} 
</script>
</head>
<body>
<div id="warp">
<?php include 'header.tlp.php';?>
<div class="container clearfix">
<?php include 'sidebar.tlp.php';?>

<div id="content">
<div id="here">
<h2 class="title"><?php echo $memlang['member-collect'];?></h2>
</div>
<div class="tabs_header">
<ul class="tabs clearfix">
<li class="active"><a href="javascript:void(0);"><?php echo $memlang['collect-manage'];?></a></li>
<li><a href="member/index.php?file=content&action=manage"><?php echo $memlang['my-message'];?></a></li>
</ul>
</div>
<div class="display">
<form action="" method="post" name="myform">
<input type="hidden" name="do_submit" value="1" />
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table_title">
<tbody>
<tr>
<td class="select"><?php echo $memlang['selectall'];?></td>
<td class="infotitle"><?php echo $memlang['title'];?></td>
<td class="click"><?php echo $memlang['clicks'];?></td>
<td class="time"><?php echo $memlang['collect-time'];?></td>
</tr>
</tbody>
</table>
<?php if(is_array($result))foreach($result as $val){?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table_list">
<tbody>
<tr>
<td class="select"><input type="checkbox" name="id[]" value="<?php echo $val['id'];?>" /></td>
<td class="infotitle"><a href="<?php echo $val['url'];?>" target="_blank"><?php echo $val['title'];?></a></td>
<td class="click">0</td>
<td class="time"><?php echo date('Y-m-d H:i:s',$val['time']);?></td>
</tr>
</tbody>
</table>
<?php }?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table_title">
<tbody>
<tr>
<td class="infotitle">&nbsp;&nbsp;<a href="javascript:;" onClick="selectAll(0,'checked');"><?php echo $memlang['selectall'];?></a> / <a href="javascript:;" onClick="selectAll(0,'');"><?php echo $memlang['do-cancel'];?></a>
</td><td><div align="right">
<INPUT class="input_sub" id="button1" type="button" value="<?php echo $memlang['batch'].$memlang['delete'];?>" onClick="if(confirm('<?php echo $memlang['confirm'];?>')){this.form.submit();}" name="dodelete">
</div></td>
</tr>
</tbody>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table_title">
<tbody>
<tr>
<td colspan="2"><?php echo $pagestring;?></td>
</tr>
</tbody>
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
