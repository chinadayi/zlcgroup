<?php
/**
	* 更新会员缓存文件
*/

if(!class_exists('member'))
{
	include dirname(__FILE__).'/admin/member.class.php';
	$member=new member();
}

if(in_array('cache_member',get_class_methods('member')))
{
	$member->cache_member();
}
?>
