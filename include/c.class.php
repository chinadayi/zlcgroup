<?php
/**
	* 常规缓存类
*/

set_time_limit(0);
class c
{
	public $db;

	function __construct()
	{
		@set_time_limit(0);
		global $db;
		$this->db=$db;
		$expiretime=time()-CACHE_COUNT_TTL;
		if($db && file_exists(RETENG_ROOT.'data/retengcms.lock'))
		{
			$this->db->query('DELETE FROM `'.DB_PRE.'counts` WHERE `'.DB_PRE.'counts`.`updatetime`<'.$expiretime,true);
		}
	}

	function c()
	{
		$this->__construct();
	}

	function cache_all()
	{
		global $cache,$module;
		if($cache && is_object($cache))
		{
			$cache->clear();
		}

		cache_delete('*.*',RETENG_ROOT.'data/c/');
		cache_delete('*.*',RETENG_ROOT.'data/tmp/');
		cache_delete('*.*',RETENG_ROOT.'data/cache_cateogry/');
		$this->cache_author();
		$this->cache_copyfrom();
		$this->cache_posid();
		$this->cache_model();
		$this->cache_selectmenu();
		$this->cache_category();
		$this->cache_tag();
		$this->cache_template();
		$this->cache_module();

		/*
			导入模块模板解析文件
		*/
		if($module && is_object($module))
		{
			$modlist=$module->module_list(false);
			if($modlist)foreach($modlist as $mod)
			{
				$cache_file=RETENG_ROOT.$mod['folder'].'/include/cache.php';
				if(file_exists($cache_file) && is_file($cache_file))
				{
					include $cache_file;
				}
			}
		}
		return true;
	}

	function cache_template()
	{	
		set_cookie('project','');
		$tlp_cache_path=substr(TPL_CACHEPATH,0,strlen(RETENG_ROOT))==RETENG_ROOT?TPL_CACHEPATH:RETENG_ROOT.TPL_CACHEPATH;
		rmdirs($tlp_cache_path);
		@mkdir($tlp_cache_path,0777);
		return true;
	}
	
	function cache_tag()
	{
		global $cache;
		if($cache && is_object($cache))
		{
			$cache->clear();
		}
		return true;
	}

	function cache_author()
	{
		$r=$this->db->fetch_all("SELECT * FROM `".DB_PRE."author` ORDER BY `".DB_PRE."author`.`orderby` ASC,`".DB_PRE."author`.`id` DESC");
		cache_write('author.cache.php',$r,RETENG_ROOT.'data/c/');
	}

	function cache_copyfrom()
	{
		$r=$this->db->fetch_all("SELECT * FROM `".DB_PRE."copyfrom` ORDER BY `".DB_PRE."copyfrom`.`orderby` ASC,`".DB_PRE."copyfrom`.`id` DESC");
		cache_write('copyfrom.cache.php',$r,RETENG_ROOT.'data/c/');
	}

	function cache_posid()
	{
		$r=$this->db->fetch_all("SELECT * FROM `".DB_PRE."posid` ORDER BY `".DB_PRE."posid`.`orderby` ASC,`".DB_PRE."posid`.`id` DESC");
		cache_write('posid.cache.php',$r,RETENG_ROOT.'data/c/');
	}

	function cache_model()
	{
		$r=$this->db->fetch_all("SELECT * FROM `".DB_PRE."model` ORDER BY `".DB_PRE."model`.`id` ASC");
		cache_write('model.cache.php',$r,RETENG_ROOT.'data/c/');
		if($r)foreach($r as $_r)
		{
			cache_write('model'.$_r['id'].'.cache.php',$_r,RETENG_ROOT.'data/c/');

			$fileds=$this->db->fetch_all("SELECT * FROM `".DB_PRE."model_fields` WHERE `".DB_PRE."model_fields`.`modelid`=".$_r['id']." ORDER BY `".DB_PRE."model_fields`.`orderby` 
ASC");
			cache_write('model'.$_r['id'].'_fields.cache.php',$fileds,RETENG_ROOT.'data/c/');
			
			if($fileds)foreach($fileds as $field)
			{
				cache_write('model_fields'.$field['id'].'.cache.php',$field,RETENG_ROOT.'data/c/');
			}	
		}

	}

	function cache_selectmenu()
	{
		$r=$this->db->fetch_all("SELECT * FROM `".DB_PRE."stepselect` ORDER BY `".DB_PRE."stepselect`.`id` ASC");
		cache_write('stepselect.cache.php',$r,RETENG_ROOT.'data/c/');
		if($r)foreach($r as $_r)
		{
			$re=array();
			$enum=$this->db->fetch_all("SELECT * FROM `".DB_PRE."stepselect_enum` WHERE `".DB_PRE."stepselect_enum`.`selectid`=".$_r['id']." ORDER BY `".DB_PRE."stepselect_enum`.`orderby` ASC");
			if($enum)foreach($enum as $_num)
			{
				cache_write('stepselect_enum'.$_r['table'].$_num['id'].'.cache.php',$_num,RETENG_ROOT.'data/c/');
				$re[$_num['id']]=$_num['name'];
			}
			cache_write('stepselect_enum'.$_r['table'].'_id.cache.php',$enum,RETENG_ROOT.'data/c/');
			cache_write('stepselect_enum'.$_r['table'].'.cache.php',$re,RETENG_ROOT.'data/c/');
		}
	}

	function cache_category()
	{
		$base=$setting=$parent0=array();

		$catid =array(); // 所有栏目ID
		$finalcat=array();  // 所有最终栏目
		$finalcatid=array();  // 所有最终栏目ID
		$parent=array(); // 所有父栏目 

		$r=$this->db->fetch_all("SELECT * FROM `".DB_PRE."category` ORDER BY `".DB_PRE."category`.`orderby` ASC");

		cache_write('cat.cache.php',$r,RETENG_ROOT.'data/cache_category/'); // cat.cache.php 全部栏目

		if($r)foreach($r as $_r)
		{
			$catid[]= $_r['id'];

			$base=$_r;
			unset($base['setting']);
			cache_write('cat'.$_r['id'].'.cache.php',$base,RETENG_ROOT.'data/cache_category/');

			$setting=string2array($_r['setting']);
			cache_write('cat_setting'.$_r['id'].'.cache.php',$setting,RETENG_ROOT.'data/cache_category/');

			if($_r['parentid']==0)
			{
				$parent0[]=$_r;
				$parent[]=$_r;
			}
			
			$r2=$this->db->fetch_all("SELECT * FROM `".DB_PRE."category` WHERE `".DB_PRE."category`.`parentid`=".intval($_r['id'])." ORDER BY `".DB_PRE."category`.`orderby` ASC");

			cache_write('cat_parent'.$_r['id'].'.cache.php',$r2,RETENG_ROOT.'data/cache_category/');
			if(!$r2)
			{
				$finalcat[]=$base;
				//$finalcatid[]=$base['id'];
			}
			if($setting['islist'])
			{
				$finalcatid[]=$base['id'];
			}
			
		}
		cache_write('catid.cache.php',$catid,RETENG_ROOT.'data/cache_category/');
		cache_write('cat_parent0.cache.php',$parent0,RETENG_ROOT.'data/cache_category/');
		cache_write('finalcat.cache.php',$finalcat,RETENG_ROOT.'data/cache_category/');
		cache_write('finalcatid.cache.php',$finalcatid,RETENG_ROOT.'data/cache_category/');
		cache_write('parent.cache.php',$parent,RETENG_ROOT.'data/cache_category/');
		return true;
	}

	function cache_module()
	{
		$r=$this->db->fetch_all("SELECT * FROM `".DB_PRE."module` ORDER BY `".DB_PRE."module`.`orderby` ASC");
		cache_write('module.cache.php',$r,RETENG_ROOT.'data/c/');
		if($r)foreach($r as $_r)
		{
			cache_write('module'.$_r['folder'].'.cache.php',$_r,RETENG_ROOT.'data/c/');
		}
		return true;
	}
}
?>