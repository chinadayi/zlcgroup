<?php
/**
	* 更新缓存文件
*/

if(!class_exists('ads'))
{
	include dirname(__FILE__).'/ads.class.php';
	$ads=new ads();
}

if(in_array('ads_cache',get_class_methods('ads')))
{
	$ads->ads_cache();
}
?>
