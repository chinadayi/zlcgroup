<?php
	!defined('RETENG_INSTALL') && exit('Access Denied!');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="template/images/style.css" />
<title><?php echo RETENG_VERSION;?> 安装向导</title>
</head>
<body>
<div class="main">
	<div class="sidebar">
		<div class="logo" title="<?php echo RETENG_VERSION;?> 安装向导"><a href="http://cms.reteng.org/" target="_blank"></a></div>
		<div class="step">
			<ul class="done">
				<li class="statusdot"></li>
				<li class="name">1、软件使用授权许可协议</li>
			</ul>
			<ul class="done">
				<li class="statusdot"></li>
				<li class="name">2、环境以及文件目录权限检查</li>
			</ul>
			<ul class="done">
				<li class="statusdot"></li>
				<li class="name">3、数据库连接参数设置</li>
			</ul>
			<ul class="done">
				<li class="statusdot"></li>
				<li class="name">4、执行数据库安装</li>
			</ul>
			<ul class="done">
				<li class="statusdot"></li>
				<li class="name">5、完成安装</li>
			</ul>
		</div>
	</div>
	<div class="main">
		<div class="version">程序版本：<?php echo RETENG_VERSION,'&nbsp;',RETENG_RELEASE;?></div>
		<div class="bg_center">
			<div class="bg_left">
				<div class="bg_right">
					<div class="content">
						<div class="endclass">
						<strong>恭喜您，ReTengCMS 安装成功。</strong><br />
						网站首页访问地址：<a target="_blank" href="<?php echo $RETENG['site_url'];?>"><?php echo $RETENG['site_url'];?></a><br />
						系统后台登录地址：<a target="_blank" href="<?php echo $RETENG['site_url'];?>admin.php"><?php echo $RETENG['site_url'];?>admin.php</a>
						<input type="button" value="关闭页面" onclick="window.opener=null;window.open('','_self');window.close();" class="btn" />
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<div class="foot">&copy; 2014 ReTengCMS 热腾网 </div>
</body>
</html>
