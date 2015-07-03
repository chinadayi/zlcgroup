<?php
	include substr(dirname(__FILE__),0,-5).'/include/common.inc.php';
	include dirname(__FILE__).'/data/config.inc.php';
	session_start();

	if(!POST_ENABLED)
	{
		showmsg('管理员已禁止前台投稿功能!');
	}

	/*
		IP判定
	*/
	if(POST_IS_FORBIDDEN_AREA)
	{
		$nowarea=get_selectmenu('area',POST_FORBIDDEN_AREA);
		if(POST_FORBIDDEN_AREA && !strstr(IPADDRESS,$nowarea))
		{
			showmsg($baselang['ip_forbidden']);	
		}
	}

	$langdir=$childsite['site_dir']?$childsite['site_dir']:'zh-cn';
	$langfile=RETENG_ROOT.'post/data/lang/'.$langdir.'/lang.inc.php';
	if(!file_exists($langfile))
	{
		$langfile=RETENG_ROOT.'post/data/lang/zh-cn/lang.inc.php';
	}

	include_once $langfile;

	$catid=isset($catid) && intval($catid) >0?intval($catid):0;

	if($_userid && !$module->module_disabled('member'))
	{
		if($catid)
		{
			header('location:'.SITE_URL.'member/index.php?file=content&action=add&catid='.$catid);
		}
		else
		{
			header('location:'.SITE_URL.'member/index.php');
		}
		exit();
	}

	if(!$catid)
	{
		include template('index','post');
	}
	else
	{
		require RETENG_ROOT.'/include/c.class.php';
		$c=new c();

		include_once RETENG_ROOT.'include/content.class.php';
		$conobj=new content();

		/*
			权限检查
		*/
		if($catid)
		{
			$catinfo=getcatinfo($catid);

			if(!$catinfo || $catinfo['type']!=1 )
			{
				showmsg($postlang['err-cat-noexists']);
			}

			if(!isfinalcatid($catid))
			{
				showmsg($postlang['err-cat-notchildren']);
			}

			if(!$catinfo['ispost'])
			{
				showmsg($postlang['err-post-closed']);
			}

			if(!$module->module_disabled('member'))
			{
				require RETENG_ROOT.'member/include/member.class.php';
				$member=new member();

				if(!$member->catpostcheck($catid,$_groupid,$_gradeid))
				{
					showmsg($postlang['err-post-pri']);
				}
			}
		}

		if(isset($dosubmit))
		{
			if(POST_CHECKCODE_ENABLED && (!isset($_SESSION['checkcode']) || $_SESSION['checkcode']!=strtolower($checkcode)))
			{
				showmsg($postlang['err-post-checkcode']);
			}
			if(POST_ASK_ENABLED && (!isset($_SESSION['post_answer']) || $_SESSION['post_answer']!=$post_answer))
			{
				showmsg($postlang['err-post-qustion']);
			}
			$info['catid']=intval($catid);
			$err=$conobj->add($info);
			if($err===true)
			{
				if(POST_VERIFY_ENABLED)
				{
					showmsg($postlang['msg-post-verify']);
				}
				else
				{
					showmsg($postlang['msg-post-ok']);
				}
			}
			else
			{
				showmsg($lang['CONTENT_ERR'.$err]);
			}
		}
		/*
			获取验证问题
		*/
		$post_question='';
		$post_answer='';
		if(POST_ASK_ENABLED)
		{
			$post_question=explode('|',trim(POST_ASK));
			$post_answer=explode('|',trim(POST_ANSWER));
			$key=mt_rand(0,(sizeof($post_question)-1));
			$post_question=$post_question[$key];
			$_SESSION['post_answer']=$post_answer=$post_answer[$key];
		}
		$forms=$conobj->getform($catinfo['modelid']);
		include template('post','post');
	}
?>