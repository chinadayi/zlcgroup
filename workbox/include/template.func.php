<?php
/*
	外链工具箱模板解析文件
	版本: v1.0
*/

function parse_workbox_template($str)
{
	$str=preg_replace('/\{reteng:tools\s+([^\}]+)\}/ie',"retengcms_call_user_func('get_tools_tag','\\1')",$str);
	$str=preg_replace('/\{\/reteng:tools\}/i',"<?php }unset(\$_DATA); ?>",$str); 
	return $str;
}

function get_tools_tag($para)
{
	/*
		设置区块默认参数
	*/
	$args=array('boxid'=>'1',
				'row'=>'10');
	foreach($para as $key => $arg)
	{
		if(isset($args[$key]))
		{
			$args[$key]=$arg;
		}
	}
	extract($args);

	$sql="SELECT * FROM `\".DB_PRE.\"tools` WHERE `\".DB_PRE.\"tools`.`boxid`=$boxid ORDER BY `\".DB_PRE.\"tools`.`orderby` ASC";
	return '<?php $_DATA=get_sql_tag_data("'.$sql.'",'.$row.');foreach($_DATA as $no => $r)if(is_array($r)){?>';
}
?>
