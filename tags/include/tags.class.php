<?php
/**
	* 文章tags标签
*/

class tags
{
	public $pagestring='';
	private $db;
	private $table;
	private $type_table;

	function __construct()
	{
		global $db;
		$this->db=$db;
		$this->table=DB_PRE.'taglist';
		$this->index_table=DB_PRE.'tagindex';
	}

	function tags()
	{
		$this->__construct();
	}

	function tags_cache()
	{
		$r=$this->db->fetch_all("SELECT * FROM `$this->index_table` ORDER BY `$this->index_table`.`orderby` ASC");
		cache_write('tags.cache.php',$r,RETENG_ROOT.'data/cache_module/');
		if($r)foreach($r as $_r)
		{
			cache_write('tags'.$_r['id'].'.cache.php',$_r,RETENG_ROOT.'data/cache_module/');
		}
		return true;
	}
	
	/*
		tag列表
	*/
	function taglist()
	{
		global $page;
		include RETENG_ROOT.'include/datalist.class.php';
		$datalist = new datalist();
		$where='siteid='.SITEID;
		$orderby='id ASC';
		$page=max(isset($page)?intval($page):1,1);
		$pagesize=15;
		$result=$datalist->getlist($this->index_table,$where,$orderby,$page,$pagesize);
		$this->pagestring=$datalist->pagestring;
		return $result;
	}

	function tags_add($info)
	{
		$info['siteid']=SITEID;
		$tags=$info['tag'];
		$this->db->insert($this->table,$info);
		$this->tags_count_add($tags);
		//$this->link_cache();
		return true;
	}
	function tags_edit($info)
	{
		$info['siteid']=SITEID;
		$id=$info['contentid'];
		$tags=$info['tag'];
		$r=$this->db->fetch_all("SELECT * FROM $this->table WHERE contentid=".$id);
		if($r)foreach($r as $_r)
		{
			if($_r['tag']!=$tags)
			{
				$this->db->insert($this->table,$info);
				$this->tags_count_add($tags);
			}
		}
		return true;
	}
	//*清理一篇文章的tag
	function tags_del($id)
	{
		$r=$this->db->fetch_all("SELECT * FROM $this->table WHERE contentid=".$id);
		if($r)foreach($r as $_r)
		{
				$tags=$_r['tag'];
				$tagid=$_r['id'];
				$this->tags_count_del($tags);
			    $this->db->mysql_delete($this->table,$tagid,'id');//删除taglist中的原始标签
				
		}
		return true;
	}
	function tags_del_by_tag($tag)
	{
		$r=$this->db->fetch_all("SELECT * FROM $this->table WHERE tag='$tag'");
		if($r)foreach($r as $_r)
		{
				$tags=$_r['tag'];
				$this->tags_count_del($tags);
			    $this->db->mysql_delete($this->table,$tagid,'id');//删除taglist中的原始标签
				
		}
		return true;
	}
	
	function tags_count_add($tags)
	{
		$r=$this->db->fetch_one("SELECT * FROM $this->index_table WHERE tag='$tags'");
		if($r)
		{
			$tag['count']=$r['count']+1;
			$tag['uptime']=TIME;
			$tag['tag']=$tags;
			$tag['siteid']=SITEID;
			$this->db->update($this->index_table,$tag,'tag="'.$tags.'"');
		}else
		{
			$tag['count']=1;
			$tag['addtime']=TIME;
			$tag['uptime']=TIME;
			$tag['tag']=$tags;
			$tag['siteid']=SITEID;
			$this->db->insert($this->index_table,$tag,true);
		}
	}
	function tags_count_del($tags)
	{
		$r=$this->db->fetch_one("SELECT * FROM $this->index_table WHERE tag='$tags'");
		if($r)
		{
			if($r['count']>1)
			{
			   $this->db->update($this->index_table,array('count'=>$r['count']-1),'tag="'.$tags.'"');
			}else
			{
				$this->db->query("delete from $this->index_table WHERE tag='$tags'");
			}
		}
	}


}
?>
