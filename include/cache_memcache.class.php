<?php
/**
* 数据缓存类
*/

class cache
{
	var $memcache;

    function __construct()
    {
		$this->memcache = new Memcache;
		$this->memcache->connect(MEMCACHE_HOST, MEMCACHE_PORT, MEMCACHE_TIMEOUT);
    }

    function cache()
    {
		$this->__construct();
    }

	function get($name)
    {
        return retengcms_stripslashes(string2array($this->memcache->get(md5($name))));
    }

    function set($name, $value, $ttl = 0)
    {
		$ttl=$ttl?$ttl:CACHE_TTL;
		$ttl=intval($ttl);
		$value=var_export(retengcms_addslashes($value),true);
        return $this->memcache->set(md5($name), $value, 0, $ttl);
    }

    function rm($name)
    {
        return $this->memcache->delete(md5($name));
    }

    function clear()
    {
        return $this->memcache->flush();
    }
}
?>