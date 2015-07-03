<?php
	!defined('MEMBER_CENTER') && exit('Access Denied!');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<title>会员中心</title>
<base href="<?php echo $RETENG['site_url'];?>" />
<link href="member/template/images/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="images/js/jquery.min.js" charset="utf-8"></script>
<script language="javascript">
$(document).ready(function(){
	if(<?php echo $_message;?>)
	{
		$('#tgmsg').show('slow');
	}
});
</script>
</head>
<body>
<div class="tgmsg" id="tgmsg"><img src="member/template/images/sms.gif" /> <a href="member/index.php?file=msg&action=inbox">您有<?php echo $_message;?>条新信息,不要错过哦！</a></div>
<div id="warp">
<?php include member_tlp('header');?>
<div class="container clearfix">
<?php include member_tlp('sidebar');?>

<div id="content">
<div id="here">
<h2 class="title">留言管理</h2>
</div>
<div class="tabs_header">
<ul class="tabs clearfix">
<li class="active"><a href="javascript:void(0);">留言管理</a></li>
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
<td class="select">选中</td>
<td class="infotitle" align="center">内容</td>
<td class="sender">IP</td>
<td class="time">留言时间</td>
</tr>
</tbody>
</table>

<?php if(is_array($result))foreach($result as $val){?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table_list">
<tbody>
<tr>
<td class="select"><input type="checkbox" name="id[]" value="<?php echo $val['id'];?>" /></td>
<td class="infotitle"><?php echo $val['status']?'':'<font color="#ff0000">[待审]</font>';?><?php echo sub_string(htmlspecialchars($val['content']),100,'...');?></td>
<td class="sender"><?php echo $val['ip'];?></td>
<td class="time"><?php echo date('Y-m-d H:i:s',$val['addtime']);?></td>
</tr>
</tbody>
</table>
<?php }?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table_title">
<tbody>
<tr>
<td class="select"><input type="checkbox" name="chkall" value="on" onclick="CheckAll(this.form)" class="noborder" /></td>
<td class="infotitle">
<INPUT class="input_sub" id="button1" type="button" value="批量审核" onClick="if(confirm('确定进行审核操作吗？')){this.form.action='member/index.php?mod=space&file=<?php echo $file;?>&action=guestbook_pass';this.form.submit();}" name="dopass">  
<INPUT class="input_sub" id="button1" type="button" value="批量待审" onClick="if(confirm('确定进行待审操作吗？')){this.form.action='member/index.php?mod=space&file=<?php echo $file;?>&action=guestbook_unpass';this.form.submit();}" name="dounpass">  
<INPUT class="input_sub" id="button1" type="button" value="批量删除" onClick="if(confirm('确定进行删除操作吗？')){this.form.action='member/index.php?mod=space&file=<?php echo $file;?>&action=guestbook_delete';this.form.submit();}" name="dodelete"></td><td><div align="right">
</div></td>
</tr>
<tr>
<td colspan="3"><?php echo $space->pagestring;?></td>
</tr>
</tbody>
</table>
</form>
</div>
</div>



</div>
<?php include member_tlp('footer');?>
</body>
</html>
