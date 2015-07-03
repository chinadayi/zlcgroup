<?php
/*
	tag解析函数
	版本: v1.1
*/

function parse_tags_template($str)
{
	$str=preg_replace('/\{reteng:tags\s+([^\}]+)\}/ie',"retengcms_call_user_func('get_tags','\\1')",$str);
	$str=preg_replace('/\{\/reteng:tags\}/i',"<?php }unset(\$_DATA); ?>",$str); 
	return $str;
}

function get_tags($para)
{
	/*
		设置区块默认参数
	*/
	$args=array('row'=>'10',
				'tag'=>'',
				'orderby'=>'ID',
				'orderbyway'=>'DESC',
				'page'=>'0',
				'siteid'=>'all');
	foreach($para as $key => $arg)
	{
		if(isset($args[$key]))
		{
			$args[$key]=$arg;
		}
	}
	extract($args);
	$where="1=1";
	if($tag)
	{
		$where.=" and tag='$tag'";
	}
	if($siteid!="all")
	{
		$where=" and siteid=$siteid";
	}
	$order=" ORDER BY a.$orderby $orderbyway";
    //$sql="SELECT * FROM `\".DB_PRE.\"taglist` where tag='$tag' ORDER BY `\".DB_PRE.\"taglist`.`orderby` ASC";
	$sql="SELECT * FROM ".DB_PRE."content a ,".DB_PRE."taglist b WHERE a.id=b.contentid AND ".$where.$order;
	return '<?php $_DATA=get_sql_tag_data("'.$sql.'",'.$row.','.$page.');foreach($_DATA as $no => $r)if(is_array($r)){ ?>';
}
?>
