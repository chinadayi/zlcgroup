<?php
/**
	* 广告管理类
*/

class ads
{
	public $pagestring='';
	private $db;
	private $table;
	private $adspos_table;

	function __construct()
	{
		global $db;
		$this->db=$db;
		$this->table=DB_PRE.'ads';
		$this->adspos_table=DB_PRE.'adspos';
	}
	
	/*
		广告位操作
	*/

	function adsposlist()
	{
		global $page;
		include RETENG_ROOT.'include/datalist.class.php';
		$datalist = new datalist();
		$where='siteid='.SITEID;
		$orderby='id DESC';
		$page=max(isset($page)?intval($page):1,1);
		$pagesize=15;
		$result=$datalist->getlist($this->adspos_table,$where,$orderby,$page,$pagesize);
		$this->pagestring=$datalist->pagestring;
		return $result;
	}

	function adspos_lock($ispassed,$id)
	{
		$this->db->update($this->adspos_table,array('ispassed'=>intval($ispassed)),'id='.intval($id));
		$this->db->update($this->table,array('ispassed'=>intval($ispassed)),'adsposid='.intval($id));
		$this->ads_cache();
		return true;
	}

	function adspos_delete($id)
	{
		$this->db->mysql_delete($this->adspos_table,intval($id));
		$this->db->mysql_delete($this->table,intval($id),'adsposid');
		$this->ads_cache();
		return true;
	}

	function adspos_editname($names)
	{
		foreach($names as $id => $name)
		{
			$this->db->update($this->adspos_table,array('name'=>trim($name)),'id='.intval($id));
		}
		$this->ads_cache();
		return true;
	}

	function adspos_add($info)
	{
		$info['siteid']=SITEID;
		$this->db->insert($this->adspos_table,$info);
		$this->ads_cache();
		return true;
	}

	function adspos_edit($info,$id)
	{
		$info['siteid']=SITEID;
		$this->db->update($this->adspos_table,$info,'id='.intval($id));
		$this->ads_cache();
		return true;
	}

	function adspos_info($id)
	{
		return $this->db->fetch_one("SELECT * FROM `$this->adspos_table` WHERE `$this->adspos_table`.`id`=".intval($id));
	}

	function ads_cache()
	{
		$r=$this->db->fetch_all("SELECT * FROM `$this->adspos_table` ORDER BY `$this->adspos_table`.`id` DESC");
		cache_write('adspos.cache.php',$r,RETENG_ROOT.'data/cache_module/');
		if($r)foreach($r as $_r)
		{
			cache_write('adspos'.$_r['id'].'.cache.php',$_r,RETENG_ROOT.'data/cache_module/');
		}
	}

	function ads_show($id)
	{
		global $RETENG;
		$id=intval($id);
		$r=cache_read('adspos'.$id.'.cache.php',RETENG_ROOT.'data/cache_module/');
		if(!$id || !$r || !$r['ispassed']) exit('document.writeln("")');
		$ads=$this->db->fetch_all("SELECT * FROM `$this->table` WHERE `$this->table`.`adsposid`=".intval($id)." AND `$this->table`.`ispassed`=1 AND `$this->table`.`todate`>=".TIME." ORDER BY `$this->table`.`id` ASC");
		if(!$ads)
		{
			exit('document.writeln(\'此广告位已过期!\')');
		}
		if($r['option'])
		{
			$contents=array();
			if($ads)foreach($ads as $ad)
			{
				if($ad['type']==1)
				{
					$contents[]='<a href="'.$RETENG['site_url'].'adv/api/adv.php?id='.$ad['id'].'" title="'.$ad['alt'].'" target="_blank"><img src="'.$RETENG['site_url'].$ad['imageurl'].'" width="'.$r['width'].'" height="'.$r['height'].'" alt="'.$ad['alt'].'"/></a>';
				}

				if($ad['type']==2)
				{
					$contents[]='<OBJECT width="'.$r['width'].'" height="'.$r['height'].'"><PARAM NAME=movie value="'.$RETENG['site_url'].$ad['flashurl'].'"><PARAM NAME=quality value=high><PARAM NAME=wmode value='.$ad['wmode'].'><EMBED width="'.$r['width'].'" height="'.$r['height'].'" src="'.$RETENG['site_url'].$ad['flashurl'].'" quality=high wmode=transparent TYPE="application/x-shockwave-flash"></EMBED></OBJECT>';
				}

				if($ad['type']==3)
				{
					$adbody = str_replace("'", "\'",$ad['text']);
					$adbody = str_replace("\r", "\\r",$adbody);
					$adbody = str_replace("\n", "\\n",$adbody);
					$contents[] = str_replace('script', "scr'+'ipt",$adbody);
				}
				
				if($ad['type']==4)
				{
					$contents[]='<a href="'.$RETENG['site_url'].'adv/api/adv.php?id='.$ad['id'].'" title="'.$ad['code'].'" target="_blank">'.$ad['code'].'</a>';
				}
			}
		}
		else
		{
			$randkey=mt_rand(0,sizeof($ads)-1);
			$ad=$ads[$randkey];
			if($ad['type']==1)
			{
				$contents[]='<a href="'.$RETENG['site_url'].'adv/api/adv.php?id='.$ad['id'].'" title="'.$ad['alt'].'" target="_blank"><img src="'.$RETENG['site_url'].$ad['imageurl'].'" width="'.$r['width'].'" height="'.$r['height'].'" alt="'.$ad['alt'].'"/></a>';
			}

			if($ad['type']==2)
			{
				$contents[]='<OBJECT width="'.$r['width'].'" height="'.$r['height'].'"><PARAM NAME=movie value="'.$RETENG['site_url'].$ad['flashurl'].'"><PARAM NAME=quality value=high><PARAM NAME=wmode value='.$ad['wmode'].'><EMBED width="'.$r['width'].'" height="'.$r['height'].'" src="'.$RETENG['site_url'].$ad['flashurl'].'" quality=high wmode=transparent TYPE="application/x-shockwave-flash"></EMBED></OBJECT>';
			}

			if($ad['type']==3)
			{
				$adbody = str_replace("'", "\'",$ad['text']);
				$adbody = str_replace("\r", "\\r",$adbody);
				$adbody = str_replace("\n", "\\n",$adbody);
				$contents[] = str_replace('script', "scr'+'ipt",$adbody);
			}
			
			if($ad['type']==4)
			{
				$contents[]='<a href="'.$RETENG['site_url'].'adv/api/adv.php?id='.$ad['id'].'" title="'.$ad['code'].'" target="_blank">'.$ad['code'].'</a>';
			}
		}
		ob_start();
		include template($r['template'],'adv');
		$adcontent=ob_get_contents();
		ob_end_clean();
		
		$type=$ad['type'];
		if($r['option'])
		{
			$adcontent=explode("\r\n",$adcontent);
			//print_r($adcontent);
			foreach($adcontent as $ad)
			{
				if($type==3)
				{
					echo('document.writeln(\''.$ad.'\');'."\r\n");
				}
				else
				{
					echo('document.writeln(\''.str_replace('\'','"',$ad).'\');'."\r\n");
				}
			}
			exit();
		}
		else
		{
			if($type==3)
			{
				exit('document.writeln(\''.$adcontent.'\');'."\r\n");
			}
			else
			{
				exit('document.writeln(\''.str_replace('\'','"',$adcontent).'\');'."\r\n");
			}
		}
	}

	/*
		广告操作
	*/
	function adslist($adsposid)
	{
		global $page;
		include RETENG_ROOT.'include/datalist.class.php';
		$datalist = new datalist();
		$where='adsposid='.intval($adsposid);
		$orderby='id DESC';
		$page=max(isset($page)?intval($page):1,1);
		$pagesize=15;
		$result=$datalist->getlist($this->table,$where,$orderby,$page,$pagesize);
		if($result)foreach($result as $key => $val)
		{
			$r=cache_read('adspos'.$val['adsposid'].'.cache.php',RETENG_ROOT.'data/cache_module/');
			
			$result[$key]['adspos']=$r['name'];
		}
		$this->pagestring=$datalist->pagestring;
		return $result;
	}

	function ads_add($info)
	{
		global $upload;
		$text=$info['text'];
		$info=array_map('strip_tags',$info);
		$info['text']=$text;
		$info['fromdate']=strtotime($info['fromdate']);
		$info['todate']=strtotime($info['todate']);
		$info['addtime']=TIME;

		/*
			处理图片或Flash
		*/
		if($info['type']==1)
		{
			$info['imageurl']='data/attached/'.$upload->uploadfile('imageurl', RETENG_ROOT.'data/attached/', md5($info['name']), array('jpg','jpeg','gif','png'),1024000);
			$info['alt']=$info['alt']?strip_tags($info['alt']):strip_tags($info['name']);
		}
		else if($info['type']==2)
		{
			$info['flashurl']='data/attached/'.$upload->uploadfile('flashurl', RETENG_ROOT.'data/attached/', md5($info['name']), array('swf','flv'));
		}


		$this->db->insert($this->table,$info);
		$this->ads_cache();
		return true;
	}

	function ads_editname($names,$fromdates=array(),$todates=array())
	{
		foreach($names as $id => $name)
		{
			$this->db->update($this->table,array('name'=>trim($name),'fromdate'=>strtotime($fromdates[$id]),'todate'=>strtotime($todates[$id])),'id='.intval($id));
		}
		$this->ads_cache();
		return true;
	}

	function ads_edit($info,$id)
	{
		global $upload;
		$text=$info['text'];
		$info=array_map('strip_tags',$info);
		$info['text']=$text;
		$info['fromdate']=strtotime($info['fromdate']);
		$info['todate']=strtotime($info['todate']);

		/*
			处理图片或Flash
		*/
		if($info['type']==1 && isset($_FILES['imageurl']))
		{
			$info['imageurl']='data/attached/'.$upload->uploadfile('imageurl', RETENG_ROOT.'data/attached/', md5($info['name']), array('jpg','jpeg','gif','png'),1024000);
			$info['alt']=$info['alt']?strip_tags($info['alt']):strip_tags($info['name']);
		}
		else if($info['type']==2 && isset($_FILES['flashurl']))
		{
			$info['flashurl']='data/attached/'.$upload->uploadfile('flashurl', RETENG_ROOT.'data/attached/', md5($info['name']), array('swf','flv'));
		}

		$this->db->update($this->table,$info,'id='.intval($id));
		$this->ads_cache();
		return true;
	}

	function ads_lock($ispassed,$id)
	{
		$this->db->update($this->table,array('ispassed'=>intval($ispassed)),'id='.intval($id));
		$this->ads_cache();
		return true;
	}

	function ads_delete($id)
	{
		$this->db->mysql_delete($this->table,intval($id));
		$this->ads_cache();
		return true;
	}

	function ads_info($id)
	{
		return $this->db->fetch_one("SELECT * FROM `$this->table` WHERE `$this->table`.`id`=".intval($id));
	}
}
?>
