<?php
/**
	* 会员管理类
*/

class member
{
	public $pagestring='';
	private $db;
	private $table;
	private $cache_table;
	private $group_table;
	private $grade_table;
	private $honor_table;
	private $message_table;
	private $model_table;
	private $model_table_fields;

	function __construct()
	{
		global $db;
		$this->db=$db;
		$this->table=DB_PRE.'member';
		$this->cache_table=DB_PRE.'member_cache';
		$this->group_table=DB_PRE.'membergroup';
		$this->grade_table=DB_PRE.'membergrade';
		$this->honor_table=DB_PRE.'memberhonor';
		$this->message_table=DB_PRE.'message';
		$this->model_table=DB_PRE.'membermodel';
		$this->model_table_fields=DB_PRE.'memberdb_fields';
	}

	function member()
	{
		$this->__construct();
	}

	function cache_member()
	{
		/*
			会员模型
		*/
		$r=$this->db->fetch_all("SELECT * FROM `$this->model_table` ORDER BY `$this->model_table`.`id` ASC");
		cache_write('model.cache.php',$r,RETENG_ROOT.'data/cache_module/');
		if($r)foreach($r as $_r)
		{
			cache_write('model'.$_r['id'].'.cache.php',$_r,RETENG_ROOT.'data/cache_module/');

			$fileds=$this->db->fetch_all("SELECT * FROM `$this->model_table_fields` WHERE `$this->model_table_fields`.`modelid`=".$_r['id']." ORDER BY `$this->model_table_fields`.`orderby` ASC");
			cache_write('model'.$_r['id'].'_fields.cache.php',$fileds,RETENG_ROOT.'data/cache_module/');
			
			if($fileds)foreach($fileds as $field)
			{
				cache_write('model_fields'.$field['id'].'.cache.php',$field,RETENG_ROOT.'data/cache_module/');
			}	
		}

		/*
			会员组
		*/
		$r=$this->db->fetch_all("SELECT * FROM `$this->group_table` ORDER BY `$this->group_table`.`orderby` ASC");
		cache_write('membergroup.cache.php',$r,RETENG_ROOT.'data/cache_module/');
		if($r)foreach($r as $_r)
		{
			cache_write('membergroup'.$_r['id'].'.cache.php',$_r,RETENG_ROOT.'data/cache_module/');
		}

		/*
			会员级别
		*/
		$r=$this->db->fetch_all("SELECT * FROM `$this->grade_table` ORDER BY `$this->grade_table`.`grade` ASC");
		cache_write('membergrade.cache.php',$r,RETENG_ROOT.'data/cache_module/');
		if($r)foreach($r as $_r)
		{
			cache_write('membergrade'.$_r['grade'].'.cache.php',$_r,RETENG_ROOT.'data/cache_module/');
		}

		/*
			会员头衔
		*/
		$r=$this->db->fetch_all("SELECT * FROM `$this->honor_table` ORDER BY `$this->honor_table`.`point` ASC");
		cache_write('memberhonor.cache.php',$r,RETENG_ROOT.'data/cache_module/');
		if($r)foreach($r as $_r)
		{
			cache_write('memberhonor'.$_r['id'].'.cache.php',$_r,RETENG_ROOT.'data/cache_module/');
		}
	}
	
	/*
		会员操作
	*/
	function datalist($orderby,$level=1,$field='',$fieldid='',$stype='username',$k='')
	{
		global $page;
		include RETENG_ROOT.'include/datalist.class.php';
		$datalist = new datalist();
		$where=intval($level)?'level!=0':'level=0';
		if($field && $fieldid)
		{
			$where.=' AND `'.$field.'`=\''.$fieldid.'\'';
		}
		if($stype && $k)
		{
			$where.=' AND `'.$stype.'`=\''.$k.'\'';
		}
		$orderby=$orderby;
		$page=max(isset($page)?intval($page):1,1);
		$pagesize=15;
		$result=$datalist->getlist($this->table,$where,$orderby,$page,$pagesize);
		if($result)foreach($result as $key => $_r)
		{
			$r=cache_read('membergroup'.$_r['groupid'].'.cache.php',RETENG_ROOT.'data/cache_module/');
			$result[$key]['group']=$r['name'];
			$r=cache_read('membergrade'.$_r['gradeid'].'.cache.php',RETENG_ROOT.'data/cache_module/');
			$result[$key]['grade']=$r['name'];
			$r=cache_read('model'.$_r['modelid'].'.cache.php',RETENG_ROOT.'data/cache_module/');
			$result[$key]['model']=$r['name'];
		}
		$this->pagestring=$datalist->pagestring;
		return $result;
	}

	function member_add($info)
	{
		if(!$info['username'] || !$info['password'] || !$info['modelid']) return false;

		$info['password']=PWD($info['password']);
		$info['regtime']=TIME;
		$info['logintime']=TIME;
		$info['loginip']=IP;
		$info['level']=1;
		$info['areaid']=CITY;
		$insertid=$this->db->insert($this->table,$info);

		/*
			更新拓展表
		*/
		$modelinfo=cache_read('model'.$info['modelid'].'.cache.php',RETENG_ROOT.'data/cache_module/');
		if($modelinfo)
		{
			return $this->db->insert(DB_PRE.$modelinfo['table'],array('userid'=>$insertid));
		}
		else
		{
			$this->db->mysql_delete($this->table,$insertid);
			return false;
		}
	}

	function member_edit($info,$id)
	{
		if(!$info['username'] || !$info['modelid']) return false;
		if(!trim($info['password']))
		{
			unset($info['password']);
		}
		else
		{
			$info['password']=PWD($info['password']);
		}
		
		$r=cache_read('model'.$info['oldmodelid'].'.cache.php',RETENG_ROOT.'data/cache_module/');
		if($info['oldmodelid']!=$info['modelid'])
		{
			/*
				更换模型
			*/
			$this->db->mysql_delete(DB_PRE.$r['table'],$id,'userid');
			$r=cache_read('model'.$info['modelid'].'.cache.php',RETENG_ROOT.'data/cache_module/');
			$this->db->insert(DB_PRE.$r['table'],array('userid'=>$id));
		}
		else
		{
			/*
				更新拓展表信息
			*/
			$this->db->update(DB_PRE.$r['table'],$info,'userid='.$id);
		}
		$this->db->update($this->table,$info,'id='.$id);
		$this->db->update($this->cache_table,$info,'id='.$id);
		return true;
	}

	function member_upgrade($ids,$gradeid=20,$expire=365)
	{
		$ids=array_map('intval',$ids);
		foreach($ids as $id)
		{
			if($id && $gradeid > 10)
			{
				$this->db->update($this->table,array('level'=>2,'gradeid'=>intval($gradeid),'expire'=>TIME+$expire*24*3600),'id='.$id);
			}
			else if($id && $gradeid == 10)
			{
				$this->db->update($this->table,array('level'=>1,'gradeid'=>intval($gradeid),'expire'=>''),'id='.$id);
			}
		}
		$this->db->mysql_delete($this->cache_table,$id);
		return true;
	}

	function member_lock($ids,$islock=1)
	{
		$level=intval($islock)?0:1;
		$groupid=intval($islock)?3:4;
		$ids=array_map('intval',$ids);
		foreach($ids as $id)
		{
			if($id && $id!=ADMIN_FOUNDERS)
			{
				if($level)
				{
					$info=$this->memberinfo($id,'expire,modelid');
					if($info['expire'] > TIME)
					{
						$level=2;
					}
					unset($info);
				}
				$this->db->update($this->table,array('level'=>$level,'groupid'=>$groupid),'id='.$id);
			}
		}
		$this->db->mysql_delete($this->cache_table,$id);
		return true;
	}

	function member_delete($ids)
	{
		$ids=array_map('intval',$ids);
		foreach($ids as $id)
		{
			if($id && $id!=ADMIN_FOUNDERS)
			{
				$this->db->mysql_delete($this->table,$id);
			}
		}
		$this->db->mysql_delete($this->cache_table,$id);
		return true;
	}

	function setting($config)
	{
		if(!is_array($config)) return false;
		$configfile = substr(dirname(__FILE__),0,-14).'/data/config.inc.php';
		if(!is_writable($configfile)) fatal_error('Please chmod ./data/config.inc.php to 0777 !');
		$pattern = $replacement = array();

		foreach($config as $k=>$v)
		{
			$pattern[$k] = "/define\(\s*['\"]".strtoupper($k)."['\"]\s*,\s*([']?)[^']*([']?)\s*\)/is";
			$replacement[$k] = "define('".strtoupper($k)."', \${1}".$v."\${2})";
		}
		$str = file_get_contents($configfile);
		$str = preg_replace($pattern, $replacement, $str);
		return file_put_contents($configfile, $str);
	}

	function memberinfo($id,$fields='*',$more=false)
	{
		$baseinfo=$this->db->fetch_one("SELECT $fields FROM `$this->table` WHERE `$this->table`.`id`=".intval($id));
		$modelinfo=cache_read('model'.$baseinfo['modelid'].'.cache.php',RETENG_ROOT.'data/cache_module/');
		if(!$more || empty($modelinfo['table']) || !$modelinfo)
		{
			return $baseinfo;
		}

		$moreinfo=$this->db->fetch_one("SELECT * FROM `".DB_PRE.$modelinfo['table']."` WHERE `".DB_PRE.$modelinfo['table']."`.`userid`=".intval($id));
		$moreinfo=$moreinfo?$moreinfo:array();
		return array_merge($baseinfo,$moreinfo);
	}

	/*
		会员模型
	*/

	function modellist()
	{
		global $page;
		include RETENG_ROOT.'include/datalist.class.php';
		$datalist = new datalist();
		$where=1;
		$orderby='id ASC';
		$page=max(isset($page)?intval($page):1,1);
		$pagesize=15;
		$result=$datalist->getlist($this->model_table,$where,$orderby,$page,$pagesize);
		$this->pagestring=$datalist->pagestring;
		return $result;
	}

	function model_install($info)
	{
		if($this->chkmodeltable(DB_PRE.$info['table']) || empty($info['name'])) return false;

		if($this->db->create_member_table(DB_PRE.$info['table']))
		{
			$modelid=$this->db->insert($this->model_table,$info);

			if($modelid)
			{
				$this->db->query("INSERT INTO `".$this->model_table_fields."` (`form` ,`modelid` ,`name` ,`enname` ,`tips` ,`unit` ,`options` ,`default` ,`regex` ,`css` ,`length` ,`orderby` ,`disabled` ,`cantdelete` ,`adminonly`)VALUES ('selectmenu_area', ".$modelid.", '所属地区', 'areaid', '', '', '', ".CITY.", '', '', '', '1', '0', '1', '0');",true);
				$this->cache_member();
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

	function model_delete($id)
	{
		$modelinfo=$this->modelinfo(intval($id));
		if($modelinfo['issystem'])return false;

		if($this->db->mysql_delete($this->model_table,intval($id)) && $this->db->mysql_delete($this->model_table_fields,intval($id),'modelid'))
		{
			$this->db->query("DROP TABLE `".DB_PRE.$modelinfo['table']."`",true);

			/*
				将该模型下的会员转为普通模型
			*/
			$this->db->update($this->table,array('modelid'=>1),'modelid='.intval($id));
			$this->cache_member();
			return true;
		}
		else
		{
			return false;
		}
	}

	function model_disabled($id,$disabled)
	{
		$modelinfo=$this->modelinfo(intval($id));
		if($modelinfo['issystem'])return false;

		if($this->db->update($this->model_table,array('disabled'=>intval($disabled)),'id='.intval($id)))
		{
			/*
				将该模型下的会员转为普通模型
			*/
			$this->db->update($this->table,array('modelid'=>1),'modelid='.intval($id));
			$this->cache_member();
			return true;
		}
		else
		{
			return false;
		}
	}

	function modelinfo($id)
	{
		return $this->db->fetch_one("SELECT * FROM `$this->model_table` WHERE `$this->model_table`.`id`=".intval($id));
	}

	function chkmodeltable($table)
	{
		$table=trim($table);
		return in_array(DB_PRE.$table,$this->db->get_tables())?true:false;
	}

	function getform($modelid,$default=array())
	{
		include RETENG_ROOT.'include/form.class.php';
		$form = new form('info');
		return $form->get($modelid,$default,'member');
	}

	/*
		模型字段
	*/
	function fieldsdatalist($modelid)
	{
		global $page;
		include RETENG_ROOT.'include/datalist.class.php';
		$datalist = new datalist();
		$where='modelid='.$modelid;
		$orderby='orderby ASC';
		$page=max(isset($page)?intval($page):1,1);
		$pagesize=15;
		$result=$datalist->getlist($this->model_table_fields,$where,$orderby,$page,$pagesize);
		$this->pagestring=$datalist->pagestring;
		return $result;
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

			if(in_array($info['form'],array('videourl','downurl','attachment','images','fckeditor')))
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
			$insertid=$this->db->insert($this->model_table_fields,$info);
			$this->db->update($this->model_table_fields,array('orderby'=>$insertid),'id='.$insertid);
			$this->cache_member();
			return true;
		}
		else
		{
			return false;
		}
	}

	function fields_manage_edit($ids,$orderby,$name,$css,$unit)
	{
		if(!$ids)return false;
		$ids=array_map('intval',$ids);
		foreach($ids as $id)
		{
			$info=array('orderby'=>intval($orderby[$id]),'name'=>trim($name[$id]),'css'=>trim($css[$id]),'unit'=>trim($unit[$id]));
			if(trim($name[$id]))$this->db->update($this->model_table_fields,$info,'id='.$id);
		}

		$this->cache_member();
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
			$this->db->mysql_delete($this->model_table_fields,intval($id));
			$this->cache_member();
			return true;
		}
		return false;
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

			if(!in_array(trim($info['enname']), $this->db->get_fields(DB_PRE.'member')))
			{
				$re=$this->db->query("ALTER TABLE `".DB_PRE.$modelinfo['table']."` DROP `".$info['enname']."`",true);
			}

			if($re)
			{
				$info['length']=empty($info['length'])?'8':str_replace(array('，','.'),',',$info['length']);

				if(in_array($info['form'],array('videourl','downurl','attachment','images','fckeditor')))
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
				else if(!in_array(trim($info['enname']), $this->db->get_fields(DB_PRE.'member')))
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

				$this->db->update($this->model_table_fields,$info,'id='.$id);
				$this->cache_member();
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

	function fields_disabled($id,$disabled)
	{
		if($this->db->update($this->model_table_fields, array('disabled'=>intval($disabled)), 'id='.intval($id)))
		{
			$this->cache_member();
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

	function fieldsinfo($id)
	{
		return $this->db->fetch_one("SELECT * FROM `$this->model_table_fields` WHERE `$this->model_table_fields`.`id`=".intval($id));
	}

	/*
		会员组
	*/

	function grouplist()
	{
		return $this->db->fetch_all("SELECT * FROM `$this->group_table` ORDER BY `$this->group_table`.`orderby` ASC");
	}

	function groupinfo($id)
	{
		return $this->db->fetch_one("SELECT * FROM `$this->group_table` WHERE `$this->group_table`.`id` =".intval($id));
	}

	function group_add($info)
	{
		$info['postcatid']=$info['postcatid'] && !in_array(0, $info['postcatid'])?implode(",",$info['postcatid']):0;
		$info['viewcatid']=$info['viewcatid'] && !in_array(0, $info['viewcatid'])?implode(",",$info['viewcatid']):0;
		$insertid=$this->db->insert($this->group_table,$info);
		$this->db->update($this->group_table,array('orderby'=>$insertid),'id='.$insertid);
		$this->cache_member();
		return true;
	}

	function group_edit_name($names,$orderbys)
	{
		if($names)foreach($names as $id => $name)
		{
			$this->db->update($this->group_table,array('orderby'=>intval($orderbys[$id]),'name'=>trim($name)),'id='.intval($id));
		}
		$this->cache_member();
		return true;
	}

	function group_edit($info,$id)
	{
		$info['postcatid']=$info['postcatid'] && !in_array(0, $info['postcatid'])?implode(",",$info['postcatid']):0;
		$info['viewcatid']=$info['viewcatid'] && !in_array(0, $info['viewcatid'])?implode(",",$info['viewcatid']):0;
		$this->db->update($this->group_table,$info,'id='.$id);
		$this->cache_member();
		return true;
	}

	function group_delete($id)
	{
		$id=intval($id);
		$groupinfo=$this->groupinfo($id);

		/*
			系统会员组禁止删除
		*/
		if($groupinfo['issystem'] || !$id) return false;
		$this->db->mysql_delete($this->group_table,$id);
		$this->db->update($this->table,array('groupid'=>4),'groupid='.intval($id));
		$this->cache_member();
		return true;
	}

	function group_disabled($id,$disabled)
	{
		$id=intval($id);
		$groupinfo=$this->groupinfo($id);

		/*
			系统会员组禁止禁用
		*/
		if($groupinfo['issystem'] || !$id) return false;
		$this->db->update($this->group_table,array('disabled'=>intval($disabled)),'id='.$id);
		$this->db->update($this->table,array('groupid'=>4),'groupid='.intval($id));
		$this->cache_member();
		return true;
	}

	/*
		会员级别
	*/
	
	function gradelist()
	{
		return $this->db->fetch_all("SELECT * FROM `$this->grade_table` ORDER BY `$this->grade_table`.`grade` ASC");
	}

	function gradeinfo($id)
	{
		return $this->db->fetch_one("SELECT * FROM `$this->grade_table` WHERE `$this->grade_table`.`id` =".intval($id));
	}

	function grade_add($info)
	{
		$info['postcatid']=$info['postcatid'] && !in_array(0, $info['postcatid'])?implode(",",$info['postcatid']):0;
		$info['viewcatid']=$info['viewcatid'] && !in_array(0, $info['viewcatid'])?implode(",",$info['viewcatid']):0;
		$info['module']=isset($info['module']) && $info['module']?implode(",",$info['module']):0;
		$insertid=$this->db->insert($this->grade_table,$info);
		$this->cache_member();
		return true;
	}

	function grade_edit($info,$id)
	{
		$info['postcatid']=$info['postcatid'] && !in_array(0, $info['postcatid'])?implode(",",$info['postcatid']):0;
		$info['viewcatid']=$info['viewcatid'] && !in_array(0, $info['viewcatid'])?implode(",",$info['viewcatid']):0;
		$info['module']=isset($info['module']) && $info['module']?implode(",",$info['module']):0;
		$insertid=$this->db->update($this->grade_table,$info,'id='.$id);
		$this->cache_member();
		return true;
	}

	function grade_edit_name($grades,$names,$amounts,$points,$infos)
	{
		if($names)foreach($names as $id => $name)
		{
			$this->db->update($this->grade_table,array('grade'=>intval($grades[$id]),'name'=>trim($name),'amount'=>intval($amounts[$id]),'point'=>intval($amounts[$id]),'info'=>trim($infos[$id])),'id='.intval($id));
		}
		$this->cache_member();
		return true;
	}

	function grade_delete($id)
	{
		$id=intval($id);
		$gradeinfo=$this->gradeinfo($id);

		/*
			系统会员组禁止删除
		*/
		if($gradeinfo['issystem'] || !$id) return false;
		$this->db->mysql_delete($this->grade_table,$id);
		$this->cache_member();
		return true;
	}

	function grade_disabled($id,$disabled)
	{
		$id=intval($id);
		$gradeinfo=$this->gradeinfo($id);

		/*
			系统会员组禁止禁用
		*/
		if($gradeinfo['issystem'] || !$id) return false;
		$this->db->update($this->grade_table,array('disabled'=>intval($disabled)),'id='.$id);
		$this->cache_member();
		return true;
	}

	/*
		会员头衔
	*/
	function honorlist()
	{
		return $this->db->fetch_all("SELECT * FROM `$this->honor_table` ORDER BY `$this->honor_table`.`id` ASC");
	}

	function honorinfo($id)
	{
		return $this->db->fetch_one("SELECT * FROM `$this->honor_table` WHERE `$this->honor_table`.`id` =".intval($id));
	}

	function honor_add($info)
	{
		$insertid=$this->db->insert($this->honor_table,$info);
		$this->cache_member();
		return true;
	}

	function honor_edit($names,$points,$icos)
	{
		if($names)foreach($names as $id =>$name)
		{
			$this->db->update($this->honor_table,array('name'=>$name,'point'=>$points[$id],'ico'=>$icos[$id]),'id='.$id);
		}
		return true;
	}

	function honor_delete($id)
	{
		$id=intval($id);
		$this->db->mysql_delete($this->honor_table,$id);
		$this->cache_member();
		return true;
	}

	function honor_disabled($id,$disabled)
	{
		$id=intval($id);
		$this->db->update($this->honor_table,array('disabled'=>intval($disabled)),'id='.$id);
		$this->cache_member();
		return true;
	}

	/*
		站内信
	*/
	function message_send($info)
	{
		$content=filterhtml($info['content'],3);
		$info=array_map('htmlspecialchars',$info);
		$info['content']=$content;
		return $this->db->insert($this->message_table,$info);
	}
}
?>
