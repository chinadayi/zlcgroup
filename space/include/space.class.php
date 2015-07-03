<?php
/**
	* 会员空间类
*/

class space
{
	public $pagestring='';
	private $db;
	private $table;
	private $comment_table;
	private $visitor_table;
	private $friends_table;

	function __construct()
	{
		global $db;
		$this->db=$db;
		$this->table=DB_PRE.'space';
		$this->comment_table=DB_PRE.'space_comment';
		$this->visitor_table=DB_PRE.'space_newvisitor';
		$this->friends_table=DB_PRE.'space_friends';
	}

	function space()
	{
		$this->__construct();
	}
	
	function datalist($k='',$pagesize=15)
	{
		global $page;
		include RETENG_ROOT.'include/datalist.class.php';
		$datalist = new datalist();
		$where=1;
		$where.=$k?' AND name LIKE \'%'.strip_tags(trim($k)).'%\'':'';
		$orderby='id DESC';
		$page=max(isset($page)?intval($page):1,1);
		$result=$datalist->getlist($this->table,$where,$orderby,$page,intval($pagesize));
		$this->pagestring=$datalist->pagestring;
		return $result;
	}

	function guestbooklist($pagesize=15)
	{
		global $page;
		include RETENG_ROOT.'include/datalist.class.php';
		$datalist = new datalist();
		$where=1;
		$orderby='id DESC';
		$page=max(isset($page)?intval($page):1,1);
		$result=$datalist->getlist($this->comment_table,$where,$orderby,$page,intval($pagesize));
		$this->pagestring=$datalist->pagestring;
		return $result;
	}

	function view($id)
	{
		global $cache;
		$cache->clear();
		exit('<script language="javascript">window.open("'.SITE_URL.'space/index.php?id='.intval($id).'");history.back();</script>');
	}

	function set($id,$data)
	{
		return $this->db->update($this->table,$data,'id='.$id);
	}

	function getvistors($id,$len=10)
	{
		global $cache;
		$id=intval($id);

		$sql="SELECT * FROM `$this->visitor_table` WHERE `$this->visitor_table`.`userid`=$id ORDER BY `$this->visitor_table`.`visittime` DESC LIMIT 0, $len";
		$result=$cache->get($sql);

		if(!$result)
		{
			
			$result=$this->db->fetch_all($sql);
			$cache->set($sql,$result);
		}
		return $result;
	}

	function newfriend($id)
	{
		global $_userid;

		$id=intval($id);
		if(!$id || !$_userid) return '-1';

//		if($id==$_userid)return '-2';
		
		$spaceinfo=$this->spaceinfo($id);
		if(!$spaceinfo) return '-3';

		if($this->db->fetch_one("SELECT * FROM $this->friends_table WHERE userid=$_userid AND spaceid=$id")) return '-4';

		$info=array();
		$info['userid']=$_userid;
		$info['spaceid']=$id;
		$info['spacename']=$spaceinfo['name'];
		$info['spacelogo']=$spaceinfo['logo'];
		$info['addtime']=TIME;

		return $this->db->insert($this->friends_table,$info,true);
	}

	function blackfriend($id)
	{
		global $_userid;
		return $this->db->query("DELETE FROM $this->friends_table WHERE userid=$_userid AND spaceid=$id");
	}

	function addcomment($info)
	{
		return $this->db->insert($this->comment_table,$info);
	}

	function guestbook_pass($ids,$status=1)
	{
		global $_userid;
		$ids=is_array($ids)?array_map('intval',$ids):array(intval($ids));
		if(!$ids) return false;
		foreach($ids as $id)
		{
			$r=$this->db->fetch_one("SELECT userid FROM $this->comment_table WHERE id=$id");
			$spaceinfo=$this->spaceinfo($r['userid']);

			if($spaceinfo['userid']==$_userid)
			{
				$this->db->update($this->comment_table,array('status'=>intval($status)),'id='.$id);
			}
		}
		return true;
	}

	function guestbook_delete($ids)
	{
		global $_userid;
		$ids=is_array($ids)?array_map('intval',$ids):array(intval($ids));
		if(!$ids) return false;
		foreach($ids as $id)
		{
			$r=$this->db->fetch_one("SELECT userid FROM $this->comment_table WHERE id=$id");
			$spaceinfo=$this->spaceinfo($r['userid']);

			if($spaceinfo['userid']==$_userid)
			{
				$this->db->query("DELETE FROM $this->comment_table WHERE id=$id");
			}
		}
		return true;
	}

	function getfriends($id,$len=10)
	{
		global $cache;
		$id=intval($id);

		$sql="SELECT * FROM `$this->friends_table` WHERE `$this->friends_table`.`userid`=$id ORDER BY `$this->friends_table`.`addtime` DESC LIMIT 0, $len";
		$result=$cache->get($sql);

		if(!$result)
		{
			
			$result=$this->db->fetch_all($sql);
			$cache->set($sql,$result);
		}
		return $result;
	}

	function refreshvistors($id)
	{
		global $_userid;
		$id=intval($id);
		
		$spaceinfo=$this->userspaceinfo($_userid);
		if($_userid==$id) 
		{
			return false;
		}
		if(!$spaceinfo)
		{
			return false;
		}
		
		if($this->db->fetch_one("SELECT * FROM `$this->visitor_table` WHERE `$this->visitor_table`.`userid`=$id AND `$this->visitor_table`.`spaceid`=".$spaceinfo['id']))
		{
			return $this->db->update($this->visitor_table,array('visittime'=>TIME),'userid='.$id);
		}
		else
		{
			$info['userid']=$id;
			$info['spaceid']=$spaceinfo['id'];
			$info['spacename']=$spaceinfo['name'];
			$info['spacelogo']=$spaceinfo['logo'];
			$info['visittime']=TIME;
			return $this->db->insert($this->visitor_table,$info,true);
		}
	}

	function editinfo($info)
	{
		global $_userid ,$cache,$_facephoto;
		$info=retengcms_htmlspecialchars($info);
		$info['userid']=$_userid;
		$info['logo']=$info['logo']?$info['logo']:$_facephoto;

		if($this->userspaceinfo($_userid,'id'))
		{
			$this->db->update($this->table,$info,'userid='.$_userid);
		}
		else
		{
			$info['opentime']=TIME;
			$info['template']='default';
			$this->db->insert($this->table,$info,true);
		}
		$cache->clear();
		return true;
	}

	function settemplate($template='default')
	{
		global $_userid,$cache;
		
		$template=preg_replace('/[^a-z0-9_]/i','',$template);
		if(empty($template))return false;

		$file=TPL_ROOT.TPL_NAME.'/space/'.$template.'/';
		if(file_exists($file) && is_dir($file) && is_readable($file))
		{
			$this->db->update($this->table,array('template'=>$template),'userid='.$_userid);
			$cache->rm("SELECT * FROM `{$this->table}` WHERE `{$this->table}`.`userid`=".intval($_userid));
			return true;
		}
		else
		{
			return false;	
		}
	}

	function userspaceinfo($userid,$fields = '*')
	{
		global $cache;
		$sql="SELECT {$fields} FROM `{$this->table}` WHERE `{$this->table}`.`userid`=".intval($userid);
		$result=$cache->get($sql);

		if(!$result)
		{
			$result=$this->db->fetch_one($sql);
			$cache->set($sql,$result);
		}
		return $result;
	}

	function spaceinfo($id,$fields = '*')
	{
		global $cache;
		$sql="SELECT {$fields} FROM `{$this->table}` WHERE `{$this->table}`.`id`=".intval($id);
		$result=$cache->get($sql);

		if(!$result)
		{
			$result=$this->db->fetch_one($sql);
			$cache->set($sql,$result);
		}
		return $result;
	}

	function lock($ids,$lock=0)
	{
		global $cache,$_userid;
		$ids=is_array($ids)?array_map('intval',$ids):array(intval($ids));
		if(!$ids) return false;
		foreach($ids as $id)
		{
			$this->db->update($this->table,array('syslock'=>intval($lock)),'id='.$id);
		}
		$cache->rm("SELECT * FROM `{$this->table}` WHERE `{$this->table}`.`userid`=".intval($_userid));
		return true;
	}
}
?>
