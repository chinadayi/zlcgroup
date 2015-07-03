<?php
/*
	* HTML类
*/

@set_time_limit(0);
set_cookie('project','');

class html
{
	private $c;
	private $db;

	function __construct()
	{	
		global $c,$db;
		$this->c=$c;
		$this->db=$db;
	}

	function cache()
	{
		return $this->c->cache_all();
	}

	function cache_tag()
	{
		return $this->c->cache_tag();
	}

	function cache_category()
	{
		return $this->c->cache_category();
	}

	function cache_template()
	{
		return $this->c->cache_template();
	}

	function sitemaphtml()
	{
		global $RETENG,$_username,$_userid,$install,$sitecrowdobj,$childsite,$hotWord;
		$head['title']=$RETENG['site_name'].'-'.$RETENG['meta_title'];
		$head['keywords']=$RETENG['meta_keywords'];
		$head['description']=$RETENG['meta_description'];
		ob_start();
		include template('sitemap');
		$sitemap=RETENG_ROOT.$sitedir.'sitemap.html';
		create_html($sitemap);
		/*
			远程发布点
		*/
		if($childsite['issueid'])
		{
			$issueids=array_map('intval',explode(',',$childsite['issueid']));
			if(!in_array(0,$issueids) && $issueids)
			{
				foreach($issueids as $issueid)
				{
					$issueinfo=array_map('trim',$sitecrowdobj->issueinfo($issueid));
					if($issueinfo['ftphost'] && $issueinfo['ftpuser'] && $issueinfo['ftppwd'] && $issueinfo['ftpport'])
					{
						$ftpobj=new ftp();
						$result=$ftpobj->connect($issueinfo['ftphost'],$issueinfo['ftpuser'],$issueinfo['ftppwd'],$issueinfo['ftpport'],FTP_TIMEOUT,$issueinfo['ftpssl'],$issueinfo['ftppasv']);
						if($result)
						{
							$remotedir=$issueinfo['ftpdir'].'/'.SITEDIR.'/';
							if($ftpobj->ftp_mkdir($remotedir))
							{
								$ftpobj->ftp_upload($remotedir.basename($sitemap),$sitemap);
							}
							$ftpobj->ftp_close();
						}
					}
				}
			}
		}
		return $filesize;
	}

	function index()
	{
		global $RETENG,$_username,$_userid,$install,$sitecrowdobj,$childsite,$hotWord;
		if(!ISHTML) return true;
		$head['title']=$RETENG['site_name'].'-'.$RETENG['meta_title'];
		$head['keywords']=$RETENG['meta_keywords'];
		$head['description']=$RETENG['meta_description'];
		ob_start();
		include template('index');
		$sitedir=SITEDIR?str_replace('//','/',SITEDIR.'/'):'';
		$file=RETENG_ROOT.$sitedir.'index'.HTMLEXT;
		$filesize=create_html($file);
		
		/*
			远程发布点
		*/
		if($childsite['issueid'])
		{
			$issueids=array_map('intval',explode(',',$childsite['issueid']));
			if(!in_array(0,$issueids) && $issueids)
			{
				foreach($issueids as $issueid)
				{
					$issueinfo=array_map('trim',$sitecrowdobj->issueinfo($issueid));
					if($issueinfo['ftphost'] && $issueinfo['ftpuser'] && $issueinfo['ftppwd'] && $issueinfo['ftpport'])
					{
						$ftpobj=new ftp();
						$result=$ftpobj->connect($issueinfo['ftphost'],$issueinfo['ftpuser'],$issueinfo['ftppwd'],$issueinfo['ftpport'],FTP_TIMEOUT,$issueinfo['ftpssl'],$issueinfo['ftppasv']);
						if($result)
						{
							$remotedir=$issueinfo['ftpdir'].'/'.SITEDIR.'/';
							if($ftpobj->ftp_mkdir($remotedir))
							{
								$ftpobj->ftp_upload($remotedir.basename($file),$file);
							}
							$ftpobj->ftp_close();
						}
					}
				}
			}
		}
		return $filesize;
	}

	function category($catid ,$page=1)
	{	
		global $RETENG,$_username,$_userid,$install,$sitecrowdobj,$childsite,$hotWord;
		$catid=intval($catid);
		$page=intval($page);
		if(!$catid) return true;
		$updateinfo=array();

		/*	
			获取栏目信息 由数组 $catinfo 存贮
		*/

		$catinfo=getcatinfo($catid);
		$catinfo['setting']=cache_read('cat_setting'.$catid.'.cache.php',RETENG_ROOT.'data/cache_category/');
		if($catinfo['setting']['catishtml']!=1 && $catinfo['type']==1)
		{
			if($catinfo['setting']['catishtml']==2)
			{
				$listurlrule=$catinfo['setting']['listurlrule']?$catinfo['setting']['listurlrule']:'{sitedir}{catdir}list_{page}'.HTMLEXT;
				$listurlrule=str_replace('{sitedir}',SITEDIR?SITEDIR.'/':'',$listurlrule);
				$listurlrule=str_replace('{tid}',$catid,$listurlrule);
				$listurlrule=str_replace('{page}','1',$listurlrule);
				$listurlrule=str_replace('{catdir}',$catinfo['catdir'],$listurlrule);
				$listurlrule=str_replace('\\','/',$listurlrule);
				$listurlrule=str_replace('//','/',$listurlrule);
				$updateinfo['url']=$listurlrule;
			}
			else
			{
				$updateinfo['url']='/list/?id='.$catid.'&siteid='.$catinfo['siteid'];
			}

			if($catid)
			{
				$this->db->update(DB_PRE.'category',$updateinfo,'id='.$catid);
			}
			return true;
		}
		else
		{
			/*
				定义常用模板变量
			*/
			$reteng_postion=get_pos($catid);
			$reteng_catname=$catinfo['catname'];
			$reteng_catid=$catid;
			$reteng_url=$catinfo['url'];

			$head['title'] = $catinfo['catname'].'-'.($catinfo['setting']['meta_title']?$catinfo['setting']['meta_title'] : $RETENG['site_name']);
			$head['keywords'] = $catinfo['setting']['meta_keywords'];
			$head['description'] = $catinfo['setting']['meta_description'];
			/*		
				根据分类静态化
			*/	
			if($catinfo['type']==1 || $catinfo['modelid']==-1 ) // 常规栏目
			{
				ob_start();
				@extract($catinfo ,EXTR_SKIP);
				@extract($catinfo['setting'] ,EXTR_SKIP);
				@extract($catinfo['expand'] ,EXTR_PREFIX_ALL,'');
				$template=isfinalcatid($catid)?$catinfo['setting']['templist']:$catinfo['setting']['tempindex'];
				include template($template);
				$listurlrule=(isset($catinfo['listurlrule']) && $catinfo['listurlrule']) ?$catinfo['listurlrule']:'{sitedir}{catdir}list_{page}'.HTMLEXT;
				$listurlrule=str_replace('{sitedir}',SITEDIR?SITEDIR.'/':'',$listurlrule);
				$listurlrule=str_replace('{tid}',$catid,$listurlrule);
				$listurlrule=str_replace('{page}',$page,$listurlrule);
				$listurlrule=str_replace('{catdir}',$catinfo['catdir'],$listurlrule);
				$listurlrule=str_replace('\\','/',$listurlrule);
				$listurlrule=str_replace('//','/',$listurlrule);
				$file=RETENG_ROOT.$listurlrule;

				makedir($catinfo['catdir']);
				create_html($file);
				if($page==1)
				{
					copy($file ,RETENG_ROOT.$catinfo['catdir'].'index'.HTMLEXT);
				}

				/*
					远程发布点
				*/ 
				if($childsite['issueid'])
				{
					$issueids=array_map('intval',explode(',',$childsite['issueid']));
					if(!in_array(0,$issueids) && $issueids)
					{
						foreach($issueids as $issueid)
						{
							$issueinfo=array_map('trim',$sitecrowdobj->issueinfo($issueid));
							if($issueinfo['ftphost'] && $issueinfo['ftpuser'] && $issueinfo['ftppwd'] && $issueinfo['ftpport'])
							{
								$ftpobj=new ftp();
								$result=$ftpobj->connect($issueinfo['ftphost'],$issueinfo['ftpuser'],$issueinfo['ftppwd'],$issueinfo['ftpport'],FTP_TIMEOUT,$issueinfo['ftpssl'],$issueinfo['ftppasv']);
								if($result)
								{
									$remotedir=$issueinfo['ftpdir'].'/'.$catinfo['catdir'];
									$remotedir=str_replace('//','/',$remotedir);

									if($ftpobj->ftp_mkdir($remotedir))
									{
										$ftpobj->ftp_upload($remotedir.basename($file),$file);
										if($page==1)
										{
											$ftpobj->ftp_upload($remotedir.'index'.HTMLEXT,RETENG_ROOT.$catinfo['catdir'].'index'.HTMLEXT);
										}
									}
									$ftpobj->ftp_close();
								}
							}
						}
					}
				}
				return true;
			}
			else // 模块
			{
				return true;
			}
		}
	}

	function content($contentid,$inlink=0)
	{
		global $RETENG,$module,$_username,$_userid,$install,$sitecrowdobj,$childsite,$hotWord;
		$contentid=intval($contentid);
		if(!$contentid)showmsg('请先添加内容，再生成!');

		global $RETENG,$_username,$_userid,$db;
		
		/*	
			获取内容信息
		*/
		require_once RETENG_ROOT.'include/content.class.php';
		$conobj=new content();
		$coninfo=$conobj->get($contentid,true);

		if(!$coninfo['status'] || $coninfo['islink'])return true;
		
		/*
			获取栏目信息
		*/
		require_once RETENG_ROOT.'include/admin/category.class.php';
		$category=new category();
		$catinfo=$category->catinfo($coninfo['catid']);

		if(empty($coninfo['keywords']) || trim($coninfo['keywords'])=="")
			{
							include_once RETENG_ROOT.'include/wordsplit.class.php';
							$wordsplit=new wordsplit(RETENG_ROOT.'/include/dict/cnwords.dict');
							$str=iconv('GBK', 'UTF-8', $coninfo['title']);
							$re=$wordsplit->splitWords($str);
							$keywords=iconv('UTF-8', 'GBK',implode(',',$re));
							$updatekey['keywords']=$keywords;
							$conobj->set($contentid,$updatekey);
						
		}

		
		/*
			更新内链
		*/
		if($inlink && !$module->module_disabled('workbox'))
		{
			$inlinkarr=array();
			include_once RETENG_ROOT.'workbox/include/workbox.class.php';
			$workbox= new workbox();
			$inlinkarr['content']=$workbox->addinlink($coninfo['content']);
			$conobj->set($contentid,$inlinkarr,true);
		}

		/*
			先更新内容链接
		*/
		$updateinfo=array();



		if(!$catinfo['setting']['ishtml'])
		{
			$updateinfo['url']='/show/?id='.$contentid.'&siteid='.$catinfo['siteid'];
			$conobj->set($contentid,$updateinfo);
		}
		else
		{
			$dir='';
			if(!$coninfo['template'])
			{
				$coninfo['template']=$updateinfo['template']=$catinfo['setting']['temparticle'];
			}

			include_once RETENG_ROOT.'/include/cnspell.class.php';
			$cnspell=new cnspell();
			$catinfo['setting']['urlrule']=strpos($catinfo['setting']['urlrule'],'.')?trim($catinfo['setting']['urlrule']):'{sitedir}html/{Y}{M}/a{cid}'.HTMLEXT;
			$updateinfo['url']=str_replace('{sitedir}',SITEDIR?SITEDIR.'/':'',$catinfo['setting']['urlrule']);
			$updateinfo['url']=str_replace('{catdir}',$catinfo['catdir'],$updateinfo['url']);
			$updateinfo['url']=str_replace('{Y}',date('Y',$coninfo['inputtime']),$updateinfo['url']);
			$updateinfo['url']=str_replace('{M}',date('m',$coninfo['inputtime']),$updateinfo['url']);
			$updateinfo['url']=str_replace('{D}',date('d',$coninfo['inputtime']),$updateinfo['url']);
			$updateinfo['url']=str_replace('{timestamp}',$coninfo['inputtime'],$updateinfo['url']);
			$updateinfo['url']=str_replace('{cid}',intval($contentid),$updateinfo['url']);
			$updateinfo['url']=str_replace('{pinyin}',$cnspell->getcnSpell($coninfo['title'],'GBK',0).intval($contentid),$updateinfo['url']);
			$updateinfo['url']=str_replace('{py}',$cnspell->getcnSpell($coninfo['title'],'GBK',1).intval($contentid),$updateinfo['url']);
			$updateinfo['url']=str_replace('\\','/',$updateinfo['url']);
			$updateinfo['url']=str_replace('//','/',$updateinfo['url']);

			if($catinfo['setting']['ishtml']==1)
			{
				makedir(dirname($updateinfo['url']));
			}

			$conobj->set($contentid,$updateinfo);
			
			if($catinfo['setting']['ishtml']==1)
			{
				/*
					定义常用模板变量
				*/
				$reteng_postion=get_pos($coninfo['catid']);
				$reteng_contentid=$contentid;
				$reteng_catname=$catinfo['catname'];
				$reteng_catid=$catid=$coninfo['catid'];
				$reteng_url=$coninfo['url'];
				$reteng_page='';
				$page_array=$page_t=array();
				
				/*
					开始静态化
				*/

				@extract($coninfo,EXTR_SKIP);
				ob_start();
				if($coninfo['ispage']==2) // 自动分页
				{
					$cons=preg_split('/<\/p>/i',$content);
					$conlen=0;
					$constr='';
					foreach($cons as $key => $con)
					{
						$constr.=$con.(substr(strtolower($con),-4)=='</p>'?'':'</p>');
						$conlen+=strlen($constr);
						if($conlen>$coninfo['pagecount'] || ($key+1)==sizeof($cons))
						{
							if($constr && strtolower($constr)!='</p>')
							{
								$conarray[]=$constr;
							}
							$conlen=0;
							$constr='';
						}
					}
				}
				else if($coninfo['ispage']==1) // 手动分页
				{
					$conarray=preg_split('/#page_break_tag#/',$content);
				}
				else // 不分页
				{
					$conarray=array();
				}

				if(sizeof($conarray)>1) // 分页
				{
					/**
						获取分页字符串
					*/
					$pagelen=count($conarray);
					for($i=1; $i<=$pagelen; $i++)
					{
						if($i==1)
						{
							$page_array[$i]='<a href="'.$coninfo['url'].'">'.$i.'</a>';
						}
						else
						{
							$page_array[$i]='<a href="'.dirname($coninfo['url']).'/'.basename($coninfo['url'],'.'.get_fileext($coninfo['url'])).'_'.$i.HTMLEXT.'">'.$i.'</a>';
						}
					}
					$page_t=$page_array;
					
					foreach(glob(RETENG_ROOT.dirname($coninfo['url']).'/'.basename($coninfo['url'],'.'.get_fileext($coninfo['url'])).'_*'.HTMLEXT) as $file_name)
					{
						if(basename($file_name))
						{
							@unlink($file_name);
						}
					}
					foreach($conarray as $conkey => $content)
					{
						$page_t[$conkey+1]=$conkey+1;
						$content_page=$reteng_page=implode('&nbsp;',$page_t);
						$page_t=$page_array;
						$url=dirname($coninfo['url']).'/'.basename($coninfo['url'],'.'.get_fileext($coninfo['url'])).'_'.($conkey+1).HTMLEXT;
						$title=$conkey?$coninfo['title'].'('.($conkey+1).')':$coninfo['title'];
						include template($coninfo['template']);
						$content=ob_get_contents();
						ob_clean();

						$file=RETENG_ROOT.$url;
						file_put_contents($file,$content);
						if($conkey==0)
						{
							@copy($file,RETENG_ROOT.$coninfo['url']);
							@unlink($file);
						}

						/*
							远程发布点
						*/
						if($childsite['issueid'])
						{
							$issueids=array_map('intval',explode(',',$childsite['issueid']));
							if(!in_array(0,$issueids) && $issueids)
							{
								foreach($issueids as $issueid)
								{
									$issueinfo=array_map('trim',$sitecrowdobj->issueinfo($issueid));
									if($issueinfo['ftphost'] && $issueinfo['ftpuser'] && $issueinfo['ftppwd'] && $issueinfo['ftpport'])
									{
										$ftpobj=new ftp();
										$result=$ftpobj->connect($issueinfo['ftphost'],$issueinfo['ftpuser'],$issueinfo['ftppwd'],$issueinfo['ftpport'],FTP_TIMEOUT,$issueinfo['ftpssl'],$issueinfo['ftppasv']);
										if($result)
										{
											$remotedir=$issueinfo['ftpdir'].'/'.dirname($url).'/';
											$remotedir=str_replace('//','/',$remotedir);
											if($ftpobj->ftp_mkdir($remotedir))
											{
												$ftpobj->ftp_upload($remotedir.basename($file),$file);
												if($conkey==0)
												{
													$ftpobj->ftp_upload($remotedir.$coninfo['url'],RETENG_ROOT.$coninfo['url']);
												}
											}
											$ftpobj->ftp_close();
										}
									}
								}
							}
						}
					}
				}
				else  // 不分页
				{
					$file=RETENG_ROOT.$coninfo['url'];
					include template($coninfo['template']);
					$content=ob_get_contents();
					ob_clean();	
					file_put_contents($file,$content);
					
					/*
						远程发布点
					*/
					if($childsite['issueid'])
					{
						$issueids=array_map('intval',explode(',',$childsite['issueid']));
						if(!in_array(0,$issueids) && $issueids)
						{
							foreach($issueids as $issueid)
							{
								$issueinfo=array_map('trim',$sitecrowdobj->issueinfo($issueid));
								if($issueinfo['ftphost'] && $issueinfo['ftpuser'] && $issueinfo['ftppwd'] && $issueinfo['ftpport'])
								{
									$ftpobj=new ftp();
									$result=$ftpobj->connect($issueinfo['ftphost'],$issueinfo['ftpuser'],$issueinfo['ftppwd'],$issueinfo['ftpport'],FTP_TIMEOUT,$issueinfo['ftpssl'],$issueinfo['ftppasv']);
									if($result)
									{
										$remotedir=$issueinfo['ftpdir'].'/'.dirname($coninfo['url']).'/';
										$remotedir=str_replace('//','/',$remotedir);
										if($ftpobj->ftp_mkdir($remotedir))
										{
											$ftpobj->ftp_upload($remotedir.basename($file),$file);
										}
										$ftpobj->ftp_close();
									}
								}
							}
						}
					}
				}
			}
		}
		return true;
	}
}
?>