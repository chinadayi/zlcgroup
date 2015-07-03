<?php
/**
	* 站内短信息类
*/

class msg
{
	public $pagestring='';
	private $table;
	private $member_table;
	private $member_cache_table;

	function __construct()
	{
		global $db;
		$this->db=$db;
		$this->table=DB_PRE.'message';
		$this->member_table=DB_PRE.'member';
		$this->member_cache_table=DB_PRE.'member_cache';
	}

	function msg()
	{
		$this->__construct();
	}

	function msglist($type='inbox')
	{
		global $_userid,$_username,$page;
		include RETENG_ROOT.'include/datalist.class.php';
		$datalist = new datalist();
		if($type=='inbox')
		{
			$where="`send_to_user`='{$_username}' OR `send_to_user`='#system#'";
		}
		else
		{
			$where="`send_from_user`='{$_username}'";
		}
		$orderby='id DESC';
		$page=max(isset($page)?intval($page):1,1);
		$pagesize=20;
		$result=$datalist->getlist($this->table,$where,$orderby,$page,$pagesize);
		$this->pagestring=$datalist->pagestring;
		return $result;
	}

	function delete($ids)
	{
		global $_userid,$_username;
		$ids=is_array($ids)?array_map('intval',$ids):array(intval($ids));
		if(!$ids)return false;
		foreach($ids as $id)
		{
			$this->db->query("DELETE FROM `$this->table` WHERE `$this->table`.`id`=$id AND (`$this->table`.`send_to_user`='$_username' OR `$this->table`.`send_from_user`='$_username')");
		}
		return true;
	}

	function send($msgs)
	{
		global $_userid,$_username,$member;
		$content=filterhtml($msgs['content'],3);
		$msgs=array_map('htmlspecialchars',$msgs);
		$msgs['content']=$content;
		$msgs['send_from_user']=$_username;
		$msgs['message_time']=TIME;
		
		if(!$member->_exists('username', $msgs['send_to_user']))
		{
			return -1;
		}

		if($_username==$msgs['send_to_user'])
		{
			return -2;
		}

		if($this->db->insert($this->table,$msgs))
		{
			/*
				更新用户msg数量
			*/

			$this->db->query("UPDATE `$this->member_table` SET `$this->member_table`.`message`=`$this->member_table`.`message`+1 WHERE `$this->member_table`.`username`='".$msgs['send_to_user']."'");
			$this->db->query("UPDATE `$this->member_cache_table` SET `$this->member_cache_table`.`message`=`$this->member_cache_table`.`message`+1 WHERE `$this->member_cache_table`.`username`='".$msgs['send_to_user']."'");
			return true;
		}
		return false;
	}

	function msginfo($id,$fields='*')
	{
		global $_userid,$_username;
		return $this->db->fetch_one("SELECT {$fields} FROM `{$this->table}` WHERE (`$this->table`.`send_to_user`='$_username' OR `$this->table`.`send_to_user`='#system#' OR `$this->table`.`send_from_user`='$_username') AND `{$this->table}`.`id`=".intval($id));
	}

	function readed($id)
	{
		global $_userid,$_username,$_message;
		$info=$this->msginfo($id,'status');
		if(!$info['status'])
		{
			/*
				更新用户msg数量
			*/
			$this->db->query("UPDATE `$this->member_table` SET `$this->member_table`.`message`=".max(0,intval($_message-1))." WHERE `$this->member_table`.`username`='".$_username."'");
			$this->db->query("UPDATE `$this->member_cache_table` SET `$this->member_cache_table`.`message`=".max(0,intval($_message-1))." WHERE `$this->member_cache_table`.`username`='".$_username."'");
		}
		$this->db->query("UPDATE `$this->table` SET `$this->table`.`status`=1 WHERE `$this->table`.`id`=$id AND (`$this->table`.`send_to_user`='$_username' OR `$this->table`.`send_from_user`='$_username')");
		return true;
	}
}
?>
