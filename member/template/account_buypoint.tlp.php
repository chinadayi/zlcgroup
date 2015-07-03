<?php
	!defined('MEMBER_CENTER') && exit('Access Denied!');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $memlang['member-center'];?></title>
<base href="<?php echo $RETENG['site_url'];?>" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script src="images/js/check.func.js"></script>
<script language="javascript" type="text/javascript">
	$(document).ready(function(){
		checkForm(0);
	});
</script>
<link href="member/template/images/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="warp">
<?php include 'header.tlp.php';?>
<div class="container clearfix">
<?php include 'sidebar.tlp.php';?>

<div id="content">
<script>
function ChangeShowBuyFen(amount){
	var fen;
	fen=Math.floor(amount)*<?=$pr[paymoneytofen]?>;
	document.getElementById("showbuyfen").innerHTML=fen+" 点";
}
</script>
<div id="here">
<h2 class="title"><?php echo $memlang['mem-point'];?></h2>
</div>
<div class="tabs_header">
<ul class="tabs clearfix">
	<li class="active"><a href="member/index.php?file=account&action=buypoint"><?php echo $memlang['buy-point'];?></a></li>
</ul>
</div>
<div class="display">
<div class="tdline">
<form action="member/index.php?file=<?php echo $file;?>&action=buypoint" method="post" name="myform" >
<input type="hidden" name="do_submit" value="1" />
<input type="hidden" name="forward" value="<?php echo getcururl();?>" />
<table border="0" cellpadding="0" cellspacing="0" width="100%">

<tr>
<td class="left"><?php echo $memlang['point-left'];?>：</td>
<td id="showbuyfen"> <?php echo $_point;?> <?php echo $memlang['point-unit'];?></td>
</tr>
<tr>
<td class="left"><?php echo $memlang['amount-left'];?>：</td>
<td><?php echo $_amount;?> <?php echo $memlang['amount-unit'];?></td>
</tr>
<tr>
<td class="left"><?php echo $memlang['buy-point'];?>：</td>
<td id="showbuyfen"> <input type="text" name="point" datatype="integer" size="6" /></td>
</tr>
<tr>
<td class="left"><?php echo $memlang['checkcode'];?>：</td>
<td id="showbuyfen"> <input type="text" name="inputcheckcode" datatype="limit" min=1 max="4" size="6" /> &nbsp;<img src='<?php echo RETENG_PATH;?>api/imcode/checkcode.php' onClick="this.src='<?php echo RETENG_PATH;?>api/imcode/checkcode.php?M'+Math.random()*5;" title="<?php echo $memlang['checkcode-reset'];?>" style="cursor:pointer" align="middle"></img> <span class="errtip" id="checkcodetip" style="color:#FF3300"></span></td>
</tr>
<tr>
<td colspan="2">

<input type="button" value="<?php echo $memlang['do-buy'];?>" name="dosubmit" onClick="doSubmit(this);" class="input_sub"/>
<span style="color:#FF3300"><?php echo $memlang['price-buy'];?>：<?php echo AMOUNTTOPOINT;?><?php echo $memlang['amount-unit'];?>/<?php echo $memlang['point-unit'];?></span>
</td>
</tr>
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
