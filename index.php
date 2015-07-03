<?php

	if(!file_exists(dirname(__FILE__).'/data/retengcms.lock'))
	{
		header('location:install/index.php');
		exit();
	}
	include dirname(__FILE__).'/include/common.inc.php';

	if(!ISHTML || !file_exists(RETENG_ROOT.'index'.HTMLEXT) || isset($_GET['nocache']))
	{
		$head['title'] = $RETENG['site_name'].'-'.$RETENG['meta_title'];
		$head['keywords'] = $RETENG['meta_keywords'];
		$head['description'] = $RETENG['meta_description'];
		$dayu_url=$RETENG['site_url'];
		include template('index');
	}
	else
	{
		header( "HTTP/1.1 301 Moved Permanently" );
		header('location:index'.HTMLEXT);
	}
	exit();
?>