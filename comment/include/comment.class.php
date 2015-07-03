<?php
/**
* 内容评论管理类
*/

error_reporting (E_ALL & ~E_NOTICE & ~E_WARNING);

class comment
{
	private $db;
	private $table;
	private $c;

	function __construct()
	{
		global $db,$c;
		$this->db=$db;
		$this->c=$c;
		$this->table=DB_PRE.'comment';
	}

	function comment()
	{
		$this->__construct();
	}

	function concomment($comment=array())
	{
		return $this->db->insert($this->table,$comment);
	}

	function concommentlist($contentid,$len=10,$iscache=true)
	{
		global $cache;
		$len=intval($len) > 0?intval($len):10;
		$sql="SELECT * FROM `$this->table` WHERE `$this->table`.`contentid`=".intval($contentid)." AND `$this->table`.`status`=1 ORDER BY `$this->table`.`support` DESC,`$this->table`.`id` DESC LIMIT 0,$len";
		
		$data=$cache->get($sql);
		if(!$iscache || !$data)
		{
			$data=$this->db->fetch_all($sql);
			$cache->set($sql,$data);
		}
		return $data;
	}

	function concommentinfo($id)
	{
		return $this->db->fetch_one("SELECT * FROM `$this->table` WHERE `$this->table`.`id`=".intval($id));
	}

	function digup($id)
	{
		$this->db->query("UPDATE `$this->table` SET `$this->table`.`support`=`$this->table`.`support`+1 WHERE `$this->table`.`id`=".intval($id));
		$r=$this->concommentinfo($id);
		return $r['support'];
	}

	function digdown($id)
	{
		$this->db->query("UPDATE `$this->table` SET `$this->table`.`against`=`$this->table`.`against`+1 WHERE `$this->table`.`id`=".intval($id));
		$r=$this->concommentinfo($id);
		return $r['against'];
	}
}	
?>
