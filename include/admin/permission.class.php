<?php
/**
	* 管理员权限检查及设置 网站创始人拥有全部权限
*/

class permission
{
	public $msg;
	private $db;
	private $table;
	private $cache_table;
	private $per_table;
	
	function __construct()
	{
		global $db;
		$this->db=$db;
		$this->table=DB_PRE.'admin';
		$this->cache_table=DB_PRE.'admin_cache';
		$this->per_table=DB_PRE.'permission';
		$this->category_roleid_table=DB_PRE.'category_roleid';
		admin_cache();
	}
	
	function permissionlist()
	{
		return $this->db->fetch_all("SELECT * FROM `$this->per_table` ORDER BY `id` ASC");
	}

	function admin_check($userid)
	{
		$r=$this->db->fetch_one("SELECT * FROM `$this->cache_table` WHERE `$this->cache_table`.`userid`=".intval($userid));

		if(isset($r['password']))unset($r['password']);
		return $r;
	}

	function category_permission_check($userid,$catid)
	{
		$r=$this->db->fetch_one("SELECT `$this->category_roleid_table`.`catid` FROM `$this->category_roleid_table` WHERE `$this->category_roleid_table`.`adminid`=".intval($userid));
		if(!$r && $userid != ADMIN_FOUNDERS)
		{
			return false;
		}
		$r=explode(',',$r['catid']);
		return (in_array($catid,$r) || $userid == ADMIN_FOUNDERS || in_array(0,$r))?true:false;
	}

	// 检查是否具有管理权限
	public function roleid_check($id,$roleid)
	{
		global $_userid;
		$r=$this->get($id,'roleid');
		$r=explode(',',$r['roleid']);
		return (in_array($roleid,$r) || $_userid == ADMIN_FOUNDERS)?true:false;
	}
	
	// 取得权限表字段值
	private function get($id,$fields='*')
	{
		$id=intval($id);
		return $this->db->fetch_one("SELECT `$this->per_table`.$fields FROM `$this->per_table` WHERE `$this->per_table`.`id`={$id}");
	}
}
?>
