<?php
/**
* 级联菜单类
*/

class stepselect
{
	public $pagestring;
	private $table;
	private $enum_table;
	private $db;
	private $c;

	function __construct()
	{
		global $db,$c;
		$this->db=$db;
		$this->c=$c;
		$this->table=DB_PRE.'stepselect';
		$this->enum_table=DB_PRE.'stepselect_enum';
	}
	
	function stepselect()
	{
		$this->__construct();
	}

	function datalist()
	{
		global $page;
		include RETENG_ROOT.'include/datalist.class.php';
		$datalist = new datalist();
		$where='siteid='.SITEID;
		$orderby='ID DESC';
		$page=max(isset($page)?intval($page):1,1);
		$pagesize=15;
		$result=$datalist->getlist($this->table,$where,$orderby,$page,$pagesize);
		$this->pagestring=$datalist->pagestring;
		return $result;
	}

	function add($info)
	{
		if(!$info['name'] || !$info['table'])return false;
		$info['siteid']=SITEID;
		$this->db->insert($this->table,$info,true);
		$this->c->cache_selectmenu();
		return true;
	}

	function delete($id)
	{
		$id=is_array($id)?array_map('intval',$id):array(intval($id));
		if(!$id)return false;
		$this->db->mysql_delete($this->table,$id); // 删除 stepselect 表内容
		$this->db->mysql_delete($this->enum_table,$id,'selectid'); // 删除 stepselect_enum 表内容
		$this->c->cache_selectmenu();
		return true;
	}

	function update($name,$ids)
	{
		$ids=is_array($ids)?array_map('intval',$ids):array(intval($ids));
		if(!$ids)return false;
		foreach($ids as $id)
		{
			if(trim($name[$id]))$this->db->update($this->table,array('name'=>trim($name[$id])),'id='.intval($id));
		}
		$this->c->cache_selectmenu();
		return true;
	}

	function enuminfo($type='area',$parentid=0,$isall=false,$row="0")
	{
		global $cache;
		$data=array();

		$parentid=intval($parentid);
		$type=preg_replace('/[^a-z0-9_]/i','',$type);
		$menuinfo=$this->db->fetch_one("SELECT `$this->table`.`id` FROM `$this->table` WHERE `$this->table`.`table`='$type'");
		if($menuinfo)
		{
			if(!$isall)
			{
				$sql="SELECT * FROM `$this->enum_table` WHERE `$this->enum_table`.`parentid`=$parentid AND `$this->enum_table`.`selectid`=".$menuinfo['id']." ORDER BY `$this->enum_table`.`orderby` ASC";
			}
			else
			{
				$sql="SELECT * FROM `$this->enum_table` WHERE `$this->enum_table`.`selectid`=".$menuinfo['id']." ORDER BY `$this->enum_table`.`orderby` ASC LIMIT 0,".intval($row);
			}

			$data=$cache->get($sql);
			if(!$data)
			{
				$data=$this->db->fetch_all($sql);
				$cache->set($sql,$data);
			}
			
		}
		return $data;
	}

	function enuminfobyid($id=0)
	{
		global $cache;
		$sql="SELECT * FROM `$this->enum_table` WHERE `$this->enum_table`.`id`=".intval($id);

		$data=$cache->get($sql);
		if(!$data)
		{
			$data=$this->db->fetch_one($sql);
			$cache->set($sql,$data);
		}
			
		return $data;
	}
	
	function enumlist($id)
	{
		global $page;
		include RETENG_ROOT.'include/datalist.class.php';
		$datalist = new datalist();
		$where='selectid='.intval($id);
		$orderby='evalue ASC,orderby ASC';
		$page=max(isset($page)?intval($page):1,1);
		$pagesize=15;
		$result=$datalist->getlist($this->enum_table,$where,$orderby,$page,$pagesize);
		$this->pagestring=$datalist->pagestring;
		return $result;
	}

	function add_enum($info)
	{
		if(!$info['names'])return false;
		$names=explode("\r\n",$info['names']);
		unset($info['names']);
		foreach($names as $value)
		{
			$info['name']=trim($value);
			if($info['name'])
			{
				if($info['parentid']!=0)
				{
					$parinfo=$this->get_enum_byid($info['parentid']);

					if($parinfo['evalue']%500 ==0)
					{
						$info['evalue']=$this->get_max_evalue($info['parentid'])+1;
					}
					else
					{
						$info['evalue']=$this->get_max_evalue($info['parentid'])+0.001;
					}
				}
				else
				{
					$info['evalue']=$this->get_max_evalue(0)+500;
				}
				$info['orderby']=intval($info['evalue']);
				$this->db->insert($this->enum_table,$info,true);
			}
		}
		return true;
	}

	function get_max_evalue($id=0)
	{
		$id=intval($id);
		$r=$this->db->fetch_one("SELECT MAX(`$this->enum_table`.`evalue`+0) AS maxv FROM `$this->enum_table` WHERE `$this->enum_table`.`parentid`=$id");
		if($r && $r['maxv'])
		{
			return $r['maxv'];
		}
		else
		{
			$r=$this->db->fetch_one("SELECT `$this->enum_table`.`evalue` FROM `$this->enum_table` WHERE `$this->enum_table`.`id`=$id");
			return $r && $r['evalue']?$r['evalue']:500;
		}
	}

	function delete_enum($id)
	{
		$id=is_array($id)?array_map('intval',$id):array(intval($id));
		if(!$id)return false;
		foreach($id as $_id)
		{
			$ids=get_childrenid($this->db,$this->enum_table,$_id);
			$this->db->mysql_delete($this->enum_table,$ids); // 删除菜单
		}
		return true;
	}

	function update_enum($name,$orderby,$ids)
	{
		$ids=is_array($ids)?array_map('intval',$ids):array(intval($ids));
		if(!$ids)return false;
		foreach($ids as $id)
		{
			$this->db->update($this->enum_table,array('name'=>trim($name[$id]),'orderby'=>trim($orderby[$id])),'id='.intval($id));
		}
		return true;
	}

	function get_parent_enum($selectid,$formname='parentid')
	{
		$formname=trim($formname);
		$str='<select name="'.$formname.'">';
		$str.='<option value="0">一级分类</option>';
		$r=$this->get_enums_byselectid($selectid);
		if($r)foreach($r as $_r)
		{
			if(!strpos($_r['evalue'],'.') || $_r['evalue']%500 == 0)
			{
				$dot='';
				if($_r['evalue']%500 == 0)
				{
					$dot='';
				}
				else if(!strpos($_r['evalue'],'.'))
				{
					$dot='└─';
				}
				$str.='<option value="'.$_r['id'].'">'.$dot.$_r['name'].'</option>';
			}
		}
		$str.='</select>';

		return $str;
	}

	function get_enums_byselectid($selectid)
	{
		$selectid=intval($selectid);
		return $this->db->fetch_all("SELECT * FROM `$this->enum_table` WHERE `$this->enum_table`.`selectid`=$selectid ORDER BY evalue ASC,orderby ASC");
	}

	function get_enum_byid($id)
	{
		$id=intval($id);
		return $this->db->fetch_one("SELECT * FROM `$this->enum_table` WHERE `$this->enum_table`.`id`=$id");
	}

	function cache($id)
	{
		$r=$this->db->fetch_one("SELECT `$this->table`.`table` FROM `$this->table` WHERE `$this->table`.`id`=$id");
		$table=$r['table'];
		$r=$this->get_enums_byselectid($id);
		$result='var stepselect_'.$table.'=new Array();'."\n";

		if($r)foreach($r as $key => $_r)
		{
			$result.='stepselect_'.$table.'['.$key.']=["'.$_r['name'].'",'.$_r['id'].','.$_r['parentid'].'];'."\n";
		}
		
		$result.='function killerror_'.$table.'()
{
	return true; 
}
 
window.onerror=killerror_'.$table.';

var '.$table.'_top_select=document.getElementById(stepselect+"_top_select");
var '.$table.'_self_select=document.getElementById(stepselect+"_self_select");
var '.$table.'_son_select=document.getElementById(stepselect+"_son_select");

'.$table.'_top_select.options[0]=new Option("请选择..",0);
'.$table.'_self_select.options[0]=new Option("请选择..",0);
'.$table.'_son_select.options[0]=new Option("请选择..",0);

'.$table.'_self_select.style.display="none";
'.$table.'_son_select.style.display="none";

//function load_'.$table.'_config()
//{
	for(var i=0,n=1;i<stepselect_'.$table.'.length;i++)
	{
		if(stepselect_'.$table.'[i][2]==0)
		{
			'.$table.'_top_select.options[n]=null;
			'.$table.'_top_select.options[n]=new Option(stepselect_'.$table.'[i][0],stepselect_'.$table.'[i][1]);
			n++;
		}
	}
	'.$table.'_top_select.focus();
//}

function reset_'.$table.'selectnemu()
{
	'.$table.'_top_select.options[0]=new Option("请选择..",0);
	'.$table.'_top_select.value=0;
	'.$table.'_top_select.disabled="";
}

function get_'.$table.'self_select(name,table,value)
{
	'.$table.'_self_select.options.length=1;
	'.$table.'_son_select.options.length=1;
	
	'.$table.'_self_select.style.display="none";
	'.$table.'_son_select.style.display="none";
	
	if('.$table.'_top_select.value!=0)
	{
		for(var i=0,n=1;i<stepselect_'.$table.'.length;i++)
		{
			if(stepselect_'.$table.'[i][2]=='.$table.'_top_select.value)
			{
				'.$table.'_self_select.options[n]=null;
				'.$table.'_self_select.options[n]=new Option(stepselect_'.$table.'[i][0],stepselect_'.$table.'[i][1]);
				n++;
			}
		}
		if(n>1)'.$table.'_self_select.style.display="";
	}
	if(value)
	{
		document.getElementById(name+\'_id_\'+table).value=value;
		document.getElementById(table).value=value;
	}
	'.$table.'_self_select.focus();
}

function get_'.$table.'son_select(name,table,value)
{
	'.$table.'_son_select.options.length=1;
	'.$table.'_son_select.style.display="none";
	
	if('.$table.'_self_select.value!=0)
	{		
		for(var i=0,n=1;i<stepselect_'.$table.'.length;i++)
		{
			if(stepselect_'.$table.'[i][2]=='.$table.'_self_select.value)
			{
				'.$table.'_son_select.options[n]=null;
				'.$table.'_son_select.options[n]=new Option(stepselect_'.$table.'[i][0],stepselect_'.$table.'[i][1]);
				n++;
			}
		}
		if(n>1)'.$table.'_son_select.style.display="";
	}
	if(value)
	{
		document.getElementById(name+\'_id_\'+table).value=value;
		document.getElementById(table).value=value;
	}
	'.$table.'_son_select.focus();
}

function get_'.$table.'_value(name,table,value)
{
	if(value)
	{
		document.getElementById(name+\'_id_\'+table).value=value;
		document.getElementById(table).value=value;
	}
}
//window.onload(load_'.$table.'_config());';
		$this->c->cache_selectmenu();
		if(file_put_contents(RETENG_ROOT.'data/cache_stepselect/'.$table.'.js',$result))return true;
		return false;
	}

	function preview($table)
	{
		echo '<html><title>预览级联菜单</title><body>'.js_selectmenu($table).'</body></html>';
		exit();
	}
}
?>
