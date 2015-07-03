<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<base href="<?php echo $RETENG['site_url'];?>" />
<title><?php echo $memlang['mem-register'];?>-<?php echo $RETENG['site_name'];?></title>
<link href="member/template/images/register.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript" src="images/js/jquery.min.js"></script>
<script language="javascript" type="text/javascript">
$(document).ready(function(){
	$('#username').focus();
	$('#regform').submit(function()
	{
		var email=/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
		var telephone=/^((\(\d{3}\))|(\d{3}\-))?1[3-9][0-9]\d{8}?$|15[0-9]\d{8}?$/;
		
		if($.trim($('#username').val()).length<1 || $.trim($('#username').val()).length>30)
		{
			$('#usernamemsg').html('<font color="#FF0000"><?php echo $memlang['register-err-username'];?></font>');
			$('#username').focus();
			return false;
		}
		else
		{
			var url='<?php echo SITE_URL;?>member/index.php?file=login&action=regcheckusername&data='+$('#username').val();
			$.get(url,function(data){
				if(data=='yes')
				{
					$('#usernamemsg').html('<font color=\'#FF0000\'>该用户名已存在，请更换!</font>');
					$('#username').focus();
					return false;
				}
				else
				{
					$('#usernamemsg').html('<?php echo $memlang['login-ok-username'];?>');
				}
			});
		}
		
		if($.trim($('#pwd').val()).length<3 || $.trim($('#pwd').val()).length>30)
		{
			$('#pwdmsg').html('<font color="#FF0000"><?php echo $memlang['register-err-pwd'];?></font>');
			$('#pwd').focus();
			return false;
		}
		else
		{
			$('#pwdmsg').html('<?php echo $memlang['login-ok-pwd'];?>');
		}
		
		if($('#pwdconfirm').val()!=$('#pwd').val())
		{
			$('#pwdconfirmmsg').html('<font color="#FF0000"><?php echo $memlang['register-err-pwd2'];?></font>');
			$('#pwdconfirm').focus();
			return false;
		}
		else
		{
			$('#pwdconfirmmsg').html('<?php echo $memlang['register-ok-pwd2'];?>');
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
		
		<?php if(AUDIT_TYPE==4){?>
		if(!telephone.test($('#telephone').val()))
		{
			$('#telephonemsg').html('<font color="#FF0000"><?php echo $memlang['register-err-telephone'];?></font>');
			$('#telephone').focus();
			return false;
		}
		else
		{
			$('#telephonemsg').html('<?php echo $memlang['register-ok-telephone'];?>');
		}
		<?php }?>
		
		<?php if($ischeckcode){?>
		if($.trim($('#checkcode').val()).length!=4)
		{
			$('#checkcodemsg').html('<font color="#FF0000"><?php echo $memlang['err-checkcode'];?></font>');
			$('#checkcode').focus();
			return false;
		}
		else
		{
			var url='<?php echo SITE_URL;?>member/index.php?file=login&action=regcheckcode&data='+$('#checkcode').val();
			$.get(url,function(data){
				if(data=='no')
				{
					$('#checkcodemsg').html('<font color=\'#FF0000\'>验证码不正确!</font>');
					$('#checkcode').focus();
					return false;
				}
				else
				{
					$('#checkcodemsg').html('');
				}
			});
		}
		<?php }?>
		
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
    <div class="register-page-box">
      <div class="reg-box fl"> <strong class="regi-title"><?php echo $memlang['mem-register-2'];?></strong>
        <div class="tb">
          <form action="member/index.php?file=login&action=register" method="post" name="myform" id="regform">
		  <input type="hidden" name="do_submit" value="1" />
		  <input type="hidden" name="registerinfo[openid]" value="<?php echo $user->openid;?>" />
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr class="hover">
                <th width="20%" scope="row"><span class="red">*</span><?php echo $memlang['mem-model'];?>：</th>
                <td width="80%"><?php echo $membermodel;?></td>
              </tr>
              <tr class="hover">
                <th width="20%" scope="row"><span class="red">*</span><?php echo $memlang['getpwd-username'];?>：</th>
                <td width="80%"><input name="registerinfo[username]" id="username" type="text" class="txt"/></td>
              </tr>
              <tr>
                <th width="20%" scope="row"></th>
                <td width="80%" valign="top"><p class="gray" id="usernamemsg"><?php echo $memlang['register-username-tips'];?></p>
                  </p></td>
              </tr>
              <tr class="hover">
                <th scope="row" valign="top"><span class="red">*</span><?php echo $memlang['register-pwd-1'];?>：</th>
                <td><input name="pwd" id="pwd" type="password" class="txt"/></td>
              </tr>
              <tr>
                <th width="20%" scope="row"></th>
                <td width="80%" valign="top"><p class="gray" id="pwdmsg"><?php echo $memlang['register-pwd-tips'];?></p>
                  </p></td>
              </tr>
              <tr class="hover">
                <th scope="row" valign="top"><span class="red">*</span><?php echo $memlang['register-pwd-2'];?>：</th>
                <td><input name="pwdconfirm" id="pwdconfirm" type="password" class="txt"/></td>
              </tr>
              <tr>
                <th width="20%" scope="row"></th>
                <td width="80%" valign="top"><p class="gray" id="pwdconfirmmsg"><?php echo $memlang['register-pwd-confirm'];?></p>
                  </p></td>
              </tr>
              <tr class="hover">
                <th scope="row" valign="top"><span class="red">*</span><?php echo $memlang['getpwd-email'];?>：</th>
                <td><input name="registerinfo[email]" id="email" type="text" class="txt"/></td>
              </tr>
              <tr>
                <th width="20%" scope="row"></th>
                <td width="80%" valign="top"><p class="gray" id="emailmsg"><?php echo $memlang['register-email-tips'];?></p>
                  </p></td>
              </tr>
			  <tr class="hover">
                <th scope="row" valign="top"><?php if(AUDIT_TYPE==4){?><span class="red">*</span><?php }?><?php echo $memlang['register-phone'];?>：</th>
                <td><input name="registerinfo[telephone]" id="telephone" type="text" class="txt"/></td>
              </tr>
              <tr>
                <th width="20%" scope="row"></th>
                <td width="80%" valign="top"><p class="gray" id="telephonemsg"><?php echo $memlang['register-telephone-tips'];?></p>
                  </p></td>
              </tr>
			  <?php if($ischeckcode){?>
              <tr class="hover">
                <th scope="row" valign="top"><span class="red">*</span><?php echo $memlang['getpwd-checkcode'];?>：</th>
                <td><input name="chkcode" id="checkcode" type="text" class="txt txt2"/>
                 <span class="code"><img src="api/imcode/checkcode.php" width="65" id="checkcode" class="checkcode" onclick="this.src='api/imcode/checkcode.php?id='+Math.random()*5;"  alt="<?php echo $memlang['checkcode-reset'];?>" align="absmiddle"/></span><a href="javascript:void(0);" onclick="$('.checkcode').attr('src','api/imcode/checkcode.php?id='+Math.random()*5);" class="blue fz12"><?php echo $memlang['checkcode-reset2'];?></a></td>
              </tr>
			  
              <tr>
                <th width="20%" scope="row"></th>
                <td width="80%" valign="top"><p class="gray" id="checkcodemsg"><?php echo $memlang['register-checkcode-tips'];?></p>
                  </p></td>
              </tr>
			  <?php }?>
              <tr>
                <th scope="row" valign="top"></th>
                <td><p class="gray agreement"><input name="regagreement" id="regagreement" checked="checked" type="checkbox" value="1" />
                    <?php echo $memlang['register-copyright-tips'];?></p></td>
              </tr>
              <tr>
                <th scope="row" valign="top"></th>
                <td><p>
                    <input name="doreg" type="submit" value="<?php echo $memlang['btn-register'];?>" class="register-btn"/>
                  </p></td>
              </tr>
            </table>
          </form>
        </div>
      </div>
      <div class="reg-login-tip fr">
        <div class="reg-login">
          <p class="fz14"><?php echo $memlang['has-register'];?><br><?php echo $memlang['login-now-2'];?></p>
          <p><input type="button" onclick="window.location.href='<?php echo $RETENG['site_url'];?>member/index.php?file=login&action=login'" value="<?php echo $memlang['btn-login'];?>" class="login-btn">
		  &nbsp;&nbsp;<a href="member/index.php?file=login&action=getpwd"><?php echo $memlang['forget-pwd'];?></a>
		  </p>
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
