<?php
	header("Cache-Control: no-cache, must-revalidate");
	include substr(dirname(__FILE__),0,-8).'/include/common.inc.php';
	$langdir=$childsite['site_dir']?$childsite['site_dir']:'zh-cn';
	$langfile=RETENG_ROOT.'comment/data/lang/'.$langdir.'/lang.inc.php';
	if(!file_exists($langfile))
	{
		$langfile=RETENG_ROOT.'comment/data/lang/zh-cn/lang.inc.php';
	}

	include_once $langfile;

	include_once RETENG_ROOT.'include/content.class.php';
	$conobj=new content();
	$coninfo=$conobj->get(intval($contentid));
	
	if(!intval($contentid) || !$coninfo || !$coninfo['iscomment'])
	{
		show404($commentlang['no-data']);
	}
	
	@extract($coninfo);
	$page=max(isset($page)?intval($page):1,1);
	$head['title']=$commentlang['comment'].'-'.$title;
	$reteng_postion='<a href="'.SITE_URL.'">'.$commentlang['page-index'].'</a> > '.$commentlang['page-comment'];
	if($do=="ajax")
	{
		include template($temp);
	}else
	{
		include template('index','comment');	
	}
	
?>