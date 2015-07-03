<?php
/**
* 作者管理类
*/

class posid
{
	public $pagestring;
	private $db;
	private $table;
	private $c;

	function __construct()
	{
		global $db,$c;
		$this->db=$db;
		$this->c=$c;
		$this->table=DB_PRE.'posid';
	}

	function posid()
	{
		$this->__construct();
	}

	function datalist()
	{
		global $page;
		include RETENG_ROOT.'include/datalist.class.php';
		$datalist = new datalist();
		$where=1;
		$orderby='orderby ASC';
		$page=max(isset($page)?intval($page):1,1);
		$pagesize=15;
		$result=$datalist->getlist($this->table,$where,$orderby,$page,$pagesize);
		$this->pagestring=$datalist->pagestring;
		return $result;
	}

	function add($info)
	{
		if(!$info['name'])return false;
		$this->db->insert($this->table,$info,true);
		$this->c->cache_posid();
		return true;
	}

	function delete($id)
	{
		$id=is_array($id)?array_map('intval',$id):array(intval($id));
		if(!$id)return false;
		$this->db->mysql_delete($this->table,$id);
		$this->c->cache_posid();
		return true;
	}

	function update($name,$orderby,$ids)
	{
		$ids=is_array($ids)?array_map('intval',$ids):array(intval($ids));
		if(!$ids)return false;
		foreach($ids as $id)
		{
			if(trim($name[$id]))$this->db->update($this->table,array('name'=>trim($name[$id]),'orderby'=>intval($orderby[$id])),'id='.intval($id));
		}
		$this->c->cache_posid();
		return true;
	}
}
?>
