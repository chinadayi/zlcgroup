<?php
	!defined('MEMBER_CENTER') && exit('Access Denied!');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<base href="<?php echo $RETENG['site_url'];?>" />
<title><?php echo $memlang['audit_admin'];?>-<?php echo $RETENG['site_name'];?></title>
<link href="member/template/images/register.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript" src="images/js/jquery.min.js"></script>
</head>
<body>
<div class="header-bg">
  <div class="header">
    <h1><a href="<?php echo $RETENG['site_url'];?>"><img src="member/template/images/logo.png" alt="<?php echo $RETENG['site_name'];?>" title="<?php echo $RETENG['site_name'];?>"></a></h1>
    <div class="h-link"><a href="<?php echo $RETENG['site_url'];?>"><?php echo $memlang['index'];?></a>|<a href="sitemaps.xml" target="_blank"><?php echo $memlang['rss'];?></a>|<a href="javascript:void(0);" onClick="this.style.behavior='url(#default#homepage)';this.setHomePage('<?php echo $RETENG['site_url'];?>');" title="<?php echo $RETENG['site_name'];?><?php echo $memlang['homepage'];?>"><?php echo $memlang['homepage'];?></a>|<a href="javascript:window.external.addFavorite('<?php echo $RETENG['site_url'];?>','<?php echo $RETENG['site_name'];?>');"><?php echo $memlang['addfavorite'];?></a></div>
  </div>
</div>

	<div class="regBox">	
		<h1 class="regSuccessTit"><?php echo $memlang['audit_admin'];?></h1>
	  	<div class="regSuccess">
			<div class="title">恭喜，您已经注册成功！您的会员帐号为：<b><?php echo $registerinfo['username'];?> </b></div>
			<div class="msg">您的账号是： <font color="#FF6600"><?php echo $registerinfo['username'];?></font> 您的登陆密码是： <font color="#FF6600"><?php echo $pwdconfirm;?></font><br />请牢记您的账号密码，切勿泄露! <?php echo DETAILS_NEEDED?'您需要先完善资料后才能发布信息!':'';?> <a href="<?php echo $RETENG['site_url'];?>member/index.php?file=user&action=edit">完善资料>></a></div>
			<div><input type="button" value="返回首页" onclick="window.location.href='<?php echo $RETENG['site_url'];?>'" class="aduitbutton" /> &nbsp; <input type="button" value="完善资料" onclick="window.location.href='<?php echo $RETENG['site_url'];?>member/index.php?file=user&action=edit'" class="aduitbutton" /></div>
			<div class="guild">操作提示<br />
			  请牢记您的账号密码，切勿泄露!
			</div>
		</div>
	</div>
<div class="footer">
  <p class="copyright"><?php echo $RETENG['copyright'];?></p>
  <p class="copyright"><?php echo $RETENG['icpno'];?></p>
</div>
</body>
</html>
