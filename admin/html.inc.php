<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(8,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
	$action=empty($action)?'manage':trim($action);
	require RETENG_ROOT.'include/html.class.php';
	$html=new html();
	switch($action)
	{
		case 'cache':
			if($html->cache())
			{
				$job=isset($job)?$job:'';

				if($job=='cache')
				{
					showmsg('缓存更新完毕, 开始更新首页...',ADMIN_FILE.'?file=html&action=index&job=index',500);
				}
				else
				{
					showmsg_nourl('所有缓存更新完毕!');
				}
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'cache_tag':
			if($html->cache_tag())
			{
				showmsg_nourl('数据缓存更新完毕!');
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'cache_template':
			if($html->cache_template())
			{
				showmsg_nourl('模板缓存更新完毕!');
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'cache_category':
			if($html->cache_category())
			{
				showmsg_nourl('栏目缓存更新完毕!');
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'index':
			$job=isset($job)?$job:'';

			if(!ISHTML)
			{
				if($job=='index')
				{
					showmsg('首页无需静态化, 开始更新栏目...',ADMIN_FILE.'?file=html&action=category&do_submit=1&job=cat&catid=1',500);
				}
				else
				{
					showmsg_nourl('首页无需静态化!');
				}
			}
			$filesize=$html->index();
			$filesize=round((float)($filesize/1024),2);	
			if($filesize)
			{
				if($job=='index')
				{
					showmsg('首页更新完毕, 开始更新栏目...',ADMIN_FILE.'?file=html&action=category&do_submit=1&job=cat&catid=1',500);
				}
				else
				{
					showmsg_nourl('网站首页更新成功! 文件大小: '.$filesize.'K');
				}
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'all':
			if(isset($do_submit))
			{
				showmsg('准备工作就绪, 开始更新系统缓存...',ADMIN_FILE.'?file=html&action=cache&job=cache',500);
			}
			include admin_tlp('html_all');
			break;
		case 'category':
			if(isset($do_submit)) 
			{
				$job=isset($job)?$job:'';
				$allcatid=array();

				/**
					首次存储所有栏目ID
				*/
				if(isset($catid))
				{
					if(!is_array($catid))
					{
						$catid=cache_read('cat.cache.php',RETENG_ROOT.'data/cache_category/');
						foreach($catid as $_catid)
						{
							if($_catid['siteid']==SITEID)
							{
								$catsetting=getcatsetting($_catid['id']);
								if($_catid['type']==1 || $_catid['type']==2)
								{
										$allcatid[]=$_catid['id'];
								}
							}
						}
					}
					else
					{
						$allcatid=$catid;
						if(in_array(0,$catid))
						{
							$allcatid=array();
							$catid=cache_read('cat.cache.php',RETENG_ROOT.'data/cache_category/');
							foreach($catid as $_catid)
							{
								if($_catid['siteid']==SITEID)
								{
									$catsetting=getcatsetting($_catid['id']);
									if($_catid['type']==1 || $_catid['type']==2)
									{
										$allcatid[]=$_catid['id'];
									}
								}
							}
						}
						else
						{
							foreach($catid as $_catid)
							{
								$allcatid=array_merge($allcatid,get_childrencatid($_catid));
							}
							$allcatid=array_unique($allcatid);
						}
					}
					$allcatid=array_map('intval',$allcatid);
					cache_write('user'.$_userid.'-catid.cache.php',$allcatid,RETENG_ROOT.'data/tmp/');
					showmsg('准备工作结束,开始更新栏目...',ADMIN_FILE.'?file=html&action=category&do_submit=1&job='.$job,500);
				}
				/**
					开始 从缓存读取栏目ID
				*/
				else
				{
					$allcatid=cache_read('user'.$_userid.'-catid.cache.php',RETENG_ROOT.'data/tmp/');
					
					/*
						继续更新栏目
					*/
					if($allcatid || isset($nowcatid))
					{
						$nowcatid=isset($nowcatid)?intval($nowcatid):intval(array_shift($allcatid));
						cache_write('user'.$_userid.'-catid.cache.php',$allcatid,RETENG_ROOT.'data/tmp/');

						if($nowcatid)
						{
							$catsetting=getcatinfo($nowcatid);
							$r=cache_read('cat-listsize'.$nowcatid.'.cache.php',RETENG_ROOT.'data/cache_template/');
							$row=$r && intval($r[$nowcatid])?intval($r[$nowcatid]):$catsetting['listnum'];

							if(($catsetting['type']==1 && $catsetting['catishtml']==1 && ($catsetting['islist'] || isfinalcatid($nowcatid))) || $catsetting['type']==2)
							{
								if($catsetting['type']==2)
								{
									$html->category($nowcatid);
									showmsg('栏目['.catname($nowcatid).']更新成功...',ADMIN_FILE.'?file=html&action=category&do_submit=1&job='.$job,0);
								}
								else
								{
									/*
										更新列表页
									*/
									if(!isset($pagecount))
									{
										$count=get_cache_counts("SELECT COUNT(*) AS `count` FROM `".DB_PRE."content` WHERE ".getCatid($nowcatid)." AND status=1",30);
										$pagecount=max(ceil($count/$row),1);
									}

									if($pagecount<=0)
									{
										showmsg('栏目['.catname($nowcatid).']更新成功...',ADMIN_FILE.'?file=html&action=category&do_submit=1&job='.$job,0);
									}
									$len=min($pagecount,50);
									$start=isset($start)?intval($start):1;
									for($i=$start;$i < ($start+$len);$i++)
									{
										if($catsetting['catishtml'])
										{
											$html->category($nowcatid,$i);
										}	
									}
									if($pagecount>50)
									{
										showmsg('栏目['.catname($nowcatid).']列表'.$start.'-'.($start+$len).'更新成功...',ADMIN_FILE.'?file=html&action=category&do_submit=1&nowcatid='.$nowcatid.'&start='.($start+$len).'&pagecount='.($pagecount-$len).'&job='.$job,0);
									}
									else
									{
										showmsg('栏目['.catname($nowcatid).']更新成功...',ADMIN_FILE.'?file=html&action=category&do_submit=1&job='.$job,0);
									}
								}
							}
							else
							{
								/*
									更新非列表页
								*/
								if(isset($catsetting['catishtml']) || $catsetting['type']==2)
								{
									$html->category($nowcatid);
									showmsg('栏目['.catname($nowcatid).']更新成功...',ADMIN_FILE.'?file=html&action=category&do_submit=1&job='.$job,0);
								}
								else
								{
									showmsg('跳过栏目['.catname($nowcatid).']...',ADMIN_FILE.'?file=html&action=category&do_submit=1&job='.$job,0);
								}
							}
						}
						else
						{
							cache_delete('user'.$_userid.'-catid.cache.php',RETENG_ROOT.'data/tmp/');
							if($job=='cat')
							{
								showmsg('栏目更新完毕, 开始更新内容...',ADMIN_FILE.'?file=html&action=content&&job=con&do_submit=1catid=1&type=all&pagesize=50');
							}
							else
							{
								$html->cache_category();
								$html->cache_tag();
								showmsg('所有栏目更新完毕!',ADMIN_FILE.'?file=html&action=category');
							}
						}
					}
					/*
						全部更新完毕
					*/
					else
					{
						cache_delete('user'.$_userid.'-catid.cache.php',RETENG_ROOT.'data/tmp/');
						if($job=='cat')
						{
							showmsg('栏目更新完毕, 开始更新内容...',ADMIN_FILE.'?file=html&action=content&do_submit=1&job=con&catid=1&type=all&pagesize=50');
						}
						else
						{
							$html->cache_category();
							$html->cache_tag();
							showmsg('所有栏目更新完毕!',ADMIN_FILE.'?file=html&action=category');
						}
					}
				}
			}
			require RETENG_ROOT.'/include/options.class.php';
			$options=new options();
			include admin_tlp('html_category');
			break;
		case 'content':
			if(isset($do_submit)) 
			{
				$job=isset($job)?$job:'';
				$allcatid=array();
				$tcatid=array();
				$allcontentid=array();

				/**
					首次存储需要更新的栏目ID
				*/
				if(isset($catid))
				{
					if(!is_array($catid))
					{
						$catid=cache_read('cat.cache.php',RETENG_ROOT.'data/cache_category/');
						foreach($catid as $_catid)
						{
							if($_catid['siteid']==SITEID)
							{
								$catsetting=getcatsetting($_catid['id']);
								if($_catid['type']==1)
								{
										$allcatid[]=$_catid['id'];
								}
							}
						}
					}
					else
					{
						if(in_array(0,$catid))
						{
							$catid=cache_read('finalcat.cache.php',RETENG_ROOT.'data/cache_category/');
							foreach($catid as $_catid)
							{
								if($_catid['siteid']==SITEID)
								{
									$catsetting=getcatsetting($_catid['id']);
									if($_catid['type']==1)
									{
										$allcatid[]=$_catid['id'];
									}
								}
							}
						}
						else
						{
							foreach($catid as $_catid)
							{
								$tcatid=get_childrencatid($_catid);
								foreach($tcatid as $_tcatid)
								{
									$catsetting=getcatsetting(intval($_tcatid));
									if(isfinalcatid($_tcatid))
									{
										$allcatid[]=intval($_tcatid);
									}
								}
							}
							$allcatid=array_unique($allcatid);
						}
					}
					$allcatid=array_map('intval',$allcatid);
					
					if(!$allcatid)
					{
						showmsg("请选择要更新的栏目!");
					}
					$sql="SELECT `".DB_PRE."content`.`id`,`".DB_PRE."content`.`catid` FROM `".DB_PRE."content`";
					$where=" WHERE `".DB_PRE."content`.`catid` IN (".implode(',',$allcatid).") AND `".DB_PRE."content`.`status`=1";
					if($type=='realate')
					{
						$where.=' ORDER BY `'.DB_PRE.'content`.`id` DESC LIMIT 0,'.intval($number);
					}

					if($type=='limit')
					{
						$where.=' AND `'.DB_PRE.'content`.`id` BETWEEN '.intval($fromid).' AND '.intval($toid);
					}

					$sql=$sql.$where;
					$allcontentid=$db->fetch_all($sql);
					$count=count($allcontentid);
					$pagecount=ceil($count/$pagesize);
					cache_write('user'.$_userid.'-contentid.cache.php',$allcontentid,RETENG_ROOT.'data/tmp/');
					$inlink=isset($inlink)?intval($inlink):0;
					showmsg('准备工作结束,开始更新内容...',ADMIN_FILE.'?file=html&action=content&do_submit=1&inlink='.$inlink.'&count='.$count.'&pagesize='.$pagesize.'&job='.$job,500);
				}
				/**
					开始 从缓存读取内容ID
				*/
				else
				{
					$allcontentid=cache_read('user'.$_userid.'-contentid.cache.php',RETENG_ROOT.'data/tmp/');
					
					if($allcontentid)
					{
						for($i=0;$i<min(intval($pagesize),count($allcontentid));$i++)
						{
							$nowcontentid=array_shift($allcontentid);
							$html->content($nowcontentid['id'],$inlink);
							cache_write('user'.$_userid.'-contentid.cache.php',$allcontentid,RETENG_ROOT.'data/tmp/');
						}
						
						showmsg("当前栏目 [".catname($nowcontentid['catid'])."], 共需更新 <font color='red'>$count</font> 个网页, 已更新 <font color='red'>".($count-count($allcontentid)+min(intval($pagesize),count($allcontentid)))."</font> 个网页（<font color='red'>".(round(($count-count($allcontentid)+min(intval($pagesize),count($allcontentid)))/$count,1)*100)."%</font>）",ADMIN_FILE.'?file=html&action=content&do_submit=1&inlink='.$inlink.'&count='.$count.'&pagesize='.$pagesize.'&job='.$job,0);
					}
					else
					{
						cache_delete('user'.$_userid.'-contentid.cache.php',RETENG_ROOT.'data/tmp/');
						if($job=='con')
						{
							showmsg('内容更新完毕, 开始更新Sitemaps...',ADMIN_FILE.'?file=html&action=rss&job=rss');
						}
						else
						{
							$html->cache_tag();
							showmsg('所有内容更新完毕!',ADMIN_FILE.'?file=html&action=content');
						}
					}
					
				}
			}
			require RETENG_ROOT.'/include/options.class.php';
			$options=new options();
			include admin_tlp('html_content');
			break;
		case 'rss':
			$job=isset($job)?$job:'';
			
			$html->sitemaphtml();

			$rss='<?xml version="1.0" encoding="UTF-8" ?>'."\n";
			$rss.='<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
			$rss.='<url>
  <loc>'.$RETENG['site_url'].'</loc> 
  <lastmod>'.date('Y-m-d').'</lastmod> 
  <changefreq>always</changefreq> 
  <priority>1.0</priority> 
  </url>';
			$r=cache_read('finalcat.cache.php',RETENG_ROOT.'data/cache_category/');
			if($r)foreach($r as $_r)
			{
				if($_r['siteid']==SITEID)
				{
					$rss.='<url>
	  <loc>'.$RETENG['site_url'].str_replace('&','&amp;',$_r['url']).'</loc> 
	  <lastmod>'.date('Y-m-d').'</lastmod> 
	  <changefreq>daily</changefreq> 
	  <priority>'.(!$_r['parentid']?'0.9':'0.8').'</priority> 
	  </url>';
					$content=$db->fetch_all("SELECT url,updatetime,posid FROM ".DB_PRE."content WHERE catid=".intval($_r['id'])." ORDER BY id DESC LIMIT 0,50");
					
					if($content)foreach($content as $_content)
					{
						$rss.='<url>
	  <loc>'.$RETENG['site_url'].str_replace('&','&amp;',$_content['url']).'</loc> 
	  <lastmod>'.date('Y-m-d',$_content['updatetime']).'</lastmod> 
	  <changefreq>monthly</changefreq> 
	  <priority>'.($_content['posid']?'0.7':'0.6').'</priority> 
	  </url>';
					}
				}
			}
			$rss.='</urlset>';

			file_put_contents(RETENG_ROOT.SITEDIR.'/sitemaps.xml',$rss);
			$filesize=round(filesize(RETENG_ROOT.SITEDIR.'/sitemaps.xml')/1024,2);

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
								$remotedir=str_replace('//','/',$remotedir);

								if($ftpobj->ftp_mkdir($remotedir))
								{
									$ftpobj->ftp_upload($remotedir.'sitemaps.xml',RETENG_ROOT.SITEDIR.'/sitemaps.xml');
								}
								$ftpobj->ftp_close();
							}
						}
					}
				}
			}
			if($job=='rss')
			{
				showmsg('Sitemaps 生成成功,一键更新完毕!',ADMIN_FILE.'?file=html&action=all');
			}
			else
			{
				showmsg_nourl('Sitemaps 生成成功! 文件大小: '.$filesize.'K');
			}
			break;
	}
?>
