<?php
/*
	在线投票模板解析文件
	版本: v1.0
*/

function parse_vote_template($str)
{
	$str=preg_replace('/\{reteng:vote\s+([^\}]+)\}/ie',"retengcms_call_user_func('get_vote_tag','\\1')",$str);
	$str=preg_replace('/\{\/reteng:vote\}/i',"<?php }unset(\$_DATA); ?>",$str); 
	return $str;
}

function get_vote_tag($para)
{
	/*
		设置区块默认参数
	*/
	$args=array('row'=>'10','id'=>'0');
	foreach($para as $key => $arg)
	{
		if(isset($args[$key]))
		{
			$args[$key]=$arg;
		}
	}
	extract($args);
	$id=implode(',',array_map('intval',explode(',',$id)));
	if(!$id)
	{
		$sql="SELECT * FROM `\".DB_PRE.\"vote` WHERE `\".DB_PRE.\"vote`.`endtime` >=\".TIME.\" ORDER BY `\".DB_PRE.\"vote`.`id` DESC";
	}
	else
	{
		$sql="SELECT * FROM `\".DB_PRE.\"vote` WHERE `\".DB_PRE.\"vote`.`endtime` >=\".TIME.\" AND `\".DB_PRE.\"vote`.`id` IN ($id)";
	}
	return '<?php $_DATA=get_sql_tag_data("'.$sql.'",'.$row.');foreach($_DATA as $no => $r)if(is_array($r)){?>';
}

function vote_options($voteid)
{
	global $db;
	$data=$db->fetch_one("SELECT * FROM `".DB_PRE."vote` WHERE `".DB_PRE."vote`.`id`=$voteid");
	if(!$data)return false;
	$r=explode("\n",$data['votenote']);
	foreach($r as $key => $value)
	{
		if(!$value)
		{
			unset($r[$key]);
		}
		else
		{
			$r[$key]=vote_option($value,$data['totalcount'],$data['ismore']);
		}
	}
	$data['options']=$r;
	return $data;
}

function vote_option($option,$totalcount=100,$ismore=1)
{
	$data=array();
	preg_match('/<vote id="([0-9]+)" count="([0-9]+)">([^\<]+)<\/vote>/i',trim($option),$matches);
	$data['id']=$matches[1];
	if(!intval($ismore))
	{
		$data['form']='<input type="radio" value="'.$data['id'].'" name="voteitem" />';
	}
	else
	{
		$data['form']='<input type="checkbox" value="'.$data['id'].'" name="voteitem[]" />';
	}
	$data['count']=$matches[2];
	$data['name']=$matches[3];
	$data['per']=round($data['count']/$totalcount,2)*100;
	return $data;
}
?>
