<?php
/**
	* 关键词操作类
*/

class keywords
{
	public $pagestring='';
	private $db;
	private $table;
	private $content_table;

	function __construct()
	{
		global $db;
		$this->db=$db;
		$this->table=DB_PRE.'keywords';
		$this->content_table=DB_PRE.'content';
	}

	function keywords()
	{
		$this->__construct();
	}

	/*
		分割关键词 用于搜索
	*/
	function keywordsql($str,$fields='keywords')
	{
		global $wordsplit;
		$result='';
		$oldstr=trim($str);
		$str=iconv('gbk', 'utf-8//IGNORE', $str);
		$str=$wordsplit->splitWords($str);
		if($str)
		{
			@sort($str);
			foreach($str as $string)
			{
				$string=iconv('utf-8', 'gbk//IGNORE', $string);
				if($string)
				{
					/*
						更新关键词表
					*/
					$this->updatekeywords($string);
					$result.=$fields.' LIKE "%'.$string.'%" AND ';
				}
			}
			return '('.substr($result,0,-4).')';
		}
		else
		{
			return $fields.' LIKE "%'.$oldstr.'%"';
		}
	}

	function splitkeywords($str)
	{
		$string=array();
		global $wordsplit;
		$keystr=trim($str);
		$str=iconv('gbk', 'utf-8//IGNORE', $str);
		$str=$wordsplit->splitWords($str);

		if($str)foreach($str as $val)
		{
			$string[]=iconv('utf-8', 'gbk//IGNORE', $val);
		}
		return $string?$string:array($keystr);
	}

	/*
		关键字管理
	*/

	function updatekeywords($string)
	{
		$string=trim($string);
		if(!$string)
		{
			return false;
		}

		$r=$this->db->fetch_one("SELECT * FROM $this->table WHERE keywords='$string'");
		if($r)
		{	
			$this->db->update($this->table,array('counts'=>$r['counts']+1),'keywords="'.$string.'"');
		}
		else
		{
			$this->db->insert($this->table,array('keywords'=>$string),true);
		}
		return true;
	}

	function keywordslist()
	{
		global $page;
		include RETENG_ROOT.'include/datalist.class.php';
		$datalist = new datalist();
		$where=1;
		$orderby='counts DESC';
		$page=max(isset($page)?intval($page):1,1);
		$pagesize=15;
		$result=$datalist->getlist($this->table,$where,$orderby,$page,$pagesize);
		$this->pagestring=$datalist->pagestring;
		return $result;
	}

	function delete($id)
	{
		$id=is_array($id)?array_map('intval',$id):array(intval($id));
		if(!$id)return false;
		$this->db->mysql_delete($this->table,$id);
		return true;
	}

	function update($keywords,$counts,$weight,$ids)
	{
		$ids=is_array($ids)?array_map('intval',$ids):array(intval($ids));
		if(!$ids)return false;
		foreach($ids as $id)
		{
			if(trim($keywords[$id]))
			{
				$info=array('keywords'=>trim($keywords[$id]),'counts'=>intval($counts[$id]),'weight'=>intval($weight[$id]));
				$this->db->update($this->table,$info,'id='.intval($id));
			}
		}
		return true;
	}
}
?>
