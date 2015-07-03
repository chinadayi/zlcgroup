<?php
/**
	* 更新缓存文件
*/

if(!class_exists('flink'))
{
	include dirname(__FILE__).'/flink.class.php';
	$flink=new flink();
}

if(in_array('link_cache',get_class_methods('flink')))
{
	$flink->link_cache();
}
?>
