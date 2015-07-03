<?php
/**
* 列表分页类
*/

class options
{
	public $db;
	private $category_table;
	private $page_table;
	
	function __construct()
	{
		global $db;
		$this->db=$db;
		$this->page_table=DB_PRE.'page';
	}
	
	function getoptions($table,$fieldname='name',$parentid=0,$dotfield='m',$where='')
	{
		$parentid=intval($parentid);

		if(in_array('siteid',$this->db->get_fields($table)))
		{
			$r=$this->db->fetch_all("SELECT * FROM `$table` WHERE `$table`.siteid=".SITEID." AND `$table`.parentid=$parentid".$where);
		}
		else
		{
			$r=$this->db->fetch_all("SELECT * FROM `$table` WHERE `$table`.parentid=$parentid".$where);
		}
		
		if(!$r)
		{
			return false;
		}
		else
		{
			foreach($r as $_r)
			{
				echo '<option value="'.$_r['id'].'">'.str_repeat('&nbsp;',($_r[$dotfield]-1)*4).'|-'.$_r[$fieldname].'</option>';
				$this->getoptions($table,$fieldname,$_r['id']);
			}
		}
	}

	/*
		栏目菜单
	*/
	function catoptions($parentid=0,$default=array(),$type=array(),$modelid='0')
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
					$where=$modelid?$_r['modelid']==$modelid:1;
					if(!$type)
					{
						if(($_r['type']==1 || $_r['type']==4 || $_r['type']==2)  && $check_admin->category_permission_check($_userid,$_r['id']) && $where)
						{
							$selected=in_array($_r['id'],$default)?' selected="selected"':'';
							echo '<option value="'.$_r['id'].'"'.$selected.'>'.str_repeat('&nbsp;',($_r['m']-1)*4).'|-'.$_r['catname'].'</option>';
							$this->catoptions($_r['id'],$default,$type);
						}
					}
					else
					{
						if(in_array($_r['type'],$type) && $check_admin->category_permission_check($_userid,$_r['id']) && $where)
						{
							$selected=in_array($_r['id'],$default)?' selected="selected"':'';
							echo '<option value="'.$_r['id'].'"'.$selected.'>'.str_repeat('&nbsp;',($_r['m']-1)*4).'|-'.$_r['catname'].'</option>';
							$this->catoptions($_r['id'],$default,$type);
						}
					}
				}
			}
		}
	}

	function htmlcatoptions($parentid=0,$default=array(),$type=array())
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
					$catsetting=getcatsetting($_r['id']);
					if(!$type)
					{
						if($_r['type']==1 && $check_admin->category_permission_check($_userid,$_r['id']))
						{
							$selected=in_array($_r['id'],$default)?' selected="selected"':'';
							echo '<option value="'.$_r['id'].'"'.$selected.'>'.str_repeat('&nbsp;',($_r['m']-1)*4).'|-'.$_r['catname'].'</option>';
							$this->catoptions($_r['id'],$default,$type);
						}
					}
					else
					{
						if((in_array($_r['type'],$type) && $check_admin->category_permission_check($_userid,$_r['id'])) || $_r['type']==2)
						{
							$selected=in_array($_r['id'],$default)?' selected="selected"':'';
							echo '<option value="'.$_r['id'].'"'.$selected.'>'.str_repeat('&nbsp;',($_r['m']-1)*4).'|-'.$_r['catname'].'</option>';
							$this->htmlcatoptions($_r['id'],$default,$type);
						}
					}
				}
			}
		}
	}

	function htmlconoptions($parentid=0,$default=array(),$type=array())
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
					$catsetting=getcatsetting($_r['id']);
					if(!$type)
					{
						if($_r['type']==1 && $check_admin->category_permission_check($_userid,$_r['id']))
						{
							$selected=in_array($_r['id'],$default)?' selected="selected"':'';
							echo '<option value="'.$_r['id'].'"'.$selected.'>'.str_repeat('&nbsp;',($_r['m']-1)*4).'|-'.$_r['catname'].'</option>';
							$this->catoptions($_r['id'],$default,$type);
						}
					}
					else
					{
						if(in_array($_r['type'],$type) && $check_admin->category_permission_check($_userid,$_r['id']))
						{
							$selected=in_array($_r['id'],$default)?' selected="selected"':'';
							echo '<option value="'.$_r['id'].'"'.$selected.'>'.str_repeat('&nbsp;',($_r['m']-1)*4).'|-'.$_r['catname'].'</option>';
							$this->htmlcatoptions($_r['id'],$default,$type);
						}
					}
				}
			}
		}
	}

	function catuseroptions($parentid=0,$default=array(),$type=array())
	{
		global $member,$_roleid,$_userid,$_groupid,$_gradeid;
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
					if(!$type)
					{
						if($_r['type']==1 && $member->catpostcheck($_r['id'],$_groupid,$_gradeid))
						{
							$selected=in_array($_r['id'],$default)?' selected="selected"':'';
							echo '<option value="'.$_r['id'].'"'.$selected.'>'.str_repeat('&nbsp;',($_r['m']-1)*4).'|-'.$_r['catname'].'</option>';
							$this->catoptions($_r['id'],$default,$type);
						}
					}
					else
					{
						if(in_array($_r['type'],$type) && $member->catpostcheck($_r['id'],$_groupid,$_gradeid))
						{
							$selected=in_array($_r['id'],$default)?' selected="selected"':'';
							echo '<option value="'.$_r['id'].'"'.$selected.'>'.str_repeat('&nbsp;',($_r['m']-1)*4).'|-'.$_r['catname'].'</option>';
							$this->catoptions($_r['id'],$default,$type);
						}
					}
				}
			}
		}
	}

	/*
		单页菜单
	*/
	function pageoptions($parentid=0)
	{
		$this->getoptions($this->page_table,'pagename',$parentid,'m');
	}

	/*
		admin栏目左侧菜单
	*/
	function admincatlist($parentid=0)
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
					if($_r['type']==1 ||$_r['type']==2  && $check_admin->category_permission_check($_userid,$_r['id']))
					{
						echo "\n";
						$class=ishaschildren($_r['id'])?"plus":(isfinalcatid($_r['id'])?"page":"minus");
						if($_r['modelid']>=0)
						{
						$url=!ishaschildren($_r['id'])?'?file=content&action=manage&catid='.$_r['id']:"javascript:togglecat('cat_li_".$_r['id']."','cat_p_".$_r['id']."');";
						}else
						{
						$url=!ishaschildren($_r['id'])?'?file=category&action=edit&id='.$_r['id']:"javascript:togglecat('cat_li_".$_r['id']."','cat_p_".$_r['id']."');";
						}
						$target=!ishaschildren($_r['id'])?' target="main"':'';
						echo '<li id="cat_li_'.$_r['id'].'" style="margin-left:'.($_r['m']*10).'px" class="'.$class.'"><a href="'.$url.'"'.$target.'>'.$_r['catname'].'</a></li>';
						if(ishaschildren($_r['id']))echo '<span id="cat_p_'.$_r['id'].'" style="display:none">';
						$this->admincatlist($_r['id']);
						if(ishaschildren($_r['id']))echo '</span>';
						echo "\n";
					}
				}
			}
		}
	}

	/*
		member栏目左侧菜单
	*/
	function membercatlist($parentid=0)
	{
		global $member,$_roleid,$_userid,$_groupid,$_gradeid;
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
					if($_r['type']==1 && $member->catpostcheck($_r['id'],$_groupid,$_gradeid) && $_r['ispost']==1)
					{
						echo "\n";
						$class=ishaschildren($_r['id'])?"plus":(isfinalcatid($_r['id'])?"page":"minus");
						$url=!ishaschildren($_r['id'])?'member/index.php?file=content&action=manage&catid='.$_r['id']:"javascript:togglecat('cat_li_".$_r['id']."','cat_p_".$_r['id']."');";
						$target=!ishaschildren($_r['id'])?' target="_self"':'';
						echo '<li id="cat_li_'.$_r['id'].'" style="margin-left:'.($_r['m']*10).'px" class="'.$class.'"><a href="'.$url.'"'.$target.'>'.$_r['catname'].'</a></li>';
						if(ishaschildren($_r['id']))echo '<span id="cat_p_'.$_r['id'].'" style="display:none">';
						$this->membercatlist($_r['id']);
						if(ishaschildren($_r['id']))echo '</span>';
						echo "\n";
					}
				}
			}
		}
	}
}
?>