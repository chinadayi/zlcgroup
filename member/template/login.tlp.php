<?php
	!defined('MEMBER_CENTER') && exit('Access Denied!');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<base href="<?php echo $RETENG['site_url'];?>" />
<title><?php echo $memlang['mem-login'];?>-<?php echo $RETENG['site_name'];?></title>
<link href="member/template/images/login.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript" src="images/js/jquery.min.js"></script>
<script language="javascript" type="text/javascript">
$(document).ready(function(){
	$('#username').focus();
	$('#loginform').submit(function()
	{
		if($.trim($('#username').val()).length<1 || $.trim($('#username').val()).length>30)
		{
			$('#msg').html('<font color="#FF0000"><?php echo $memlang['login-err-username'];?></font>');
			$('#username').focus();
			return false;
		}
		else
		{
			$('#msg').html('<?php echo $memlang['login-ok-username'];?>');
		}
		
		if($.trim($('#password').val()).length<3 || $.trim($('#password').val()).length>30)
		{
			$('#msg').html('<font color="#FF0000"><?php echo $memlang['login-err-pwd'];?></font>');
			$('#password').focus();
			return false;
		}
		else
		{
			$('#msg').html('<?php echo $memlang['login-ok-pwd'];?>');
		}
		
		<?php if(LOGIN_CHECKCODE_ENABLED){?>
		if($.trim($('#checkcode').val()).length!=4)
		{
			$('#msg').html('<font color="#FF0000"><?php echo $memlang['err-checkcode'];?></font>');
			$('#checkcode').focus();
			return false;
		}
		else
		{
			$('#msg').html('');
		}
		<?php }?>
		return true;
	})
	});
</script>
       <script type="text/javascript">
            var childWindow;
            function toQzoneLogin()
            {
                childWindow = window.open("member/oauth/index.php","TencentLogin","width=450,height=320,menubar=0,scrollbars=1, resizable=1,status=1,titlebar=0,toolbar=0,location=1");
            } 
            
            function closeChildWindow()
            {
                childWindow.close();
            }
        </script>
</head>
<body>
<div class="header-bg">
  <div class="header">
    <h1><a href="<?php echo $RETENG['site_url'];?>"><img src="member/template/images/logo.png" alt="<?php echo $RETENG['site_name'];?>" title="<?php echo $RETENG['site_name'];?>"></a></h1>
    <div class="h-link"><a href="<?php echo $RETENG['site_url'];?>"><?php echo $memlang['index'];?></a>|<a href="sitemaps.xml" target="_blank"><?php echo $memlang['rss'];?></a>|<a href="javascript:void(0);" onClick="this.style.behavior='url(#default#homepage)';this.setHomePage('<?php echo $RETENG['site_url'];?>');" title="<?php echo $RETENG['site_name'];?><?php echo $memlang['homepage'];?>"><?php echo $memlang['homepage'];?></a>|<a href="javascript:window.external.addFavorite('<?php echo $RETENG['site_url'];?>','<?php echo $RETENG['site_name'];?>');"><?php echo $memlang['addfavorite'];?></a></div>
  </div>
</div>
<div class="container">
  <div class="page-wrap">
    <div class="login-page-box">
      <div class="match-pic fl"><img src="member/template/images/login_match.jpg" width="430" height="230" alt="<?php echo $RETENG['site_name'];?>"/></div>
      <div class="login-box fr"> <strong class="login-title"><?php echo $memlang['mem-login'];?></strong>
        <div class="input-box">
          <form action="member/index.php?file=login&action=login" method="post"  name="myform" id="loginform">
		  <input type="hidden" name="do_submit" value="1" />
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="23%" align="right" class="gray"><?php echo $memlang['mem-username'];?>：</td>
                <td width="77%" align="left"><input name="username" id="username" type="text" class="txt"/></td>
              </tr>
              <tr>
                <td align="right" class="gray"><?php echo $memlang['mem-pwd'];?>：</td>
                <td align="left"><input name="password" id="password" type="password" class="txt"/></td>
              </tr>
			  <?php if(LOGIN_CHECKCODE_ENABLED){?>
              <tr>
                <td align="right" class="gray"><?php echo $memlang['mem-checkcode'];?>：</td>
                <td align="left"><input name="chkcode" id="checkcode" type="text" class="txt txt2"/>
                 <span class="code"><img src="api/imcode/checkcode.php" width="65" id="checkcode" class="checkcode" onclick="this.src='api/imcode/checkcode.php?id='+Math.random()*5;"  alt="<?php echo $memlang['checkcode-reset'];?>" align="absmiddle"/></span><a href="javascript:void(0);" onclick="$('.checkcode').attr('src','api/imcode/checkcode.php?id='+Math.random()*5);" class="blue fz12"><?php echo $memlang['checkcode-reset2'];?></a></td>
              </tr>
			  <?php }?>
              <tr>
                <td align="right" class="gray"><?php echo $memlang['mem-cookie'];?>：</td>
                <td align="left">
<select name="cookietime">
	<option value="0"><?php echo $memlang['cookie-0'];?></option>
	<option value="86400"><?php echo $memlang['cookie-86400'];?></option>
	<option value="2592000"><?php echo $memlang['cookie-2592000'];?></option>
	<option value="31536000"><?php echo $memlang['cookie-31536000'];?></option>
</select>
				</td>
              </tr>
            </table>

            <p class="login-btn-box">
              <input name="dolongin" type="submit" value="<?php echo $memlang['btn-login'];?>" class="login-btn"/>
              <a href="member/index.php?file=login&action=getpwd" class="blue"><?php echo $memlang['forget-pwd'];?></a></p>
            <p class="login-error-tips red" id="msg"></p>
            <div class="no-accoutn"><?php echo $memlang['no-register'];?> <a href="member/index.php?file=login&action=register" class="blue"><?php echo $memlang['register-now'];?></a> <img src="member/template/images/qq_login.png" onclick='toQzoneLogin()' 
            style="cursor:hand"></div>
          </form>
        </div>
      </div>
      <div class="clear"></div>
    </div>
  </div>
</div>
<div class="footer">

  <p class="copyright"><?php echo $RETENG['copyright'];?></p>
  <p class="copyright"><?php echo $RETENG['icpno'];?></p>
</div>
</body>
</html>
