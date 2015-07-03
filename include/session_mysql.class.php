<?php
/**
* session会话
* 类用法
* $session=new session();;
* session_start();
*/
class session
{
	private $db; // 数据库连接
	private $lifetime=SESSION_TTL;	// session生存周期，可在 config.inc.php 中设置，默认为 1800
	private $table; // 存储session的数据表名，为memory类型

	function __construct() // 构造函数重载SESSION存储方式为mysql数据库存储（默认为文件存储，不适合同时在线人数过多的情况，并共享），并为一些成员变量赋初值
	{
		global $db;
		$this->db=&$db;
		$this->lifetime=SESSION_TTL;
		$this->table = '`'.DB_NAME.'`.`'.DB_PRE.'session`';
		session_set_save_handler(array($this,'open'),array($this,'close'),array($this,'read'),array($this,'write'),array($this,'destroy'),array($this,'gc'));
		// 成员函数作为参数时的调用方法
	}

	function session() // 如果 PHP 5 在类中找不到 __construct() 函数，它就会尝试寻找旧式的构造函数，也就是和类同名的函数
	{
		$this->__construct();
	}

	function open($save_path,$session_name) // 一般返回true
	{
		return true;
	}

	function close() // 也可以 直接返回 true
	{
		return $this->gc($this->lifetime);
	}

	function read($id) // 读 session ,读取 session 时触发此函数，如 echo $_SESSION['user'];
	{
		$r=$this->db->fetch_one("SELECT `data` FROM {$this->table} WHERE `sessionid`='$id'");
		return $r?$r['data']:'';
	}

	function write($id, $sess_data) // 写 session, 定义session时触发此函数，如 $_SESSION['user']='Jim';
	{
		global $_userid;
		$_userid=intval($_userid);
		$_userid=isset($_userid)?$_userid:1;
		$ip=IP;
		$time=TIME;
		$sess_data=strlen($sess_data)>255?'no data':addslashes($sess_data); // session支持无限大的数据，但是过大的数据有会耗费大量服务器内存，这里强制限制一下，不要超过255个字符
		return $this->db->query("REPLACE INTO $this->table(`sessionid`,`userid`,`ip`,`lastvisit`,`data`) VALUES('{$id}',{$_userid},'{$ip}',{$time},'{$sess_data}')",true);
	}

	function destroy($id) // 调用函数 session_destroy() 时触发此函数，unset()是不触发该函数的
	{
		return $this->db->query("DELETE FROM $this->table WHERE `sessionid`='$id'",true);
	}

	function gc($maxlifetime) // session 存活周期到后触发此函数
	{
		$expiretime=TIME-$maxlifetime;
		return $this->db->query("DELETE FROM $this->table WHERE `lastvisit`<$expiretime",true);
    }
}
?>