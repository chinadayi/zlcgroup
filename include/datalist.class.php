<?php
/**
	 列表分页类
*/

class datalist
{
	public $db;
	public $pagestring;
	public $number;
	
	function __construct()
	{
		global $db;
		$this->db=$db;
	}
	
	function getlist($table,$where,$orderby,$page=1,$pagesize=15,$totalnumber=0,$align='right',$atttable='',$mainindex='id',$attindex='catid',$morefields='*')
	{
		$array=array();
		$where=empty($where)?'':'WHERE '.$where;
		$orderby=empty($orderby)?'':'ORDER BY '.$orderby;
		if(!$totalnumber)
		{
			if(!empty($atttable))
			{
				/*
					读取多表级联 , 一般不建议使用!
				*/
				$number=get_cache_counts("SELECT COUNT(*) AS count FROM `$table` LEFT JOIN `$atttable` ON `$table`.`$mainindex`=`$atttable`.`$attindex` $where"); 
			}
			else
			{
				$number=get_cache_counts("SELECT COUNT(*) AS count FROM `$table` $where"); 
			}
		}
		else
		{
			$number=intval($totalnumber);
		}
		$pagenum=ceil($number/$pagesize);
		$page=max(1,min(max(intval($page),1),$pagenum));
		$start=($page-1)*$pagesize;
		$limit="LIMIT $start,$pagesize";
		$this->pagestring=getpages($number,$page,$pagesize,0,$align);
		if(!empty($atttable))
		{
			/*
				读取多表级联 , 一般不建议使用!
			*/
			$array=$this->db->fetch_all("SELECT `$table`.*,`$atttable`.".$morefields." FROM `$table` LEFT JOIN `$atttable` ON `$table`.`$mainindex`=`$atttable`.`$attindex` $where $orderby $limit");
		}
		else
		{
			$array=$this->db->fetch_all("SELECT * FROM `$table` $where $orderby $limit");
		}

		return $array;
	}
}
?>