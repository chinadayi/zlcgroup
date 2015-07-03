<?php
/**
	* 模块管理类
*/
@ini_set("memory_limit","-1"); // 去除内存限制
include RETENG_ROOT.'include/pclzip.lib.php';
class module
{
	public $pagestring='';
	private $db;
	private $lang;
	private $table;
	private $category_table;
	
	function __construct()
	{
		global $db,$lang;
		$this->db=$db;
		$this->lang=$lang;
		$this->table=DB_PRE.'module';
		$this->category_table=DB_PRE.'category';
	}
	
	function module()
	{
		$this->__construct();
	}

	function datalist()
	{
		global $page;
		include RETENG_ROOT.'include/datalist.class.php';
		$datalist = new datalist();
		$where=1;
		$orderby='orderby ASC';
		$page=max(isset($page)?intval($page):1,1);
		$pagesize=15;
		$result=$datalist->getlist($this->table,$where,$orderby,$page,$pagesize);
		$this->pagestring=$datalist->pagestring;
		return $result;
	}

	function disabled($ids,$disabled=1)
	{
		global $c;
		$ids=is_array($ids)?array_map('intval',$ids):array(intval($ids));

		if(!$ids)return false;
		foreach($ids as $id)
		{
			$moduleinfo=$this->get($id,'*','id');
			$this->db->update($this->table,array('disabled'=>intval($disabled)),'id='.$id);
			
			if($disabled && $moduleinfo['folder'])
			{
				$this->db->query("DELETE FROM `$this->category_table` WHERE `$this->category_table`.`catdir`='".$moduleinfo['folder']."'");
			}
			else
			{
				/*
					更新栏目表
				*/
				
				$cat=array();

				$cat['modelid']=0;
				$cat['parentid']=0;
				$cat['type']=3;
				$cat['catname']=$moduleinfo['name'];
				$cat['catdir']=$moduleinfo['folder'];
				$cat['url']=$moduleinfo['menu']?$moduleinfo['folder'].'/':'';
				$cat['orderby']=$id;
				$cat['ispost']=0;
				$cat['ismenu']=$moduleinfo['menu'];
				$cat['m']=1;
				$this->db->insert($this->category_table,$cat,true);
				unset($cat);
			}
		}
		$c->cache_module();
		$c->cache_category();
		return true;
	}

	function adminmenu($ids,$adminmenu=1)
	{
		global $c;
		$ids=is_array($ids)?array_map('intval',$ids):array(intval($ids));
		if(!$ids)return false;
		foreach($ids as $id)
		{
			$this->db->update($this->table,array('adminmenu'=>intval($adminmenu)),'id='.$id);
		}
		$c->cache_module();
		return true;
	}

	function delete($ids)
	{
		global $c;
		$ids=is_array($ids)?array_map('intval',$ids):array(intval($ids));

		if(!$ids)return false;
		foreach($ids as $id)
		{
			$r=$this->get($id,'folder','id');
			if($r && !empty($r['folder']))
			{
				/*
					执行卸载SQL语句
				*/

				$uninstallfile=RETENG_ROOT.$r['folder'].'/uninstall.sql';
				$uninstallsql=trim(file_get_contents($uninstallfile));
				if(file_exists($uninstallfile) && $uninstallsql)
				{
					$sqls=explode(";",$uninstallsql);
					if($sqls)foreach($sqls as $sql)
					{
						if(!empty($sql))$this->db->query(str_replace('retengcms_',DB_PRE,trim($sql)));
					}
				}
				rmdirs(RETENG_ROOT.$r['folder']);
				if(file_exists(TPL_ROOT.TPL_NAME.'/'.$r['folder']) && preg_match('/^[a-z0-9_]{1,}$/i',$r['folder']))
				{
					rmdirs(TPL_ROOT.TPL_NAME.'/'.$r['folder']);
				}
			}
			$this->db->mysql_delete($this->table,$id);
			$this->db->query("DELETE FROM `$this->category_table` WHERE `$this->category_table`.`catdir`='".$r['folder']."' AND `$this->category_table`.`type`=3");
		}
		$c->cache_all();
		return true;
	}

	function export($id)
	{
		$id=intval($id);

		/*
			获取模块信息
		*/

		$modinfo=$this->get($id,'*','id');
		$modpath=$modinfo['folder'].'/';
		$zipfile=RETENG_ROOT.'data/tmp/'.$modinfo['name'].'.zip';
		
		/*
			获取模块信息并写入文件
		*/
		$infos=$this->get($id,'*','id');
		unset($infos['id']);
		cache_write('module.cache.php',$infos,RETENG_ROOT.$modinfo['folder'].'/');

		/*
			导出数据库安装、卸载文件
		*/
		$installsql='';
		$uninstallsql='';

		if(!empty($infos['tables']))
		{
			$tables=explode(',',trim($infos['tables']));
			if($tables)foreach($tables as $table)
			{
				if(!empty($table))
				{
					$r=$this->db->fetch_one("SHOW CREATE TABLE `{$table}`");
					$installsql.="DROP TABLE IF EXISTS `".str_replace(DB_PRE,'retengcms_',$table)."`;\n";
					$installsql.=str_replace(DB_PRE,'retengcms_',$r['Create Table']).";\n";
					$uninstallsql.="DROP TABLE IF EXISTS `".str_replace(DB_PRE,'retengcms_',$table)."`;\n";
				}
			}
		}
		@file_put_contents(RETENG_ROOT.$infos['folder'].'/install.sql',$installsql);
		@file_put_contents(RETENG_ROOT.$infos['folder'].'/uninstall.sql',$uninstallsql);
		/*
			导出模块为压缩文件
		*/
		$archive = new PclZip($zipfile);
		$result = $archive->create(implode(',',glob($modpath.'*')).','.implode(',',glob('template/'.TLP_NAME.'/'.$infos['folder'])),PCLZIP_OPT_ADD_TEMP_FILE_ON);
        if (!$result) 
		{
			return false;
        }
		else
		{
			/*
				提供下载
			*/
			if(ob_get_length() !== false) @ob_end_clean();
			header('Pragma: public');
			header('Last-Modified: '.gmdate('D, d M Y H:i:s') . ' GMT');
			header('Cache-Control: no-store, no-cache, must-revalidate');
			header('Cache-Control: pre-check=0, post-check=0, max-age=0');
			header('Content-Transfer-Encoding: binary');
			header('Content-Encoding: none');
			header('Content-type: application/x-zip');
			header('Content-Disposition: attachment; filename="'.$modinfo['folder'].'.zip"');
			header('Content-length: '.filesize($zipfile));
			readfile($zipfile);
			@unlink($zipfile);
			exit();
		}
	}

	function install($info=array())
	{
		global $c;
		if(!$info || !is_array($info))return false;

		/*
			检查模块文件夹并建立
		*/
		if(!file_exists(RETENG_ROOT.$info['folder']))
		{
			@mkdir(RETENG_ROOT.$info['folder'],0777);
		}

		$info['tables']=trim($info['tables']);

		/*
			插入并更新模块数据表
		*/
		$info['roleid']=implode(',',$info['roleid']);
		if(isset($info['modelid']))$info['modelid']=implode(',',$info['modelid']);
		$insertid=$this->db->insert($this->table,$info);
		$this->db->update($this->table,array('orderby'=>$insertid),'id='.$insertid);
		
		/*
			更新栏目表
		*/
		
		$cat=array();

		$cat['modelid']=0;
		$cat['parentid']=0;
		$cat['type']=3;
		$cat['catname']=$info['name'];
		$cat['catdir']=$info['folder'];
		$cat['url']=$info['menu']?$info['folder'].'/':'';
		$cat['orderby']=$insertid;
		$cat['ispost']=0;
		$cat['ismenu']=$info['menu'];
		$cat['m']=1;
		$this->db->insert($this->category_table,$cat);
		unset($cat);

		/*
			获取模块信息并写入文件
		*/
		$infos=$this->get($insertid,'*','id');
		unset($infos['id']);
		cache_write('module.cache.php',$infos,RETENG_ROOT.$info['folder'].'/');
		
		/*
			更新缓存
		*/
		$c->cache_module();
		$c->cache_category();
		return true;
	}

	function set($info,$id)
	{
		global $c;
		if(!$info || !is_array($info))return false;
		
		$id=intval($id);
		/*
			插入并更新模块数据表
		*/
		$info['roleid']=implode(',',$info['roleid']);
		if(isset($info['modelid']))$info['modelid']=implode(',',$info['modelid']);
		$this->db->update($this->table,$info,'id='.$id);

		/*
			获取模块信息并写入文件
		*/
		$infos=$this->get($id,'*','id');
		unset($infos['id']);
		cache_write('module.cache.php',$infos,RETENG_ROOT.$infos['folder'].'/');
		
		/*
			更新缓存
		*/
		$c->cache_module();
		$c->cache_category();
		return true;
	}

	function installimport($zipname,$fpath="../")
	{
		global $c;
		$zipfile='module/'.$zipname.'.zip';
		$archive = new PclZip($zipfile);
		$archive->extract(PCLZIP_OPT_PATH, $fpath);
		$modpath=RETENG_ROOT.$zipname.'/';
		if(!file_exists($modpath.'module.cache.php') || filesize($modpath.'module.cache.php')==0)return false;
		$info=cache_read('module.cache.php',$modpath);
		$insertid=$this->db->insert($this->table,$info,true);
		//导入栏目表
		$cat=array();
		$cat['modelid']=0;
		$cat['parentid']=0;
		$cat['type']=3;
		$cat['catname']=$info['name'];
		$cat['catdir']=$info['folder'];
		$cat['url']=$info['menu']?$info['folder'].'/':'';
		$cat['orderby']=$insertid;
		$cat['ispost']=0;
		$cat['ismenu']=$info['menu'];
		$cat['m']=1;
		$this->db->insert($this->category_table,$cat);
		unset($cat);
		
		/*
			找寻安装SQL并执行
		*/
		
		if(file_exists($modpath.'install.sql') && filesize($modpath.'install.sql')>0)
		{
			$sqlfile=trim(file_get_contents($modpath.'install.sql'));
			$installsqls=explode(';',$sqlfile);
			if($installsqls && $sqlfile)foreach($installsqls as $sql)
			{
				if(!empty($sql))$this->db->query(str_replace('retengcms_',DB_PRE,$sql),true);
			}
		}

		/*
			更新模块缓存 更新栏目缓存
		*/
		//$c->cache_module();
		//$c->cache_category();
		return true;

	}
	function import()
	{
		global $upload,$c;

		if($this->module_installed(basename($_FILES['file']['name'],'.zip')))
		{
			return true;
		}

		/*
			上传ZIP压缩文件
		*/
		$zipfile=$upload->uploadfile('file', 'data/tmp/',$_FILES['file']['name'], array('zip'), 20480000);
		$zipfile='data/tmp/'.$zipfile;

		/*
			检查并解压Zip文档
		*/
		if(!file_exists($zipfile) || filesize($zipfile)==0)
		{
			return false;
		}
		$archive = new PclZip($zipfile);

		if($archive->extract(PCLZIP_OPT_ADD_TEMP_FILE_ON) == 0)
		{
			return false;
        }
		else
		{
			@unlink($zipfile);
		}

		$modpath=RETENG_ROOT.basename($_FILES['file']['name'],'.zip').'/';

		if(!file_exists($modpath)) 
		{
			return false;
		}

		/*
			导入模块表
		*/
		if(!file_exists($modpath.'module.cache.php') || filesize($modpath.'module.cache.php')==0)return false;
		$info=cache_read('module.cache.php',$modpath);

		$insertid=$this->db->insert($this->table,$info,true);

		/*
			导入栏目表
		*/
		$cat=array();

		$cat['modelid']=0;
		$cat['parentid']=0;
		$cat['type']=3;
		$cat['catname']=$info['name'];
		$cat['catdir']=$info['folder'];
		$cat['url']=$info['menu']?$info['folder'].'/':'';
		$cat['orderby']=$insertid;
		$cat['ispost']=0;
		$cat['ismenu']=$info['menu'];
		$cat['m']=1;
		$this->db->insert($this->category_table,$cat);
		unset($cat);
		
		/*
			找寻安装SQL并执行
		*/
		
		if(file_exists($modpath.'install.sql') && filesize($modpath.'install.sql')>0)
		{
			$sqlfile=trim(file_get_contents($modpath.'install.sql'));
			$installsqls=explode(';',$sqlfile);
			if($installsqls && $sqlfile)foreach($installsqls as $sql)
			{
				if(!empty($sql))$this->db->query(str_replace('retengcms_',DB_PRE,$sql),true);
			}
		}

		/*
			更新模块缓存 更新栏目缓存
		*/
		$c->cache_module();
		$c->cache_category();
		return true;
	}

	function setorderby($orderby=array())
	{
		global $c;
		if(!$orderby) return false;

		foreach($orderby as $id => $_orderby)
		{
			$this->db->update($this->table,array('orderby'=>intval($_orderby)),'id='.intval($id));
		}
		$c->cache_module();
		return true;
	}
	
	function module_installed($module)
	{
		$r=cache_read('module'.$module.'.cache.php',RETENG_ROOT.'data/c/');
		return $r && $module?true:false;
	}

	function module_disabled($module)
	{
		if(!$this->module_installed($module))return true;
		$r=cache_read('module'.$module.'.cache.php',RETENG_ROOT.'data/c/');
		return $r['disabled']?true:false;
	}

	function module_list($all=true)
	{
		$r=cache_read('module.cache.php',RETENG_ROOT.'data/c/');
		if(!$all)
		{
			if($r)foreach($r as $k => $_r)
			{
				if($this->module_disabled($_r['folder']))
				{
					unset($r[$k]);
				}
			}
		}
		return $r;
	}

	function get_setting($module)
	{	
		$r=$this->get($module,'setting');
		return string2array($r['setting']);
	}

	function get_menu($module,$type='admin')
	{
		$field=$type=='admin'?'menu_admin':'menu_member';
		$r=$this->get($module,$field);
		return $r && $r[$field] ?explode("\r\n",$r[$field]):array();
	}

	function get_version($module)
	{	
		$r=$this->get($module,'version');
		return $r['version'];
	}

	function roleid_check($module,$roleid)
	{
		global $_userid;
		$r=cache_read('module'.$module.'.cache.php',RETENG_ROOT.'data/c/');
		$r=explode(',',$r['roleid']); 
		return (in_array($roleid,$r) || $_userid == ADMIN_FOUNDERS)?true:false;
	}

	function get($value,$fields='*',$byfield='folder')
	{
		if($byfield=='folder' && !$this->module_installed($value))
		{
			exit($this->lang['MODULE_DISABLED']);
		}
		return $this->db->fetch_one("SELECT $fields FROM `$this->table` WHERE `$this->table`.`{$byfield}`='{$value}'");
	}
}
?>