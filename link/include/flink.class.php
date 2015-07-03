<?php
/**
	* 广告管理类
*/

class flink
{
	public $pagestring='';
	private $db;
	private $table;
	private $type_table;

	function __construct()
	{
		global $db;
		$this->db=$db;
		$this->table=DB_PRE.'link';
		$this->type_table=DB_PRE.'linktype';
	}

	function flink()
	{
		$this->__construct();
	}

	function link_cache()
	{
		$r=$this->db->fetch_all("SELECT * FROM `$this->type_table` ORDER BY `$this->type_table`.`orderby` ASC");
		cache_write('linktype.cache.php',$r,RETENG_ROOT.'data/cache_module/');
		if($r)foreach($r as $_r)
		{
			cache_write('linktype'.$_r['id'].'.cache.php',$_r,RETENG_ROOT.'data/cache_module/');
		}
		return true;
	}
	
	/*
		友链类型操作
	*/
	function typelist()
	{
		global $page;
		include RETENG_ROOT.'include/datalist.class.php';
		$datalist = new datalist();
		$where='siteid='.SITEID;
		$orderby='orderby ASC';
		$page=max(isset($page)?intval($page):1,1);
		$pagesize=15;
		$result=$datalist->getlist($this->type_table,$where,$orderby,$page,$pagesize);
		$this->pagestring=$datalist->pagestring;
		return $result;
	}

	function type_add($info)
	{
		$info['siteid']=SITEID;
		$insertid=$this->db->insert($this->type_table,$info);
		$this->db->update($this->type_table,array('orderby'=>intval($insertid)),'id='.intval($insertid));
		$this->link_cache();
		return true;
	}

	function type_edit($info,$id)
	{
		$info['siteid']=SITEID;
		$this->db->update($this->type_table,$info,'id='.intval($id));
		$this->link_cache();
		return true;
	}

	function type_editname($names,$orderby)
	{
		foreach($names as $id => $name)
		{
			$this->db->update($this->type_table,array('name'=>trim($name),'orderby'=>intval($orderby[$id])),'id='.intval($id));
		}
		$this->link_cache();
		return true;
	}

	function type_info($id)
	{
		return $this->db->fetch_one("SELECT * FROM `$this->type_table` WHERE `$this->type_table`.`id`=".intval($id));
	}

	function type_disabled($disabled,$id)
	{
		$this->db->update($this->type_table,array('disabled'=>intval($disabled)),'id='.intval($id));
		$this->db->update($this->table,array('disabled'=>intval($disabled)),'typeid='.intval($id));
		$this->link_cache();
		return true;
	}

	function type_delete($id)
	{	
		$this->db->mysql_delete($this->type_table,intval($id));
		$this->db->mysql_delete($this->table,intval($id),'typeid');
		$this->link_cache();
		return true;
	}

	/*
		友链操作
	*/

	function linklist($typeid)
	{
		global $page;
		include RETENG_ROOT.'include/datalist.class.php';
		$datalist = new datalist();
		$where='siteid='.SITEID.' AND typeid='.intval($typeid);
		$orderby='orderby ASC';
		$page=max(isset($page)?intval($page):1,1);
		$pagesize=15;
		$result=$datalist->getlist($this->table,$where,$orderby,$page,$pagesize);
		$this->pagestring=$datalist->pagestring;
		return $result;
	}

	function add($info)
	{
		global $_roleid;
		$info=array_map('strip_tags',$info);
		$info['addtime']=TIME;
		$info['siteid']=SITEID;
		$info['disabled']=$_roleid?intval($info['disabled']):1;
		$info['isindex']=$_roleid?intval($info['isindex']):0;
		$insertid=$this->db->insert($this->table,$info);
		$this->db->update($this->table,array('orderby'=>intval($insertid)),'id='.intval($insertid));
		return true;		
	}

	function editname($names,$url,$orderby)
	{
		foreach($names as $id => $name)
		{
			$this->db->update($this->table,array('name'=>trim($name),'url'=>trim($url[$id]),'orderby'=>intval($orderby[$id])),'id='.intval($id));
		}
		return true;
	}

	function edit($info,$id)
	{
		$info['siteid']=SITEID;
		$this->db->update($this->table,$info,'id='.intval($id));
		return true;
	}

	function disabled($disabled,$id)
	{
		global $RETENG;
		$this->db->update($this->table,array('disabled'=>intval($disabled)),'id='.intval($id));

		/*
			发送提醒邮件
		*/
		$linkinfo=$this->info($id);
		if(is_email($linkinfo['email']) && !intval($disabled) && MAIL_USER && MAIL_PWD && MAIL_SERVER)
		{
			require_once(RETENG_ROOT.'include/email.class.php');
			$sendemail=new email();
			$sendemail->send($linkinfo['email'], $RETENG['site_name'].'友链申请通过通知','尊敬的: '.$linkinfo['name'].'站长,您提交的友链申请已通过我们的审核,请尽快加上我们的友链,合作愉快! 网址: <a href="'.$RETENG['site_url'].'">'.$RETENG['site_url'].'</a>',MAIL_USER);
		}
		return true;
	}

	function isindex($isindex,$id)
	{
		$this->db->update($this->table,array('isindex'=>intval($isindex)),'id='.intval($id));
		return true;
	}

	function delete($id)
	{	
		$this->db->mysql_delete($this->table,intval($id));
		return true;
	}

	function info($id)
	{
		return $this->db->fetch_one("SELECT * FROM `$this->table` WHERE `$this->table`.`id`=".intval($id));
	}
}
?>
