<?php
/**
* 数据缓存类
*/

class cache
{
	private $db; // 数据库连接
	private $table; // 存储cache的数据表名，为memory类型

	function __construct() // 构造函数重载cache存储方式为mysql数据库存储
	{
		global $db;
		$this->db=$db;
		$this->table = DB_PRE.'cache';
	}

	function cache() // 如果 PHP 5 在类中找不到 __construct() 函数，它就会尝试寻找旧式的构造函数，也就是和类同名的函数
	{
		$this->__construct();
	}

	function set($name, $value, $ttl = 0)
    {
		$ttl=$ttl?$ttl:CACHE_TTL;
		$ttl=intval($ttl);
		$name=md5($name);
		$expire=TIME+$ttl;

		$value=addslashes(var_export(retengcms_addslashes($value),true));
		return $this->db->query("REPLACE INTO $this->table(`name`,`value`,`expire`) VALUES('{$name}','{$value}',{$expire})",true);
	}

	function get($name)
	{
		$r=$this->db->fetch_one("SELECT `value`,`expire` FROM {$this->table} WHERE `name`='".md5($name)."'");
		if($r && (TIME < $r['expire']))
		{
			return string2array($r['value']);
		}
		else
		{
			$this->rm($name);
			return '';
		}
	}

	function rm($name)
    {
		$name=md5($name);
		return $this->db->query("DELETE FROM `$this->table` WHERE `name`='$name'",true);
    }

    function clear()
    {
        return $this->db->query("TRUNCATE TABLE `$this->table`",true);
    }
}