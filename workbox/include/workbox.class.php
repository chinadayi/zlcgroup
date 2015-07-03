<?php
/**
	* 外链工具箱类
*/

class workbox
{
	public $pagestring='';
	private $db;
	private $workbox_table;
	private $tools_table;

	function __construct()
	{
		global $db;
		$this->db=$db;
		$this->workbox_table=DB_PRE.'workbox';
		$this->tools_table=DB_PRE.'tools';
	}
	
	function workbox()
	{
		$this->__construct();
	}
	
	/*
		工具类型
	*/
	function workboxlist()
	{
		return $this->db->fetch_all("SELECT * FROM `$this->workbox_table`");
	}

	function edit_workbox($names=array())
	{	
		if(!$names || !is_array($names)) return false;

		foreach($names as $id => $name)
		{
			$name=trim($name);
			$id=intval($id);
			if(!empty($name))
			{
				$this->db->insert($this->workbox_table,array('id'=>$id,'name'=>$name),true);
			}
			else
			{
				$this->db->mysql_delete($this->workbox_table,$id);
			}
		}
		return true;
	}

	function inlink($id,$inlink)
	{
		return $this->db->update($this->workbox_table,array('inlink'=>intval($inlink)),'id='.intval($id));
	}

	function addinlink($content='')
	{
		$r=$this->db->fetch_all("SELECT a.name,a.url,b.inlink FROM `$this->tools_table` a LEFT JOIN `$this->workbox_table` b ON a.boxid=b.id WHERE b.`inlink`=1");
		if($r)
		{
			$search = "/(alt=|title=)[\"|\'](.+?)[\"|\']/ise";
			$replace = "txt_urlencode('\\1','\\2')";
			$replace1 = "txt_urldecode('\\1','\\2')";
			$content = preg_replace($search, $replace, $content);
			foreach($r as $_r)
			{
				$content=preg_replace('/'.$_r['name'].'/i','<a href="'.$_r['url'].'" title="'.$_r['name'].'" target="_blank">'.$_r['name'].'</a>',$content,1);
			}
			$content = preg_replace($search, $replace1, $content);
		}
		return $content;
	}

	/*
		工具选项
	*/
	function toolslist($boxid)
	{
		global $page;
		include RETENG_ROOT.'include/datalist.class.php';
		$datalist = new datalist();
		$where='boxid='.intval($boxid);
		$orderby='orderby ASC';
		$page=max(isset($page)?intval($page):1,1);
		$result=$datalist->getlist($this->tools_table,$where,$orderby,$page,15);
		$this->pagestring=$datalist->pagestring;
		return $result;
	}

	function toolsinfo($id)
	{
		return $this->db->fetch_one("SELECT * FROM `$this->tools_table` WHERE `$this->tools_table`.`id`=".intval($id));
	}

	function tools_add($info)
	{
		$insertid=$this->db->insert($this->tools_table,$info);

		if($insertid)
		{
			$this->db->update($this->tools_table,array('orderby'=>$insertid),'id='.$insertid);
			return $insertid;
		}
		return false;
	}

	function tools_edit($info,$id)
	{
		return $this->db->update($this->tools_table,$info,'id='.intval($id));
	}

	function tools_editname($names,$urls,$ids)
	{
		if(!$names) return false;
		foreach($names as $id => $name)
		{
			$sql="UPDATE `$this->tools_table` SET `$this->tools_table`.`name`='".$name."',`$this->tools_table`.`url`='".$urls[$id]."' WHERE `$this->table`.`id`=$id";
			$this->db->query($sql,true);
		}
		return true;
	}

	function tools_delete($id)
	{
		return $this->db->mysql_delete($this->tools_table,intval($id));;
	}
}
?>
