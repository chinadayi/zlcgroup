<?php
	include substr(dirname(__FILE__),0,-7).'/include/common.inc.php';

	if($module->module_disabled('search'))
	{
		show404('该模块已被管理员禁用!');
	}
	
	if(isset($k))
	{
		$k=trim($k);
	}

	if(isset($modelid) && isset($k) && $k=='')
	{
		header('location:'.SITE_URL.'search/index.php');
		exit();
	}

	if(isset($k) && isset($modelid))
	{
		if($modelid=='baidu')
		{
			header('location:http://www.baidu.com/baidu?word='.$k);
			exit();
		}

		if($modelid=='google')
		{
			header('location:http://www.google.com.hk/search?q='.$k);
			exit();
		}

		if($modelid=='qihu')
		{
			header('location:http://www.qihoo.com/wenda.php?do=search&kw='.$k);
			exit();
		}
	}

	include dirname(__FILE__).'/include/keywords.class.php';
	$keyobj=new keywords();

	include RETENG_ROOT.'/include/wordsplit.class.php';
	$wordsplit=new wordsplit();

	if($_GET)foreach($_GET as $key => $val)
	{
		$val=trim($val);
		if(!$val && !is_numeric($val))
		{
			unset($_GET[$key]);
		}
		else
		{
			$_GET[$key]=htmlspecialchars($val);
		}
	}
	$mod='search';

	if(!isset($modelid) && !isset($catid))
	{
		$template = 'index';
		$head['title'] = '搜索首页-'.$RETENG['site_name'];
		$head['keywords'] = $RETENG['meta_keywords'];
		$head['description'] = $RETENG['meta_description'];
	}
	else
	{
		$stop=false;

		$searcharray=$replacearray=array();

		$template = 'list';
		$head['title'] = '搜索结果页-'.$RETENG['site_name'];
		$head['keywords'] = $RETENG['meta_keywords'];
		$head['description'] = $RETENG['meta_description'];
		
		$k=isset($k)?htmlspecialchars(trim($k)):'';
		$catid=isset($catid)?intval($catid):0;
		$modelid=isset($modelid)?trim($modelid):'all';
		$modelid=trim($modelid)=='all'?trim($modelid):(intval($modelid)>0?intval($modelid):1);
		
		$where ='a.siteid='.SITEID.' AND a.status=1 AND a.islink=0';

		/*
			优先以栏目ID搜索 否则以模型ID搜素
		*/
		if($catid && cat_exists($catid))
		{
			$catinfo=getcatinfo($catid);
			if($catinfo['type']==1)
			{
				$where='a.'.getCatid($catid);
			}

			$modelid=$catinfo['modelid'];
		}
		else
		{
			if($modelid!='all' && model_exists($modelid))
			{
				$where='a.modelid='.$modelid;
			}
		}
		
		/*
			模型信息 
		*/
		if($modelid!='all')
		{
			$modelinfo=cache_read('model'.intval($modelid).'.cache.php',RETENG_ROOT.'data/c/');

			$fieldsinfo=cache_read('model'.intval($modelid).'_fields.cache.php',RETENG_ROOT.'data/c/');

			if($fieldsinfo)
			{
				foreach($fieldsinfo as $field)
				{
					$pre=in_array($field['enname'],array('title','description','keywords'))?'a.':'b.';
					if($field['form']=='number')
					{
						if(isset($_GET['min'.$field['enname']]) && isset($_GET['max'.$field['enname']]))
						{
							$min=intval($_GET['min'.$field['enname']]);
							$max=intval($_GET['max'.$field['enname']]);
							$where.=' AND '.$pre.$field['enname'].' BETWEEN '.$min.' AND '.$max;
						}
					}
					else if(in_array($field['form'],array('title','textarea','fckeditor','description')))
					{
						if(isset($_GET[$field['enname']]))
						{
							$value=trim($_GET[$field['enname']]);

							if($value)
							{
								$morewhere=$keyobj->keywordsql($value,$pre.$field['enname']);
								if($morewhere)
								{
									$where.=' AND '.$morewhere;
									$searcharray=$keyobj->splitkeywords($value);

									if($searcharray)
									{
										foreach($searcharray as $key => $val)
										{
											$replacearray[$key]='<font color="#FF0000">'.$val.'</font>';
										}
									}
								}
								else
								{
									$stop=true;
									$where.=' AND 0 ';
								}
							}
						}
					}
					else if(in_array($field['form'],array('radio','select','author','copyfrom')) || substr($field['form'],0,11)=='selectmenu_')
					{
						if(isset($_GET[$field['enname']]))
						{
							$value=trim($_GET[$field['enname']]);

							if($value)
							{
								$pre=substr($field['form'],0,11)=='selectmenu_'?'a.':$pre;
								$where.=' AND '.$pre.$field['enname']. ' = "'.$value.'"';
							}
						}
					}
					else if(in_array($field['form'],array('text','checkbox')))
					{
						if(isset($_GET[$field['enname']]))
						{
							$value=trim($_GET[$field['enname']]);

							if($value)
							{
								$where.=' AND '.$pre.$field['enname']. ' LIKE "%'.$value.'%"';
							}
						}
					}
				}
			}

			$template='search_'.$modelinfo['table'];
		}

		/*
			是否含有关键字 $k 否则按照 模型搜索字段搜索
		*/
		if($k!='' && !$stop)
		{
			$stype=isset($stype)?$stype:'keywords';
			$stype=in_array($stype,array('title','keywords','description'))?$stype:'keywords';
			$pre='a.';
			$morewhere=$keyobj->keywordsql($k,$pre.$stype);

			if($morewhere)
			{
				$where.=' AND '.$morewhere;
			}
			else
			{
				$stop=true;
				$where.=' AND 0 ';
			}
			
			if(!$stop)
			{
				$searcharray=$keyobj->splitkeywords($k);

				if($searcharray)
				{
					foreach($searcharray as $key => $val)
					{
						$replacearray[$key]='<font color="#FF0000">'.$val.'</font>';
					}
				}
			}
		}

		if($modelid!='all')
		{
			$sql="SELECT a.*,b.* FROM ".DB_PRE."content a LEFT JOIN ".DB_PRE.$modelinfo['table']." b ON a.id=b.contentid WHERE $where ORDER BY a.updatetime DESC";
		}
		else
		{
			$sql="SELECT a.* FROM ".DB_PRE."content a WHERE $where ORDER BY a.updatetime DESC";
		}

		$start=microtime(true);
		$data=$cache->get($sql);
		if(!$data)
		{
			$data=$db->fetch_all($sql);
			$cache->set($sql,$data);
		}

		$totalnum=count($data);
		$pagesize=isset($pagesize)?max(1,intval($pagesize)):15;
		$pagenum=ceil($totalnum/$pagesize);
		$page=isset($page)?min($pagenum,max(1,intval($page))):1;

		$data=array_slice($data,($page-1)*$pagesize,$pagesize);

		if($data && $searcharray && $replacearray)foreach($data as $key => $val)
		{
			$data[$key]['title']=str_replace($searcharray,$replacearray,$val['title']);

			if(isset($val['content']))
			{
				$data[$key]['description']=trim($val['description'])?trim($val['description']):sub_string(trim(strip_tags($val['content'])),255);
				$data[$key]['description']=str_replace($searcharray,$replacearray,$val['description']);
			}
		}
		
		$pagearray=range(1,$pagenum);
		$pagearray=array_slice($pagearray,($page/10 < 1?0:floor($page/10)*10) ,10);

		$reteng_page=array();

		$querystring=array();
		if($_GET)
		{
			if(isset($_GET['page']))unset($_GET['page']);
			foreach($_GET as $key => $val)
			{
				$querystring[]=$key.'='.$val;
			}
		}
		if($page!=1)
		{
			$querystring['page']='page='.max($page-1,1);
			$reteng_page[]='<a href="search/index.php?'.implode('&',$querystring).'">上一页</a>';
		}

		foreach($pagearray as $_page)
		{
			if($page==$_page)
			{
				$reteng_page[]='['.$_page.']';
			}
			else
			{
				$querystring['page']='page='.$_page;
				$reteng_page[]='<a href="search/index.php?'.implode('&',$querystring).'">['.$_page.']</a>';
			}
		}

		if($page!=$pagenum)
		{
			$querystring['page']='page='.min($page+1,$pagenum);
			$reteng_page[]='<a href="search/index.php?'.implode('&',$querystring).'">下一页</a>';
		}

		$result_page=$reteng_page=$data?implode(' ',$reteng_page):'';
		$expire=round(microtime(true)-$start,4);
	}
 
	/*
		模型信息数组
	*/
	$modelinfo=cache_read('model.cache.php',RETENG_ROOT.'data/c/');
	if($template!='list' && $template!='index' && !file_exists(RETENG_ROOT.'template/'.TPL_NAME.'/search/'.$template.'.htm'))
	{
		$template='list';
	}
	
	include template($template,$mod);
?>
