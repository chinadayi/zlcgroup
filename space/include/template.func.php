<?php
/*
	个人空间模板解析文件
	版本: v1.0
*/

function parse_space_template($str)
{
	$str=preg_replace('/\{reteng:space_guestbook\s+([^\}]+)\}/ie',"retengcms_call_user_func('get_space_guestbook_tag','\\1')",$str);
	$str=preg_replace('/\{\/reteng:space_guestbook\}/i',"<?php }\$reteng_page=\$_DATA['pagestring'];unset(\$_DATA); ?>",$str); 

	$str=preg_replace('/\{reteng:space\s+([^\}]+)\}/ie',"retengcms_call_user_func('get_space_tag','\\1')",$str);
	$str=preg_replace('/\{\/reteng:space\}/i',"<?php }\$reteng_page=\$_DATA['pagestring'];unset(\$_DATA); ?>",$str); 
	return $str;
}

function get_space_guestbook_tag($para)
{
	/*
		设置区块默认参数
	*/
	$args=array('spaceid'=>'0',
				'row'=>'10',
				'page'=>'0');
	foreach($para as $key => $arg)
	{
		if(isset($args[$key]))
		{
			$args[$key]=$arg;
		}
	}
	extract($args);

	if($spaceid)
	{
		$sql='SELECT * FROM `".DB_PRE."space_comment` WHERE `".DB_PRE."space_comment`.`status`=1 AND `".DB_PRE."space_comment`.`userid`=".intval('.$spaceid.')." ORDER BY `".DB_PRE."space_comment`.`id` DESC';	
	}
	else
	{
		$sql="SELECT * FROM `\".DB_PRE.\"space_comment` WHERE `\".DB_PRE.\"space_comment`.`status`=1 ORDER BY `\".DB_PRE.\"space_comment`.`id` DESC";
	}

	return '<?php $reteng_page="";$_DATA=get_sql_tag_data("'.$sql.'",'.$row.','.$page.');foreach($_DATA as $no => $r)if(is_array($r)){?>';
}

function get_space_tag($para)
{
	/*
		设置区块默认参数
	*/
	$args=array('isindex'=>'0',
				'row'=>'10',
				'page'=>'0');
	foreach($para as $key => $arg)
	{
		if(isset($args[$key]))
		{
			$args[$key]=$arg;
		}
	}
	extract($args);

	if($isindex)
	{
		$sql='SELECT * FROM `".DB_PRE."space` WHERE `".DB_PRE."space`.`index`=1 AND `".DB_PRE."space`.`lock`=0 ORDER BY `".DB_PRE."space`.`id` DESC';
	}
	else
	{
		$sql='SELECT * FROM `".DB_PRE."space` WHERE `".DB_PRE."space`.`lock`=0 ORDER BY `".DB_PRE."space`.`id` DESC';
	}
	return '<?php $reteng_page="";$_DATA=get_sql_tag_data("'.$sql.'",'.$row.','.$page.');foreach($_DATA as $no => $r)if(is_array($r)){?>';
}
?>
