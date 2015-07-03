<?php
/**
* @插件管理类
*/

class plugins
{
	private $db;
	
	function __construct()
	{
		global $db;
		$this->db=$db;

		$plugin=$this->get_actived_plugins();

		if($plugin)
		{
			foreach($plugin as $name)
			{
				$name=preg_replace('/[^a-z0-9_]/i','',$name);
				if(file_exists(RETENG_ROOT.PLUGINS.'/'.$name.'/'.$name.'.php'))
				{
					include(RETENG_ROOT.PLUGINS.'/'.$name.'/'.$name.'.php');
				}
			}
		}
	}

	function plugins()
	{
		$this->__construct();
	}

	function get_all_plugins()
	{
		$result=$re=array();
		$r =cache_read("plugins.cache.php",RETENG_ROOT.'data/cache_plugins/');
		$all=glob(RETENG_ROOT.PLUGINS.'/*');
		$files=glob(RETENG_ROOT.PLUGINS.'/*.*');
		$re=array_diff($all,$files);

		if($re)
		{
			foreach($re as $_re)
			{
				$name=basename($_re);
				$result[$name]=isset($r[$name])?$r[$name]:'0';
			}
		}

		cache_write("plugins.cache.php",$result,RETENG_ROOT.'data/cache_plugins/');
		return $result;
	}

	function get_actived_plugins()
	{
		$result=array();
		$r =cache_read("plugins.cache.php",RETENG_ROOT.'data/cache_plugins/');
		if($r)
		{
			foreach($r as $name => $actived)
			{
				if($actived)$result[]=$name;
			}
		}
		return $result;
	}
	function get_plugins($plugin)
	{
		$r =cache_read("plugins.cache.php",RETENG_ROOT.'data/cache_plugins/');
		return $r[$plugin];
	}
	function active_plugins($plugin,$actived=1)
	{
		$plugin=preg_replace('/[^a-z0-9_]/i','',$plugin);
		$r =cache_read("plugins.cache.php",RETENG_ROOT.'data/cache_plugins/');
		if(array_key_exists($plugin,$r))
		{
			$r[$plugin]=intval($actived);

			return cache_write("plugins.cache.php",$r,RETENG_ROOT.'data/cache_plugins/');
		}
		return false;
	}

	function get_plugins_info($plugin)
	{
		$plugin=preg_replace('/[^a-z0-9_]/i','',$plugin);
		$info=array();
		if(file_exists(RETENG_ROOT.PLUGINS.'/'.$plugin.'/'.$plugin.'.php'))
		{
			$content=file_get_contents(RETENG_ROOT.'plugins/'.$plugin.'/'.$plugin.'.php');
			preg_match('/Plugins Name:([^\r\n]*)/',$content,$matches);
			$info['Plugins Name']=isset($matches[1])?$matches[1]:$plugin;

			preg_match('/Plugins Description:([^\r\n]*)/',$content,$matches);
			$info['Plugins Description']=isset($matches[1])?$matches[1]:'暂无简介';

			preg_match('/Plugins Author:([^\r\n]*)/',$content,$matches);
			$info['Plugins Author']=isset($matches[1])?$matches[1]:'佚名';

			preg_match('/Author Url:([^\r\n]*)/',$content,$matches);
			$info['Author Url']=isset($matches[1])?$matches[1]:SITE_URL;

			preg_match('/Plugins Version:([^\r\n]*)/',$content,$matches);
			$info['Plugins Version']=isset($matches[1])?$matches[1]:'不详';			
		}

		return $info;
	}

	function install_plugins($plugin)
	{
		$plugin=preg_replace('/[^a-z0-9_]/i','',$plugin);
		if(file_exists(RETENG_ROOT.PLUGINS.'/'.$plugin.'/'.$plugin.'.php'))
		{
			if(file_exists(RETENG_ROOT.PLUGINS.'/'.$plugin.'/'.'install.sql'))
			{
				$sqls=explode(';',trim(file_get_contents(RETENG_ROOT.PLUGINS.'/'.$plugin.'/'.'install.sql')));

				if($sqls)foreach($sqls as $sql)
				{
					if(trim($sql))
					{
						$this->db->query(trim(str_replace('retengcms_',DB_PRE,$sql)));
					}
				}
			}
			@rename(RETENG_ROOT.PLUGINS.'/'.$plugin.'/'.'install.sql',RETENG_ROOT.PLUGINS.'/'.$plugin.'/'.'installed.sql');
			return true;
		}
		return false;
	}

	function uninstall_plugins($plugin)
	{
		$plugin=preg_replace('/[^a-z0-9_]/i','',$plugin);
		if(file_exists(RETENG_ROOT.PLUGINS.'/'.$plugin.'/'.$plugin.'.php'))
		{
			if(file_exists(RETENG_ROOT.PLUGINS.'/'.$plugin.'/'.'uninstall.sql'))
			{
				$sqls=explode(';',trim(file_get_contents(RETENG_ROOT.PLUGINS.'/'.$plugin.'/'.'uninstall.sql')));

				if($sqls)foreach($sqls as $sql)
				{
					if(trim($sql))
					{
						$this->db->query(trim(str_replace('retengcms_',DB_PRE,$sql)));
					}
				}
			}
			if(strlen($plugin)>=1)
			{
				rmdirs(RETENG_ROOT.PLUGINS.'/'.$plugin.'/');
			}

			$r =cache_read("plugins.cache.php",RETENG_ROOT.'data/cache_plugins/');
			unset($r[$plugin]);
			return cache_write("plugins.cache.php",$r,RETENG_ROOT.'data/cache_plugins/');
		}
		return false;
	}
}
?>
