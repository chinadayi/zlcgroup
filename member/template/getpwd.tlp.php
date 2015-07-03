<?php
	!defined('MEMBER_CENTER') && exit('Access Denied!');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<base href="<?php echo $RETENG['site_url'];?>" />
<title><?php echo $memlang['get-pwd'];?>-<?php echo $RETENG['site_name'];?></title>
<link href="member/template/images/getpwd.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript" src="images/js/jquery.min.js"></script>
<script language="javascript" type="text/javascript">
$(document).ready(function(){
	$('#username').focus();
	$('#getpwdform').submit(function()
	{
		var email=/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
		
		if($.trim($('#username').val()).length<1 || $.trim($('#username').val()).length>30)
		{
			$('#usernamemsg').html('<font color="#FF0000"><?php echo $memlang['register-err-username'];?></font>');
			$('#username').focus();
			return false;
		}
		else
		{
			$('#usernamemsg').html('<?php echo $memlang['login-ok-username'];?>');
		}
		
		if(!email.test($('#email').val()))
		{
			$('#emailmsg').html('<font color="#FF0000"><?php echo $memlang['register-err-email'];?></font>');
			$('#email').focus();
			return false;
		}
		else
		{
			$('#emailmsg').html('<?php echo $memlang['register-ok-email'];?>');
		}
		
		if($.trim($('#checkcode').val()).length!=4)
		{
			$('#checkcodemsg').html('<font color="#FF0000"><?php echo $memlang['err-checkcode'];?></font>');
			$('#checkcode').focus();
			return false;
		}
		else
		{
			$('#checkcodemsg').html('');
		}
		return true;
	})
	});
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
    <div class="find-pw-page-box">
      <div class="find-pw-box fl"> <strong class="find-pw-title"><?php echo $memlang['get-pwd'];?></strong>
        <div class="find-pw">
          <form action="" method="post" name="myform" id="getpwdform">
		  <input type="hidden" name="do_submit" value="1" />
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th width="20%" scope="row"><?php echo $memlang['getpwd-username'];?>：</th>
                <td width="80%"><input name="username" type="text" id="username" size="30" class="txt"/> <span id="usernamemsg"></span></td>
              </tr>
              <tr>
                <th scope="row" valign="top"><?php echo $memlang['getpwd-email'];?>：</th>
                <td><input name="email" type="text" class="txt" size="30" id="email" />  <span id="emailmsg"></span></td>
              </tr>              
              <tr>
                <th scope="row" valign="middle"><?php echo $memlang['getpwd-checkcode'];?>：</th>
                <td class="pd4">
				<input name="chkcode" id="checkcode" type="text" class="txt" size="4"/>
                 <span class="code"><img src="api/imcode/checkcode.php" width="65" id="checkcode" class="checkcode" onclick="this.src='api/imcode/checkcode.php?id='+Math.random()*5;"  alt="<?php echo $memlang['checkcode-reset'];?>" align="absmiddle"/></span><a href="javascript:void(0);" onclick="$('.checkcode').attr('src','api/imcode/checkcode.php?id='+Math.random()*5);" class="blue fz12"><?php echo $memlang['checkcode-reset2'];?></a>
				  <span id="checkcodemsg"></span>
				</td></td>
              </tr>
              <tr>
                <th scope="row" valign="top"></th>
                <td class="pd10">
                  <input name="dogetpwd" type="submit" value="<?php echo $memlang['get-pwd'];?>" class="find-pw-btn"/>
                  </td>
              </tr>
            </table>
          </form>
        </div>
      </div>
       <div class="reg-login-tip fr">
        <div class="reg-login">
          <p class="fz14"><?php echo $memlang['login-now'];?></p>
          <p><input type="button" onclick="window.location.href='<?php echo $RETENG['site_url'];?>member/index.php?file=login&action=login'" value="<?php echo $memlang['btn-login'];?>" class="login-btn"></p>
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
