<?php
/**
	* 管理员操作类
*/
class admin
{
	public $msg;
	public $_userid=0;
	public $pagestring='';
	private $db;
	private $table;
	private $member_table;
	private $cache_table;
	private $table_session;
	private $roleid_table;
	private $log_table;
	private $auth_table;
	private $category_roleid_table;

	function __construct()
	{
		global $db;
		$this->db=$db;
		$this->table=DB_PRE.'admin';
		$this->member_table=DB_PRE.'member';
		$this->cache_table=DB_PRE.'admin_cache';
		$this->table_session=DB_PRE.'session';
		$this->roleid_table=DB_PRE.'role';
		$this->log_table=DB_PRE.'log';
		$this->auth_table=DB_PRE.'permission';
		$this->category_roleid_table=DB_PRE.'category_roleid';
	}

	function admin()
    {
    	$this->__construct();
    }

	/*
		管理角色操作
	*/

	function get_catauth($userid)
	{
		$r=$this->db->fetch_one("SELECT * FROM `$this->category_roleid_table` WHERE `$this->category_roleid_table`.`adminid`=$userid");
		return $r?explode(',',$r['catid']):array();
	}

	function authlist($parentid=0)
	{
		global $admobj;
		$parentid=intval($parentid);
		$roleinfo=$admobj->rolelist();

		$r=$this->db->fetch_all("SELECT * FROM `$this->auth_table` WHERE `$this->auth_table`.`parentid`=$parentid");
		if(!$r)
		{
			return false;
		}
		else
		{
			foreach($r as $_r)
			{
				$rolelist='';
				$_r['roleid']=explode(',',$_r['roleid']);
				foreach($roleinfo as $key => $_roleinfo)
				{
					if($key==0)
					{
						$rolelist.='<input type="hidden" value="1" name="roleid['.$_r['id'].'][]" />';
					}
					$rolelist.='<input type="checkbox" style="border:0px" name="roleid['.$_r['id'].'][]" '.($_roleinfo['id']==1?' disabled="disabled"':'').' value="'.$_roleinfo['id'].'"'.($_roleinfo['id']==1 || in_array($_roleinfo['id'],$_r['roleid'])?' checked="checked"':'').' />'.$_roleinfo['name'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				}
				echo '<tr>
				<td width="50">&nbsp;</td>
				<td align="left" style="padding-left:20px">'.(!$_r['parentid']?'':'&nbsp;&nbsp;&nbsp;&nbsp;|-').$_r['name'].'</td>
				<td align="center">'.$rolelist.'</td>
			</tr>';
				$this->authlist($_r['id']);
			}
		}
	}

	function set_role_auth($roleids)
	{
		if(!$roleids || !is_array($roleids)) return false;
		foreach($roleids as $key => $roleid)
		{
			sort($roleid);
			$roleid=implode(',',array_map('intval',$roleid));
			$this->db->update($this->auth_table,array('roleid'=>$roleid),'id='.intval($key));
		}
		return true;
	}
	
	function rolelist()
	{
		return $this->db->fetch_all("SELECT * FROM `$this->roleid_table` WHERE 1");
	}

	function role_add($newrole)
	{
		if(!is_array($newrole) || !$newrole) return false;
		$newrole['issystem']=0;
		$newrole=array_map('strip_tags',$newrole);
		return $this->db->insert($this->roleid_table,$newrole);
	}

	function role_edit($orderby,$name)
	{
		if(!is_array($orderby) || !is_array($name) || !$orderby) return false;
		foreach($orderby as $key => $_orderby)
		{
			$this->db->update($this->roleid_table,array('orderby'=>$_orderby,'name'=>$name[$key]),'id='.$key);
		}
		return true;
	}

	function role_lock($disabled,$id)
	{
		$this->db->update($this->roleid_table,array('disabled'=>intval($disabled)),'id='.intval($id));
		$this->db->update($this->table,array('disabled'=>intval($disabled)),'roleid='.intval($id).' AND userid!='.ADMIN_FOUNDERS);
		$this->db->update($this->cache_table,array('disabled'=>intval($disabled)),'roleid='.intval($id).' AND userid!='.ADMIN_FOUNDERS);

		return true;
	}

	function role_delete($id)
	{
		$id=intval($id);
		
		/*
			检查是否是系统角色
		*/
		$r=$this->db->fetch_one("SELECT `$this->roleid_table`.`issystem` FROM `$this->roleid_table` WHERE `$this->roleid_table`.`id`=$id");
		if($r['issystem']) return false;

		/*
			删除角色表
		*/
		$this->db->mysql_delete($this->roleid_table,$id);
		
		/*
			删除该角色下的管理员 但是禁止删除创始人
		*/
		$this->db->query("DELETE FROM `$this->table` WHERE `$this->table`.`roleid`=".$id." AND `$this->table`.`userid`!=".ADMIN_FOUNDERS,true);
		$this->db->query("DELETE FROM `$this->cache_table` WHERE `$this->cache_table`.`roleid`=".$id." AND `$this->cache_table`.`userid`!=".ADMIN_FOUNDERS,true);

		return true;
	}

	function getrole($roleid=0)
	{
		$roleid=intval($roleid);
		if(!$roleid)return false;
		return $this->db->fetch_one("SELECT * FROM `$this->roleid_table` WHERE `$this->roleid_table`.`id`=$roleid");
	}

	/*
		管理员操作
	*/
	function adminlist($roleid=0)
	{	
		global $page;
		$roleid=abs(intval($roleid));
		include RETENG_ROOT.'include/datalist.class.php';
		$datalist = new datalist();
		$where=1;
		$where=$roleid?$where.' AND roleid='.$roleid:$where;
		$orderby='userid ASC';
		$page=max(isset($page)?intval($page):1,1);
		$pagesize=15;
		$result=$datalist->getlist($this->cache_table,$where,$orderby,$page,$pagesize,0,'right',$this->roleid_table,'roleid','id','name');
		$this->pagestring=$datalist->pagestring;
		return $result;
	}

	function add($newadmin)
	{
		global $module,$_roleid;
		if(!is_array($newadmin) || $this->name_exists($newadmin['username'])=='yes') return false;
		$catauth=implode(',',$newadmin['category']);
		unset($newadmin['category']);

		$newadmin['ip']=IP;
		$newadmin['logintime']=TIME;
		$newadmin['password']=PWD($newadmin['password']);
		$newadmin['roleid']=$_roleid==1?intval($newadmin['roleid']):$_roleid;
		$id=$this->db->insert($this->table,$newadmin);
		$newadmin['userid']=$id;
		$this->db->insert($this->cache_table,$newadmin);

		/*
			更新栏目权限表
		*/
		$this->db->insert($this->category_roleid_table,array('adminid'=>$id,'catid'=>$catauth));

		/*
			会员模块安装的话，添加到会员表
		*/
		if($module->module_disabled('member'))
		{
			include RETENG_ROOT.'member/include/member.class.php';
			$memobj=new member();

			$member=array();
			$member['modelid']=1;
			$member['groupid']=1;
			$member['gradeid']=10;
			$member['areaid']=CITY;
			$member['email']='@';
			$member['username']=$newadmin['username'];
			$member['password']=$newadmin['password'];
			$member['regtime']=$member['logintime']=TIME;
			$member['loginip']=IP;
			$member['level']=1;

			if($memobj->_exists('username', $newadmin['username']))
			{
				$memobj->edit_password_username($newadmin['username'], $newadmin['password'],true);
			}
			else
			{
				$memobj->add($member);
			}
		}
		return true;
	}

	function edit($admininfo,$id)
	{
		global $_userid,$_roleid,$module;
		$id=intval($id);
		$admininfo['roleid']=$_roleid==1?intval($admininfo['roleid']):$_roleid;

		$admininfo['password']=trim($admininfo['password']);

		if($_userid==$id || $_userid==ADMIN_FOUNDERS)
		{
			unset($admininfo['disabled']);
		}

		$catauth=implode(',',$admininfo['category']);
		unset($admininfo['category']);

		$admininfo['password']=preg_match('/[a-z0-9_]{3,25}/i',$admininfo['password'])?PWD($admininfo['password']):'';

		if(!$admininfo['password'])
		{
			unset($admininfo['password']);
		}

		$this->db->update($this->table,$admininfo,'userid='.$id);
		$this->db->update($this->cache_table,$admininfo,'userid='.$id);
		/*
			更新栏目权限表
		*/
		$this->db->update($this->category_roleid_table,array('catid'=>$catauth),'adminid='.$id);

		/*
			会员模块安装的话，更新会员表密码
		*/
		if($module->module_disabled('member') && $admininfo['password'])
		{
			$this->db->update(DB_PRE.'member',array('password'=>PWD($admininfo['password'])),'username=\''.$admininfo['username'].'\'');
		}
		return true;
	}

	function name_exists($username)
	{
		if(empty($username))return 'no';
		if(!$this->check_username($username)) return 'yes';
		$r=$this->db->fetch_one("SELECT `$this->cache_table`.`userid` FROM `$this->cache_table` WHERE `$this->cache_table`.`username`='{$username}'");
		return $r?'yes':'no';
	}

	function delete($id)
	{
		global $_userid;
		if(intval($id)==ADMIN_FOUNDERS || intval($id)==$_userid) return false;

		$admininfo=$this->get_byid($id);

		$this->db->mysql_delete($this->table,intval($id),'userid');
		$this->db->mysql_delete($this->cache_table,intval($id),'userid');

		if($module->module_disabled('member') && $admininfo['password'])
		{
			$this->db->update(DB_PRE.'member',array('groupid'=>4),'username=\''.$admininfo['username'].'\'');
		}

		return true;
	}
	
	function lock($id,$disabled=0)
	{
		global $_userid;
		if(intval($id)==ADMIN_FOUNDERS || intval($id)==$_userid) return false;

		$this->db->update($this->table,array('disabled'=>intval($disabled)),'userid='.intval($id));
		$this->db->update($this->cache_table,array('disabled'=>intval($disabled)),'userid='.intval($id));
		return true;
	}

	function allowmultilogin($id,$allowmultilogin=0)
	{
		$this->db->update($this->table,array('allowmultilogin'=>intval($allowmultilogin)),'userid='.intval($id));
		$this->db->update($this->cache_table,array('allowmultilogin'=>intval($allowmultilogin)),'userid='.intval($id));
		return true;
	}

	/*
		日志
	*/

	function loglist()
	{
		global $page;
		include RETENG_ROOT.'include/datalist.class.php';
		$datalist = new datalist();
		$where=1;
		$orderby='id DESC';
		$page=max(isset($page)?intval($page):1,1);
		$pagesize=15;
		$result=$datalist->getlist($this->log_table,$where,$orderby);
		$this->pagestring=$datalist->pagestring;
		return $result;
	}

	function log_clear()
	{
		require_once RETENG_ROOT.'/include/admin/adminlog.class.php';
		$adminlog=new adminlog();
		return $adminlog->clear();
	}

	/*
		管理登陆、登出操作
	*/

	function login($username,$passord)
	{
		if(!$this->check_username($username))
		{
			$this->msg=-1; // 用户不存在
			return false;
		}

		$r=$this->get($username);
		if(!$r)
		{
			$this->msg=-1; // 用户不存在
			return false;
		}

		if(PWD($passord)!=$r['password'])
		{
			$this->msg=-2; // 用户密码不正确
			return false;
		}
		
		if($r['disabled'])
		{
			$this->msg=-3; // 管理员被禁用
			return false;
		}

		if(!$r['allowmultilogin'] && $this->is_multilogin($r['userid']))
		{
			$this->msg=-4; // 多地点不同IP登陆
			return false;
		}
		$_SESSION['is_admin']=true;
		$_SESSION['admin_id']=intval($r['userid']);

		/*
			更新用户登陆状态
		*/
		$loginlog=array();
		$loginlog['ip']=IP;
		$loginlog['logintime']=TIME;

		$this->db->update($this->table,$loginlog,'userid='.intval($r['userid']));
		$this->db->update($this->cache_table,$loginlog,'userid='.intval($r['userid']));

		unset($loginlog);
		return true;
	}

	function logout()
	{
		unset($_SESSION['is_admin'],$_SESSION['admin_id']);
		session_destroy();
		return true;
	}

	function is_multilogin($userid)
	{
		$userid=intval($userid);
		$r=$this->db->fetch_one("SELECT `ip` FROM `$this->table_session` WHERE `userid`=$userid");
		return ($r && $r['ip']!=IP);
	}

	function get($username)
	{
		if(!$this->check_username($username)) return false;
		$sql = "SELECT * FROM `$this->cache_table` WHERE `$this->cache_table`.`username`='$username' LIMIT 1";
		$user = $this->db->fetch_one($sql);
		return $user;
	}

	function get_byid($userid)
	{
		$sql = "SELECT * FROM `$this->cache_table` WHERE `$this->cache_table`.`userid`=$userid LIMIT 1";
		$user = $this->db->fetch_one($sql);
		return $user;
	}

	function get_rolename($roleid)
	{
		$roleid=intval($roleid);
		$r=$this->db->fetch_one("SELECT `$this->roleid_table`.`name` FROM `$this->roleid_table` WHERE `$this->roleid_table`.`id`=$roleid");
		return $roleid && $r?$r['name']:'';
	}

	function check_username($str)
	{
		if(!$str)return false;
		if(strlen(trim_str($str))>30)return false;
		return preg_match('/^[\x80-\xff_a-zA-Z0-9]{1,60}$/i',trim_str($str));
	}
}
?>
