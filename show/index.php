<?php
	require substr(dirname(__FILE__),0,-4).'/include/common.inc.php';
	require RETENG_ROOT.'include/admin/category.class.php';
	$catobj=new category();
	require RETENG_ROOT.'include/content.class.php';
	$conobj=new content();
	
	session_start();
	$id=intval($id);
	
	/*
		获取内容以及栏目信息
	*/
	$coninfo=$conobj->get($id,true);
	if($coninfo)
	{
		$catinfo=$catobj->catinfo($coninfo['catid']);
	}

	if(!$id || !$coninfo || !$catinfo)
	{
		show404('指定内容ID='.$id.'不存在!');
	}

	if((!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) && !$coninfo['status'])
	{
		show404('文章内容尚未通过审核,将返回到网站首页...');
	}

	/*
		判断会员浏览权限
	*/
	if(isset($install['member']) && $install['member'])
	{
		include(RETENG_ROOT.'member/include/member.class.php');
		$memobj=new member();
		$groupidsviewcatid=$memobj->groupidviewcatid($_groupid);
		$gradeidsviewcatid=$memobj->gradeidviewcatid($_gradeid);
		$viewcatid=array_intersect($groupidsviewcatid,$gradeidsviewcatid);

		if(!in_array($coninfo['catid'],$viewcatid) && !in_array(0,$viewcatid))
		{
			show404('指定内容ID='.$id.'的访问权限不足!');
		}
	}
	
	if(!$coninfo['template'])
	{
		$coninfo['template']=$catinfo['setting']['temparticle'];
	}
	@extract($coninfo,EXTR_SKIP);
	
	/*
		定义常用模板变量
	*/
	$reteng_postion=get_pos($coninfo['catid']);
	$reteng_contentid=$id;
	$reteng_catname=$catinfo['catname'];
	$reteng_catid=$catid=$coninfo['catid'];
	$reteng_url=$coninfo['url'];
	$reteng_page='';
	$conarray=$page_array=array();
	if(empty($keywords) || trim($keywords)=="")
	{
		require(RETENG_ROOT.'include/wordsplit.class.php');
		$wordsplit=new wordsplit(RETENG_ROOT.'include/dict/cnwords.dict');
		$str=iconv('GBK', 'UTF-8', $title);
		$re=$wordsplit->splitWords($str);
		$keywords=iconv('UTF-8', 'GBK',implode(',',$re));
	}
	if($coninfo['ispage']==2) // 自动分页
	{
		$cons=preg_split('/<\/p>/i',$coninfo['content']);
		$conlen=0;
		$constr='';
		foreach($cons as $key => $con)
		{
			$constr.=$con.(substr(strtolower($con),-4)=='</p>'?'':'</p>');
			$conlen+=strlen($constr);
			if($conlen>$coninfo['pagecount'] || ($key+1)==sizeof($cons))
			{
				if($constr && strtolower($constr)!='</p>')
				{
					$conarray[]=$constr;
				}
				$conlen=0;
				$constr='';
			}
		}
	}
	else if($coninfo['ispage']==1) // 手动分页
	{
		$conarray=preg_split('/#page_break_tag#/',$coninfo['content']);
	}
	else // 不分页
	{
		$conarray=array();
	}

	if(sizeof($conarray)>1)
	{
		include_once RETENG_ROOT.'/include/cnspell.class.php';
		$cnspell=new cnspell();
		$page=isset($page) && intval($page)?max(1,intval($page)):1;
		$title=$coninfo['title'].'('.$page.')';
		$page=min(sizeof($conarray),intval($page));
		$conurl=strpos($catinfo['setting']['urlrule'],'.')?trim($catinfo['setting']['urlrule']):'{sitedir}html/{Y}{M}/a{cid}'.HTMLEXT;
		$conurl=str_replace('{sitedir}',SITEDIR?SITEDIR.'/':'',$conurl);
		$conurl=str_replace('{catdir}',$catinfo['catdir'],$conurl);
		$conurl=str_replace('{Y}',date('Y',$coninfo['inputtime']),$conurl);
		$conurl=str_replace('{M}',date('m',$coninfo['inputtime']),$conurl);
		$conurl=str_replace('{D}',date('d',$coninfo['inputtime']),$conurl);
		$conurl=str_replace('{timestamp}',$coninfo['inputtime'],$conurl);
		$conurl=str_replace('{cid}',intval($coninfo['id']),$conurl);
		$conurl=str_replace('{pinyin}',$cnspell->getcnSpell($coninfo['title'],'GBK',0).intval($coninfo['id']),$conurl);
		$conurl=str_replace('{py}',$cnspell->getcnSpell($coninfo['title'],'GBK',1).intval($coninfo['id']),$conurl);
		$conurl=str_replace('\\','/',$conurl);
		$conurl=str_replace('//','/',$conurl);

		for($i=1;$i<=sizeof($conarray);$i++)
		{
			if($page==$i)
			{
				$page_array[]='<li><a href="#">'.$i.'</a></li>';
			}
			else
			{
				if($catinfo['setting']['ishtml']==2)
				{
					$page_array[]='<li><a href="'.substr($conurl,0,-strlen('.'.get_fileext($conurl))).'_'.$i.'.'.get_fileext($conurl).'">'.$i.'</a></li>';
				}
				else
				{
					$cururl=preg_replace('/([&\?]?)(page=[0-9]+)([&\?]?)/i','\\1',getcururl());
					$cururl=substr($cururl,-1)=='&'?$cururl:$cururl.'&';
					$page_array[]='<li><a href="'.$cururl.'page='.$i.'">'.$i.'</a></li>';
				}
			}
		}
		$t=max(0,$page-1);
		$content=$conarray[$t];
	}
	
	$content_page=$reteng_page=implode('&nbsp;',$page_array);
	if(!$coninfo['status'] && isset($_SESSION['is_admin']) && $_SESSION['is_admin'])
	{
		$title='[<font color="#FF0000">待审</font>]'.$title;
	}

	if(($point || $amount) && $_userid && $install['member'])
	{
		require_once RETENG_ROOT.'member/include/member.class.php';
		$member=new member();
	}

	/*
		扣除积分
	*/
	if($point && !$_userid)
	{
		$content='<font color="#FF0000">您当前的会员组不允许查看该信息</font>';
	}

	if($point && $_userid)
	{
		if($_point < $point)
		{
			$content='<font color="#FF0000">阅读当前文章需要消耗'.$point.'积分, 您的当前积分为'.$_point.'</font>';
		}
		else
		{
			$member->vipread($_userid,$id,array('point'=>intval($_point - $point)));
		}
	}

	/*
		扣除金钱
	*/
	if(floatval($amount) && !$_userid)
	{
		$content='<font color="#FF0000">您当前的会员组不允许查看该信息</font>';
	}

	if(floatval($amount) && $_userid)
	{
		if($_amount < $amount)
		{
			$content='<font color="#FF0000">阅读当前文章需要消耗'.$amount.'金钱, 您的当前金钱为'.$_amount.'</font>';
		}
		else
		{
			$member->vipread($_userid,$id,array('amount'=>floatval($_amount - $amount)));
		}
	}
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
