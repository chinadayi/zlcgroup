<?php
/**
	* 后台操作日志
*/

class adminlog
{
	private $db;
	private $table;
	
	function __construct()
	{
		global $db;
		$this->db=$db;
		$this->table=DB_PRE.'log';
	}

	function adminlog()
	{
		$this->__construct();
	}

	function add()
	{
		global $_username;
		$log=array();
		$log['admin']=$_username;
		$log['method']=isset($_SERVER['REQUEST_METHOD'])?addslashes($_SERVER['REQUEST_METHOD']):'';
		$query=explode('?',getcururl());
		$log['query']=isset($query[1])?addslashes($query[1]):'';
		$log['comeurl']=getpreurl();
		$log['ip']=IP;
		$log['time']=TIME;
		if($log['query'])$this->db->insert($this->table,$log);
		return true;
	}

	function clear()
	{
		return $this->db->query("TRUNCATE TABLE `$this->table`");
	}
}
?>
