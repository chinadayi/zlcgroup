<?php
/**
	* 留言管理类
*/

class guestbook
{
	public $pagestring='';
	private $db;
	private $table;

	function __construct()
	{
		global $db;
		$this->db=$db;
		$this->table=DB_PRE.'guestbook';
	}

	function datalist($passed=1,$k='')
	{
		global $page;
		include RETENG_ROOT.'include/datalist.class.php';
		$datalist = new datalist();
		$where='siteid='.SITEID.' AND passed='.$passed;
		$where.=$k?' AND content LIKE "%'.$k.'%"':'';
		$orderby='id DESC';
		$page=max(isset($page)?intval($page):1,1);
		$pagesize=15;
		$result=$datalist->getlist($this->table,$where,$orderby,$page,$pagesize);
		$this->pagestring=$datalist->pagestring;
		return $result;
	}

	function pass($passed,$id)
	{
		global $RETENG;
		$this->db->update($this->table,array('passed'=>intval($passed)),'id='.intval($id));

		/*
			发送提醒邮件
		*/
		$guestbookinfo=$this->info($id);
		if(is_email($guestbookinfo['email']) && intval($passed) && MAIL_USER && MAIL_PWD && MAIL_SERVER)
		{
			require_once(RETENG_ROOT.'include/email.class.php');
			$sendemail=new email();
			$sendemail->send($guestbookinfo['email'], $RETENG['site_name'].'留言审核通过通知','尊敬的 '.$guestbookinfo['username'].' '.$guestbookinfo['sex'].',您在我们网站提交的留言已通过我们的审核,感谢您的关注! 网址: <a href="'.$RETENG['site_url'].'guestbook/index.php">'.$RETENG['site_name'].'</a>',MAIL_USER);
		}
		return true;
	}

	function info($id)
	{
		return $this->db->fetch_one("SELECT * FROM `$this->table` WHERE `$this->table`.`id`=".intval($id));
	}

	function hidden($hidden,$id)
	{
		global $RETENG;
		$this->db->update($this->table,array('hidden'=>intval($hidden)),'id='.intval($id));

		/*
			发送提醒邮件
		*/
		$guestbookinfo=$this->info($id);
		if(is_email($guestbookinfo['email']) && !intval($hidden) && MAIL_USER && MAIL_PWD && MAIL_SERVER)
		{
			require_once(RETENG_ROOT.'include/email.class.php');
			$sendemail=new email();
			$sendemail->send($guestbookinfo['email'], $RETENG['site_name'].'留言审核通过通知','尊敬的 '.$guestbookinfo['username'].' '.$guestbookinfo['sex'].',您在我们网站提交的留言已通过我们的审核,感谢您的关注! 网址: <a href="'.$RETENG['site_url'].'guestbook/index.php">'.$RETENG['site_name'].'</a>',MAIL_USER);
		}
		return true;
	}

	function delete($ids)
	{
		$ids=is_array($ids)?array_map('intval',$ids):array(intval($ids));
		if(!$ids)return false;

		foreach($ids as $id)
		{
			$this->db->mysql_delete($this->table,$id);
		}
		return true;
	}

	function reply($info,$id)
	{
		global $_username,$RETENG;
		$info['replyer']=$_username;
		$info['replytime']=TIME;
		$this->db->update($this->table,$info,'id='.intval($id));

		/*
			发送提醒邮件
		*/
		$guestbookinfo=$this->info($id);
		if(is_email($guestbookinfo['email']) && MAIL_USER && MAIL_PWD && MAIL_SERVER)
		{
			require_once(RETENG_ROOT.'include/email.class.php');
			$sendemail=new email();
			$sendemail->send($guestbookinfo['email'], $RETENG['site_name'].'留言回复通知','尊敬的 '.$guestbookinfo['username'].' '.$guestbookinfo['sex'].',您在我们网站提交的留言已回复,感谢您的关注! 详情请看: <a href="'.$RETENG['site_url'].'guestbook/index.php">'.$RETENG['site_name'].'在线留言</a>',MAIL_USER);
		}
		return true;
	}

	function add($info)
	{
		if(!$info || !is_array($info))return false;
		global $_userid,$_username,$_email;
		$content=filterhtml($info['content'],3);
		$info=array_map('htmlspecialchars',$info);
		$info['siteid']=SITEID;
		$info['content']=$content;
		$info['userid']=$_userid;
		$info['username']=$info['username']?$info['username']:$_username;
		$info['email']=is_email($info['email'])?$info['email']:($_email?$_email:'');
		$info['addtime']=TIME;
		$info['ip']=IP;
		$info['hidden']=$_userid?0:1;
		$info['passed']=$_userid?1:0;
		$info['reply']='';
		$info['replyer']='';
		$info['replytime']='';
		return $this->db->insert($this->table,$info);
	}
}
?>
