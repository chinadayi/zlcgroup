<?php
/**
	* 分站站群操作类
*/

class sitecrowd
{
	public $pagestring;
	private $db;
	private $sitecrowd;
	private $sitecrowdissue;

	function __construct()
	{
		global $db;
		$this->db=$db;
		$this->sitecrowd=DB_PRE.'sitecrowd';
		$this->sitecrowdissue=DB_PRE.'sitecrowdissue';
	}

	function sitecrowd()
	{
		$this->__construct();
	}

	function maindomain()
	{
		return 'http://'.(strtolower($_SERVER['SERVER_NAME']?$_SERVER['SERVER_NAME']:$_SERVER['HTTP_HOST'])).($_SERVER['SERVER_PORT']==80?'':':'.$_SERVER['SERVER_PORT']).dirname($_SERVER['PHP_SELF']).'/';
	}

	/*
		站点管理
	*/
	function datalist()
	{
		global $page;
		include RETENG_ROOT.'include/datalist.class.php';
		$datalist = new datalist();
		$where=1;
		$orderby='id ASC';
		$page=max(isset($page)?intval($page):1,1);
		$pagesize=15;
		$result=$datalist->getlist($this->sitecrowd,$where,$orderby,$page,$pagesize);
		$this->pagestring=$datalist->pagestring;
		return $result;
	}

	function add($info)
	{
		$info['issueid']=implode(',',$info['issueid']);
		$info=array_map('trim',$info);
		if($siteid=$this->db->insert($this->sitecrowd,$info,true))
		{
			$config=array(
				array(
					'groupid'=>'1',
					'varname'=>'site_name',
					'desc'=>'网站名称',
					'alt'=>'',
					'type'=>'string',
					'value'=>$info['site_name'],
					'system'=>1,
					'siteid'=>$siteid
				),
				array(
					'groupid'=>'1',
					'varname'=>'childsite_url',
					'desc'=>'网站地址',
					'alt'=>'请填写完整URL地址，以"/"结尾',
					'type'=>'string',
					'value'=>$info['site_url'],
					'system'=>1,
					'siteid'=>$siteid
				),
				array(
					'groupid'=>'1',
					'varname'=>'tpl_name',
					'desc'=>'默认模板',
					'alt'=>'',
					'type'=>'string',
					'value'=>$info['tlp_name'],
					'system'=>1,
					'siteid'=>$siteid
				),
				array(
					'groupid'=>'1',
					'varname'=>'meta_title',
					'desc'=>'网站副标题',
					'alt'=>'',
					'type'=>'string',
					'value'=>$info['seo_title'],
					'system'=>1,
					'siteid'=>$siteid
				),
				array(
					'groupid'=>'1',
					'varname'=>'meta_keywords',
					'desc'=>'网站关键字',
					'alt'=>'设置Meta标签的关键字，用英文逗号分隔',
					'type'=>'string',
					'value'=>$info['seo_keywords'],
					'system'=>1,
					'siteid'=>$siteid
				),
				array(
					'groupid'=>'1',
					'varname'=>'meta_description',
					'desc'=>'网站描述',
					'alt'=>'设置Meta标签的描述信息',
					'type'=>'bstring',
					'value'=>$info['seo_description'],
					'system'=>1,
					'siteid'=>$siteid
				),
				array(
					'groupid'=>'1',
					'varname'=>'separator',
					'desc'=>'导航分隔符',
					'alt'=>'如：网站首页 > 新闻',
					'type'=>'string',
					'value'=>$info['separator'],
					'system'=>1,
					'siteid'=>$siteid
				),
				array(
					'groupid'=>'1',
					'varname'=>'htmlext',
					'desc'=>'HTML后缀',
					'alt'=>'HTML后缀不要经常修改!修改后请更新内容。',
					'type'=>'string',
					'value'=>$info['htmlext'],
					'system'=>1,
					'siteid'=>$siteid
				),
				array(
					'groupid'=>'1',
					'varname'=>'iscity',
					'desc'=>'只读取默认地区数据',
					'alt'=>'开启后, 将自动读取默认地区数据，其他地区数据将不显示在前台。',
					'type'=>'bool',
					'value'=>$info['iscity'],
					'system'=>1,
					'siteid'=>$siteid
				),
				array(
					'groupid'=>'1',
					'varname'=>'city',
					'desc'=>'默认地区名',
					'alt'=>'',
					'type'=>'string',
					'value'=>$info['city'],
					'system'=>1,
					'siteid'=>$siteid
				),
				array(
					'groupid'=>'1',
					'varname'=>'map',
					'desc'=>'地图精准定位',
					'alt'=>'',
					'type'=>'string',
					'value'=>$info['map'],
					'system'=>1,
					'siteid'=>$siteid
				),
				array(
					'groupid'=>'1',
					'varname'=>'ishtml',
					'desc'=>'首页是否静态化',
					'alt'=>'',
					'type'=>'string',
					'value'=>$info['ishtml'],
					'system'=>1,
					'siteid'=>$siteid
				),
				array(
					'groupid'=>'1',
					'varname'=>'copyright',
					'desc'=>'版权信息',
					'alt'=>'',
					'type'=>'string',
					'value'=>$info['copyright'],
					'system'=>1,
					'siteid'=>$siteid
				),
				array(
					'groupid'=>'1',
					'varname'=>'icpno',
					'desc'=>'网站ICP备案序号',
					'alt'=>'',
					'type'=>'string',
					'value'=>$info['icpno'],
					'system'=>1,
					'siteid'=>$siteid
				)
			);

			foreach($config as $_config)
			{
				$this->db->insert(DB_PRE.'config',$_config,true);
			}

			makedir($info['site_dir']);
			return true;
		}
		return false;
	}

	function edit($info,$oldsite_dir,$siteid)
	{
		$siteid=intval($siteid);
		$info['issueid']=implode(',',$info['issueid']);
		$info=array_map('trim',$info);
		if($this->db->update($this->sitecrowd,$info,'id='.$siteid))
		{
			$config=array(
				array(
					'groupid'=>'1',
					'varname'=>'childsite_url',
					'desc'=>'网站地址',
					'alt'=>'请填写完整URL地址，以"/"结尾',
					'type'=>'string',
					'value'=>$info['site_url'],
					'system'=>1,
					'siteid'=>$siteid
				),
				array(
					'groupid'=>'1',
					'varname'=>'tpl_name',
					'desc'=>'默认模板',
					'alt'=>'',
					'type'=>'string',
					'value'=>$info['tlp_name'],
					'system'=>1,
					'siteid'=>$siteid
				),
				array(
					'groupid'=>'1',
					'varname'=>'meta_title',
					'desc'=>'网站副标题',
					'alt'=>'',
					'type'=>'string',
					'value'=>$info['seo_title'],
					'system'=>1,
					'siteid'=>$siteid
				),
				array(
					'groupid'=>'1',
					'varname'=>'meta_keywords',
					'desc'=>'网站关键字',
					'alt'=>'设置Meta标签的关键字，用英文逗号分隔',
					'type'=>'string',
					'value'=>$info['seo_keywords'],
					'system'=>1,
					'siteid'=>$siteid
				),
				array(
					'groupid'=>'1',
					'varname'=>'meta_description',
					'desc'=>'网站描述',
					'alt'=>'设置Meta标签的描述信息',
					'type'=>'bstring',
					'value'=>$info['seo_description'],
					'system'=>1,
					'siteid'=>$siteid
				),
				array(
					'groupid'=>'1',
					'varname'=>'separator',
					'desc'=>'导航分隔符',
					'alt'=>'如：网站首页 > 新闻',
					'type'=>'string',
					'value'=>$info['separator'],
					'system'=>1,
					'siteid'=>$siteid
				),
				array(
					'groupid'=>'1',
					'varname'=>'htmlext',
					'desc'=>'HTML后缀',
					'alt'=>'HTML后缀不要经常修改!修改后请更新内容。',
					'type'=>'string',
					'value'=>$info['htmlext'],
					'system'=>1,
					'siteid'=>$siteid
				),
				array(
					'groupid'=>'1',
					'varname'=>'iscity',
					'desc'=>'只读取默认地区数据',
					'alt'=>'开启后, 将自动读取默认地区数据，其他地区数据将不显示在前台。',
					'type'=>'bool',
					'value'=>$info['iscity'],
					'system'=>1,
					'siteid'=>$siteid
				),
				array(
					'groupid'=>'1',
					'varname'=>'city',
					'desc'=>'默认地区名',
					'alt'=>'',
					'type'=>'string',
					'value'=>$info['city'],
					'system'=>1,
					'siteid'=>$siteid
				),
				array(
					'groupid'=>'1',
					'varname'=>'map',
					'desc'=>'地图精准定位',
					'alt'=>'',
					'type'=>'string',
					'value'=>$info['map'],
					'system'=>1,
					'siteid'=>$siteid
				),
				array(
					'groupid'=>'1',
					'varname'=>'ishtml',
					'desc'=>'首页是否静态化',
					'alt'=>'',
					'type'=>'string',
					'value'=>$info['ishtml'],
					'system'=>1,
					'siteid'=>$siteid
				),
				array(
					'groupid'=>'1',
					'varname'=>'copyright',
					'desc'=>'版权信息',
					'alt'=>'',
					'type'=>'string',
					'value'=>$info['copyright'],
					'system'=>1,
					'siteid'=>$siteid
				),
				array(
					'groupid'=>'1',
					'varname'=>'icpno',
					'desc'=>'网站ICP备案序号',
					'alt'=>'',
					'type'=>'string',
					'value'=>$info['icpno'],
					'system'=>1,
					'siteid'=>$siteid
				)
			);

			foreach($config as $_config)
			{
				$this->db->update(DB_PRE.'config',$_config,'siteid='.$siteid.' AND varname="'.$_config['varname'].'"');
			}

			if($oldsite_dir!=$info['site_dir'])
			{
				rename(RETENG_ROOT.$oldsite_dir,RETENG_ROOT.$info['site_dir']);
			}
			return true;
		}
		return false;
	}

	function delete($id)
	{
		$r=$this->sitecrowdinfo($id);
		if(!$r || $r['system'] || !$r['site_dir'] || $r['site_dir']=='/')
		{
			return false;
		}

		$this->db->mysql_delete($this->sitecrowd,$id);
		$this->db->mysql_delete(DB_PRE.'config',$id,'siteid');
		return rmdirs(RETENG_ROOT.$r['site_dir']);
	}

	function allcrowd()
	{
		return $this->db->fetch_all("SELECT * FROM `$this->sitecrowd` ORDER BY `$this->sitecrowd`.`id` ASC");
	}

	function sitecrowdinfo($siteid,$field='*')
	{
		$siteid=intval($siteid);
		if($siteid <= 0)
		{
			return false;
		}

		$r=$this->db->fetch_one("SELECT * FROM `$this->sitecrowd` WHERE `$this->sitecrowd`.`id`=$siteid");

		if(!$r)return false;
		return $field=='*' || !array_key_exists($field,$r)?$r:$r[$field];
	}

	function setdefaultsite($siteid)
	{
		$siteid=intval($siteid);
		if(!$this->sitecrowdinfo($siteid))
		{
			return false;
		}
		set_cookie('adminsiteid',$siteid);
		return true;
	}

	/*
		发布点管理
	*/
	function issuelist()
	{
		return $this->db->fetch_all("SELECT * FROM `$this->sitecrowdissue`  ORDER BY `$this->sitecrowdissue`.`issueid` ASC");
	}

	function issueadd($info)
	{
		$info=array_map('trim',$info);
		$info['ftpdir']=$info['ftpdir']?$info['ftpdir']:'./';
		return $this->db->insert($this->sitecrowdissue,$info,true);
	}

	function issueedit($info,$id)
	{
		$info=array_map('trim',$info);
		$info['ftpdir']=$info['ftpdir']?$info['ftpdir']:'./';
		return $this->db->update($this->sitecrowdissue,$info,'issueid='.intval($id));
	}

	function issuedelete($id)
	{
		$this->db->mysql_delete($this->sitecrowdissue,$id,'issueid');
		$r=$this->allcrowd();

		foreach($r as $_r)
		{
			if($_r['issueid'])
			{
				$issueid=explode(',',$_r['issueid']);
				foreach($issueid as $key => $value)
				{
					if($value==$id)
					{
						unset($issueid[$key]);
					}
				}
			}
			$issueid=implode(',',$issueid);
			$this->db->update($this->sitecrowd,array('issueid'=>$issueid),'id='.$_r['id']);
		}
		return true;
	}

	function issueinfo($id,$field='*')
	{
		$id=intval($id);
		return $this->db->fetch_one("SELECT * FROM `$this->sitecrowdissue` WHERE `$this->sitecrowdissue`.`issueid` =$id");
		if(!$r)return false;
		return $field=='*' || !array_key_exists($field,$r)?$r:$r[$field];
	}
}

?>