<?php
	!defined('MEMBER_CENTER') && exit('Access Denied!');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<title><?php echo $memlang['member-center'];?></title>
<base href="<?php echo $RETENG['site_url'];?>" />
<link href="member/template/images/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="images/js/jquery.min.js" charset="utf-8"></script>
<script language="javascript" charset="utf-8">
$(document).ready(function(){
	if(<?php echo $_message;?>)
	{
		$('#tgmsg').show('slow');
	}
	$('#dcspan').html(dcspan);
});
</script>
</head>
<body>
<div class="tgmsg" id="tgmsg"><img src="member/template/images/sms.gif" /> <a href="member/index.php?file=msg&action=inbox"><?php echo $memlang['you-has'];?><?php echo $_message;?><?php echo $memlang['no-miss'];?></a></div>
<div id="warp">
<?php include 'header.tlp.php';?>
<div class="container clearfix">
<?php include 'sidebar.tlp.php';?>

<div id="content">
<div class="content_main">
<div class="clearfix" id="user">
<div class="user_img" style="padding-top:10px"> <a href="member/index.php?file=user&action=editphoto"><img src="<?php echo $_facephoto;?>" alt="<?php echo $_username;?>"  title="<?php echo $_username;?>" /></a></div>
<div class="user_info">
<h3 class="title"><em><?php echo $_username;?></em>，<?php echo $memlang['welcome-back'];?> <span><a href="member/index.php?file=msg&action=inbox"><?php echo max(0,$_message);?></a></span></h3>
<p><?php echo $memlang['point-left'];?> <font color="#FF0000"><b><?php echo $_point;?></b></font> <?php echo $memlang['point-unit'];?> <?php echo $memlang['amount-left'];?> <font color="#FF0000"><b><?php echo $_amount;?></b></font> <?php echo $memlang['amount-unit'];?></p>
<ul>
<li><?php echo $memlang['member-grade'];?>：<?php echo $_gradename;?> <a href="member/index.php?file=user&action=upgrade"><font color="#FF0000"><u><?php echo $memlang['grade-update'];?></u></font></a></li>
<li><?php echo $memlang['reg-time'];?>：<?php echo date('Y-m-d H:i:s',$_regtime);?></li>
<li><?php echo $memlang['expire-time'];?>：<?php echo $_expire?date('Y-m-d H:i:s',$_expire):$memlang['expire-long'];?></li>
</ul>
</div>
</div>
<div class="fava">
<div class="tabs_header">
<ul class="tabs clearfix">
<li class="active"><a href="member/index.php?file=content&action=manage"><?php echo $memlang['my-message'];?></a></li>

</ul>
</div>
<div class="display">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table_title">
<tbody>
<tr>
<td class="infotitle" align="center"><b><?php echo $memlang['title'];?></b></td>
<td class="click"><b><?php echo $memlang['clicks'];?></b></td>
<td class="time"><b><?php echo $memlang['inputtime'];?></b></td>
</tr>
</tbody>
</table>
<?php if(is_array($content))foreach($content as $val){?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table_list">
<tbody>
	<tr>
		<td class="infotitle"><a href="<?php echo $RETENG['site_url'].$val['url'];?>" target="_blank"><font <?php echo $val['style']?'style="'.$val['style'].'"':'style="font-size:12px"';?>><?php echo sub_string(htmlspecialchars($val['title']),40);?></font></A> &nbsp;<?php echo $val['thumb']?'<font color="#ff0000">图</font>':'';?>&nbsp;<?php echo $val['posid']?'<font color="#00ff00">荐</font>':'';?></td>
		<td class="click"><font color="#FF0000"><b><?php echo $val['clicks'];?></b></font></td>
		<td class="time"><?php echo date('Y-m-d',$val['inputtime']);?></td>
	</tr>
</tbody>
</table>
<?php }?>
</div>
</div>
</div>
<div class="content_sub">
<div class="box" id="search_user">
<h2 class="title" style="font-size:14px"><?php echo $memlang['search-tips'];?></h2>
<div class="line"></div>
<div class="pad">
<form action="member/index.php?" method="get" name="search" class="clearfix">
<input type="hidden" name="file" value="content"> 
<input type="hidden" name="action" value="manage">
<input name="k" type="text" value="<?php echo $memlang['search-k'];?>" id="keyboard" size="20" class="input_text" />
<input type="submit" name="Submit" value="<?php echo $memlang['search-btn'];?>" class="input_sub" />
</form>
<p><a href="member/index.php?file=content&action=manage"><?php echo $memlang['my-message'];?></a>| <a href="member/index.php?file=msg&action=inbox"><?php echo $memlang['my-msgbox'];?></a></p>
</div>
</div>

<div class="box">
<h2 class="title" style="font-size:14px"><?php echo $memlang['hot-post'];?></h2>
<div class="line"></div>
<div class="user_list" style="height:130px">
<ul class="clearfix">
<?php $i=1;if($newcontent)foreach($newcontent as $val){?>
	<li><span style="float:left"><a href="<?php echo $val['url'];?>" title="<?php echo $val['title'];?>" target="_blank"><?php echo $i;?>.<?php echo sub_string(strip_tags($val['title']),30,'...');?></a></span><span style="float:right"><?php echo $val['clicks'];?>次</span></li>
<?php $i++;}else{echo '<li>'.$memlang['no-msg'].'！</li>';}?>
</ul>
</div>
</div>

<div class="box">
<h2 class="title" style="font-size:14px"><?php echo $memlang['recent-post'];?></h2>
<div class="line"></div>
<div class="user_list" style="height:130px">
<ul class="clearfix">
<?php $i=1;if($topcontent)foreach($topcontent as $val){?>
	<li><span style="float:left"><a href="<?php echo $val['url'];?>" title="<?php echo $val['title'];?>" target="_blank"><?php echo $i;?>.<?php echo sub_string(strip_tags($val['title']),30,'...');?></a></span><span style="float:right"><?php echo date('m-d',$val['inputtime']);?></span></li>
<?php $i++;}else{echo '<li>'.$memlang['no-msg'].'！</li>';}?>
</ul>
</div>
</div>
<div style="margin:8px auto; width:250px; height:90px; clear:both" id="dcspan"></div>

</div>
</div>

</div>
<?php include 'footer.tlp.php';?>
</div>
</body>
</html>
