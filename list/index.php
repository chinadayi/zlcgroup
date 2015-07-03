<?php
	require substr(dirname(__FILE__),0,-4).'/include/common.inc.php';
	$catid=intval($id);
	if($catid <=0)
	{
		show404('指定栏目ID='.$catid.'不存在!');
	}

	/*	
		获取栏目信息 由数组 $catinfo 存贮
	*/

	include RETENG_ROOT.'include/admin/category.class.php';
	$category=new category();
	$catinfo=$category->catinfo($catid);
	
	if(!$catinfo || $catinfo['type']!=1 && $catinfo['type']!=2)
	{
		show404('指定栏目ID='.$catid.'不存在!');
	}

	/*
		判断会员浏览权限
	*/
	if(isset($install['member']) && $install['member'])
	{
		require_once(RETENG_ROOT.'member/include/member.class.php');
		$memobj=new member();
		$groupidsviewcatid=$memobj->groupidviewcatid($_groupid);
		$gradeidsviewcatid=$memobj->gradeidviewcatid($_gradeid);
		$viewcatid=array_intersect($groupidsviewcatid,$gradeidsviewcatid);
		$viewcatid=$groupidsviewcatid;
		if(!in_array($catid,$viewcatid) && !in_array(0,$viewcatid))
		{
			show404('指定栏目ID='.$catid.'的访问权限不足!');
		}
	}	

	@extract($catinfo ,EXTR_SKIP);
	@extract($catinfo['setting'] ,EXTR_SKIP);
	@extract($catinfo['expand'] ,EXTR_PREFIX_ALL,'');
	/*
		定义常用模板变量
	*/
	$reteng_postion=get_pos($catid);
	$reteng_catname=$catinfo['catname'];
	$reteng_catid=$catid;
	$reteng_url=$catinfo['url'];

	$head['title'] = $catinfo['catname'].'-'.($catinfo['setting']['meta_title']?$catinfo['setting']['meta_title'] : $RETENG['site_name']);
	$head['keywords'] = $catinfo['setting']['meta_keywords'];
	$head['description'] = $catinfo['setting']['meta_description'];
	
	$page=isset($page)?intval($page):1;
	$template=isfinalcatid($catid)?$catinfo['setting']['templist']:$catinfo['setting']['tempindex'];
	if($do=="json")
	{
		//json调用的接口
	
	}elseif($do=="ajax")
	{
		//如果是ajax调用，增加$temp模版动态调用函数
		include template($temp);
	}
	elseif($do=="rss")
	{
		header("Content-type: text/xml; charset=utf-8");
		include template($template,'rss');
	}
	else
	{
		include template($template);
	}
?>
