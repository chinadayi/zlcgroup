<?php
/**
	* 模板引擎
	* @author reteng
*/
error_reporting (E_ALL & ~E_NOTICE & ~E_WARNING);
set_time_limit(0);

function template_complie($tlpname,$project='',$module='dc',$folder='')
{
	$project=$project && file_exists(TPL_ROOT.$project)?$project:TPL_NAME;
	$module=str_replace(array('//','/'),array('/',''),$module);
	$module=$module==''?'':$module.'/';
	$folder=trim($folder)?trim($folder).'/':'';
	$tlpfile=TPL_ROOT.$project.'/'.$module.$folder.$tlpname.'.htm';
	!file_exists($tlpfile) && show404('模板文件template/'.$project.'/'.$module.$folder.$tlpname.'.htm不存在!');
	$content=file_get_contents($tlpfile);

	if(!file_exists(TPL_CACHEPATH.$project))
	{
		@mkdir(TPL_CACHEPATH.$project,0777);
	}
	if(!file_exists(TPL_CACHEPATH.$project.'/'.$module))
	{
		@mkdir(TPL_CACHEPATH.$project.'/'.$module,0777);
	}
	if(!file_exists(TPL_CACHEPATH.$project.'/'.$module.$folder))
	{
		@mkdir(TPL_CACHEPATH.$project.'/'.$module.$folder,0777);
	}

	$compliedfile=TPL_CACHEPATH.$project.'/'.$module.$folder.$tlpname.'.tlp.php';
	$content=template_parse($content);

	$strlen=@file_put_contents($compliedfile,$content);
	@chmod($compliedfile,0777);
	return $strlen;
}

function template_parse($str) //解析模板
{
	global $_roleid,$module;
	$str=preg_replace('/\{tlp\s+(.+)\}/i','<?php include template(\'\\1\');?>',$str);
	$str=preg_replace('/\{include\s+(.+)\}/i','<?php include(\\1);?>',$str);
	$str=preg_replace('/\{field:([0-9a-z_]+)\}/i','<?php echo $r[\'\\1\'];?>',$str);
	$str=preg_replace('/field:([0-9a-z_]+)/i','$r[\'\\1\']',$str);
	$str=preg_replace('/\{js:([0-9a-z_]+)\}/i','<script language=javascript>document.write(js_\\1);</script>',$str);
	$str=preg_replace('/\{retengcms\s+(.+)\}/','<?php \\1?>',$str);
	$str=preg_replace('/\{(\$[a-z0-9_\+\'\"\[\]\x7f-\xff\$]+)\}/i','<?php echo \\1;?>',$str);
	$str=preg_replace('/\{if\s+([^\}]+)\}/i','<?php if(\\1) { ?>',$str);
	$str=preg_replace('/\{else\s*if\s+([^\}]+)\}/i','<?php }elseif(\\1){ ?>',$str);
	$str=preg_replace('/\{else\}/i','<?php }else{ ?>',$str);
	$str=preg_replace('/\{end\s*if\}/i','<?php }?>',$str);
	$str=preg_replace('/\{\/if\}/i','<?php }?>',$str);
	$str=preg_replace('/\{loop\s+(\S+)\s+(\S+)\}/i','<?php $no=1;if(is_array(\\1))foreach(\\1 as \\2){?>',$str);
	$str=preg_replace('/\{loop\s+(\S+)\s+(\S+)\s+(\S+)\}/i','<?php $no=1;if(is_array(\\1))foreach(\\1 as \\2=>\\3){?>',$str);
	$str=preg_replace('/\{end\s*loop\}/i','<?php $no++;}?>',$str);
	$str=preg_replace('/\{\/loop\}/i','<?php $no++;}?>',$str);
	$str=preg_replace('/\{([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff:]*\(([^{}]*)\))\}/','<?php echo \\1;?>',$str);
	//2013.12.11新增for标记
	$str=preg_replace('/\{for\s+([^\}]+)\}/i','<?php for(\\1) { ?>',$str);
	$str=preg_replace('/\{\/for\}/i','<?php }?>',$str);
	
	//栏目标记
	$str=preg_replace('/\{reteng:category\s+([^\}]+)\}/ie',"retengcms_call_user_func('get_category_tag','\\1')",$str);
	$str=preg_replace('/\{\/reteng:category\}/i',"<?php } \$catid=isset(\$loopcatid)?\$reteng_catid:0;unset(\$_DATA);?>",$str);
	//内容标记
	$str=preg_replace('/\{reteng:content\s+([^\}]+)\}/ie',"retengcms_call_user_func('get_tag','\\1')",$str);
	$str=preg_replace('/\{\/reteng:content\}/i',"<?php }unset(\$_DATA); ?>",$str);
	//栏目列表标记
	$str=preg_replace('/\{reteng:list\s+([^\}]+)\}/ie',"retengcms_call_user_func('get_list_tag','\\1')",$str);
	$str=preg_replace('/\{\/reteng:list\}/i',"<?php } \$reteng_page=\$_DATA['pagestring'];\$retengcount=\$_DATA['count'];\$retengpagecount=\$_DATA['pagecount'];unset(\$_DATA); ?>",$str);
	//万能标记
	$str=preg_replace('/\{table:([0-9a-z_\.]+)\s+([^\}]+)\}/ie',"retengcms_call_user_func('get_table_tag','table=\"\\1\" \\2','')",$str);
	$str=preg_replace('/\{\/table:([0-9a-z_\.]+)\}/i',"<?php } \$retengcount=\$_DATA['count'];\$retengpagecount=\$_DATA['pagecount'];unset(\$_DATA); ?>",$str);
	$str=preg_replace('/\{\/table\}/i',"<?php } \$retengcount=\$_DATA['count'];\$retengpagecount=\$_DATA['pagecount']; unset(\$_DATA); ?>",$str);
	//SQL标记
	$str=preg_replace('/\{reteng:sql sql=\"([^\"]+)\"\s+dbhost=\"([a-z0-9_\.]*)\"\s+dbuser=\"([a-z0-9_]*)\"\s+dbpwd=\"([^\"]*)\"\s+dbname=\"([a-z0-9_]*)\"\s+charset=\"([a-z0-9\-]*)\"\\}/i',"<?php \$_DATA=get_diy_sql_tag('\\1','\\2','\\3','\\4','\\5','\\6');foreach(\$_DATA as \$no => \$r)if(is_array(\$r)){?>",$str);
	$str=preg_replace('/\{\/reteng:sql\}/i',"<?php }unset(\$_DATA); ?>",$str);
	//评论
	$str=preg_replace('/\{reteng:comment\s+([^\}]+)\}/ie',"retengcms_call_user_func('get_comment_tag','\\1')",$str);
	$str=preg_replace('/\{\/reteng:comment\}/i',"<?php }\$reteng_page=\$_DATA['pagestring'];unset(\$_DATA); ?>",$str);
    //钩子
	$str=preg_replace('/\{hook:([0-9a-z_]+)\}/ie',"do_hook('\\1')",$str);
	$str=preg_replace('/\{hook:([0-9a-z_]+)\s+args:([a-z0-9_\,\$]+)\}/ie',"do_hook('\\1','\\2')",$str);
	//列表分页
	$str=preg_replace('/\{reteng:pagelist\s+listsize=[\'\"]?([0-9]+)[\'\"]?\}/i',"<?php \$_DATA=listpage(\$catid,\\1,\$page);@extract(\$_DATA); ?>",$str);
	$str=preg_replace('/\{\/reteng:pagelist\}/i',"<?php unset(\$_DATA); ?>",$str);
    //导入模块模板解析文件
	if($module && is_object($module))
	{
		$modlist=$module->module_list(false);
		if($modlist)foreach($modlist as $mod)
		{
			if(function_exists('parse_'.$mod['folder'].'_template'))
			{
				$str=call_user_func('parse_'.$mod['folder'].'_template',$str);
			}
		}
	}
	return $str;
}
//-----------------------------------------------------------上一页
function getpre($id,$catid=0,$len=20,$thumb=false)
{
	global $db,$baselang;
	$id=intval($id);
	$catid=intval($catid);
	if(!$thumb)
	{
		if($catid)
		{
			$r=$db->fetch_one("SELECT `".DB_PRE."content`.`url`,`".DB_PRE."content`.`title` FROM `".DB_PRE."content` WHERE `".DB_PRE."content`.`id`<$id AND `".DB_PRE."content`.`catid`=$catid ORDER BY id DESC LIMIT 0,1");
		}
		else
		{
			$r=$db->fetch_one("SELECT `".DB_PRE."content`.`url`,`".DB_PRE."content`.`title` FROM `".DB_PRE."content` WHERE `".DB_PRE."content`.`id`<$id ORDER BY id DESC LIMIT 0,1");
		}
		return $r?'<a href="'.$r['url'].'" title="'.$r['title'].'">'.sub_string($r['title'],$len).'</a>':$baselang['content-none'];
	}
	else
	{
		if($catid)
		{
			$r=$db->fetch_one("SELECT `".DB_PRE."content`.`url`,`".DB_PRE."content`.`title`,`".DB_PRE."content`.`thumb` FROM `".DB_PRE."content` WHERE `".DB_PRE."content`.`thumb` !='' AND `".DB_PRE."content`.`id`<$id AND `".DB_PRE."content`.`catid`=$catid ORDER BY id DESC LIMIT 0,1");
		}
		else
		{
			$r=$db->fetch_one("SELECT `".DB_PRE."content`.`url`,`".DB_PRE."content`.`title`,`".DB_PRE."content`.`thumb` FROM `".DB_PRE."content` WHERE `".DB_PRE."content`.`thumb` !='' AND `".DB_PRE."content`.`id`<$id ORDER BY id DESC LIMIT 0,1");
		}
		return $r?'<a href="'.$r['url'].'" title="'.$r['title'].'"><img src="'.$r['thumb'].'" /></a>':$baselang['content-none'];
	}
}

//-----------------------------------------------------------------下一页
function getnext($id,$catid=0,$len=20,$thumb=false)
{
	global $db,$baselang;
	$id=intval($id);
	$catid=intval($catid);
	if(!$thumb)
	{
		if($catid)
		{
			$r=$db->fetch_one("SELECT `".DB_PRE."content`.`url`,`".DB_PRE."content`.`title` FROM `".DB_PRE."content` WHERE `".DB_PRE."content`.`id`>$id AND `".DB_PRE."content`.`catid`=$catid ORDER BY id ASC LIMIT 0,1");
		}
		else
		{
			$r=$db->fetch_one("SELECT `".DB_PRE."content`.`url`,`".DB_PRE."content`.`title` FROM `".DB_PRE."content` WHERE `".DB_PRE."content`.`id`>$id ORDER BY id ASC LIMIT 0,1");
		}
		return $r?'<a href="'.$r['url'].'" title="'.$r['title'].'">'.sub_string($r['title'],$len).'</a>':$baselang['content-none'];
	}
	else
	{
		if($catid)
		{
			$r=$db->fetch_one("SELECT `".DB_PRE."content`.`url`,`".DB_PRE."content`.`title`,`".DB_PRE."content`.`thumb` FROM `".DB_PRE."content` WHERE `".DB_PRE."content`.`thumb` !='' AND `".DB_PRE."content`.`id`>$id AND `".DB_PRE."content`.`catid`=$catid ORDER BY id ASC LIMIT 0,1");
		}
		else
		{
			$r=$db->fetch_one("SELECT `".DB_PRE."content`.`url`,`".DB_PRE."content`.`title`,`".DB_PRE."content`.`thumb` FROM `".DB_PRE."content` WHERE `".DB_PRE."content`.`thumb` !='' AND `".DB_PRE."content`.`id`>$id ORDER BY id ASC LIMIT 0,1");
		}
		return $r?'<a href="'.$r['url'].'" title="'.$r['title'].'"><img src="'.$r['thumb'].'" /></a>':$baselang['content-none'];
	}
}

function get_diy_sql_tag($sql='',$dbhost='',$dbuser='',$dbpwd='',$dbname='',$charset='utf8',$iscache=true)
{
	global $cache ,$db;

	$data=array();
	if($iscache)
	{
		$data=$cache->get($sql);
	}

	if(!$data)
	{
		if(!$dbhost || !$dbuser  || !$dbname)
		{
			
			$data=$db->fetch_all($sql);
		}
		else
		{

			if($db->connect($dbhost,$dbuser,$dbpwd,$dbname,DB_PCONNECT,$charset))
			{
				$data=$db->fetch_all($sql);
				$db->close();
			}
		}
	}
	$db->connect(DB_HOST,DB_USER,DB_PSW,DB_NAME,DB_PCONNECT,DB_CHARSET);
	return $data;
}

function get_sql_tag_data($sql='',$row=10,$page=0,$iscache=false,$dbtype='mysql',$dbhost='',$dbuser='',$dbpwd='',$dbname='')
{
	global $db,$reteng_page,$cache,$newdb;
	$offset=0;
	$row=intval($row)?intval($row):1;
	if($page)$page=max(intval($page),1);

	if($page)
	{
		$row=intval($row)>0?intval($row):PAGESIZE;
		$count_sql=preg_replace("/^SELECT([^(]+)\s*FROM(.+)(ORDER BY.+)$/i", "SELECT COUNT(*) AS `count` FROM\\2", $sql);
		$count=get_cache_counts($count_sql);
		$pagecount=max(ceil($count/$row),1);
		$page=$page>$pagecount?$pagecount:$page;
		$offset=($page-1)*$row;
		$reteng_page=getpages($count,$page,$row,0,'center',0);
	}
	$sql.=' LIMIT '.$offset.','.$row;
	if($page || !$iscache)
	{
		if($dbtype=='mysql' && (!$dbhost || !$dbuser  || !$dbname))
		{
			$data=$db->fetch_all($sql);
		}
		else
		{
			if(!$newdb)
			{
				if($dbtype!='mysql')
				{
					include(RETENG_ROOT.'include/'.$dbtype.'.class.php');
				}
				$newdb=new $dbtype();
			}
			if($newdb->connect($dbhost,$dbuser,$dbpwd,$dbname,0,DB_CHARSET))
			{
				if($data=$newdb->fetch_all($sql))
				{
					$newdb->close();
				}
			}
		}
	}
	else
	{
		$data=$cache->get($sql);
		if(!$data)
		{
			if($dbtype=='mysql' && (!$dbhost || !$dbuser || !$dbpwd || !$dbname))
			{
				$data=$db->fetch_all($sql);
			}
			else
			{
				if(!$newdb)
				{
					if($dbtype!='mysql')
					{
						include(RETENG_ROOT.'include/'.$dbtype.'.class.php');
					}
					$newdb=new $dbtype();
				}
				if($newdb->connect($dbhost,$dbuser,$dbpwd,$dbname,0,DB_CHARSET))
				{
					if($data=$newdb->fetch_all($sql))
					{
						$newdb->close();
					}
				}
			}

			if($data)
			{
				$cache->set($sql,$data);
			}
		}
	}
	$data['pagestring']=$reteng_page;
	$data['count']=$count;
	$data['pagecount']=$pagecount;
	return $data;
}

//---------------------------------------------万能标记
function get_table_tag($para)
{
	$args=array('table'=>'content',
				'row'=>'10',
				'orderby'=>'id',
				'orderbyway'=>'desc',
				'dbtype'=>'mysql',
				'dbhost'=>'',
				'dbuser'=>'',
				'dbpwd'=>'',
				'dbname'=>'',
				'where'=>'1=1',
				'page'=>'0',
				'fields'=>'*');
	foreach($para as $key => $arg)
	{
		if(isset($args[$key]))
		{
			$args[$key]=$arg;
		}
	}
	extract($args);

	$row=$row?$row:10;
	//$orderby=$orderby.' '.$orderbyway;
	//$table=$table?str_replace('retengcms_',DB_PRE,trim($table)):DB_PRE.'content';
	$table=DB_PRE.$table;
	$where=$where?$where:'1=1';

	if($dbtype=='mssql')
	{
		$_fields=array();
		$fields=explode(',',$fields);
		foreach($fields as $key => $field)
		{
			if(strpos($field,':'))
			{
				$field=explode(':',$field);
				$_fields[$key]='CAST('.$field[0].' AS '.$field[1].') AS '.$field[0];
			}
			else
			{
				$_fields[$key]=$field;
			}
		}
		$fields=implode(',',$_fields);
	}
	$sql="SELECT ".$fields." FROM {$table} WHERE {$where} ORDER BY {$orderby}";
	//echo $sql;
	//exit;
	return '<?php $_DATA=get_sql_tag_data("'.$sql.'",'.$row.','.$page.',0,"'.$dbtype.'","'.$dbhost.'","'.$dbuser.'","'.$dbpwd.'","'.$dbname.'");foreach($_DATA as $no => $r)if(is_array($r)){?>';
}

//----------------------------------------------------栏目标记
function get_category_tag($para)
{
	$args=array(
				'id'=>'0',
				'catid'=>'0',
				'offset'=>'0',
				'parentid'=>'0',
				'row'=>'0',
				'mod'=>'1,2,4',
				'nav'=>'0',
				'type'=>'');
	foreach($para as $key => $arg)
	{
		if(isset($args[$key]))
		{
			$args[$key]=$arg;
		}
	}
	
	
	extract($args);
	$mod=!$mod?0:array_map('intval',explode(',',$mod));
	$type=in_array($type,array('top','son','self','all'))?$type:'all';
	$row=intval($row)>0?intval($row):100;
	
	return '<?php $_DATA=get_category_data('.$id.','.$offset.','.$catid.','.$parentid.','.var_export($mod,true).',\''.$type.'\','.$row.','.$nav.');$loopcatid=$catid;foreach($_DATA as $no => $r)if(is_array($r)){$catid=$r["id"];?>';
}

function get_category_data($id,$offset,$catid,$parentid,$mod,$type,$row,$nav)
{
	global $cache;
	$result=$_DATA=array();
	$catid=intval($catid)?intval($catid):intval($id);
	if($catid)
	{
		return array(getcatinfo($catid));
	}
	else
	{
	    $offset=intval($offset);
		switch($type)
			{

				case 'top':
						$_DATA=cache_read('cat_parent'.$parentid.'.cache.php',RETENG_ROOT.'data/cache_category/');
						$len=intval($len)?intval($len):sizeof($_DATA);

					break;
				case 'son':
						if($parentid==0)$parentid=$_GET['id'];
						$_DATA=cache_read('cat_parent'.$parentid.'.cache.php',RETENG_ROOT.'data/cache_category/');
						$row=intval($row)?intval($row):sizeof($_DATA);

					break;
				case 'self':

						$r=cache_read('cat'.$parentid.'.cache.php',RETENG_ROOT.'data/cache_category/');
						$_DATA=cache_read('cat_parent'.$r['parentid'].'.cache.php',RETENG_ROOT.'data/cache_category/');

					break;
				case 'all':
						$r=cache_read('cat.cache.php',RETENG_ROOT.'data/cache_category/');
						$_DATA=cache_read('cat.cache.php',RETENG_ROOT.'data/cache_category/');
				break;
			//}
			
		}
		
		if($_DATA)foreach($_DATA as $key => $_re)
		{
			if(!$mod || in_array($_re['type'],$mod))
			{
				$result[$key]=$_re;
				$expand=string2array($_re['expand']);

				if($expand)foreach($expand as $_key => $_value)
				{
					$result[$key]['_'.$_key]=$_value;
				}
			}
		}
		$_DATA=$result;
		if($_DATA&&$nav!=0)foreach($_DATA as $key => $_re)
		{
			$ccc=explode(',',$_re['navtype']);  //添加，过滤导航设置
			if(in_array($nav,$ccc))
			{
				$result1[$key]=$_re;
			}
			$_DATA=$result1;
		}
		if($_DATA)foreach($_DATA as $key => $_re)
		{
			if($_re['siteid']!=0 && $_re['siteid']==SITEID)
			{
				$result2[$key]=$_re;
			}
			$_DATA=$result2;
		}

		return array_slice($_DATA,$offset,$row);
		
	}
}


//--------------------------------------------------------------------内容标记
function get_tag($para)
{
	/*
		设置区块默认参数
		2013-11-28新增参数
		@subday 多少天
		@titlelen 标题长度
		2014-5-20
		@$conditions
	*/
	$args=array('catid'=>'$catid',
				'areaid'=>'0',
				'posid'=>'0',
				'row'=>'10',
				'limit'=>'0',
				'withthumb'=>'0',
				'orderby'=>'\'id\'',
				'orderbyway'=>'\'desc\'',
				'subday'=>'0',
				'titlelen'=>'0',
				'infolen'=>'0',
				'keyword'=>'\'\'',
				'conditions'=>'\'\'',
				'ismore'=>'0',
				'userid'=>'\'all\'');
	foreach($para as $key => $arg)
	{
		if(isset($args[$key]))
		{
			$args[$key]=strpos($arg,'$')===false && !is_numeric($arg) ?'\''.$arg.'\'':$arg;
		}
	}
	$args=implode(',',$args);
	return '<?php $reteng_page="";$_DATA=call_user_func(\'get_tag_data\','.$args.');foreach($_DATA as $no => $r)if(is_array($r)){?>';
}

/*评论标记*/
function get_comment_tag($para)
{
	/*
		设置区块默认参数
	*/
	$args=array('parentid'=>'0',
				'contentid'=>'0',
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
	if($contentid)
	{
		$sql='SELECT * FROM `".DB_PRE."comment` WHERE `".DB_PRE."comment`.`siteid`='.SITEID.' AND `".DB_PRE."comment`.`status`=1 AND `".DB_PRE."comment`.`parentid`=0 AND `".DB_PRE."comment`.`contentid`=".intval('.$contentid.')." ORDER BY `".DB_PRE."comment`.`support` DESC,`".DB_PRE."comment`.`id` DESC';
	}
	else if($parentid)
	{
		$sql='SELECT * FROM `".DB_PRE."comment` WHERE `".DB_PRE."comment`.`siteid`='.SITEID.' AND `".DB_PRE."comment`.`status`=1 AND `".DB_PRE."comment`.`parentid`=".intval('.$parentid.')." ORDER BY `".DB_PRE."comment`.`support` DESC,`".DB_PRE."comment`.`id` DESC';
	}
	else
	{
		$sql='SELECT * FROM `".DB_PRE."comment` WHERE `".DB_PRE."comment`.`siteid`='.SITEID.' AND `".DB_PRE."comment`.`status`=1 AND `".DB_PRE."comment`.`parentid`=0 ORDER BY `".DB_PRE."comment`.`support` DESC,`".DB_PRE."comment`.`id` DESC';
	}
	return '<?php $reteng_page="";$_DATA=get_sql_tag_data("'.$sql.'",'.$row.','.$page.',0);foreach($_DATA as $no => $r)if(is_array($r)){?>';
}


//栏目列表标记
function get_list_tag($para)
{
	$args=array('catid'=>'$catid',
				'row'=>'10',
				'orderby'=>'\'id\'',
				'orderbyway'=>'\'desc\'',
				'ismore'=>'0',
				'page'=>'$page',
				'subday'=>'0',
				'titlelen'=>'0',
				'infolen'=>'0',
				'keyword'=>'\'\'',
				'conditions'=>'\'\'',
				'userid'=>'all');
	unset($para['catid'],$para['page']);
	foreach($para as $key => $arg)
	{
		if(isset($args[$key]))
		{
			$args[$key]=strpos($arg,'$')===false && !is_numeric($arg) ?'\''.$arg.'\'':$arg;
		}
	}
	$args=implode(',',$args);
	return '<?php $reteng_page="";$_DATA=call_user_func(\'get_list_tag_data\','.$args.');foreach($_DATA as $no => $r)if(is_array($r)){?>';
}

/*get_list_tag_data() 函数是内容列表调用专用的函数*/
function get_list_tag_data($catid,$row="10",$orderby="id",$orderbyway='desc',$ismore="0",$page=0,$subday="0",$titlelen="0",$infolen="0",$keyword="",$conditions="",$userid="all")
{
	global $db,$reteng_page,$cache;
	$row=intval($row)?intval($row):1;
	$page=max(intval($page),1);

	$orderbyarr=explode(" ",trim($orderby));

	$orderby=$orderbyarr[0];
	$orderbyway=isset($orderbyarr[1]) && $orderbyarr[1]?$orderbyarr[1]:$orderbyway;

	$orderby=' ORDER BY '.$orderby.' '.$orderbyway;
	$where='a.siteid='.SITEID.' AND a.status=1';
	if($conditions)
	{
		if(is_array($conditions))
		{
			while (list($key, $val) = each($conditions)) {
				if($val!="")
				{
					$con = @explode(",",$val); 
					if(count($con)>1)
					{
						$str_condition.= " and $con[0]<=c.$key and c.$key<=$con[1]";
					}else
					{
						$str_condition.= " and c.$key = '$val'\n";
					}
					
				}
			}
		}
	}
	if(ISCITY)
	{
		$areaid=get_cookie('areaid');
		if($areaid)
		{
			$where.=' AND a.areaid='.intval($areaid);
		}
		else if(CITY)
		{
			$where.=' AND a.areaid='.intval(CITY);
		}
	}
	cache_write('cat-listsize'.$catid.'.cache.php',array($catid=>$row),RETENG_ROOT.'data/cache_template/');
	if(intval($catid))
	{
		$catid=str_replace('，',',',$catid);
		if(strpos($catid,','))
		{
			$recatid=$catid=array_map('intval',explode(',',$catid));
			foreach($catid as $_catid)
			{
				$r=get_childrencatid($_catid);
				foreach($r as $value)
				{
					if(isfinalcatid($value))$recatid[]=$value;
				}
			}
			$catid=implode(',',array_unique($recatid));
			$where.=' AND a.catid IN ('.$catid.')';
		}
		else
		{
			$catid=str_replace(',','',$catid);
			$catid=intval($catid)?intval($catid):0;
			$where.=' AND a.'.getCatid($catid);
		}
	}

	if($userid!='all')
	{
		$where.=' AND a.userid ='.intval($userid);
	}
    if($subday>0)
	{
            $ntime = gmmktime(0, 0, 0, gmdate('m'), gmdate('d'), gmdate('Y'));
            $limitday = $ntime - ($subday * 24 * 3600);
            $where.= " AND a.updatetime > $limitday ";
    }

	if($keyword)
	{
		$keyword=str_replace('，','|',str_replace(' ','|',$keyword));
		$where.=" AND CONCAT(a.title,a.keywords) REGEXP '$keyword' ";
	}

	if($ismore)
	{
		$r=cache_read('cat'.$catid.'.cache.php',RETENG_ROOT.'data/cache_category/');
		if($r)
		{
			$r=cache_read('model'.$r['modelid'].'.cache.php',RETENG_ROOT.'data/c/');
			if($r)
			{
				$sql="SELECT * FROM ".DB_PRE."content a ,".DB_PRE.$r['table']." c WHERE a.id=c.contentid AND ".$where.$str_condition.$orderby;
			}
			else
			{
				$sql="SELECT * FROM ".DB_PRE."content a WHERE ".$where.$orderby;
			}
		}
		else
		{
			$sql="SELECT * FROM ".DB_PRE."content a WHERE ".$where.$orderby;
		}
	}
	else
	{
		$sql="SELECT * FROM ".DB_PRE."content a WHERE ".$where.$orderby;
	}

	$r=getcatinfo($catid);
	$ishtml=$r['ishtml'] && $catid?$r['ishtml']:0;
	$count_sql=preg_replace("/^SELECT([^(]+)\s*FROM(.+)(ORDER BY.+)$/i", "SELECT COUNT(*) AS `count` FROM\\2", $sql);

	$count=get_cache_counts($count_sql);
	$pagecount=max(ceil($count/$row),1);
	$page=$page>$pagecount?$pagecount:$page;
	$offset=($page-1)*$row;
	$offset=!$offset&&$limit?$limit:$offset;

	$reteng_page=getpages($count,$page,$row,$ishtml,'center',$catid);

	$sql.=' LIMIT '.$offset.','.$row;

	$data=$db->fetch_all($sql);
   //新增标题默认截取功能
    $autoindex=1;
	foreach($data as $dd)
	{
		$dd['fulltitle']=$dd['title'];
		if($titlelen>0)
		{
			$dd['title']=sub_string($dd['title'],$titlelen);
		}
		if($dd['thumb']=="" )
		{
			$dd['thumb']=RETENG_PATH."images/nopic.gif";
		}
		if($infolen>0)
		{
			$dd['description']=sub_string($dd['description'],$infolen);
		}
		$dd['autoindex']=$autoindex++;
		$d[]=$dd;
	}
	$d['pagestring']=$reteng_page;
	$d['count']=$count;
	$d['pagecount']=$pagecount;
	return $d;
}

//------------------------------------------get_tag_data() 函数是内容调用专用的函数
function get_tag_data($catid, $areaid="0",$posid="0",$row="10",$limit=0,$withthumb="0",$orderby="id",$orderbyway='desc',$subday="0",$titlelen="0",$infolen="0",$keyword="",$conditions="",$ismore="0",$userid="all")
{
	global $db,$cache;
	$limit=intval($limit);
	$offset=$limit?$limit:0;
	$row=intval($row)?intval($row):1;
	$areaid=intval($areaid)?intval($areaid):0;
	$orderbyarr=explode(" ",trim($orderby));
	$orderby=$orderbyarr[0];
	$orderbyway=isset($orderbyarr[1])?$orderbyarr[1]:$orderbyway;

	if($orderby=='rand')
	{
		$orderby=' ORDER BY RAND()';
	}
	else
	{
		$orderby=' ORDER BY '.$orderby.' '.$orderbyway;
	}
	$where='a.siteid='.SITEID.' AND a.status=1';

	if(ISCITY)
	{
		$areaid=get_cookie('areaid');
		if($areaid)
		{
			$where.=' AND a.areaid='.intval($areaid);
		}
		else if(CITY)
		{
			$where.=' AND a.areaid='.intval(CITY);
		}
	}
	else if($areaid)
	{
		$where.=' AND a.areaid='.intval($areaid);
	}

	if($catid!='all' && intval($catid))
	{
		$catid=str_replace('，',',',$catid);
		if(strpos($catid,','))
		{
			$recatid=$catid=array_map('intval',explode(',',$catid));
			foreach($catid as $_catid)
			{
				$r=get_childrencatid($_catid);
				foreach($r as $value)
				{
					if(isfinalcatid($value))$recatid[]=$value;
				}
			}
			$catid=implode(',',array_unique($recatid));
			$where.=' AND a.catid IN ('.$catid.')';
		}
		else
		{
			$catid=str_replace(',','',$catid);
			$catid=intval($catid)?intval($catid):0;
			$where.=' AND a.'.getCatid($catid);

		}
	}
	if($userid!='all')
	{
		$where.=' AND a.userid ='.intval($userid);
	}
	$where.=intval($withthumb)?' AND a.thumb!=\'\'':'';
	$where.=intval($posid)?' AND b.posid='.$posid:'';
	
    if($subday>0)
	{
            $ntime = gmmktime(0, 0, 0, gmdate('m'), gmdate('d'), gmdate('Y'));
            $limitday = $ntime - ($subday * 24 * 3600);
            $where.= " AND a.updatetime > $limitday ";
    }

	if($keyword)
	{
		$keyword=str_replace('，','|',str_replace(' ','|',$keyword));
		$where.=" AND CONCAT(a.title,a.keywords) REGEXP '$keyword' ";
	}
	//附加查询
	if($conditions)
	{
		if(is_array($conditions))
		{
			while (list($key, $val) = each($conditions)) {
				if($val!="")
				{
					$con = @explode(",",$val); 
					if(count($con)>1)
					{
						$str_condition.= " and $con[0]<=c.$key and c.$key<=$con[1]";
					}else
					{
						$str_condition.= " and c.$key = '$val'\n";
					}
					
				}
			}
		}
	}
	if($posid)
	{
		if($catid && $catid!='all' && !strpos($catid,',')&&$ismore)
		{
			$r=cache_read('cat'.$catid.'.cache.php',RETENG_ROOT.'data/cache_category/');
			if($r)
			{
				$r=cache_read('model'.$r['modelid'].'.cache.php',RETENG_ROOT.'data/c/');
				if($r)
				{
					$sql="SELECT * FROM ".DB_PRE."content a ,".DB_PRE."content_posid b,".DB_PRE.$r['table']." c WHERE a.id=b.contentid AND a.id=c.contentid AND ".$where.$str_condition.$orderby;
				}
				else
				{
					$sql="SELECT * FROM ".DB_PRE."content a ,".DB_PRE."content_posid b WHERE a.id=b.contentid AND ".$where.$orderby;
				}
			}
			else
			{
				$sql="SELECT * FROM ".DB_PRE."content a ,".DB_PRE."content_posid b WHERE a.id=b.contentid AND ".$where.$orderby;
			}
		}
		else
		{
			$sql="SELECT * FROM ".DB_PRE."content a ,".DB_PRE."content_posid b WHERE a.id=b.contentid AND ".$where.$orderby;
		}
	}
	else
	{
		if($catid && $catid!='all' && !strpos($catid,',')&&$ismore)
		{
			$r=cache_read('cat'.$catid.'.cache.php',RETENG_ROOT.'data/cache_category/');
			if($r)
			{
				$r=cache_read('model'.$r['modelid'].'.cache.php',RETENG_ROOT.'data/c/');
				if($r)
				{
					$sql="SELECT * FROM ".DB_PRE."content a ,".DB_PRE.$r['table']." c WHERE a.id=c.contentid AND ".$where.$str_condition.$orderby;
				}
				else
				{
					$sql="SELECT * FROM ".DB_PRE."content a WHERE ".$where.$orderby;
				}
			}
			else
			{
				$sql="SELECT * FROM ".DB_PRE."content a WHERE ".$where.$orderby;
			}
		}
		else
		{
			$sql="SELECT * FROM ".DB_PRE."content a WHERE ".$where.$orderby;
		}
	}
	$sql.=' LIMIT '.$offset.','.$row;
	$data=$cache->get($sql);
	if(!$data)
	{
		$data=$db->fetch_all($sql);
		if($data)
		{
			$cache->set($sql,$data);
		}
	}
	/*
	2013-11-28新增
	*/
	$autoindex=1;
	
	foreach($data as $dd)
	{
		$dd['fulltitle']=$dd['title'];
		if($titlelen>0)
		{
			$dd['title']=sub_string($dd['title'],$titlelen);
		}
		if($dd['thumb']=="")
		{
			$dd['thumb']=RETENG_PATH."images/nopic.gif";
		}
		if($infolen>0)
		{
			$dd['description']=sub_string($dd['description'],$infolen);
		}
		$dd['autoindex']=$autoindex++;
		$d[]=$dd;
	}
	return $d;
}
?>