<?php
	include substr(dirname(__FILE__),0,-8).'/include/common.inc.php';

	$langdir=$childsite['site_dir']?$childsite['site_dir']:'zh-cn';
	$langfile=RETENG_ROOT.'comment/data/lang/'.$langdir.'/lang.inc.php';
	if(!file_exists($langfile))
	{
		$langfile=RETENG_ROOT.'comment/data/lang/zh-cn/lang.inc.php';
	}

	include_once $langfile;

	include dirname(__FILE__).'/include/comment.class.php';
	$commentobj=new comment();

	include RETENG_ROOT.'include/content.class.php';
	$conobj=new content();
	$coninfo=$conobj->get(intval($contentid));
	if($_username!="游客")
	{
		$guest=$_username;
	}else
	{
		$guest=$comment['username']?$comment['username']:"游客";
	}
		set_cookie("_guest",$guest);
	if(!intval($contentid) || !$coninfo || !$coninfo['iscomment'])
	{
		show404($commentlang['no-data']);
	}

	session_start();
	if(!isset($_SESSION['checkcode']) || $_SESSION['checkcode']!=strtolower($chkcode))
	{
		showmsg($commentlang['err-checkcode']);
	}
	if($authkey!=md5(AUTH_KEY.$coninfo['catid'].$contentid) || !intval($contentid) || !$coninfo)
	{
		showmsg($commentlang['err-para']);
	}

	/*
		过滤非法词语
	*/
	$badwords=$db->fetch_one("SELECT `".DB_PRE."badwords`.`badwords` FROM `".DB_PRE."badwords` WHERE `".DB_PRE."badwords`.`id`=1");
	if($badwords)
	{
		$good=$bad=array();
		$badwords=explode("\r\n",trim($badwords['badwords']));
		if($badwords)foreach($badwords as $badword)
		{
			if($badword)
			{
				$badword=explode("=",$badword);
				$bad[]=$badword[0];
				$good[]=isset($badword[1])?$badword[1]:'***';
			}
		}
		foreach($comment as $key =>$value)
		{
			$comment[$key]=str_replace($bad,$good,$value);
		}
	}


	$comment['contentid']=intval($contentid);
	$comment['content']=bbcode(sub_string(strip_tags($comment['content']),255,'...'));
	$comment['parentid']=intval($parentid);
	$comment['userid']=$_userid?$_userid:0;
	$comment['username']=$guest;
	$comment['userface']=$_facephoto?$_facephoto:'images/nophoto.gif';
	$comment['ip']=IP;
	$comment['addtime']=TIME;
	$comment['support']=0;
	$comment['against']=0;
	$comment['status']=$_userid || !COMMENTPASS?1:0;
	$comment['siteid']=SITEID;

	/*
		内容加粗
	*/
	if(isset($bstyle) && $bstyle)
	{
		$comment['content']='<font style="font-weight:bold">'.$comment['content'].'</font>';
	}
	$suc=$commentobj->concomment($comment);
	if($suc)
	{
		$conobj->set($contentid,array('comments' => $coninfo['comments']+1));

		if($_userid)
		{
			showmsg($commentlang['ok-all']);
		}
		else
		{
			showmsg($commentlang['ok-audit']);
		}
	}
	else
	{
		showmsg($commentlang['err-post']);
	}
?>
