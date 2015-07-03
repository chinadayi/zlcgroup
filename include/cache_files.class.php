<?php
/**
* 数据缓存类
*/

class cache
{
	private $file_path;

    function __construct()
    {
		$this->file_path=CACHE_PATH;
		if(!is_writeable($this->file_path))exit('缓存目录不可写!');
    }

    function cache()
    {
		$this->__construct();
    }

	function get($name)
    {
		$cache_file=CACHE_PATH.md5($name).'.cache.php';
        if(file_exists($cache_file) && (TIME-filemtime($cache_file) < CACHE_TTL))
		{
			return string2array(file_get_contents($cache_file));
		}
		return '';
    }

    function set($name, $value, $ttl = 0)
    {
		$ttl=$ttl?$ttl:CACHE_TTL;
		$ttl=intval($ttl);
		$cache_file=CACHE_PATH.md5($name).'.cache.php';
		$value=var_export($value,true);
		if($ttl)
		{
			file_put_contents($cache_file,$value);
		}
		return true;
    }

    function rm($name)
    {
		$cache_file=CACHE_PATH.md5($name).'.cache.php';
        return @unlink($cache_file);
    }

    function clear()
    {
        foreach (glob(CACHE_PATH.'*.php') as $cache_file) 
		{
			@unlink($cache_file);
		}
    }
}
?>