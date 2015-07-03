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
			<div class="title">恭喜，您已经注册成功！您的会员帐号为：<b><?php echo $registerinfo['username'];?> [<font color="#FF6600">待审核</font>]</b></div>
			<div class="msg">为确保帐户安全，我们会在 <font color="#FF6600">24小时</font> 内审核您的账号，尚未通过审核的账号暂时无法登陆会员中心。</div>
			<div><input type="button" value="返回首页" onclick="window.location.href='<?php echo $RETENG['site_url'];?>'" class="aduitbutton" /></div>
			<div class="guild">审核提示<br />
			  我们会在24小时内审核您的账号，如果超过24小时仍未审核，请及时联系网站客服人员。
			</div>
		</div>
	</div>
<div class="footer">
  <p class="copyright"><?php echo $RETENG['copyright'];?></p>
  <p class="copyright"><?php echo $RETENG['icpno'];?></p>
</div>
</body>
</html>
