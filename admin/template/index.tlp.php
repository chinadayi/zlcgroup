<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<title><?php echo $RETENG['site_name'];?> - 后台控制面板</title>
</head>
<frameset rows="96,*,4" frameborder="no" border="0" framespacing="0">
	<frame src="?file=top" noresize="noresize" id="topFrame" frameborder="0" name="topFrame" marginwidth="0" marginheight="0" scrolling="no">
	<frameset rows="*" cols="185,*" id="frame" framespacing="0" frameborder="no" border="0">
		<frame src="?file=left" name="leftFrame" id="leftFrame" noresize="noresize" marginwidth="0" marginheight="0" frameborder="0" scrolling="yes">
		<frame src="?file=main" name="main" id="main" marginwidth="0" marginheight="0" frameborder="0" scrolling="yes">
	</frameset>
	<frame src="admin/template/bottom.html" noresize="noresize" id="bottomFrame" frameborder="0" name="bottomFrame" marginwidth="0" marginheight="0" scrolling="no">
<noframes>
	<body>当前浏览器不支持框架!</body>
</noframes>
</frameset>
</html>

