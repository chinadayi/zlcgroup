<?php
/**
	* 自定义表单管理类
*/

class diyform
{
	public $pagestring='';
	private $db;
	private $table;
	private $fields_table;

	function __construct()
	{
		global $db;
		$this->db=$db;
		$this->table=DB_PRE.'form';
		$this->fields_table=DB_PRE.'form_fields';
	}

	function diyform()
	{
		$this->__construct();
	}

	function datalist()
	{
		global $page;
		include RETENG_ROOT.'include/datalist.class.php';
		$datalist = new datalist();
		$where='siteid='.SITEID;
		$orderby='id ASC';
		$page=max(isset($page)?intval($page):1,1);
		$pagesize=15;
		$result=$datalist->getlist($this->table,$where,$orderby,$page,$pagesize);
		$this->pagestring=$datalist->pagestring;
		return $result;
	}

	/*
		缓存操作
	*/
	function cache_diyform()
	{
		$r=$this->db->fetch_all("SELECT * FROM `$this->table` ORDER BY `$this->table`.`id` ASC");
		cache_write('form.cache.php',$r,RETENG_ROOT.'data/cache_module/');
		if($r)foreach($r as $_r)
		{
			cache_write('form'.$_r['id'].'.cache.php',$_r,RETENG_ROOT.'data/cache_module/');

			$fileds=$this->db->fetch_all("SELECT * FROM `$this->fields_table` WHERE `$this->fields_table`.`formid`=".$_r['id']." AND `$this->fields_table`.`disabled`=0 ORDER BY `$this->fields_table`.`orderby` ASC");
			cache_write('form'.$_r['id'].'_fields.cache.php',$fileds,RETENG_ROOT.'data/cache_module/');
			
			if($fileds)foreach($fileds as $field)
			{
				cache_write('form_fields'.$field['id'].'.cache.php',$field,RETENG_ROOT.'data/cache_module/');
			}	
		}
	}

	/*
		表单操作
	*/

	function forminfo($id)
	{
		return $this->db->fetch_one("SELECT * FROM `$this->table` WHERE `$this->table`.`id`=".intval($id));
	}

	function contentlist($formid)
	{
		global $page;
		$forminfo=$this->forminfo($formid);
		include RETENG_ROOT.'include/datalist.class.php';
		$datalist = new datalist();
		$where='1';
		$orderby='id DESC';
		$page=max(isset($page)?intval($page):1,1);
		$pagesize=15;
		$result=$datalist->getlist(DB_PRE.$forminfo['table'],$where,$orderby,$page,$pagesize);
		$this->pagestring=$datalist->pagestring;
		return $result;
	}

	function delete_data($formid,$ids)
	{
		$ids=array_map('intval',$ids);
		$forminfo=$this->forminfo($formid);
		return $this->db->mysql_delete(DB_PRE.$forminfo['table'],$ids);
	}

	function chktable($table)
	{
		$table=trim($table);
		return in_array(DB_PRE.$table,$this->db->get_tables())?true:false;
	}

	function create_table($tbname)
	{
		if(in_array($tbname,$this->db->get_tables())) return false;
		if($this->db->query("CREATE TABLE {$tbname} (
`id` mediumint(8) unsigned NOT NULL  AUTO_INCREMENT,
PRIMARY KEY ( `id` ) 
) ENGINE = MyISAM AUTO_INCREMENT=1 DEFAULT charset=utf8",true))return true;
		return false;
	}

	function add($info)
	{
		if($this->chktable(DB_PRE.$info['table']) || empty($info['name'])) return false;

		$info['siteid']=SITEID;
		if($this->create_table(DB_PRE.$info['table']))
		{
			$formid=$this->db->insert($this->table,$info);

			if($formid)
			{
				$this->cache_diyform();
				return true;
			}
			else
			{
				$this->db->query("DROP TABLE `".DB_PRE.$info['table']."`");
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	function delete($id)
	{
		$forminfo=$this->forminfo(intval($id));
		if($this->db->mysql_delete($this->table,intval($id)) && $this->db->mysql_delete($this->fields_table,intval($id),'formid'))
		{
			$this->db->query("DROP TABLE `".DB_PRE.$forminfo['table']."`",true);
			$this->cache_diyform();
			return true;
		}
		else
		{
			return false;
		}
	}

	function getform($formid,$value=array())
	{
		include_once RETENG_ROOT.'include/form.class.php';
		$form = new form('info');
		return $form->get($formid,$value,'form');
	}

	/*
		字段操作
	*/
	function fieldsdatalist($formid)
	{
		global $page;
		include RETENG_ROOT.'include/datalist.class.php';
		$datalist = new datalist();
		$where='formid='.$formid;
		$orderby='orderby ASC';
		$page=max(isset($page)?intval($page):1,1);
		$pagesize=40;
		$result=$datalist->getlist($this->fields_table,$where,$orderby,$page,$pagesize);
		$this->pagestring=$datalist->pagestring;
		return $result;
	}

	function getfields($formid)
	{
		return $this->db->fetch_all("SELECT * FROM `$this->fields_table` WHERE `$this->fields_table`.`formid`=".intval($formid)." ORDER BY orderby ASC");
	}

	function fieldsinfo($id)
	{
		return $this->db->fetch_one("SELECT * FROM `$this->fields_table` WHERE `$this->fields_table`.`id`=".intval($id));
	}

	function fields_manage_edit($ids,$orderby,$name,$css,$unit)
	{
		if(!$ids)return false;
		$ids=array_map('intval',$ids);
		foreach($ids as $id)
		{
			$info=array('orderby'=>intval($orderby[$id]),'name'=>trim($name[$id]),'css'=>trim($css[$id]),'unit'=>trim($unit[$id]));
			if(trim($name[$id]))$this->db->update($this->fields_table,$info,'id='.$id);
		}
		$this->cache_diyform();
		return true;
	}

	function fields_add($info)
	{
		if($this->chkfieldname($info['formid'],$info['enname']) || empty($info['name'])) return false;
		/*
			创建字段
		*/
		$forminfo=$this->forminfo($info['formid']);
		if($forminfo)
		{
			$info['length']=empty($info['length'])?'8':$info['length'];

			if(in_array($info['form'],array('videourl','more','downurl','attachment','images','fckeditor')))
			{
				$this->db->create_fields(DB_PRE.$forminfo['table'],$info['enname']);
			}
			else if(in_array($info['form'],array('number')))
			{
				if(strpos($info['length'],','))
				{
					$this->db->create_fields(DB_PRE.$forminfo['table'],$info['enname'],$info['length'],'DECIMAL');
				}
				else
				{
					$this->db->create_fields(DB_PRE.$forminfo['table'],$info['enname'],min(8,intval($info['length'])),'INT');
				}
			}
			else
			{
				if(intval($info['length'])>255)
				{
					$this->db->create_fields(DB_PRE.$forminfo['table'],$info['enname']);
				}
				else
				{
					$this->db->create_fields(DB_PRE.$forminfo['table'],$info['enname'],intval($info['length']));
				}
			}

			/*
				插入字段表
			*/
			$insertid=$this->db->insert($this->fields_table,$info);
			$this->db->update($this->fields_table,array('orderby'=>$insertid),'id='.$insertid);
			$this->cache_diyform();
			return true;
		}
		else
		{
			return false;
		}
	}

	function fields_edit($id,$info)
	{
		$id=intval($id);

		/*
			创建字段
		*/
		$info['form']=isset($info['form']) && $info['form']?$info['form']:$info['deform'];

		unset($info['deform']);
		$forminfo=$this->forminfo($info['formid']);
		if($forminfo)
		{
			/*
				删除旧字段
			*/
			$re=true;
			$re=$this->db->query("ALTER TABLE `".DB_PRE.$forminfo['table']."` DROP `".$info['enname']."`",true);

			if($re)
			{
				$info['length']=empty($info['length'])?'8':str_replace(array('，','.'),',',$info['length']);

				if(in_array($info['form'],array('videourl','more','downurl','attachment','images','fckeditor')))
				{
					$this->db->create_fields(DB_PRE.$forminfo['table'],$info['enname']);
				}
				else if(in_array($info['form'],array('number')))
				{
					if(strpos($info['length'],','))
					{
						$this->db->create_fields(DB_PRE.$forminfo['table'],$info['enname'],$info['length'],'DECIMAL');
					}
					else
					{
						$this->db->create_fields(DB_PRE.$forminfo['table'],$info['enname'],min(8,intval($info['length'])),'INT');
					}
				}
				else
				{
					if(intval($info['length'])>255)
					{
						$this->db->create_fields(DB_PRE.$forminfo['table'],$info['enname']);
					}
					else
					{
						$this->db->create_fields(DB_PRE.$forminfo['table'],$info['enname'],intval($info['length']));
					}
				}

				/*
					更新插入字段表
				*/
				unset($info['enname']);

				$this->db->update($this->fields_table,$info,'id='.$id);
				$this->cache_diyform();
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	function fields_delete($id)
	{
		$fieldinfo=$this->fieldsinfo(intval($id));
		if($fieldinfo['cantdelete'])return false;

		$forminfo=$this->forminfo($fieldinfo['formid']);
		$dropsql="ALTER TABLE `".DB_PRE.$forminfo['table']."` DROP `".$fieldinfo['enname']."`";

		if($this->db->query($dropsql,true))
		{
			$this->db->mysql_delete($this->fields_table,intval($id));
			$this->cache_diyform();
			return true;
		}
		return false;
	}

	function fields_disabled($id,$disabled)
	{
		if($this->db->update($this->fields_table, array('disabled'=>intval($disabled)), 'id='.intval($id)))
		{
			$this->cache_diyform();
			return true;
		}
		else
		{
			return false;
		}
	}

	function chkfieldname($formid,$field)
	{
		$field=trim($field);
		$formid=intval($formid);
		$forminfo=$this->forminfo($formid);
		return in_array($field,$this->db->get_fields(DB_PRE.$forminfo['table']))?true:false;
	}
}
