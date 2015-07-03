<?php
/**
	 留言管理类
*/

class gather
{
	public $pagestring='';
	private $db;
	private $table;
	private $tmp_table;
	private $task_table;
	private $contable;

	function __construct()
	{
		global $db;
		$this->db=$db;
		$this->table=DB_PRE.'gather';
		$this->tmp_table=DB_PRE.'gather_tmp';
		$this->task_table=DB_PRE.'server_task';
		$this->contable=DB_PRE.'content';
	}

	function datalist()
	{
		global $page;
		include RETENG_ROOT.'include/datalist.class.php';
		$datalist = new datalist();
		$where='1';
		$orderby='id DESC';
		$page=max(isset($page)?intval($page):1,1);
		$pagesize=15;
		$result=$datalist->getlist($this->table,$where,$orderby,$page,$pagesize);
		$this->pagestring=$datalist->pagestring;
		return $result;
	}

	function conlist($id)
	{
		global $page;
		include RETENG_ROOT.'include/datalist.class.php';
		$datalist = new datalist();
		if(!$id)
		{
			$where='1';
		}
		else
		{
			$where='nodeid='.$id;
		}
		$orderby='id DESC';
		$page=max(isset($page)?intval($page):1,1);
		$pagesize=25;
		$result=$datalist->getlist($this->tmp_table,$where,$orderby,$page,$pagesize);
		$this->pagestring=$datalist->pagestring;
		return $result;
	}

	function geturlfile($url)
	{
		$url=trim($url);
		$content='';
		if(extension_loaded('curl'))
		{
			$ch=curl_init();
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
			curl_setopt($ch,CURLOPT_HEADER,0);
			$content=curl_exec($ch);
			curl_close($ch);
		}
		else
		{
			$content=file_get_contents($url);
		}
		return trim($content);
	}

	function getmodelname($modelid=1)
	{
		$r=cache_read('model'.$modelid.'.cache.php',RETENG_ROOT.'data/c/');
		return $r['name'];
	}

	function add($info)
	{
		$info['name']=$info['name'].'-'.date('m-d',TIME);
		$info['listsetting']=var_export($info['listsetting'],true);
		$info['itemsetting']=var_export($info['itemsetting'],true);
		$info['addtime']=TIME;
		$info['cotime']=0;
		$info['urlcounts']=0;
		return $this->db->insert($this->table,$info);
	}

	function addcontent($info)
	{
		return $this->db->insert($this->table,$info);
	}
	function edit($info,$id)
	{
		//unset($info['name']);
		$info['listsetting']=var_export($info['listsetting'],true);
		$info['itemsetting']=var_export($info['itemsetting'],true);
		return $this->update($info,$id);
	}

	function update($info,$id)
	{
		return $this->db->update($this->table,$info,'id='.intval($id));
	}
	
	function updatetask($info,$id)
	{
		return $this->db->update($this->task_table,$info,'id='.intval($id));
	}
	function gathercon($info)
	{
		return $this->db->insert($this->tmp_table,$info,true);
	}

	function deletecon($id)
	{
		$id=is_array($id)?array_map('intval',$id):intval($id);
		return $this->db->mysql_delete($this->tmp_table,$id);
	}
	function updatecon($info,$id)
	{
		$id=is_array($id)?array_map('intval',$id):intval($id);
		return $this->db->update($this->tmp_table,$info,'id='.intval($id));
	}


	function insertcon($ids,$movetocatid)
	{
		require RETENG_ROOT.'include/content.class.php';
		$conobj=new content();

		$ids=array_map('intval',$ids);
		$movetocatid=intval($movetocatid);
		if(!$ids)return false;
		foreach($ids as $id)
		{
			$info=array();
			$coninfo=$this->coninfo($id);
			$modelid=$coninfo['modelid'];
			$fields=cache_read('model'.$modelid.'_fields.cache.php',RETENG_ROOT.'data/c/');

			$info['userid']=ADMIN_FOUNDERS;
			$info['username']='游客';
			$info['inputtime']=$info['updatetime']=TIME;
			$info['catid']=$movetocatid;
			$info['modelid']=$modelid;
			$info['clicks']=mt_rand(100,200);
			$info['comments']=0;
			$info['islink']=0;
			$info['ispage']=0;
			$info['pagecount']=5000;
			$info['status']=1;
		
			foreach($fields as $field)
			{
				$info[$field['form']]=$this->getcon($id,$field['form']);
			}
			$conobj->add($info);
			$infocon['ispost']=1;
			$this->updatecon($infocon,$id);
		}
		return true;
	}
	
	function insertonecon($id,$movetocatid)
	{
		require_once RETENG_ROOT.'include/content.class.php';
		$conobj=new content();

		//$id=array_map('intval',$id);
		$movetocatid=intval($movetocatid);
		
			$info=array();
			$coninfo=$this->coninfo($id);		
			$modelid=$coninfo['modelid'];
			$fields=cache_read('model'.$modelid.'_fields.cache.php',RETENG_ROOT.'data/c/');
			$info['userid']='1';
			$info['username']='游客';
			$info['inputtime']=$info['updatetime']=TIME;
			$info['catid']=$movetocatid;
			$info['modelid']=$modelid;
			$info['clicks']=mt_rand(100,200);
			$info['comments']=0;
			$info['islink']=0;
			$info['ispage']=0;
			$info['pagecount']=5000;
			$info['status']=1;
		
			foreach($fields as $field)
			{
				$info[$field['form']]=$this->getcon($id,$field['form']);
			}
			
			$conobj->add($info);
			
			$infocon['ispost']=1;
			$this->updatecon($infocon,$id);

		return true;
	}

	

	function test($info)
	{
		$listurls=array();
		if(trim($info['listsetting']['addurls']))
		{
			$addurls=explode("\r\n",trim($info['listsetting']['addurls']));
			if($addurls)foreach($addurls as $addurl)
			{
				$addurl=trim($addurl);
				if($addurl)
				{
					$listurls[]=$addurl;
				}
			}
		}

		if($info['listsetting']['sourcetype']=='batch' && strpos($info['listsetting']['regxurl'],'*'))
		{
			if($info['listsetting']['endid']<$info['listsetting']['startid'] || $info['listsetting']['startid']<=0)
			{
				showmsg("批量生成地址的开始页码不能大于结束的页码!");
			}
			$regxurl=$info['listsetting']['regxurl'];
			for($i=$info['listsetting']['startid'];$i<=$info['listsetting']['endid'];$i=$i+intval($info['listsetting']['addv']))
			{
				$listurls[]=str_replace('(*)',$i,$info['listsetting']['regxurl']);
			}
		}

		return $listurls;
	}

	function get_all_url($code)
	{ 
		preg_match_all('/<a.+?href=["|\']?([^>"\' ]+)["|\']?\s*[^>]*>([^>]+)<\/a>/is',$code,$arr); 
		return array('name'=>$arr[2],'url'=>$arr[1]); 
	}

	function get_sub_content($str, $start, $end)
	{
		$start=trim($start);
		$end=trim($end);
		if($start == '' || $end == '' )
		{
			return $str;
		}
		$str = explode($start, $str);
		$str = explode($end, $str[1]);
		return $str[0]; 
	}


	function export($id)
	{
		$result=array();
		$id=intval($id);
		$data=$this->db->fetch_one("SELECT * FROM `$this->table` WHERE `$this->table`.`id`=$id");
		unset($data['id']);
		$result['name']=$data['name'];
		$result['export']=base64_encode(var_export($data,true));
		if(file_exists(RETENG_ROOT.'gather/data/func/'.md5($id).'.func.php'))
		{
			$result['export']=base64_encode(file_get_contents(RETENG_ROOT.'gather/data/func/'.md5($id).'.func.php')).'-'.$result['export'];
		}
		return $result;
	}

	function gatherinfo($id)
	{
		$id=intval($id);
		$data=$this->db->fetch_one("SELECT * FROM `$this->table` WHERE `$this->table`.`id`=$id");
		if(!$data)
		{
			return array();
		}
		$data['listsetting']=string2array(trim($data['listsetting']));
		$data['itemsetting']=string2array(trim($data['itemsetting']));
		return retengcms_stripslashes($data);
	}

	function coninfo($id)
	{
		$con=$this->db->fetch_one("SELECT * FROM `$this->tmp_table` WHERE `$this->tmp_table`.`id`=$id");
		$con['contentid']=$con['id'];
		return array_merge($con,$this->gatherinfo($con['nodeid']));
	}

	function getcon($id,$field)
	{
		$coninfo=$this->coninfo($id);
		if($coninfo['itemsetting'][$field]['areastart'] && $coninfo['itemsetting'][$field]['areaend'])
		{
			$result=trim($this->get_sub_content($coninfo['content'], stripslashes($coninfo['itemsetting'][$field]['areastart']), stripslashes($coninfo['itemsetting'][$field]['areaend'])));
			$result=$result?$result:$coninfo['itemsetting'][$field]['default'];
		}
		else
		{
			$result=$coninfo['itemsetting'][$field]['default'];
			
		}
		if(!$result && $field=='thumb')
		{
			$result=get_images(trim($this->get_sub_content($coninfo['content'], stripslashes($coninfo['itemsetting']['content']['areastart']))));
		}

		if($coninfo['itemsetting'][$field]['func'])
		{
			if(file_exists(RETENG_ROOT.'gather/data/func/'.md5($coninfo['nodeid']).'.func.php') && !function_exists($coninfo['itemsetting'][$field]['func']))
			{
				include RETENG_ROOT.'gather/data/func/'.md5($coninfo['nodeid']).'.func.php';
			}

			if(function_exists($coninfo['itemsetting'][$field]['func']))
			{
				$result=call_user_func($coninfo['itemsetting'][$field]['func'],$result);
			}
		}
		$result=is_array($result)?'':$result;
		if($field!='content' && isset($coninfo['itemsetting'][$field]['striptags']) && $coninfo['itemsetting'][$field]['striptags'])
		{
			$result=strip_tags($result);
		}

		if($coninfo['itemsetting'][$field]['search'])
		{
			$result=str_replace(explode('|',$coninfo['itemsetting'][$field]['search']),explode('|',$coninfo['itemsetting'][$field]['replace']),$result);
		}
		
		/*
			远程图片本地化
		*/
		if($coninfo['listsetting']['downloadimg'])
		{
			if(is_image($result))
			{
				$result=createthumb($result,0);
			}
			else
			{
				$imgs=get_images($result);
				if($imgs)foreach($imgs as $img)
				{
					if(substr(strtolower($img),0,7)=='http://')
					{
						$localimg=createthumb($img,0);
						$result=str_replace($img,$localimg,$result);
					}
				}
			}
		}

		/*
			标题检测
		*/
		if($field=='title')
		{
			if($coninfo['listsetting']['titlerepeat']!=3)
			{
				$r=$this->db->fetch_one("SELECT	`$this->contable`.`id` FROM `$this->contable` WHERE `$this->contable`.`title`='{$result}'");
				if($r && $r['id'])
				{
					$this->db->mysql_delete($this->contable,intval($r['id']));
				}
			}
		}
		return $result;
	}

	function gathername($id)
	{
		$r=$this->gatherinfo($id);
		return $r['name'];
	}

	function import($data)
	{
		$data=explode('-',$data);
		if(isset($data[1]))
		{
			$data[1]=string2array(base64_decode(trim($data[1])));
			$id=$this->db->insert($this->table,$data[1]);
			
			if($data[0])
			{
				$data[0]=trim(base64_decode($data[0]));
			}
			if($data[0])
			{
				$this->createfunc($id,$data[0]);
			}
		}
		else
		{
			$data[0]=string2array(base64_decode(trim($data[0])));
			$this->db->insert($this->table,$data[0]);
		}
		return true;
	}

	function delete($id)
	{
		if($this->db->mysql_delete($this->table,intval($id)))
		{
			@unlink(RETENG_ROOT.'gather/data/func/'.md5($id).'.func.php');
			return $this->db->mysql_delete($this->tmp_table,intval($id),'nodeid');
		}
		else
		{
			return false;
		}
	}

	function truncate($id)
	{
		$this->update(array('urlcounts'=>0),$id);
		return $this->db->mysql_delete($this->tmp_table,intval($id),'nodeid');
	}

	function createfunc($nodeid,$func)
	{
		return file_put_contents(RETENG_ROOT.'gather/data/func/'.md5($nodeid).'.func.php',stripslashes(trim($func)));
	}
	
	function checkdup($field,$value)
	{
		$r=$this->db->fetch_one("SELECT `$this->tmp_table`.`$field` FROM `$this->tmp_table` WHERE `$this->tmp_table`.`$field`='{$value}'");
		if(!$r)
		{
			return 0;
		}else
		{
			return 1;
		}
	
	}
	function tasklist($id)
	{
		global $page;
		include RETENG_ROOT.'include/datalist.class.php';
		$datalist = new datalist();
		if(!$id)
		{
			$where='1';
		}
		else
		{
			$where='id='.$id;
		}
		$orderby='id DESC';
		$page=max(isset($page)?intval($page):1,1);
		$pagesize=25;
		$result=$datalist->getlist($this->task_table,$where,$orderby,$page,$pagesize);
		$this->pagestring=$datalist->pagestring;
		return $result;
	}
	function inserttask($info)
	{
		$info['count']='0';
		$info['status']=0;
		$info['updatetime']=date("y-m-d h:i:s",time());
		return $this->db->insert($this->task_table,$info);
	}
	function deletetask($id)
	{
		$id=is_array($id)?array_map('intval',$id):intval($id);
		return $this->db->mysql_delete($this->task_table,$id);
	}
	function getalltask()
	{
		return $this->db->fetch_all("SELECT * FROM `$this->task_table`");
	}
	

}
?>
