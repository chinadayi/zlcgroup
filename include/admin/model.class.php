<?php
/**
	* 模型管理类
*/

class model
{
	public $pagestring;
	private $table;
	private $fields_table;
	private $stepselect_table;
	private $stepselect_enum_table;
	private $cat_table;
	private $con_table;
	private $db;
	private $c;

	function __construct()
	{
		global $db,$c;
		$this->db=$db;
		$this->c=$c;
		$this->table=DB_PRE.'model';
		$this->fields_table=DB_PRE.'model_fields';
		$this->stepselect_table=DB_PRE.'stepselect';
		$this->stepselect_enum_table=DB_PRE.'stepselect_enum';
		$this->cat_table=DB_PRE.'category';
		$this->con_table=DB_PRE.'content';
	}
	
	function model()
	{
		$this->__construct();
	}

	function datalist()
	{
		global $page;
		include RETENG_ROOT.'include/datalist.class.php';
		$datalist = new datalist();
		$where='siteid='.SITEID;
		$orderby='ID ASC';
		$page=max(isset($page)?intval($page):1,1);
		$pagesize=15;
		$result=$datalist->getlist($this->table,$where,$orderby,$page,$pagesize);
		$this->pagestring=$datalist->pagestring;
		return $result;
	}

	function disabled($id,$disabled)
	{
		if($this->db->update($this->table, array('disabled'=>intval($disabled)), 'id='.intval($id)))
		{
			$this->c->cache_model();
			return true;
		}
		else
		{
			return false;
		}
	}

	function delete($id)
	{
		$modelinfo=$this->modelinfo(intval($id));
		if($modelinfo['issystem'])return false;

		if($this->db->mysql_delete($this->table,intval($id)) && $this->db->mysql_delete($this->fields_table,intval($id),'modelid'))
		{
			$this->db->query("DROP TABLE `".DB_PRE.$modelinfo['table']."`",true);
			$this->c->cache_model();

			/*
				删除该模型下的栏目
			*/

			$this->db->mysql_delete($this->cat_table,intval($id),'modelid');
			$this->c->cache_category();

			/*
				删除该模型下的内容
			*/
			$this->db->mysql_delete($this->con_table,intval($id),'modelid');
			return true;
		}
		else
		{
			return false;
		}
	}

	function export($id)
	{
		$id=intval($id);

		// 全部表信息
		$modelinfo=$this->modelinfo($id); 

		$result1=base64_encode($modelinfo['table']); // 表名

		// 1：获取创建附加表语句
		$result2=$this->db->fetch_one("SHOW CREATE TABLE `".DB_PRE.$modelinfo['table']."`");
		$result2=base64_encode(str_replace(DB_PRE,'retengcms_',$result2['Create Table']));

		// 2：获取模型表信息
		$result3=$this->db->fetch_one("SELECT * FROM `$this->table` WHERE `$this->table`.`id`=$id");
		unset($result3['id']);
		$result3=base64_encode(var_export($result3,true));

		// 3：获取字段表信息
		$result4=$this->db->fetch_all("SELECT * FROM `$this->fields_table` WHERE `$this->fields_table`.`modelid`=$id");
		$result4=base64_encode(var_export($result4,true));

		// 4：获取级联菜单信息
		$result5=$this->db->fetch_all("SELECT * FROM `$this->stepselect_table`");
		$result5=base64_encode(var_export($result5,true));

		$result6=$this->db->fetch_all("SELECT * FROM `$this->stepselect_enum_table`");
		$result6=base64_encode(var_export($result6,true));

		// 5：加密
		$export=$result1.'-'.$result2.'-'.$result3.'-'.$result4.'-'.$result5.'-'.$result6;

		// 6：提供下载
		if(ob_get_length() !== false) @ob_end_clean();
		header('Pragma: public');
		header('Last-Modified: '.gmdate('D, d M Y H:i:s') . ' GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: pre-check=0, post-check=0, max-age=0');
		header('Content-Transfer-Encoding: binary');
		header('Content-Encoding: none');
		header('Content-type: text/plain');
		header('Content-Disposition: attachment; filename='.$modelinfo['table'].'.txt');
		header('Content-length: '.strlen($export));
		exit($export);
	}

	function modelinfo($id)
	{
		return $this->db->fetch_one("SELECT * FROM `$this->table` WHERE `$this->table`.`id`=".intval($id));
	}

	function import($content)
	{
		if(!trim($content))
		{
			return -1; // 未上传文件
		}
		else
		{
			if(!$content)return -2;
			$content=explode('-',trim($content));
			if(count($content)!=6)
			{
				return -2;
			}
			
			// 判断表名是否已存在
			if(in_array(DB_PRE.base64_decode($content[0]),$this->db->get_tables()))
			{
				return -3;
			}
			
			// 创建模型表SQL
			$this->db->query(str_replace('retengcms_',DB_PRE,trim(base64_decode($content[1]))),true);

			//导入模型表数据
			$info=string2array(trim(base64_decode($content[2])));
			$modelid=$this->db->insert($this->table,$info,true);

			//导入字段表
			$infos=string2array(trim(base64_decode($content[3])));
			foreach($infos as $info)
			{
				unset($info['id']);
				$info['modelid']=$modelid;
				$this->db->insert($this->fields_table,$info,true);
			}

			//导入级联菜单
			$infos=string2array(trim(base64_decode($content[4])));
			foreach($infos as $info)
			{
				$this->db->insert($this->stepselect_table,$info,true);
			}

			//导入级联菜单选项
			$infos=string2array(trim(base64_decode($content[5])));
			foreach($infos as $info)
			{
				$this->db->insert($this->stepselect_enum_table,$info,true);
			}

			// 更新缓存
			$this->c->cache_model();
			require RETENG_ROOT.'/include/admin/stepselect.class.php';
			$stepselect=new stepselect();

			$r=$this->db->fetch_all("SELECT * FROM `$this->stepselect_table`");
			if($r)foreach($r as $v)
			{
				$stepselect->cache($v['id']);
			}

			 return true;
		}
	}

	function install($info)
	{
		if($this->chkmodeltable(DB_PRE.$info['table']) || empty($info['name'])) return false;

		$info['siteid']=SITEID;
		if($this->db->create_model_table(DB_PRE.$info['table']))
		{
			$modelid=$this->db->insert($this->table,$info);

			if($modelid)
			{
				/*
					将默认字段插入字段表 14:28
				*/
				$this->db->query("INSERT INTO `".$this->fields_table."` (`form` ,`modelid` ,`name` ,`enname` ,`tips` ,`unit` ,`options` ,`default` ,`regex` ,`css` ,`length`  ,`orderby` ,`disabled` ,`cantdelete` ,`adminonly`)VALUES ('title', ".$modelid.", '标题', 'title', '', '', '', '', '', '', '',  '1', '0', '1', '1');",true);
				$this->db->query("INSERT INTO `".$this->fields_table."` (`form` ,`modelid` ,`name` ,`enname` ,`tips` ,`unit` ,`options` ,`default` ,`regex` ,`css` ,`length`  ,`orderby` ,`disabled` ,`cantdelete` ,`adminonly`)VALUES ('style', ".$modelid.", '字体颜色', 'style', '', '', '', '', '', '', '',  '2', '0', '1', '3');",true);
				$this->db->query("INSERT INTO `".$this->fields_table."` (`form` ,`modelid` ,`name` ,`enname` ,`tips` ,`unit` ,`options` ,`default` ,`regex` ,`css` ,`length`  ,`orderby` ,`disabled` ,`cantdelete` ,`adminonly`)VALUES ('thumb', ".$modelid.", '封面图片', 'thumb', '', '', '', '', '', '', '',  '3', '0', '1', '2');",true);
				$this->db->query("INSERT INTO `".$this->fields_table."` (`form` ,`modelid` ,`name` ,`enname` ,`tips` ,`unit` ,`options` ,`default` ,`regex` ,`css` ,`length`  ,`orderby` ,`disabled` ,`cantdelete` ,`adminonly`)VALUES ('keywords', ".$modelid.", '关键字', 'keywords', '', '', '', '', '', '', '',  '4', '0', '1', '1');",true);
				$this->db->query("INSERT INTO `".$this->fields_table."` (`form` ,`modelid` ,`name` ,`enname` ,`tips` ,`unit` ,`options` ,`default` ,`regex` ,`css` ,`length`  ,`orderby` ,`disabled` ,`cantdelete` ,`adminonly`)VALUES ('selectmenu_area', ".$modelid.", '所属地区', 'areaid', '', '', '', ".CITY.", '', '', '', '5', '0', '1', '1');",true);
				$this->db->query("INSERT INTO `".$this->fields_table."` (`form` ,`modelid` ,`name` ,`enname` ,`tips` ,`unit` ,`options` ,`default` ,`regex` ,`css` ,`length`  ,`orderby` ,`disabled` ,`cantdelete` ,`adminonly`)VALUES ('description', ".$modelid.", '内容简介', 'description', '', '', '', '', '', '', '',  '6', '0', '1', '1');",true);
				$this->db->query("INSERT INTO `".$this->fields_table."` (`form` ,`modelid` ,`name` ,`enname` ,`tips` ,`unit` ,`options` ,`default` ,`regex` ,`css` ,`length`  ,`orderby` ,`disabled` ,`cantdelete` ,`adminonly`)VALUES ('posid', ".$modelid.", '推荐位', 'posid', '', '', '', '', '', '', '',  '7', '0', '1', '3');",true);
				$this->db->query("INSERT INTO `".$this->fields_table."` (`form` ,`modelid` ,`name` ,`enname` ,`tips` ,`unit` ,`options` ,`default` ,`regex` ,`css` ,`length`  ,`orderby` ,`disabled` ,`cantdelete` ,`adminonly`)VALUES ('content', ".$modelid.", '内容', 'content', '', '', '', '', '', '', '',  '8', '0', '1', '1');",true);
				$this->db->query("INSERT INTO `".$this->fields_table."` (`form` ,`modelid` ,`name` ,`enname` ,`tips` ,`unit` ,`options` ,`default` ,`regex` ,`css` ,`length`  ,`orderby` ,`disabled` ,`cantdelete` ,`adminonly`)VALUES ('status', ".$modelid.", '发布状态', 'status', '', '', '', '1', '', '', '',  '9', '0', '1', '2');",true);
				$this->db->query("INSERT INTO `".$this->fields_table."` (`form` ,`modelid` ,`name` ,`enname` ,`tips` ,`unit` ,`options` ,`default` ,`regex` ,`css` ,`length`  ,`orderby` ,`disabled` ,`cantdelete` ,`adminonly`)VALUES ('iscomment', ".$modelid.", '评论状态', 'iscomment', '', '', '', '1', '', '', '',  '10', '0', '1', '2');",true);
				$this->db->query("INSERT INTO `".$this->fields_table."` (`form` ,`modelid` ,`name` ,`enname` ,`tips` ,`unit` ,`options` ,`default` ,`regex` ,`css` ,`length`  ,`orderby` ,`disabled` ,`cantdelete` ,`adminonly`)VALUES ('point', ".$modelid.", '阅读点数', 'point', '', '点', '', '0', '', '', '',  '11', '0', '1', '2');",true);
				$this->db->query("INSERT INTO `".$this->fields_table."` (`form` ,`modelid` ,`name` ,`enname` ,`tips` ,`unit` ,`options` ,`default` ,`regex` ,`css` ,`length`  ,`orderby` ,`disabled` ,`cantdelete` ,`adminonly`)VALUES ('amount', ".$modelid.", '阅读钱数', 'amount', '', '元', '', '0.0', '', '', '',  '12', '0', '1', '2');",true);
				$this->db->query("INSERT INTO `".$this->fields_table."` (`form` ,`modelid` ,`name` ,`enname` ,`tips` ,`unit` ,`options` ,`default` ,`regex` ,`css` ,`length`  ,`orderby` ,`disabled` ,`cantdelete` ,`adminonly`)VALUES ('password', ".$modelid.", '信息删除密码', 'password', '针对游客有效，留空为屏蔽此功能!', '', '', '', '', '', '',  '13', '0', '1', '2');",true);
				$this->db->query("INSERT INTO `".$this->fields_table."` (`form` ,`modelid` ,`name` ,`enname` ,`tips` ,`unit` ,`options` ,`default` ,`regex` ,`css` ,`length`  ,`orderby` ,`disabled` ,`cantdelete` ,`adminonly`)VALUES ('expire', ".$modelid.", '信息有效期', 'expire', '0为不限!', '天', '', '0', '', '', '',  '14', '0', '1', '2');",true);
				$this->c->cache_model();
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

	function chkmodeltable($table)
	{
		$table=trim($table);
		return in_array(DB_PRE.$table,$this->db->get_tables())?true:false;
	}

	function getform($modelid)
	{
		include RETENG_ROOT.'include/form.class.php';
		$form = new form('info');
		return $form->get($modelid);
	}

	function searchform($modelid,$fields)
	{
		$modelid=intval($modelid);
		$htmlcode='<form name="searchform'.mt_rand(1,99).'" action="search/index.php" method="get">'."\n";
		$htmlcode.='<input type="hidden" name="modelid" value="'.$modelid.'" />'."\n";

		if($fields)foreach($fields as $field)
		{
			$r=cache_read('model_fields'.$field.'.cache.php',RETENG_ROOT.'data/c/');
			if($r['form']=='number')
			{
				$htmlcode.=$r['name'].'：<input type="text" name="min'.$r['enname'].'" size="8" /> 到 <input type="text" name="max'.$r['enname'].'" size="8"/> '.$r['unit'].'<br />'."\n";
			}
			else
			{
				$htmlcode.=$r['name'].'：<input type="text" name="'.$r['enname'].'" size="20" /> '.$r['unit'].'<br />'."\n";
			}
		}

		$htmlcode.='<input type="submit" value="搜索" name="searchsubmit" />'."\n";
		$htmlcode.='</form>';
		return htmlspecialchars($htmlcode);
	}
		
	function fieldsinfo($id)
	{
		return $this->db->fetch_one("SELECT * FROM `$this->fields_table` WHERE `$this->fields_table`.`id`=".intval($id));
	}

	function fieldsdatalist($modelid)
	{
		global $page;
		include RETENG_ROOT.'include/datalist.class.php';
		$datalist = new datalist();
		$where='modelid='.$modelid;
		$orderby='orderby ASC';
		$page=max(isset($page)?intval($page):1,1);
		$pagesize=40;
		$result=$datalist->getlist($this->fields_table,$where,$orderby,$page,$pagesize);
		$this->pagestring=$datalist->pagestring;
		return $result;
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

		$this->c->cache_model();
		return true;
	}

	function fields_delete($id)
	{
		$fieldinfo=$this->fieldsinfo(intval($id));
		if($fieldinfo['cantdelete'])return false;

		$modelinfo=$this->modelinfo($fieldinfo['modelid']);
		$dropsql="ALTER TABLE `".DB_PRE.$modelinfo['table']."` DROP `".$fieldinfo['enname']."`";

		if($this->db->query($dropsql,true))
		{
			$this->db->mysql_delete($this->fields_table,intval($id));
			$this->c->cache_model();
			return true;
		}
		return false;
	}

	function fields_disabled($id,$disabled)
	{
		if($this->db->update($this->fields_table, array('disabled'=>intval($disabled)), 'id='.intval($id)))
		{
			$this->c->cache_model();
			return true;
		}
		else
		{
			return false;
		}
	}

	function fields_add($info)
	{
		if($this->chkfieldname($info['modelid'],$info['enname']) || empty($info['name'])) return false;
		/*
			创建字段
		*/
		$modelinfo=$this->modelinfo($info['modelid']);
		if($modelinfo)
		{
			$info['length']=empty($info['length'])?'8':$info['length'];

			if(in_array($info['form'],array('videourl','more','downurl','attachment','images','fckeditor','simpleueditor','baidueditor')))
			{
				$this->db->create_fields(DB_PRE.$modelinfo['table'],$info['enname']);
			}
			else if(in_array($info['form'],array('number')))
			{
				if(strpos($info['length'],','))
				{
					$this->db->create_fields(DB_PRE.$modelinfo['table'],$info['enname'],$info['length'],'DECIMAL');
				}
				else
				{
					$this->db->create_fields(DB_PRE.$modelinfo['table'],$info['enname'],min(8,intval($info['length'])),'INT');
				}
			}
			else
			{
				if(intval($info['length'])>255)
				{
					$this->db->create_fields(DB_PRE.$modelinfo['table'],$info['enname']);
				}
				else
				{
					$this->db->create_fields(DB_PRE.$modelinfo['table'],$info['enname'],intval($info['length']));
				}
			}

			/*
				插入字段表
			*/
			$insertid=$this->db->insert($this->fields_table,$info);
			$this->db->update($this->fields_table,array('orderby'=>$insertid),'id='.$insertid);
			$this->c->cache_model();
			return true;
		}
		else
		{
			return false;
		}
	}

	function chkfieldname($modelid,$field)
	{
		$field=trim($field);
		$modelid=intval($modelid);
		$modelinfo=$this->modelinfo($modelid);
		return in_array($field,$this->db->get_fields(DB_PRE.$modelinfo['table']))?true:false;
	}

	function fields_edit($id,$info)
	{
		$id=intval($id);

		/*
			创建字段
		*/
		$info['form']=isset($info['form']) && $info['form']?$info['form']:$info['deform'];

		unset($info['deform']);
		$modelinfo=$this->modelinfo($info['modelid']);
		if($modelinfo)
		{
			/*
				删除旧字段
			*/
			$re=true;

			if(!in_array(trim($info['enname']), $this->db->get_fields(DB_PRE.'content')))
			{
				$re=$this->db->query("ALTER TABLE `".DB_PRE.$modelinfo['table']."` DROP `".$info['enname']."`",true);
			}

			if($re)
			{
				$info['length']=empty($info['length'])?'8':str_replace(array('，','.'),',',$info['length']);

				if(in_array($info['form'],array('videourl','more','downurl','attachment','images','fckeditor')))
				{
					$this->db->create_fields(DB_PRE.$modelinfo['table'],$info['enname']);
				}
				else if(in_array($info['form'],array('number')))
				{
					if(strpos($info['length'],','))
					{
						$this->db->create_fields(DB_PRE.$modelinfo['table'],$info['enname'],$info['length'],'DECIMAL');
					}
					else
					{
						$this->db->create_fields(DB_PRE.$modelinfo['table'],$info['enname'],min(8,intval($info['length'])),'INT');
					}
				}
				else if(!in_array(trim($info['enname']), $this->db->get_fields(DB_PRE.'content')))
				{
					if(intval($info['length'])>255)
					{
						$this->db->create_fields(DB_PRE.$modelinfo['table'],$info['enname']);
					}
					else
					{
						$this->db->create_fields(DB_PRE.$modelinfo['table'],$info['enname'],intval($info['length']));
					}
				}

				/*
					更新插入字段表
				*/
				unset($info['enname']);

				$this->db->update($this->fields_table,$info,'id='.$id);
				$this->c->cache_model();
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
}
?>
