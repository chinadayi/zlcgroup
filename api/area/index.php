<?php
	require substr(dirname(__FILE__),0,-9).'/include/common.inc.php';

	session_start();

	if(isset($id))
	{
		$id=intval($id);
		set_cookie('areaid',$id);
		showmsg('地区设置成功!',SITE_URL);
	}

	/*
		SEO数据
	*/
	$head['title'] = '选择地区-'.$RETENG['site_name'];
	$head['keywords'] =$RETENG['meta_keywords'];
	$head['description'] =$RETENG['meta_description'];
	
	$reteng_postion='<a href="'.$RETENG['site_url'].'">首页</a>'.SEPARATOR.'选择地区';
	include template('area');
?>