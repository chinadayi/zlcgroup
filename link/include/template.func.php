<?php
/*
	友情链接解析文件
	更新: 2012-03-09 14:24
	版本: v1.1
*/

function parse_link_template($str)
{
	$str=preg_replace('/\{reteng:flink\s+([^\}]+)\}/ie',"retengcms_call_user_func('get_flink_tag','\\1')",$str);
	$str=preg_replace('/\{\/reteng:flink\}/i',"<?php }unset(\$_DATA); ?>",$str); 
	return $str;
}

function get_flink_tag($para)
{
	/*
		设置区块默认参数
	*/
	$args=array('withlogo'=>'0',
				'row'=>'10',
				'isindex'=>'0',
				'where'=>'disabled=0',
				'typeid'=>'all');
	foreach($para as $key => $arg)
	{
		if(isset($args[$key]))
		{
			$args[$key]=$arg;
		}
	}
	extract($args);

	if($withlogo==0)  //所有链接
	{
		if($typeid=='all')
		{
			if(intval($isindex))
			{
				$sql="SELECT `\".DB_PRE.\"link`.`name`,`\".DB_PRE.\"link`.`url`,`\".DB_PRE.\"link`.`logo`,`\".DB_PRE.\"link`.`introduce` FROM `\".DB_PRE.\"link` WHERE `\".DB_PRE.\"link`.`siteid`=".intval(SITEID)." AND `\".DB_PRE.\"link`.`isindex`=".intval($isindex)." AND `\".DB_PRE.\"link`.`disabled`=0 ORDER BY `\".DB_PRE.\"link`.`orderby` ASC";
			}
			else
			{
				$sql="SELECT `\".DB_PRE.\"link`.`name`,`\".DB_PRE.\"link`.`url`,`\".DB_PRE.\"link`.`logo`,`\".DB_PRE.\"link`.`introduce` FROM `\".DB_PRE.\"link` WHERE `\".DB_PRE.\"link`.`siteid`=".intval(SITEID)." AND `\".DB_PRE.\"link`.`disabled`=0 ORDER BY `\".DB_PRE.\"link`.`orderby` ASC";
			}
		}
		else
		{
			if(intval($isindex))
			{
				$sql="SELECT `\".DB_PRE.\"link`.`name`,`\".DB_PRE.\"link`.`url`,`\".DB_PRE.\"link`.`logo`,`\".DB_PRE.\"link`.`introduce` FROM `\".DB_PRE.\"link` WHERE `\".DB_PRE.\"link`.`siteid`=".intval(SITEID)." AND `\".DB_PRE.\"link`.`isindex`=".intval($isindex)." AND `\".DB_PRE.\"link`.`disabled`=0 AND `\".DB_PRE.\"link`.`typeid`=\".intval(".$typeid.").\" ORDER BY `\".DB_PRE.\"link`.`orderby` ASC";
			}
			else
			{	
				$sql="SELECT `\".DB_PRE.\"link`.`name`,`\".DB_PRE.\"link`.`url`,`\".DB_PRE.\"link`.`logo`,`\".DB_PRE.\"link`.`introduce` FROM `\".DB_PRE.\"link` WHERE `\".DB_PRE.\"link`.`siteid`=".intval(SITEID)." AND `\".DB_PRE.\"link`.`disabled`=0 AND `\".DB_PRE.\"link`.`typeid`=\".intval(".$typeid.").\" ORDER BY `\".DB_PRE.\"link`.`orderby` ASC";
			}
		}
	}
	elseif($withlogo==1) //图片链接
	{
		if($typeid=='all')
		{
			if(intval($isindex))
			{
				$sql="SELECT `\".DB_PRE.\"link`.`name`,`\".DB_PRE.\"link`.`url`,`\".DB_PRE.\"link`.`logo`,`\".DB_PRE.\"link`.`introduce` FROM `\".DB_PRE.\"link` WHERE `\".DB_PRE.\"link`.`siteid`=".intval(SITEID)." AND `\".DB_PRE.\"link`.`isindex`=".intval($isindex)." AND `\".DB_PRE.\"link`.`disabled`=0 AND `\".DB_PRE.\"link`.`logo`!='' ORDER BY `\".DB_PRE.\"link`.`orderby` ASC";
			}
			else
			{
				$sql="SELECT `\".DB_PRE.\"link`.`name`,`\".DB_PRE.\"link`.`url`,`\".DB_PRE.\"link`.`logo`,`\".DB_PRE.\"link`.`introduce` FROM `\".DB_PRE.\"link` WHERE `\".DB_PRE.\"link`.`siteid`=".intval(SITEID)." AND `\".DB_PRE.\"link`.`disabled`=0 AND `\".DB_PRE.\"link`.`logo`!='' ORDER BY `\".DB_PRE.\"link`.`orderby` ASC";
			}
		}
		else
		{
			if(intval($isindex))
			{
				$sql="SELECT `\".DB_PRE.\"link`.`name`,`\".DB_PRE.\"link`.`url`,`\".DB_PRE.\"link`.`logo`,`\".DB_PRE.\"link`.`introduce` FROM `\".DB_PRE.\"link` WHERE `\".DB_PRE.\"link`.`siteid`=".intval(SITEID)." AND `\".DB_PRE.\"link`.`isindex`=".intval($isindex)." AND `\".DB_PRE.\"link`.`disabled`=0 AND `\".DB_PRE.\"link`.`logo`!='' AND `\".DB_PRE.\"link`.`typeid`=\".intval(".$typeid.").\" ORDER BY `\".DB_PRE.\"link`.`orderby` ASC";
			}
			else
			{
				$sql="SELECT `\".DB_PRE.\"link`.`name`,`\".DB_PRE.\"link`.`url`,`\".DB_PRE.\"link`.`logo`,`\".DB_PRE.\"link`.`introduce` FROM `\".DB_PRE.\"link` WHERE `\".DB_PRE.\"link`.`siteid`=".intval(SITEID)." AND `\".DB_PRE.\"link`.`disabled`=0 AND `\".DB_PRE.\"link`.`logo`!='' AND `\".DB_PRE.\"link`.`typeid`=\".intval(".$typeid.").\" ORDER BY `\".DB_PRE.\"link`.`orderby` ASC";
			}
		}
	}
	return '<?php $_DATA=get_sql_tag_data("'.$sql.'",'.$row.');foreach($_DATA as $no => $r)if(is_array($r)){?>';
}
?>
