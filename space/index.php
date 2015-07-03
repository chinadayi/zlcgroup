<?php
	include substr(dirname(__FILE__),0,-6).'/include/common.inc.php';
	if($module->module_disabled('space'))
	{
		show404('该模块已被管理员禁用!');
	}
	
	$langdir=$childsite['site_dir']?$childsite['site_dir']:'zh-cn';
	$langfile=RETENG_ROOT.'space/data/lang/'.$langdir.'/lang.inc.php';
	if(!file_exists($langfile))
	{
		$langfile=RETENG_ROOT.'space/data/lang/zh-cn/lang.inc.php';
	}
	
	include $langfile;

	include dirname(__FILE__).'/include/space.class.php';
	$space=new space();

	include RETENG_ROOT.'member/include/member.class.php';
	$member= new member();

	session_start();
	
	$id=isset($id) && intval($id)>0?intval($id):0;
	if(!$id) 
	{
		show404($spacelang['msg-space-noexists'],SITE_URL.'member/index.php?mod=space&file=space&action=info');
	}

	/*
		优先读取缓存
	*/
	$data=$cache->get(md5('Myspace_'.$id));

	if(!$data)
	{
		/*
			获取空间数据
		*/
		$spaceinfo=$space->spaceinfo($id);

		if(!$spaceinfo) 
		{
			show404($spacelang['msg-space-closed']);
		}

		if($spaceinfo['syslock'])
		{
			show404($spacelang['msg-space-admin-closed']);
		}

		if($spaceinfo['lock'])
		{
			show404($spacelang['msg-space-owner-closed']);
		}
		
		/*
			获取会员数据
		*/

		$memberinfo=$member->get($spaceinfo['userid'], '*' ,true);
		
		$memberinfo['memberid']=$memberinfo['id'];
		unset($memberinfo['id']);

		/*
			合并数组
		*/
		$data=array_merge($spaceinfo,$memberinfo);

		unset($data['password']);
		$cache->set(md5('Myspace_'.$id),$data);
	}
	extract($data);

	/*
		SEO数据
	*/
	$head['title'] = $name.'-'.$RETENG['site_name'];
	$head['keywords'] =$meta_keywords;
	$head['description'] =$meta_description;

	/*
		会员等级
	*/
	$r=cache_read('membergrade'.$gradeid.'.cache.php',RETENG_ROOT.'data/cache_module/');
	$gradename=$r['name'];

	/*
		更新访问次数
	*/
	$space->set($data['id'],array('visits'=>$visits+1));

	/*
		更新最近访客
	*/
	$space->refreshvistors($id);

	/*
		获取最近访客
	*/
	$visitors=$space->getvistors($id,10);
	
	/*
		获取我的好友
	*/
	$friends=$space->getfriends($memberid,10);

	/*
		获取我的空间ID
	*/
	$myspace=$space->userspaceinfo($_userid);
	$myspaceid=$myspace['id'];

	/*
		包含模板
	*/
	$action=isset($action)?trim($action):'index';
	switch($action)
	{
		case 'article':
			$head['title'] = $spacelang['menu-article'].'-'.$name;
			$page=isset($page) && intval($page)>0?intval($page):1;
			include template('article','space',$template);
			break;
		case 'profile':
			$head['title'] = $spacelang['menu-info'].'-'.$name;
			include template('profile','space',$template);
			break;
		case 'friends':
			$head['title'] = $spacelang['menu-friends'].'-'.$name;
			$page=isset($page) && intval($page)>0?($page):1;
			include template('friends','space',$template);
			break;
		case 'guestbook':
			if(isset($do_submit)) 
			{
				if(strtolower($chkcode)!=$_SESSION['checkcode'])
				{
					showmsg($spacelang['err-post-checkcode']);
				}

				if($authkey!=md5(AUTH_KEY.$id.$name))
				{
					showmsg($spacelang['err-post-bad']);
				}
				
				$info=array();
				$info['userid']=$id;
				$info['username']=$username;
				$info['guestid']=$id;
				$info['guestname']=$_username?$_username:$spacelang['tourist'];
				$info['guestface']=$_facephoto?$_facephoto:'images/nophoto.gif';
				$info['addtime']=TIME;
				$info['ip']=IP;
				$info['status']=$_userid || !COMMENTPASS?1:0;
				$info['content']=bbcode(strip_tags(sub_string($content,200,'...')));
				if($space->addcomment($info))
				{
					showmsg($spacelang['ok-post']);
				}
			}
			$head['title'] = $spacelang['menu-guestbook'].'-'.$name;
			$page=isset($page) && intval($page)>0?($page):1;
			include template('guestbook','space',$template);
			break;
		case 'newfriend':
			if(!$_userid)
			{
				showmsg($spacelang['err-post-nologin'],$RETENG['site_url'].'member/index.php?file=login&action=login');
			}
			$msg=$space->newfriend($id);
			
			if($msg=='-1')
			{
				showmsg($spacelang['err-post-nofriendid']);
			}
			/*
			else if($msg=='-2')
			{
				showmsg('不能加自己为好友!');
			}
			*/
			else if($msg=='-3')
			{
				showmsg($spacelang['err-post-noid']);
			}
			else if($msg=='-4')
			{
				showmsg($spacelang['err-post-hasfriend']);
			}
			else
			{
				showmsg($spacelang['ok-post-freind']);
			}
			break;
		case 'blackfriend':
			if($space->blackfriend($id))
			{
				showmsg($spacelang['ok-post-blackfreind']);
			}
			else
			{
				showmsg($spacelang['err-post-blackfreind']);
			}
			break;
		default:
			include template('index','space',$template);
			break;
	}
?>
