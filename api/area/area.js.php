<?php
	require substr(dirname(__FILE__),0,-9).'/include/common.inc.php';
	
	if(ISCITY)
	{
		$areaid=get_cookie('areaid');
		if(!$areaid)
		{
			$areaid=CITY;
		}
		exit('document.writeln("[ <a href=\"api/area/index.php\" target=\"_blank\">'.get_selectmenu('area',$areaid).'</a> ]");');
	}
	else
	{
		exit('');
	}
?>