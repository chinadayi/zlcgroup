<?php
/**
	* 游客操作类
*/

class post
{
	function setting($config)
	{
		if(!is_array($config)) return false;
		$configfile = substr(dirname(__FILE__),0,-8).'/data/config.inc.php';
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
}
?>
