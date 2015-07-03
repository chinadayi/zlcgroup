<?php
/**
	 评论类
*/

class comment
{
	public $pagestring;
	private $db;
	private $table;
	private $content_table;

	function __construct()
	{
		global $db;
		$this->db=$db;
		$this->table=DB_PRE.'comment';
		$this->content_table=DB_PRE.'content';
	}

	function comment()
	{
		$this->__construct();
	}

	function datalist($contentid=0,$userid=0,$ip='',$status=0,$k='')
	{
		global $page;
		$contentid=intval($contentid);
		$userid=intval($userid);
		$ip=preg_replace('/[^0-9\.]/i','',$ip);
		$status=intval($status);
		$k=strip_tags($k);

		include RETENG_ROOT.'include/datalist.class.php';
		$datalist = new datalist();
		$where='siteid='.SITEID;
		$where=$contentid?$where." AND contentid=".$contentid:$where;
		$where=$userid?$where." AND userid=".$userid:$where;
		$where=$ip?$where." AND ip='$ip'":$where;
		$where=$status?$where." AND status=".$status:$where;
		$where=$k?$where." AND content LIKE '%{$k}%'":$where;

		$orderby='id DESC';
		$page=max(isset($page)?intval($page):1,1);
		$pagesize=15;
		$result=$datalist->getlist($this->table,$where,$orderby,$page,$pagesize);
		$this->pagestring=$datalist->pagestring;
		return $result;
	}

	/*
		插入评论 返回评论ID
	*/
	function add($info)
	{
		global $_userid,$_username,$_roleid,$baselang;
		if(!is_array($info) || !isset($info['contentid'])) return false;
		
		$content=htmlspecialchars($info['content']);
		unset($info['content']);
		$info=array_map('strip_tags',$info);
		$info['status']=COMMENTPASS && !$_roleid ?99:1;
		
		$info['userid']=$_userid==ADMIN_FOUNDERS?0:$_userid;
		$info['username']=$_userid==ADMIN_FOUNDERS?$baselang['tourist']:$_username;
		$info['ip']=IP;
		$info['addtime']=TIME;
		$info['ip']=IP;
		$info['siteid']=SITEID;

		/*
			插入评论表
		*/
		$commentid=$this->db->insert($this->table,$info);

		/*
			更新内容表评论数量
		*/
		$this->db->query("UPDATE `$this->content_table` SET `$this->content_table`.`comments`=`$this->content_table`.`comments`+1 WHERE `$this->content_table`.`id`=".intval($info['contentid']));
		return $commentid;
	}

	function delete($ids)
	{
		$ids=is_array($ids)?array_map('intval',$ids):array(intval($ids));
		if(!$ids)return false;
		foreach($ids as $id)
		{
			/**
				更新内容表评论数量
			*/
			$r=$this->db->fetch_one("SELECT `$this->table`.`contentid` FROM `$this->table` WHERE `$this->table`.`id`=$id");
			$this->db->query("UPDATE `$this->content_table` SET `$this->content_table`.`comments`=`$this->content_table`.`comments`-1 WHERE `$this->content_table`.`id`=".$r['contentid']);

			/*
				删除子评论
			*/
			$this->db->mysql_delete($this->table,$id,'parentid');
		}
		/*
			删除评论
		*/
		$this->db->mysql_delete($this->table,$ids);
		return true;
	}

	function pass($ids)
	{
		$ids=is_array($ids)?array_map('intval',$ids):array(intval($ids));
		if(!$ids)return false;
		foreach($ids as $id)
		{
			$this->db->update($this->table,array('status'=>1),'id='.$id);
		}
		return true;
	}

	function unpass($ids)
	{
		$ids=is_array($ids)?array_map('intval',$ids):array(intval($ids));
		if(!$ids)return false;
		foreach($ids as $id)
		{
			$this->db->update($this->table,array('status'=>99),'id='.$id);
		}
		return true;
	}
}
?>