<?php
/**
	*数据库备份类
*/

class db
{
	private $db;

	function __construct()
	{
		global $db;
		$this->db=$db;
	}

	function db()
	{
		$this->__construct();
	}

	function datalist()
	{
		$result=$this->db->get_table_status(DB_NAME);
		/*
		foreach($result as $key => $value)
		{
			if(substr($value['Name'],0,strlen(DB_PRE))==DB_PRE)
			{
				$result[$key]=$value;
			}
			else 
			{
				unset($result[$key]);
			}
		}
		*/
		return $result;
	}
}
?>
