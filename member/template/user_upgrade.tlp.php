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
<h2 class="title"><?php echo $memlang['member-info'];?></h2>
</div>
<div class="tabs_header">
<ul class="tabs clearfix">
	<li><a href="member/index.php?file=user&action=editphoto"><?php echo $memlang['photo-upload'];?></a></li>
	<li><a href="member/index.php?file=user&action=edit"><?php echo $memlang['base-info'];?></a></li>
	<li><a href="member/index.php?file=user&action=editpsw"><?php echo $memlang['pwd-info'];?></a></li>
	<li class="active"><a href="member/index.php?file=user&action=upgrade"><?php echo $memlang['upgrade-info'];?></a></li>
</ul>
<div id="search_user"></div>
</div>
<div class="display">
<div class="infolist">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table_title">
<tr>
<td width="12%" align="center"><strong><?php echo $memlang['grade-name'];?></strong></td>
<td width="45%" align="center"><strong><?php echo $memlang['grade-privilege'];?></strong></td>
<td width="19%" align="center"><strong><?php echo $memlang['grade-frs'];?><?php echo UPGRADEMETHOD=='point'?$memlang['grade-point']:$memlang['grade-amount'];?></strong></td>
<td width="24%" align="center"><strong><?php echo $memlang['grade-expire'];?></strong></td>
</tr>
</table>


<?php if($r)foreach($r as $val){?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="12%" valign="top" align="center"><strong><?php echo $val['name'];?></strong></td>
<td width="45%"><?php echo nl2br($val['info']);?></td>
<td width="19%" valign="top"  align="center"><font color="#FF0000"><b><?php echo UPGRADEMETHOD=='point'?$val['point']:$val['amount'];?><?php echo UPGRADEMETHOD=='point'?$memlang['point-unit']:$memlang['amount-unit'];?><?php echo $memlang['grade-unit'];?></b></font></td>
<td width="24%" valign="top" align="center"><?php echo $val['grade']==10?$memlang['grade-forever']:($val['grade']==$_gradeid?date('Y-m-d',$_expire):$memlang['grade-unavailable']);?></td>
</tr>

<?php }?>
<form action="" method="post" name="myform" >
<input type="hidden" name="do_submit" value="1" />
<input type="hidden" name="file" value="<?php echo $file;?>"> 
<input type="hidden" name="action" value="<?php echo $action;?>">
<tr>
<td colspan="4" style="padding-top:8px" valign="middle">
<input type="submit" value="<?php echo $memlang['grade-btn-upgrade'];?>" onclick="if(!confirm('<?php echo $memlang['confirm'];?>'))return false;" name="doupgrade" />
&nbsp;
<select name="expire">
	<option value="1">30<?php echo $memlang['day'];?></option>
	<option value="2">60<?php echo $memlang['day'];?></option>
	<option value="3">90<?php echo $memlang['day'];?></option>
	<option value="4">120<?php echo $memlang['day'];?></option>
	<option value="5">150<?php echo $memlang['day'];?></option>
	<option value="6" selected="selected">180<?php echo $memlang['day'];?></option>
	<option value="7">210<?php echo $memlang['day'];?></option>
	<option value="8">240<?php echo $memlang['day'];?></option>
	<option value="9">270<?php echo $memlang['day'];?></option>
	<option value="10">300<?php echo $memlang['day'];?></option>
	<option value="11">330<?php echo $memlang['day'];?></option>
	<option value="12">365<?php echo $memlang['day'];?></option>
	<option value="24">730<?php echo $memlang['day'];?></option>
</select>
&nbsp;
<select name="gradeid" id="gradeid">
	<?php
	if($r)foreach($r as $_r)
	{
		if($_r['grade']>=$_gradeid)echo '<option value="'.$_r['grade'].'">'.$_r['name'].'</option>';
	}
	?>
</select>
&nbsp;&nbsp;
<span>
<?php echo $memlang['point-left'];?> <font color="#FF0000"><b><?php echo $_point;?></b></font> <?php echo $memlang['point-unit'];?> <?php echo $memlang['amount-left'];?> <font color="#FF0000"><b><?php echo $_amount;?></b></font> <?php echo $memlang['amount-unit'];?>
</span>
</td>
</tr>
</form>
</table>
</div>
</div>
</div>


</div>
<?php include 'footer.tlp.php';?>
</div>
</body>
</html>
