<?php
/**
内容管理类
*/

error_reporting (E_ALL & ~E_NOTICE & ~E_WARNING);

class content
{
	public $pagestring;
	private $db;
	private $table;
	private $category_table;
	private $posid_table;
	private $c;

	function __construct()
	{
		global $db,$c;
		$this->db=$db;
		$this->c=$c;
		$this->table=DB_PRE.'content';
		$this->category_table=DB_PRE.'category';
		$this->posid_table=DB_PRE.'content_posid';
	}

	function content()
	{
		$this->__construct();
	}

	function checktitle($title,$id)
	{
		global $baselang;
		$id=intval($id);
		$title=iconv("UTF-8", "GBK//IGNORE", trim(addslashes($title)));

		if(!$title)
		{
			return $baselang['err-empty-title'];
		}

		$r=$this->db->fetch_one("SELECT `$this->table`.`id` FROM `$this->table` WHERE `$this->table`.`title`='{$title}'");
		if(!$r)
		{
			return $baselang['ok-title'];
		}
		else
		{
			if(!$id)
			{
				return $baselang['err-repeat-title'];
			}

			if($id==$r['id'])
			{
				return $baselang['ok-title'];
			}
			else
			{
				return $baselang['err-repeat-title'];
			}
		}
	}

	function set($id,$arr=array(),$more=false)
	{
		$id=intval($id);

		if(!$more)
		{
			return $this->db->update($this->table,$arr,'id='.intval($id));
		}
		else
		{
			$r=$this->get($id);
			$catinfo=cache_read('cat'.$r['catid'].'.cache.php',RETENG_ROOT.'data/cache_category/');
			$modelinfo=cache_read('model'.$catinfo['modelid'].'.cache.php',RETENG_ROOT.'data/c/');
			return $this->db->update(DB_PRE.$modelinfo['table'],$arr,'contentid='.intval($id));
		}
	}

	function datalist($catid=0,$field='title',$fieldvalue='',$stype='title',$k='')
	{
		global $category,$page;
		if(!class_exists('category') || !is_object($category))
		{
			require RETENG_ROOT.'include/admin/category.class.php';
			$category=new category();
		}

		$catid=intval($catid);
		$k=htmlspecialchars(trim($k));

		include RETENG_ROOT.'include/datalist.class.php';
		$datalist = new datalist();
		$where='siteid='.SITEID;
		$where=$catid?$where." AND catid=".$catid:$where;
		$where=isset($field) && $field?$where." AND {$field}='".intval($fieldvalue)."'":$where;
		if($stype=='title')
		{
			$where=!empty($k)?$where." AND	title like '%{$k}%'":$where;
		}
		else if($stype=='id')
		{
			$where=!empty($k)?$where." AND	id ='$k'":$where;
		}
		else
		{
			$where=!empty($k)?$where." AND	description like '%{$k}%'":$where;
		}
		$orderby='ID DESC';
		$page=max(isset($page)?intval($page):1,1);
		$pagesize=100;
		$result=$datalist->getlist($this->table,$where,$orderby,$page,$pagesize);
		$this->pagestring=$datalist->pagestring;
		return $result;
	}

	function userdatalist($catid=0,$k='')
	{
		global $category,$page,$_userid,$_username;
		if(!class_exists('category') || !is_object($category))
		{
			require RETENG_ROOT.'include/admin/category.class.php';
			$category=new category();
		}

		$catid=intval($catid);

		$k=htmlspecialchars(trim($k));

		include RETENG_ROOT.'include/datalist.class.php';
		$datalist = new datalist();
		$where='siteid='.SITEID.' AND username="'.$_username.'"';
		$where=$catid?$where.' AND '.getCatid($catid):$where;
		$where=!empty($k)?$where." AND	title like '%{$k}%'":$where;

		$orderby='orderby ASC, ID DESC';
		$page=max(isset($page)?intval($page):1,1);
		$pagesize=20;
		$result=$datalist->getlist($this->table,$where,$orderby,$page,$pagesize);
		$this->pagestring=$datalist->pagestring;
		return $result;
	}

	function top($id)
	{
		global $_point;

		if($_point < TOPPOINT)return false;
		$id=intval($id);
		if($id)
		{
			$min=$this->db->get_minfield($filed='orderby',$this->table);
			$this->db->query("UPDATE `$this->table` SET `$this->table`.`orderby`=".(intval($min)-1).",`$this->table`.`posid`=1 WHERE `$this->table`.`id`=$id");
			$this->db->mysql_delete($this->posid_table,$id,'contentid');
			$this->db->insert($this->posid_table, array('contentid'=>$id,'posid'=>4),true);
			return true;
		}
		return false;
	}

	function clear_order()
	{
		return $this->db->query("UPDATE `$this->table` SET `$this->table`.`orderby`=`$this->table`.`id` WHERE 1");
	}

	function getform($modelid ,$value=array())
	{
		include RETENG_ROOT.'include/form.class.php';
		$form = new form('info');
		return $form->get($modelid, $value);
	}

	function add($info)
	{
		global $_username, $_userid, $_roleid, $RETENG, $module,$install,$sitecrowdobj,$childsite,$hotWord;
		require_once RETENG_ROOT.'include/html.class.php';
		$html=new html();

		$updateinfo=array(); // 用于更新 主表

		/*
			$catinfo数组获取 所在栏目信息!
		*/

		if(!$info['catid'])return false;

		require_once RETENG_ROOT.'include/admin/category.class.php';
		$category=new category();
		$catinfo=$category->catinfo($info['catid']);
		$modelinfo=cache_read('model'.$catinfo['modelid'].'.cache.php',RETENG_ROOT.'data/c/');

		/*
			越权检查
		*/
		if(!isfinalcatid($info['catid'])) // 非最终子栏目
		{
			return -1;
		}
		//判断是否是管理员并设置相应只有管理员后台才有的字段
		if(!$_roleid)
		{
			$info['template']=$catinfo['setting']['temparticle'];
			$info['islink']=0;
			if(!$catinfo['ispost'])
			{
				return -3;
			}
		}
		$info['siteid']=SITEID;
		/*
			检查模板是否被指定
		*/
		if(!$info['template'])
		{
			$info['template']=$catinfo['setting']['temparticle'];
		}
		/*
			获取模型ID
		*/
		$info['modelid']=$catinfo['modelid'];

		/*
			安全过滤数据
		*/
		include_once RETENG_ROOT.'include/data.input.class.php';

		$datainput = new data_input($catinfo['modelid']);
		$info=$datainput->filter($info);
		$info['title']=sub_string($info['title'],160);
		$info['description']=$info['description']?$info['description']:$info['title'].','.$info['keywords'];
		$info['status']=$_userid?(isset($info['status'])?intval($info['status']):0):0;

		if(!$_userid && !$_roleid && !$module->module_disabled('post'))
		{
			include RETENG_ROOT.'post/data/config.inc.php';
			$info['status']=POST_VERIFY_ENABLED?0:1;
		}
		$info['point']=intval($info['point']);
		$info['amount']=floatval($info['amount']);
		$info['ispage']=isset($info['ispage']) && intval($info['ispage'])>=0?intval($info['ispage']):2;
		$info['pagecount']=isset($info['pagecount']) && intval($info['pagecount'])>0?intval($info['pagecount']):5000;

		//过滤非法词语
		$badwords=$this->db->fetch_one("SELECT `".DB_PRE."badwords`.`badwords` FROM `".DB_PRE."badwords` WHERE `".DB_PRE."badwords`.`id`=1");
		if($badwords)
		{
			$good=$bad=array();
			$badwords=explode("\r\n",trim($badwords['badwords']));
			if($badwords)foreach($badwords as $badword)
			{
				if($badword)
				{
					$badword=explode("=",$badword);
					$bad[]=$badword[0];
					$good[]=isset($badword[1])?$badword[1]:'***';
				}
			}
			foreach($info as $key =>$value)
			{
				$info[$key]=str_replace($bad,$good,$value);
			}
		}
		//系统默认字段
		$info['userid']=$_userid;
		$info['username']=$_username;
		$info['inputtime']=TIME;
		$info['updatetime']=TIME;
		$posids=array_map('intval',$info['posid']);
		unset($info['posid']);
		//内容加内链
		if(!$module->module_disabled('workbox'))
		{
			include_once RETENG_ROOT.'workbox/include/workbox.class.php';
			$workbox= new workbox();
			$info['content']=$workbox->addinlink($info['content']);
		}
		//添加到content主表
		$contentid=$id=$this->db->insert($this->table, $info);

		//2014-1-6更新tags
		if(!$module->module_disabled('tags'))
		{
			include_once RETENG_ROOT.'tags/include/tags.class.php';
			$tags= new tags();
			$keywords=$info['keywords'];
			if(trim($keywords))
			{
				$keywords=str_replace(',','|',str_replace('，','|',str_replace(' ','|',trim($keywords))));	
				$arraykey=explode('|',$keywords);
	
				if(is_array($arraykey))
				{
					foreach($arraykey as $a)
					{
						$rskey['catid']=$info['catid'];
						$rskey['tag']=$a;
						$rskey['contentid']=$contentid;
						$tags->tags_add($rskey);
					}
				}
			}
		}
		//更新推荐位
		if($posids)
		{
			$info['posid']=1;
			foreach($posids as $posid)
			{
				$this->db->insert($this->posid_table, array('contentid'=>$contentid,'posid'=>$posid),true);
			}
		}
		else
		{
			$info['posid']=0;
		}
		$updateinfo['orderby']=$contentid;

		//添加到附表 (附表可无限拓展)
		$info['contentid']=$contentid;
		$this->db->insert(DB_PRE.$modelinfo['table'], $info);

		//设置url 并静态化
		if(isset($info['islink']) && $info['islink'])
		{
			$updateinfo['url']=empty($info['url'])?SITE_URL:$info['url'];
		}
		else
		{
			$dir='';

			if(($catinfo['setting']['ishtml']==1 || $catinfo['setting']['ishtml']==2) && !$info['point'] && !$info['amount'])
			{
				include_once RETENG_ROOT.'/include/cnspell.class.php';
				$cnspell=new cnspell();
				$catinfo['setting']['urlrule']=strpos($catinfo['setting']['urlrule'],'.')?trim($catinfo['setting']['urlrule']):'{sitedir}html/{Y}{M}/a{cid}'.HTMLEXT;
				$updateinfo['url']=str_replace('{sitedir}',SITEDIR?SITEDIR.'/':'',$catinfo['setting']['urlrule']);
				$updateinfo['url']=str_replace('{catdir}',$catinfo['catdir'],$updateinfo['url']);
				$updateinfo['url']=str_replace('{Y}',date('Y',$info['inputtime']),$updateinfo['url']);
				$updateinfo['url']=str_replace('{M}',date('m',$info['inputtime']),$updateinfo['url']);
				$updateinfo['url']=str_replace('{D}',date('d',$info['inputtime']),$updateinfo['url']);
				$updateinfo['url']=str_replace('{timestamp}',$info['inputtime'],$updateinfo['url']);
				$updateinfo['url']=str_replace('{cid}',intval($contentid),$updateinfo['url']);
				$updateinfo['url']=str_replace('{pinyin}',$cnspell->getcnSpell($coninfo['title'],'GBK',0).intval($contentid),$updateinfo['url']);
				$updateinfo['url']=str_replace('{py}',$cnspell->getcnSpell($coninfo['title'],'GBK',1).intval($contentid),$updateinfo['url']);
				$updateinfo['url']=str_replace('\\','/',$updateinfo['url']);
				$updateinfo['url']=str_replace('//','/',$updateinfo['url']);

				if($catinfo['setting']['ishtml']==1)
				{
					makedir(dirname($updateinfo['url']));
					//默认审核通过的话, 生成html
					if($info['status']!=0 && !$info['islink'])
					{
						@extract($info,EXTR_SKIP);

						// 定义常用模板变量
						$reteng_postion=get_pos($info['catid']);
						$reteng_contentid=$contentid;
						$reteng_catname=$catinfo['catname'];
						$reteng_catid=$catid=$info['catid'];
						$reteng_url=$updateinfo['url'];
						$reteng_page='';
						$page_array=$page_t=array();
						$content = stripslashes($content);
						ob_start();
						if($info['ispage']==2) // 自动分页
						{
							$cons=preg_split('/<\/p>/i',$content);
							$conlen=0;
							$constr='';
							foreach($cons as $key => $con)
							{
								$constr.=$con.(substr(strtolower($con),-4)=='</p>'?'':'</p>');
								$conlen+=strlen($constr);
								if($conlen>$info['pagecount'] || ($key+1)==sizeof($cons))
								{
									if($constr)
									{
										$conarray[]=$constr;
									}
									$conlen=0;
									$constr='';
								}
							}
						}
						else if($info['ispage']==1) // 手动分页
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
									$page_array[$i]='<a href="'.$updateinfo['url'].'">'.$i.'</a>';
								}
								else
								{
									$page_array[$i]='<a href="'.dirname($updateinfo['url']).'/'.basename($updateinfo['url'],HTMLEXT).'_'.$i.HTMLEXT.'">'.$i.'</a>';
								}
							}
							$page_t=$page_array;
							foreach(glob(RETENG_ROOT.dirname($updateinfo['url']).'/'.basename($updateinfo['url'],'.'.get_fileext($updateinfo['url'])).'_*'.HTMLEXT) as $file_name)
							{
								if(basename($file_name))
								{
									@unlink($file_name);
								}
							}
							foreach($conarray as $conkey => $content)
							{
								$page_t[$conkey+1]=$conkey+1;
								$title=$conkey?$info['title'].'('.($conkey+1).')':$info['title'];
								$content_page=$reteng_page=implode('&nbsp;',$page_t);
								$page_t=$page_array;
								$url=dirname($updateinfo['url']).'/'.basename($updateinfo['url'],HTMLEXT).'_'.($conkey+1).HTMLEXT;
								include template($info['template']);
								$content=ob_get_contents();
								ob_clean();
								$file=RETENG_ROOT.$url;
								file_put_contents($file,$content);

								if($conkey==0)
								{
									@copy($file,RETENG_ROOT.$updateinfo['url']);
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
													$remotedir=$issueinfo['ftpdir'].'/'.dirname($updateinfo['url']).'/';
													$remotedir=str_replace('//','/',$remotedir);

													if($ftpobj->ftp_mkdir($remotedir))
													{
														$ftpobj->ftp_upload($remotedir.basename($file),$file);
														if($conkey==0)
														{
															$ftpobj->ftp_upload($remotedir.$updateinfo['url'],RETENG_ROOT.$updateinfo['url']);
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
							$file=RETENG_ROOT.$updateinfo['url'];
							include template($info['template']);
							$content=ob_get_contents();
							ob_clean();
							file_put_contents(RETENG_ROOT.$updateinfo['url'],$content);

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
												$remotedir=$issueinfo['ftpdir'].'/'.dirname($updateinfo['url']).'/';
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
			}
			else
			{
				$updateinfo['url']='/show/?id='.$contentid.($info['ispage']?'&page=1':'').'&siteid='.SITEID;
			}
		}
		//更新content主表
		$this->db->update($this->table, $updateinfo ,'id='.$contentid);
		//更新内容缓存
		$this->c->cache_tag();
		//更新网站首页
		if(ISHTML && AUTOCREATEINDEX)
		{
			$html->index();
		}
		//更新栏目
		if(AUTOCREATECATEGORY)
		{
			$totalcontent=get_cache_counts("SELECT COUNT(*) AS count FROM `".$this->table."` WHERE `".$this->table."`.`catid`=".$info['catid']);
			for($page=1;$page<=min(max(1,intval($totalcontent/$catinfo['setting']['listnum'])),max(100,intval(HTMLSIZE)));$page++)
			{
				$html->category($info['catid'],$page);
			}
			$html->category($catinfo['parentid']);
		}
		return true;
	}

	function edit($info ,$id)
	{
		global $_username, $module,$_userid, $_roleid,$RETENG,$install,$sitecrowdobj,$childsite,$hotWord;
		require_once RETENG_ROOT.'include/html.class.php';
		$html=new html();

		/*
			$catinfo数组获取 所在栏目信息!
		*/

		if(!$info['catid'])return false;
		require_once RETENG_ROOT.'include/admin/category.class.php';
		$category=new category();
		$catinfo=$category->catinfo($info['catid']);
		$modelinfo=cache_read('model'.$catinfo['modelid'].'.cache.php',RETENG_ROOT.'data/c/');
		$info['siteid']=SITEID;
		/*
			越权检查
		*/
		if(!isfinalcatid($info['catid'])) // 非最终子栏目
		{
			return -1;
		}

		/*
			判断是否是管理员并设置相应只有管理员后台才有的字段
		*/

		if(!$_roleid)
		{
			$info['template']=$catinfo['setting']['temparticle'];
			$info['islink']=0;
			if(!$catinfo['ispost'])
			{
				return -3;
			}
		}

		/*
			检查模板是否被指定
		*/
		if(!$info['template'])
		{
			$info['template']=$catinfo['setting']['temparticle'];
		}

		/*
			获取模型ID
		*/
		$info['modelid']=$catinfo['modelid'];

		/*
			安全过滤数据
		*/
		include RETENG_ROOT.'include/data.input.class.php';

		$datainput = new data_input($catinfo['modelid']);
		$info=$datainput->filter($info);
		$info['title']=sub_string($info['title'],160);
		$info['description']=$info['description']?$info['description']:$info['title'].','.$info['keywords'];
		$info['status']=intval($info['status']);
		$info['point']=intval($info['point']);
		$info['amount']=floatval($info['amount']);
		$info['ispage']=isset($info['ispage']) && intval($info['ispage'])>=0?intval($info['ispage']):2;
		$info['pagecount']=isset($info['pagecount']) && intval($info['pagecount'])>0?intval($info['pagecount']):5000;

		//过滤非法词语
		$badwords=$this->db->fetch_one("SELECT `".DB_PRE."badwords`.`badwords` FROM `".DB_PRE."badwords` WHERE `".DB_PRE."badwords`.`id`=1");
		if($badwords)
		{
			$good=$bad=array();
			$badwords=explode("\r\n",trim($badwords['badwords']));
			if($badwords)foreach($badwords as $badword)
			{
				if($badword)
				{
					$badword=explode("=",$badword);
					$bad[]=$badword[0];
					$good[]=isset($badword[1])?$badword[1]:'***';
				}
			}
			foreach($info as $key =>$value)
			{
				$info[$key]=str_replace($bad,$good,$value);
			}
		}

		//内容加内链
		if(!$module->module_disabled('workbox'))
		{
			include_once RETENG_ROOT.'workbox/include/workbox.class.php';
			$workbox= new workbox();
			$info['content']=$workbox->addinlink($info['content']);
		}

		//系统默认字段
		$info['updatetime']=TIME;
		$posids=array_map('intval',$info['posid']);
		unset($info['posid']);

		//更新推荐位
		$this->db->mysql_delete($this->posid_table,$id,'contentid');

		if($posids)
		{
			$info['posid']=1;
			foreach($posids as $posid)
			{
				$this->db->insert($this->posid_table, array('contentid'=>$id,'posid'=>$posid),true);
			}
		}
		else
		{
			$info['posid']=0;
		}
		//更新附表 (附表可无限拓展)
		$this->db->update(DB_PRE.$modelinfo['table'], $info ,'contentid='.$id);

		//获取发布时间
		if(!$_roleid || isset($info['inputtime']) || $info['inputtime'])
		{
			$coninfo=$this->get($id,false);
			$info['inputtime']=$coninfo['inputtime'];
		}

		$info['islink']=isset($info['islink'])?intval($info['islink']):0;
		/*
			设置url 并静态化
		*/
		if($info['islink'])
		{
			$info['url']=empty($info['url'])?SITE_URL:$info['url'];
		}
		else
		{
			$dir='';

			if(($catinfo['setting']['ishtml']==1 || $catinfo['setting']['ishtml']==2) && !$info['point'] && !$info['amount'])
			{
				include_once RETENG_ROOT.'/include/cnspell.class.php';
				$cnspell=new cnspell();
				$catinfo['setting']['urlrule']=strpos($catinfo['setting']['urlrule'],'.')?trim($catinfo['setting']['urlrule']):'{sitedir}html/{Y}{M}/a{cid}'.HTMLEXT;
				$info['url']=str_replace('{sitedir}',SITEDIR?SITEDIR.'/':'',$catinfo['setting']['urlrule']);
				$info['url']=str_replace('{catdir}',$catinfo['catdir'],$info['url']);
				$info['url']=str_replace('{Y}',date('Y',$info['inputtime']),$info['url']);
				$info['url']=str_replace('{M}',date('m',$info['inputtime']),$info['url']);
				$info['url']=str_replace('{D}',date('d',$info['inputtime']),$info['url']);
				$info['url']=str_replace('{timestamp}',$info['inputtime'],$info['url']);
				$info['url']=str_replace('{cid}',intval($id),$info['url']);
				$info['url']=str_replace('{pinyin}',$cnspell->getcnSpell($info['title'],'GBK',0).intval($id),$info['url']);
				$info['url']=str_replace('{py}',$cnspell->getcnSpell($info['title'],'GBK',1).intval($id),$info['url']);
				$info['url']=str_replace('\\','/',$info['url']);
				$info['url']=str_replace('//','/',$info['url']);

				if($catinfo['setting']['ishtml']==1)
				{
					makedir(dirname($info['url']));
					//默认审核通过的话, 生成html
					if($info['status']!=0 && !$info['islink'])
					{
						@extract($info,EXTR_SKIP);

						// 定义常用模板变量
						$reteng_postion=get_pos($info['catid']);
						$reteng_contentid=$id;
						$reteng_catname=$catinfo['catname'];
						$reteng_catid=$catid=$info['catid'];
						$reteng_url=$info['url'];
						$reteng_page='';
						$page_array=$page_t=array();

						$content = stripslashes($content);
						ob_start();

						if($info['ispage']==2) // 自动分页
						{
							$cons=preg_split('/<\/p>/i',$content);
							$conlen=0;
							$constr='';
							foreach($cons as $key => $con)
							{
								$constr.=$con.(substr(strtolower($con),-4)=='</p>'?'':'</p>');
								$conlen+=strlen($constr);
								if($conlen>$info['pagecount'] || ($key+1)==sizeof($cons))
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
						else if($info['ispage']==1) // 手动分页
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
									$page_array[$i]='<a href="'.$info['url'].'">'.$i.'</a>';
								}
								else
								{
									$page_array[$i]='<a href="'.dirname($info['url']).'/'.basename($info['url'],HTMLEXT).'_'.$i.HTMLEXT.'">'.$i.'</a>';
								}
							}
							$page_t=$page_array;
							foreach(glob(RETENG_ROOT.dirname($info['url']).'/'.basename($info['url'],'.'.get_fileext($info['url'])).'_*'.HTMLEXT) as $file_name)
							{
								if(basename($file_name))
								{
									@unlink($file_name);
								}
							}
							foreach($conarray as $conkey => $content)
							{
								$page_t[$conkey+1]=$conkey+1;
								$title=$conkey?$info['title'].'('.($conkey+1).')':$info['title'];
								$content_page=$reteng_page=implode('&nbsp;',$page_t);
								$page_t=$page_array;
								$url=dirname($info['url']).'/'.basename($info['url'],HTMLEXT).'_'.($conkey+1).HTMLEXT;
								include template($info['template']);
								$content=ob_get_contents();
								ob_clean();

								$file=RETENG_ROOT.$url;
								file_put_contents($file,$content);

								if($conkey==0)
								{
									@copy($file,RETENG_ROOT.$info['url']);
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
													$remotedir=$issueinfo['ftpdir'].'/'.dirname($info['url']).'/';
													$remotedir=str_replace('//','/',$remotedir);
													if($ftpobj->ftp_mkdir($remotedir))
													{
														$ftpobj->ftp_upload($remotedir.basename($file),$file);
														if($conkey==0)
														{
															$ftpobj->ftp_upload($remotedir.$info['url'],RETENG_ROOT.$info['url']);
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
							$file=RETENG_ROOT.$info['url'];
							include template($info['template']);
							$content=ob_get_contents();
							ob_clean();
							file_put_contents(RETENG_ROOT.$info['url'],$content);

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
												$remotedir=$issueinfo['ftpdir'].'/'.dirname($info['url']).'/';
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
				/*
					更新内容缓存
				*/
				$this->c->cache_tag();

				/*
					更新网站首页
				*/
				if(ISHTML && AUTOCREATEINDEX)
				{
					$html->index();
				}

				/*
					更新栏目
				*/
				if(AUTOCREATECATEGORY)
				{
					$totalcontent=get_cache_counts("SELECT COUNT(*) AS count FROM `".$this->table."` WHERE `".$this->table."`.`catid`=".$info['catid']);
					for($page=1;$page<=min(max(1,intval($totalcontent/$catinfo['setting']['listnum'])),max(100,intval(HTMLSIZE)));$page++)
					{
						$html->category($info['catid'],$page);
					}
					$html->category($catinfo['parentid']);
				}
			}
			else
			{
				$info['url']='/show/?id='.$id.($info['ispage']?'&page=1':'').'&siteid='.SITEID;
			}
		}
		//更新content主表
		$this->db->update($this->table, $info ,'id='.$id);
		//2014-1-6更新tags
		if(!$module->module_disabled('tags'))
		{
			include_once RETENG_ROOT.'tags/include/tags.class.php';
			$tags= new tags();
			$tags->tags_del($id);
			$keywords=trim($info['keywords']);
			if($keywords)
			{
				$keywords=str_replace(',','|',str_replace('，','|',str_replace(' ','|',$keywords)));	
				$arraykey=explode('|',$keywords);
				if(is_array($arraykey))
				{
					foreach($arraykey as $a)
					{
						$rskey['catid']=$info['catid'];
						$rskey['tag']=$a;
						$rskey['contentid']=$id;
						$tags->tags_add($rskey);
					}
				}
			}
		}
		return true;
	}

	function setordeyby($orderby)
	{
		if($orderby)
		{
			foreach($orderby as $id => $value)
			{
				$this->db->update($this->table, array('orderby'=>intval($value)) ,'id='.intval($id));
			}
			return true;
		}
		else
		{
			return false;
		}
	}

	function pass($ids)
	{
		if($ids)
		{
			$ids=is_array($ids)?$ids:array($ids);
			require_once RETENG_ROOT.'include/html.class.php';
			$html=new html();

			foreach($ids as $id)
			{
				$this->db->update($this->table, array('status'=>1) ,'id='.intval($id));
				//生成静态文件
				$html->content(intval($id));
			}
			//更新内容缓存
			$this->c->cache_tag();
			return true;
		}
		else
		{
			return false;
		}
	}

	function html($ids)
	{
		if($ids)
		{
			$ids=is_array($ids)?$ids:array($ids);
			require_once RETENG_ROOT.'include/html.class.php';
			$html=new html();
			foreach($ids as $id)
			{
				$html->content(intval($id));
			}
			return true;
		}
		else
		{
			return false;
		}
	}

	function unpass($ids)
	{
		global $sitecrowdobj,$childsite;

		if($ids)
		{
			$ids=is_array($ids)?$ids:array($ids);
			foreach($ids as $id)
			{
				$id=intval($id);

				$this->db->update($this->table, array('status'=>0) ,'id='.intval($id));
				//删除静态文件
				$coninfo=$this->get($id);

				$indexpage=RETENG_ROOT.$coninfo['url'];

				if(!empty($coninfo['url']) && !$coninfo['islink'] && in_array('.'.get_fileext($coninfo['url']),array('.html','.htm','.shtml')))
				{
					if(file_exists($indexpage))
					{
						@unlink($indexpage);
						if($coninfo['ispage']!=0)
						{
							$i=1;
							$listpage=RETENG_ROOT.dirname($coninfo['url']).'/'.basename($coninfo['url'],'.'.get_fileext($coninfo['url'])).'_1'.HTMLEXT;
							$file=dirname($listpage).'/'.substr(basename($listpage,HTMLEXT),0,-1).$i.HTMLEXT;

							while(file_exists($file))
							{
								@unlink($file);
								$i++;
								$file=dirname($listpage).'/'.substr(basename($listpage,HTMLEXT),0,-1).$i.HTMLEXT;
							}
						}
					}
					//删除远程发布点数据
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
										$ftpobj->ftp_delete($issueinfo['ftpdir'].'/'.$indexpage);
										if($coninfo['ispage']!=0)
										{
											$i=1;
											$listpage=$issueinfo['ftpdir'].'/'.dirname($coninfo['url']).'/'.basename($coninfo['url'],'.'.get_fileext($coninfo['url'])).'_1'.HTMLEXT;
											$file=dirname($listpage).'/'.substr(basename($listpage,HTMLEXT),0,-1).$i.HTMLEXT;

											while($ftpobj->ftp_delete($issueinfo['ftpdir'].'/'.$file))
											{
												$i++;
												$file=dirname($listpage).'/'.substr(basename($listpage,HTMLEXT),0,-1).$i.HTMLEXT;
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

			/*
				更新内容缓存
			*/
			$this->c->cache_tag();
			return true;
		}
		else
		{
			return false;
		}
	}

	function delete_html($ids) // 删除生成的内容HTML页
	{
		global $sitecrowdobj,$childsite;

		if($ids)
		{
			$ids=is_array($ids)?$ids:array($ids);
			foreach($ids as $id)
			{
				$id=intval($id);
				$coninfo=$this->get($id);
				$indexpage=RETENG_ROOT.$coninfo['url'];

				if(!empty($coninfo['url']) && !$coninfo['islink'] && in_array('.'.get_fileext($coninfo['url']),array('.html','.htm','.shtml')))
				{
					if(file_exists($indexpage))
					{
						@unlink($indexpage);
						if($coninfo['ispage']!=0)
						{
							$i=2;
							$listpage=RETENG_ROOT.dirname($coninfo['url']).'/'.basename($coninfo['url'],'.'.get_fileext($coninfo['url'])).'_1'.HTMLEXT;
							$file=dirname($listpage).'/'.substr(basename($listpage,HTMLEXT),0,-1).$i.HTMLEXT;

							while(file_exists($file))
							{
								@unlink($file);
								$i++;
								$file=dirname($listpage).'/'.substr(basename($listpage,HTMLEXT),0,-1).$i.HTMLEXT;
							}
						}
					}

					/*
						删除远程发布点数据
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
										$ftpobj->ftp_delete($issueinfo['ftpdir'].'/'.$indexpage);
										if($coninfo['ispage']!=0)
										{
											$i=1;
											$listpage=$issueinfo['ftpdir'].'/'.dirname($coninfo['url']).'/'.basename($coninfo['url'],'.'.get_fileext($coninfo['url'])).'_1'.HTMLEXT;
											$file=dirname($listpage).'/'.substr(basename($listpage,HTMLEXT),0,-1).$i.HTMLEXT;

											while($ftpobj->ftp_delete($issueinfo['ftpdir'].'/'.$file))
											{
												$i++;
												$file=dirname($listpage).'/'.substr(basename($listpage,HTMLEXT),0,-1).$i.HTMLEXT;
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
			return true;
		}
		else
		{
			return false;
		}
	}

	function delete($ids,$user='admin',$nocache=false)
	{
		global $_userid,$_username,$ftpobj,$module,$install;
		if($ids)
		{
			$ids=is_array($ids)?$ids:array($ids);
			foreach($ids as $id)
			{
				$id=intval($id);
				$coninfo=$this->get($id,true);
				//删除字段中出现的本地图片
				foreach($coninfo as $con)
				{
					if(is_image($con))
					{
						if(substr($con,0,15)=='/data/attached/')
						{
							@unlink(RETENG_ROOT.$con);
						}
						else if(substr($con,0,(strlen(RETENG_PATH)+15))==RETENG_PATH.'/data/attached/')
						{
							@unlink(RETENG_ROOT.substr($con,strlen(RETENG_PATH)));
						}
					}
					else
					{
						$ims=get_images($con);
						if($ims)foreach($ims as $im)
						{
							if(substr($im,0,15)=='/data/attached/')
							{
								@unlink(RETENG_ROOT.$im);
							}
							else if(substr($im,0,(strlen(RETENG_PATH)+15))==RETENG_PATH.'/data/attached/')
							{
								@unlink(RETENG_ROOT.substr($im,strlen(RETENG_PATH)));
							}
						}
					}
				}
				//安全检测
				if($coninfo['username']!=$_username && $user!='admin')
				{
					return false;
				}

				/*
					开始删除操作
				*/

				
				//删除静态文件
				$this->delete_html($id);

				/**
					删除数据库
				*/

				$catinfo=cache_read('cat'.$coninfo['catid'].'.cache.php',RETENG_ROOT.'data/cache_category/');
				$modelinfo=cache_read('model'.$catinfo['modelid'].'.cache.php',RETENG_ROOT.'data/c/');
				if($modelinfo && isset($modelinfo['table']))
				{
					$this->db->mysql_delete($this->table,$id);
					$this->db->mysql_delete(DB_PRE.$modelinfo['table'],$id,'contentid');
				}
				else
				{
					$this->db->mysql_delete($this->table,$id);
				}

			     //删除缩略图
				if($coninfo['thumb'] && $_userid==$coninfo['userid'])
				{
					if(!FTP)
					{
						@unlink(RETENG_ROOT.$coninfo['thumb']);
					}
					else
					{
						$ftpobj->ftp_delete(FTP_DIR.'/'.str_replace(FTP_URL.'/','',$coninfo['thumb']));
					}
				}
				//删除tag开始
				if($coninfo['keywords'])
				{
					if(!$module->module_disabled('tags'))
					{
						include_once RETENG_ROOT.'tags/include/tags.class.php';
						$tags= new tags();
						$keywords=$coninfo['keywords'];
						if($keywords)
						{
							$keywords=str_replace(',','|',str_replace('，','|',str_replace(' ','|',$keywords)));	
							$arraykey=explode('|',$keywords);
							if(is_array($arraykey))
							{
								foreach($arraykey as $a)
								{
									$tags->tags_del_by_tag($a);
								}
							}
						}
					}
				}
				//删除tag结束
			}

			if(!$nocache)
			{
				/*
					更新内容缓存
				*/
				$this->c->cache_tag();
			}
			return true;
		}
		else
		{
			return false;
		}
	}

	function move($checkedid=array(),$movetocatid=0)
	{
		$movetocatid=intval($movetocatid);
		if(!$checkedid || !$movetocatid)return false;
		if(!isfinalcatid($movetocatid))return -2;
		//$updateinfo数组用于存贮要更新的字段
		$dir='';
		$updateinfo=array();
		$updateinfo['catid']=$movetocatid;

		require_once RETENG_ROOT.'include/content.class.php';
		$conobj=new content();

		require RETENG_ROOT.'include/cnspell.class.php';
		$cnspell=new cnspell();
		/*
			目标栏目信息
		*/
		$movetocatinfo=cache_read('cat'.$movetocatid.'.cache.php',RETENG_ROOT.'data/cache_category/');
		if(!$movetocatinfo)return false;

		$movetocatinfo['setting']=getcatsetting($movetocatid);
		$movetomodelinfo=cache_read('model'.$movetocatinfo['modelid'].'.cache.php',RETENG_ROOT.'data/c/');

		$updateinfo['modelid']=$movetocatinfo['modelid'];
		$updateinfo['template']=$movetocatinfo['setting']['temparticle'];

		foreach($checkedid as $id)
		{
			/*
				获取内容信息
			*/
			$id=intval($id);
			$coninfo=$conobj->get($id);

			/*
				源栏目信息
			*/
			$sourcecatinfo=cache_read('cat'.$coninfo['catid'].'.cache.php',RETENG_ROOT.'data/cache_category/');
			$sourcecatinfo['setting']=getcatsetting($coninfo['catid']);
			$sourcemodelinfo=cache_read('model'.$sourcecatinfo['modelid'].'.cache.php',RETENG_ROOT.'data/c/');

			/*
				假如更换了URL规则
			*/
			if($movetocatinfo['setting']['urlrule']!=$sourcecatinfo['setting']['urlrule'])
			{
				/*
					获取新的URL
				*/
				include_once RETENG_ROOT.'/include/cnspell.class.php';
				$cnspell=new cnspell();
				$movetocatinfo['setting']['urlrule']=strpos($movetocatinfo['setting']['urlrule'],'.')?trim($movetocatinfo['setting']['urlrule']):'{sitedir}html/{Y}{M}/a{cid}'.HTMLEXT;
				$updateinfo['url']=str_replace('{sitedir}',SITEDIR?SITEDIR.'/':'',$movetocatinfo['setting']['urlrule']);
				$updateinfo['url']=str_replace('{catdir}',$movetocatinfo['catdir'],$updateinfo['url']);
				$updateinfo['url']=str_replace('{Y}',date('Y',$coninfo['inputtime']),$updateinfo['url']);
				$updateinfo['url']=str_replace('{M}',date('m',$coninfo['inputtime']),$updateinfo['url']);
				$updateinfo['url']=str_replace('{D}',date('d',$coninfo['inputtime']),$updateinfo['url']);
				$updateinfo['url']=str_replace('{timestamp}',$coninfo['inputtime'],$updateinfo['url']);
				$updateinfo['url']=str_replace('{cid}',intval($id),$updateinfo['url']);
				$updateinfo['url']=str_replace('{pinyin}',$cnspell->getcnSpell($coninfo['title'],'GBK',0).intval($id),$updateinfo['url']);
				$updateinfo['url']=str_replace('{py}',$cnspell->getcnSpell($coninfo['title'],'GBK',1).intval($id),$updateinfo['url']);
				$updateinfo['url']=str_replace('\\','/',$updateinfo['url']);
				$updateinfo['url']=str_replace('//','/',$updateinfo['url']);

				makedir(dirname($updateinfo['url']));

				/*
					删除旧的HTML文件
				*/
				$this->delete_html($id);
			}

			/*
				假如更换了模型
			*/
			if($movetocatinfo['modelid']!=$sourcecatinfo['modelid'])
			{
				$coninfo=array_merge($coninfo,$this->db->fetch_one("SELECT * FROM `".DB_PRE.$sourcemodelinfo['table']."` WHERE `".DB_PRE.$sourcemodelinfo['table']."`.`contentid`=$id"));
				/*
					删除旧附加表数据
				*/

				$this->db->mysql_delete(DB_PRE.$sourcemodelinfo['table'],$id,'contentid');
				/*
					添加新附加表数据
				*/
				$this->db->insert(DB_PRE.$movetomodelinfo['table'],$coninfo,true);

				/*
					删除旧的HTML文件
				*/
				$this->delete_html($id);
			}

			/*
				更新内容表
			*/
			$this->db->update($this->table,$updateinfo,'id='.$id);

			/*
				更新 HTML
			*/
			require_once RETENG_ROOT.'include/html.class.php';
			$html=new html();
			$html->content($id);
		}
		/*
			更新内容缓存
		*/
		$this->c->cache_tag();
		return true;
	}

	function preview($info)
	{
		global $RETENG,$_username, $_userid, $_roleid;
		$contentid=0;

		$updateinfo=array(); // 用于拓展数据

		/*
			$catinfo数组获取 所在栏目信息!
		*/

		if(!$info['catid'])return false;
		require_once RETENG_ROOT.'include/admin/category.class.php';
		$category=new category();
		$catinfo=$category->catinfo($info['catid']);
		$modelinfo=cache_read('model'.$catinfo['modelid'].'.cache.php',RETENG_ROOT.'data/c/');

		/*
			越权检查
		*/
		if(!isfinalcatid($info['catid'])) // 非最终子栏目
		{
			return false;
		}

		/*
			判断是否是管理员并设置相应只有管理员后台才有的字段
		*/

		if(!$_roleid)
		{
			$info['template']=$catinfo['setting']['temparticle'];
			$info['islink']=0;
		}

		/*
			获取模型ID
		*/
		$info['modelid']=$catinfo['modelid'];

		/*
			安全过滤数据
		*/
		include RETENG_ROOT.'include/data.input.class.php';

		$datainput = new data_input($catinfo['modelid']);
		$info=$datainput->filter($info);
		$info['title']=sub_string($info['title'],160);
		$info['status']=intval($info['status']);
		$info['point']=intval($info['point']);
		$info['amount']=floatval($info['amount']);
		$info['ispage']=intval($info['ispage']);
		$info['pagecount']=intval($info['pagecount'])>0?intval($info['pagecount']):1000;

		/*
			获取系统默认字段
		*/
		$info['userid']=$_userid;
		$info['username']=$_username;
		$info['inputtime']=TIME;
		$info['updatetime']=TIME;

		/*
			获取url
		*/
		$info['url']='?file=content&action=preview';
		@extract($info);
		/*
			定义常用模板变量
		*/
		$reteng_postion=get_pos($info['catid']);
		$reteng_contentid=$id;
		$reteng_catname=$catinfo['catname'];
		$reteng_catid=$catid=$info['catid'];
		$reteng_url=$info['url'];
		$reteng_page='';
		$conarray=$page_array=array();

		if($info['ispage']==2) // 自动分页
		{
			$conarray=strsplit($info['content'] ,$info['pagecount']);
		}
		else if($info['ispage']==1) // 手动分页
		{
			$conarray=preg_split('/#page_break_tag#/',$info['content']);
		}
		else // 不分页
		{
			$conarray=array();
		}

		if(sizeof($conarray)>1)
		{
			$page=isset($page) && intval($page)?max(1,intval($page)):1;
			$page=min(sizeof($conarray),intval($page));
			$cururl=preg_replace('/([&\?]?)(page=[0-9]+)([&\?]?)/i','\\1',getcururl());
			$cururl=substr($cururl,-1)=='&'?$cururl:$cururl.'&';
			for($i=1;$i<=sizeof($conarray);$i++)
			{
				if($page==$i)
				{
					$page_array[]=$i;
				}
				else
				{
					$page_array[]='<a href="'.$cururl.'page='.$i.'">'.$i.'</a>';
				}
			}
			$t=max(0,$page-1);
			$content=$conarray[$t];
		}
		$content_page=$reteng_page=implode('&nbsp;',$page_array);
		include template($template);
	}

	function support($ids,$posid=array())
	{
		$ids=is_array($ids)?array_map('intval',$ids):array(intval($ids));
		$posid=is_array($posid)?array_map('intval',$posid):array();
		if(!$ids)return false;

		/*
			删除旧的推荐位
		*/
		$this->db->mysql_delete($this->posid_table,$ids,'contentid');

		foreach($ids as $id)
		{
			if($posid)
			{
				foreach($posid as $_posid)
				{
					$this->db->insert($this->posid_table,array('contentid'=>$id,'posid'=>$_posid));
				}
				$this->db->update($this->table,array('posid'=>1),'id='.$id);
			}
			else
			{
				$this->db->update($this->table,array('posid'=>0),'id='.$id);
			}
		}
		/*
			更新内容缓存
		*/
		$this->c->cache_tag();
		return true;
	}

	function get($contentid,$more=false,$modelid=0,$catid=0)
	{
		$contentid=intval($contentid);
		$catid=intval($catid);
		$modelid=intval($modelid);

		if(!$more)
		{
			return $this->db->fetch_one("SELECT * FROM `$this->table` WHERE `$this->table`.`id`=$contentid");
		}
		else
		{
			$modelinfo=array();
			if($modelid)
			{
				$modelinfo=cache_read('model'.$modelid.'.cache.php',RETENG_ROOT.'data/c/');
				if($modelinfo && isset($modelinfo['table']))
				{
					return $this->db->fetch_one("SELECT * FROM `$this->table` a LEFT JOIN `".DB_PRE.$modelinfo['table']."` b ON a.id=b.contentid WHERE a.`id`=$contentid");
				}
			}

			if($catid)
			{
				$catinfo=cache_read('cat'.$catid.'.cache.php',RETENG_ROOT.'data/cache_category/');
				$modelinfo=cache_read('model'.$catinfo['modelid'].'.cache.php',RETENG_ROOT.'data/c/');
				if($modelinfo && isset($modelinfo['table']))
				{
					return $this->db->fetch_one("SELECT * FROM `$this->table` a LEFT JOIN `".DB_PRE.$modelinfo['table']."` b ON a.id=b.contentid WHERE a.`id`=$contentid");
				}
			}
			$r=$this->db->fetch_one("SELECT * FROM `$this->table` WHERE `$this->table`.`id`=$contentid");
			if($r)
			{
				$catinfo=cache_read('cat'.$r['catid'].'.cache.php',RETENG_ROOT.'data/cache_category/');
				$modelinfo=cache_read('model'.$catinfo['modelid'].'.cache.php',RETENG_ROOT.'data/c/');
				if($modelinfo && isset($modelinfo['table']))
				{
					return $this->db->fetch_one("SELECT * FROM `$this->table` a LEFT JOIN `".DB_PRE.$modelinfo['table']."` b ON a.id=b.contentid WHERE a.`id`=$contentid");
				}
			}
			else
			{
				return array();
			}
		}
	}
}
?>