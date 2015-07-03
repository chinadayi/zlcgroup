<?php
/**
* 栏目管理类
*/
error_reporting (E_ALL & ~E_NOTICE & ~E_WARNING);

class category
{
	public $pagestring;
	private $db;
	private $table;
	private $content_table;
	private $c;

	function __construct()
	{
		global $db,$c;
		$this->db=$db;
		$this->c=$c;
		$this->table=DB_PRE.'category';
		$this->content_table=DB_PRE.'content';
	}

	function category()
	{
		$this->__construct();
	}

	function datalist($parentid=0)
	{
		global $check_admin,$_roleid,$_userid;
		$parentid=intval($parentid);
		$r=cache_read('cat_parent'.$parentid.'.cache.php',RETENG_ROOT.'data/cache_category/');
		if(!$r)
		{
			return false;
		}
		else
		{
			foreach($r as $_r)
			{
				if($_r['siteid']==SITEID)
				{
					if(($_r['type']==1 || $_r['type']==2 || $_r['type']==4) && $check_admin->category_permission_check($_userid,$_r['id']))
					{
					
						if($_r['type']==1 || $r_['modelid']>0)
						{
							$adminurl='?file=content&action=manage&catid='.$_r['id'];
						}else
						{
							$adminurl='?file=category&action=edit&id='.$_r['id'];
						}
						echo '<tr>
						<td align="center"><input type="hidden" size="4" name="catid[]" value="'.$_r['id'].'"/><input type="text" size="4" name="orderby['.$_r['id'].']" value="'.$_r['orderby'].'"/></td>
						<td align="center">'.$_r['id'].'</td>
						<td align="left">'.str_repeat('&nbsp;',($_r['m']-1)*4).'|-<a href="'.$adminurl.'">'.$_r['catname'].'</a>'.($_r['type']==4?' <font color="#FF0000">[外链]</font>':'').'</td>';
						if($_r['type']==2)
						{
							echo '<td align="center">单页</td>';
						}else
						{
						
						echo '<td align="center">'.($_r['ispost'] && $_r['type']!=4?'已启用 | <a href="?file=category&action=setispost&ispost=0&id='.$_r['id'].'"><u>禁用</u></a>':'<font color="#666666">已禁用</font> | '.($_r['type']==4?'<font color="#666666">启用</font>':'<a href="?file=category&action=setispost&ispost=1&id='.$_r['id'].'"><u>启用</u></a>')).'</td>';
						}
						
						echo '<td align="center">'.($_r['ismenu']?'已启用 | <a href="?file=category&action=setismenu&ismenu=0&id='.$_r['id'].'"><u>禁用</u></a>':'<font color="#666666">已禁用</font> | <a href="?file=category&action=setismenu&ismenu=1&id='.$_r['id'].'"><u>启用</u></a>').'</td>
						<td align="center"><a href="'.$_r['url'].'" target="_blank">访问</a></td>
						<td align="center">
						<a href="?file=category&action=add&parentid='.$_r['id'].'"><u>添加子栏目</u></a> |
						<a href="?file=category&action=edit&id='.$_r['id'].'"><u>配置</u></a> |
						<a href="?file=category&action=delete&id='.$_r['id'].'"  onclick="if(!confirm(\'确实要删除栏目 '.$_r['catname'].' 吗?\')){return false;}"><u>删除</u></a>
						|
					<a href="/list/?id='.$_r['id'].'" target="_blank"><u>查看</u></a>
						</td>
					</tr>';
						$this->datalist($_r['id']);
					}
				}
			}
		}
	}

	function add($info,$cache=true)
	{
		global $RETENG,$install,$sitecrowdobj,$childsite,$hotWord;
				
		$info['siteid']=SITEID;

		$info['type']=isset($info['type'])?intval($info['type']):1;

		/*
			设置栏目目录 及菜单等级
		*/
		if($info['parentid'])
		{
			$r=cache_read('cat'.$info['parentid'].'.cache.php',RETENG_ROOT.'data/cache_category/');
			$info['m']=$r['m']+1;
			$parcatdir=$r['catdir'].'/';
		}
		else
		{
			$info['m']=1;
			$parcatdir='';
		}
		
		if($info['type']==4)
		{
			if(!$info['catname'])
			{
				return false;
			}
			$info['ispost']=0;
			$info['catdir']='';
			$info['setting']=var_export($info['setting'],true);
			$this->db->insert($this->table,$info);
		}
		else
		{
			if(!$info['modelid'] || !$info['catname'] || !$info['catdir']) return false;
			$info['domain']=trim($info['domain']);
			$info['image']=$info['image']?$info['image']:'images/image128x128.png';
			$info['catdir']=$info['catdir'];
			$info['catdir']=str_replace(' ','',$info['catdir']);
			$info['catdir']=str_replace('{sitedir}',SITEDIR?SITEDIR.'/':'',$info['catdir']);
			$info['catdir']=str_replace('{parcatdir}',$parcatdir,$info['catdir']);
			$info['catdir']=str_replace('//','/',str_replace('\\','/',trim($info['catdir']).'/'));

			while($this->checkdir($info['catdir'])) // 防止文件夹重复
			{
				$info['catdir']=substr($info['catdir'],0,-1).mt_rand(1,9999).'/';
			}
			
			/*	
				获取拓展数据
			*/
			if($info['extendkey'])foreach($info['extendkey'] as $key => $value)
			{
				$value=trim($value);
				if($value)
				{
					$info['expand'][$value]=htmlspecialchars($info['extendvalue'][$key]);
				}
			}
			$info['expand']=isset($info['expand'])?var_export($info['expand'],true):'';

			if($info['setting']['catishtml']==1)
			{
				makedir($info['catdir']); // 如果是静态化的则生成文件夹!

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
									$remotedir=$issueinfo['ftpdir'].'/'.$info['catdir'];
									$remotedir=str_replace('//','/',$remotedir);
									$ftpobj->ftp_mkdir($remotedir);
									$ftpobj->ftp_close();
								}
							}
						}
					}
				}
			}

			/*
				插入数据库
			*/
			$ishtml=$info['setting']['catishtml'];
			$listurlrule=$info['setting']['listurlrule'];
			$catdir=$info['catdir'];
			$domain=$info['domain'];

			$info['setting']=var_export($info['setting'],true);
			$catid=$this->db->insert($this->table,$info);
			
			if(!$catid)return false;

			/*
				设置栏目URL 以及 排序
			*/
			unset($info);
			if($domain)
			{
				$info['url']=$domain;
			}
			else
			{
				if($ishtml==1)
				{
					$info['url']=$catdir;
				}
				else if($ishtml==2)
				{
					$listurlrule=$listurlrule?$listurlrule:'{sitedir}{catdir}list_{page}'.HTMLEXT;
					$listurlrule=str_replace('{sitedir}',SITEDIR?SITEDIR.'/':'',$listurlrule);
					$listurlrule=str_replace('{tid}',$catid,$listurlrule);
					$listurlrule=str_replace('{page}','1',$listurlrule);
					$listurlrule=str_replace('{catdir}',$catdir,$listurlrule);
					$listurlrule=str_replace('\\','/',$listurlrule);
					$listurlrule=str_replace('//','/',$listurlrule);
					$info['url']=$listurlrule;
				}
				else
				{
					$info['url']='/list/?id='.$catid.'&siteid='.SITEID;
				}
			}
			$info['orderby']=$catid;
			$this->db->update($this->table,$info,'id='.$catid);
		}

		/*
			更新栏目缓存
		*/
		if($cache)$this->c->cache_category();

		return true;
	}

	function adds($info)
	{
		global $RETENG,$install,$hotWord;
		if(!$info['modelid'] || !$info['catnames'] ) return false;
		$info['siteid']=SITEID;

		$dirspell=$info['cnspell'];

		unset($info['cnspell']);

		if($dirspell=='cnspell')
		{
			include RETENG_ROOT.'/include/cnspell.class.php';
			$cnspell=new cnspell();
		}

		$catnames=explode(',', str_replace('，',',',$info['catnames']));
		
		if($info['parentid'])
		{
			$catinfo=getcatinfo($info['parentid']);
			$parcatdir=$catinfo['catdir'];
		}
		else
		{
			$parcatdir='';
		}
		foreach($catnames as $key => $catname)
		{
			$catname=trim($catname);
			if($catname)
			{
				$info['domain']='';
				$info['catname']=$catname;
				$info['catdir']=$dirspell=='cnspell'?$cnspell->getcnSpell($info['catname']):intval($key+1);
				$info['catdir']=$info['catdir']?$info['catdir']:mt_rand(1,9999);
				$info['catdir']=$parcatdir.'/'.$info['catdir'].'/';
				$info['catdir']=str_replace('//','/',$info['catdir']);
				$info['setting']['meta_title']=$catname;
				$info['setting']['meta_keywords']=$catname;
				$info['setting']['meta_description']=$catname;
				$this->add($info,false);
			}
		}
		$this->c->cache_category();

		return true;
	}

	function setttingchildres($parentid,$setting)
	{
		$info=array();
		$childrenids=get_childrencatid($parentid);
		if($childrenids)
		{
			foreach($childrenids as $childrenid)
			{
				$info=array();
				$childrenid=intval($childrenid);
				$oldsetting=getcatsetting($childrenid);
				$setting['meta_title']=$oldsetting['meta_title'];
				$setting['meta_keywords']=$oldsetting['meta_keywords'];
				$setting['meta_description']=$oldsetting['meta_description'];
				$info['setting']=var_export($setting,true);
				if($childrenid)
				{
					$this->db->update($this->table,$info,'id='.$childrenid);
				}
			}
			return true;
		}
		else
		{
			return false;
		}
	}

	function edit($info,$id)
	{	
		global $RETENG,$install,$sitecrowdobj,$childsite;
		
		
		$info['siteid']=SITEID;
		$info['domain']=trim($info['domain']);
		$info['image']=$info['image']?$info['image']:'images/image128x128.png';
		
		$info['type']=isset($info['type'])?intval($info['type']):1;

		/*
			设置栏目目录 及菜单等级
		*/
		$oldcatdir=$info['oldcatdir'];
		if($info['parentid'])
		{
			$r=cache_read('cat'.$info['parentid'].'.cache.php',RETENG_ROOT.'data/cache_category/');
			$info['m']=$r['m']+1;
			$parcatdir=$r['catdir'].'/';
		}
		else
		{
			$info['m']=1;
			$parcatdir='';
		}

		if($info['type']==4)
		{
			if(!$info['catname']) 
			{
				return false;
			}
			$info['ispost']=0;
			$info['catdir']='';
			$info['setting']=var_export($info['setting'],true);
			$this->db->update($this->table,$info,'id='.$id);
		}
		else
		{
			if(!$info['modelid'] || !$info['catname'] ) return false;

			/*
				设置子目录
			*/
			if(isset($info['upnext']) && $info['upnext'])
			{
				$this->setttingchildres($id,$info['setting']);
			}

			$info['catdir']=str_replace(' ','',$info['catdir']);
			$info['catdir']=str_replace('{sitedir}',SITEDIR?SITEDIR.'/':'',$info['catdir']);
			$info['catdir']=str_replace('{parcatdir}',$parcatdir,$info['catdir']);
			$newcatdir=str_replace('//','/',str_replace('\\','/',trim($info['catdir']).'/'));

			while($this->checkdir($info['catdir'])  && $oldcatdir!=$newcatdir ) // 防止文件夹重复
			{
				$info['catdir']=substr($info['catdir'],0,-1).mt_rand(1,9999).'/';
			}

			if($info['oldcatdir']!=$info['catdir'] || $info['oldurlrule']!=$info['setting']['urlrule'] || $info['oldishtml']!=$info['setting']['ishtml'])
			{
				if($info['oldcatdir']!=$info['catdir'])
				{
					/*	
						删除旧文件夹
					*/
					if(trim(str_replace(array('/','\\'),'',$info['oldcatdir'])))
					{
						rmdirs(RETENG_ROOT.$info['oldcatdir']);
					}
				}

				/*
					删除旧HTML数据
				*/
				require_once RETENG_ROOT.'include/content.class.php';
				$conobj=new content();

				if($info['oldishtml']!=$info['setting']['ishtml'] || $info['oldurlrule']!=$info['setting']['urlrule'])
				{
					$contentinfo=$this->db->fetch_all("SELECT `$this->content_table`.`id`,`$this->content_table`.`title`,`$this->content_table`.`inputtime`,`$this->content_table`.`url` FROM `$this->content_table` WHERE `$this->content_table`.`catid`=$id AND `$this->content_table`.`islink`=0");
					if($contentinfo)foreach($contentinfo as $_contentinfo)
					{
						/*
							删除内容
						*/
						
						$conobj->delete_html($_contentinfo['id']);
					}
				}
			}

			/*	
				获取拓展数据
			*/
			if($info['extendkey'])foreach($info['extendkey'] as $key => $value)
			{
				$value=trim($value);
				if($value)
				{
					$info['expand'][$value]=htmlspecialchars($info['extendvalue'][$key]);
				}
			}
			$info['expand']=isset($info['expand'])?var_export($info['expand'],true):'';
			if($info['setting']['catishtml']==1)
			{
				makedir($info['catdir']); // 如果是静态化的则生成文件夹!
			}
			else
			{
				if(trim(str_replace(array('/','\\'),'',$info['catdir'])))
				{
					rmdirs(RETENG_ROOT.$info['catdir']);  // 如果是动态化的则删除已生成的旧文件夹!
				}
			}

			/*
				更新数据库
			*/

			$ishtml=$info['setting']['catishtml'];
			$listurlrule=$info['setting']['listurlrule'];

			$info['setting']=var_export($info['setting'],true);

			if(!$info['url'] || strtolower($info['url'])=='http://')
			{
				if($info['domain'])
				{
					$info['url']=$info['domain'];
				}
				else
				{
					if($ishtml==1)
					{
						$info['url']=$info['catdir'];
					}
					else if($ishtml==2)
					{
						$listurlrule=$listurlrule?$listurlrule:'{sitedir}{catdir}list_{page}'.HTMLEXT;
						$listurlrule=str_replace('{sitedir}',SITEDIR?SITEDIR.'/':'',$listurlrule);
						$listurlrule=str_replace('{tid}',$id,$listurlrule);
						$listurlrule=str_replace('{page}','1',$listurlrule);
						$listurlrule=str_replace('{catdir}',$info['catdir'],$listurlrule);
						$listurlrule=str_replace('\\','/',$listurlrule);
						$listurlrule=str_replace('//','/',$listurlrule);
						$info['url']=$listurlrule;
					}
					else
					{
						$info['url']='/list/?id='.$id.'&siteid='.SITEID;
					}
				}
			}
			$this->db->update($this->table,$info,'id='.$id);
		}

		/*
			更新缓存
		*/
		$this->c->cache_category();

		return true;
	}

	function delete($id)
	{
		$id=intval($id);

		/*
			删除栏目表
		*/
		$this->db->mysql_delete($this->table,$id,'id');
		
		/*
			获取栏目配置
		*/
		$r=cache_read('cat'.$id.'.cache.php',RETENG_ROOT.'data/cache_category/');
		$setting=getcatsetting($id);

		/*
			删除内容
		*/
		require_once RETENG_ROOT.'include/content.class.php';
		$conobj=new content();

		$contentinfo=$this->db->fetch_all("SELECT `$this->content_table`.`id` FROM `$this->content_table` WHERE `$this->content_table`.`catid`=$id");
		if($contentinfo)foreach($contentinfo as $_contentinfo)
		{
			$conobj->delete($_contentinfo['id']);
		}

		/*
			删除文件夹
		*/

		if($r && $r['type']==1 && file_exists($r['catdir']) && trim($r['catdir']))
		{
			rmdirs(RETENG_ROOT.$r['catdir']);
		}

		/*
			删除子文件夹
		*/

		$r=cache_read('cat_parent'.$id.'.cache.php',RETENG_ROOT.'data/cache_category/');
		
		if($id && $r)
		{
			foreach($r as $_r)
			{
				$this->delete($_r['id']);
			}
		}
		else
		{
			return false;
		}
	}

	function setismenu($id,$ismenu)
	{
		$this->db->update($this->table,array('ismenu'=>intval($ismenu)),'id='.intval($id));
		$this->c->cache_category();

		return true;
	}

	function sethtml($catid,$ishtml=0)
	{
		global $cache;

		/*
			设置setting
		*/
		$catinfo=$this->catinfo($catid);

		if($catinfo['type']!=1)
		{
			return false;
		}

		$setting=$catinfo['setting'];
		$setting['ishtml']=$ishtml;
		$setting=var_export($setting,true);

		$this->db->update($this->table,array('setting'=>$setting),'id='.intval($catid));

		/*
			删除原有静态文件
		*/
		if($catinfo['setting']['ishtml']==1 && strlen($catinfo['catdir'])>0)
		{
			if(file_exists(RETENG_ROOT.$catinfo['catdir']))
			{
				rmdirs(RETENG_ROOT.$catinfo['catdir']);
			}
		}

		/*
			更新栏目以及内容表链接
		*/

		if($catinfo['setting']['ishtml']!=$ishtml)
		{
			if($ishtml==1)
			{
				$this->db->update($this->table,array('url'=>$catinfo['catdir']),'id='.intval($catid));
			}
			else if($ishtml==0)
			{
				$this->db->update($this->table,array('url'=>'/list/?id='.$catid),'id='.intval($catid));
				$this->db->query("UPDATE `$this->content_table` SET `url`=CONCAT('/show/?id=',`$this->content_table`.`id`) WHERE `$this->content_table`.`catid`=".intval($catid));
			}
			else if($ishtml==2)
			{
				$this->db->update($this->table,array('url'=>'list-'.$catid.'.html'),'id='.intval($catid));
				$this->db->query("UPDATE `$this->content_table` SET `url`=CONCAT('show-',`$this->content_table`.`id`,'.html') WHERE `$this->content_table`.`catid`=".intval($catid));
			}
		}

		if($cache && is_object($cache))
		{
			$cache->clear();
		}
		$this->c->cache_category();
		return true;
	}

	function setispost($id,$ispost)
	{
		$this->db->update($this->table,array('ispost'=>intval($ispost)),'id='.intval($id));
		$r=cache_read('cat_parent'.$id.'.cache.php',RETENG_ROOT.'data/cache_category/');

		if($id && $r)
		{
			foreach($r as $_r)
			{
				$this->setispost($_r['id'],$ispost);
			}
		}
		else
		{
			return false;
		}
	}

	function setordeyby($orderby)
	{
		$orderby=array_map('intval',$orderby);
		if(!$orderby)return false;

		if($orderby)
		{
			foreach($orderby as $key => $value)
			{
				$this->db->update($this->table,array('orderby'=>intval($value)),'id='.intval($key));
			}
		}
		else
		{
			return false;
		}
		$this->c->cache_category();
		return true;
	}

	function cache()
	{
		$this->c->cache_category();
		return true;
	}

	function catinfo($catid)
	{
		$catid=intval($catid);
		$base=cache_read('cat'.$catid.'.cache.php',RETENG_ROOT.'data/cache_category/');
		$setting=cache_read('cat_setting'.$catid.'.cache.php',RETENG_ROOT.'data/cache_category/');
		$base['setting']=$setting;
		$base['expand']=$base['expand']?string2array($base['expand']):array();
		if($base['expand'])foreach($base['expand'] as $key => $value)
		{
			$base['_'.$key]=htmlspecialchars($value);
		}
		return $base;
	}

	function checkdir($dirname)
	{
		$dirname=trim($dirname);
		return file_exists(RETENG_ROOT.$dirname);
	}
}
?>
