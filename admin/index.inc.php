<?php
/*
*版本所有：热腾CMS内容管理系统
*/
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if($action=='main')exit('<script language="javascript"  type="text/javascript">self.location.href="'.$RETENG['admin_file'].'?file=main&action=main"</script>');
	include admin_tlp('index');
?>