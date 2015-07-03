<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台管理登录 - Powered by ZLCGroup</title>
<link href="admin/template/css/login3.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="admin/template/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript">
    $(function () {
        //检测IE
        if ('undefined' == typeof (document.body.style.maxHeight)) {
            window.location.href = 'ie6update.html';
        }
    });
</script>
</head>
<body class="loginbody">
<form action="" method="post" name="adminlogin" id="form1" onSubmit="return checklogin();">
<input type="hidden" name="do_submit" value="1" />
<div class="login-screen">
	<div class="login-icon">LOGO</div>
    <div class="login-form">
        <h1>系统管理登录</h1>
        <div class="control-group">
            <input name="username" type="text" id="txtUserName" class="login-field" placeholder="用户名" title="用户名" />
            <label class="login-field-icon user" for="username"></label>
        </div>
        <div class="control-group">
            <input name="password" type="password" id="txtPassword" class="login-field" placeholder="密码" title="密码" />
            <label class="login-field-icon pwd" for="txtPassword"></label>
        </div>
			 <?php
     if(CHECKCODE)
	 {
	 ?>
		<div class="control-group-yzm">
			<input name="checkcode" type="text" id="vdcode" name="checkcode" class="login-fields" placeholder="验证码" title="验证码"/>&nbsp;&nbsp;
			<img src="api/imcode/checkcode.php" onclick="this.src='api/imcode/checkcode.php?id='+Math.random()*5;" height="25" width="80"  style="cursor:pointer;" alt="验证码,看不清楚?请点击刷新验证码" align="baseline" />
        </div>
	<?php
	 }
	?>
        <div>
		<input type="submit" name="btnLogin" value="登 录" id="btnSubmit" class="btn-login" /></div>
        <span class="login-tips"><i></i><b id="msgtip">请输入用户名和密码</b></span>
    </div>
    <i class="arrow">箭头</i>
</div>
</form>
</body>
</html>