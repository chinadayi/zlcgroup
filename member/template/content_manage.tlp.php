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
<h2 class="title"><?php echo $memlang['content-manage'];?></h2>
</div>
<div class="tabs_header">
<ul class="tabs clearfix">
<li class="active"><a href="member/index.php?file=content&action=add&catid=<?php echo $catid;?>">发布<?php echo catname($catid);?></a></li>
</ul>
<div id="search_user">
<form action="member/?" method="get" name="search">
<input type="hidden" name="file" value="<?php echo $file;?>"> 
<input type="hidden" name="action" value="<?php echo $action;?>">
<?php if($channelid){?><input type="button" style="font-size:12px" name="Submit" value="发布<?php echo $_c['channelname'];?>" onclick="self.location.href='index.php?file=content&action=add&channelid=<?php echo $channelid;?>';" /><?php }?>
<input name="k" type="text" value="<?php echo isset($k)?htmlspecialchars(stripslashes($k)):'';?>" class="input_text" style="width:100px" />
<input type="submit" name="Submit2" value="<?php echo $memlang['search-btn'];?>" class="input_sub" />
</form>
</div>
</div>
<div class="display">
<div class="infolist">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table_title">
<tr>
<td align="center"><?php echo $memlang['title'];?></td>
<td align="center"><?php echo $memlang['category-lang'];?></td>
<td align="center"><?php echo $memlang['clicks'];?></td>
<td align="center"><?php echo $memlang['inputtime'];?></td>
<td align="center"><?php echo $memlang['comments'];?></td>
<td align="center"><?php echo $memlang['pass'];?></td>
<td align="center"><?php echo $memlang['manage'];?></td>
</tr>

<?php 
if($result)
{
foreach($result as $val)
{
?>
<tr title="<?php echo $val['title'];?>" bgcolor="#FFFFFF">
<td><a href="<?php echo $RETENG['site_url'].$val['url'];?>" title="<?php echo $val['title'];?>" target="_blank"><font <?php echo $val['style']?'style="'.$val['style'].'"':'style="font-size:12px"';?>><?php echo sub_string(htmlspecialchars($val['title']),30);?></font></A> &nbsp;<?php echo $val['thumb']?'<font color="#ff0000">'.$memlang['pic'].'</font>':'';?>&nbsp;<?php echo $val['posid']?'<font color="#00ff00">'.$memlang['top'].'</font>':'';?></td>
<td align="center"><?php echo $val['catname'];?></td>
<td align="center"><font color="#FF0000"><b><?php echo $val['clicks'];?></b></font></td>
<td align="center"><?php echo date('Y-m-d',$val['inputtime']);?></td>
<td align="center"><font color="#33CC00"><b><?php echo $val['comments'];?></b></font></td>
<td align="center"><?php echo $val['status']=='1'?'√':'<font color="#FF3300">×</font>';?></td>
<td align="center"><a href="member/index.php?file=<?php echo $file;?>&action=edit&catid=<?php echo $val['catid'];?>&id=<?php echo $val['id'];?>"><?php echo $memlang['edit'];?></a> | <?php if(!$val['status']){?><a href="member/index.php?file=<?php echo $file;?>&action=delete&id=<?php echo $val['id'];?>"><?php echo $memlang['delete'];?></a><?php }else{?><a href="member/index.php?file=<?php echo $file;?>&action=top&id=<?php echo $val['id'];?>" onclick="if(confirm('置顶该信息会扣除您<?php echo TOPPOINT;?>个积分,您当前的积分为:<?php echo $_point;?>\n\n<?php echo $memlang['confirm'];?>')){return true;}else{return false;}"><?php echo $memlang['dotop'];?></a><?php }?></td>
</tr>

<?php }}else {echo '<tr><td colspan="7" align="center">'.$memlang['no-msg'].'</td></tr>';}?>

</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table_title">
<tr>
<td><?php echo $conobj->pagestring;?></td>
</tr>
</table>
</div>
</div>
</div>


</div>
<?php include 'footer.tlp.php';?>
</div>
</body>
</html>
