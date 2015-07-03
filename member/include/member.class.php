<?php
/**
	* 会员类
	* @author reteng
	* @copyright			(C) 2009-2011 RTCMS
	* @lastmodify			2014-07-28
*/

class member
{
	public $msg='';
	public $activateurl='';
	private $db;
	private $table;
	private $group_table;
	private $grade_table;
	private $table_vipread;
	private $cache_table;

	function __construct()
	{
		global $db;
		$this->db=&$db;
		$this->table='`'.DB_NAME.'`.`'.DB_PRE.'member`';
		$this->group_table=DB_PRE.'membergroup';
		$this->grade_table=DB_PRE.'membergrade';
		$this->table_vipread='`'.DB_NAME.'`.`'.DB_PRE.'vipread`';
		$this->cache_table='`'.DB_NAME.'`.`'.DB_PRE.'member_cache`';
	}

	function member()
	{
		$this->__construct();
	}

	function groupidviewcatid($groupid)
	{
		$groupid=intval($groupid);
		if(!$groupid)return array();
		$info=$this->db->fetch_one("SELECT `$this->group_table`.`viewcatid` FROM `$this->group_table` WHERE `$this->group_table`.`id`=$groupid");
		return explode(',',$info['viewcatid']);
	}
	
	function gradeidviewcatid($gradeid)
	{
		$gradeid=intval($gradeid);
		if(!$gradeid)return array();
		$info=$this->db->fetch_one("SELECT `$this->grade_table`.`viewcatid` FROM `$this->grade_table` WHERE `$this->grade_table`.`grade`=$gradeid");
		return explode(',',$info['viewcatid']);
	}

	function cache_member($id)
	{
		$id=intval($id);
		if(!$id)return false;
		$info=$this->db->fetch_one("SELECT * FROM $this->table WHERE $this->table.`id`=$id");
		$this->db->insert($this->cache_table,$info,true);
		return $info;
	}

	function catpostcheck($catid,$groupid=4,$gradeid=10)
	{
		$groupid=intval($groupid);
		$gradeid=intval($gradeid);
		if(!$gradeid || !$gradeid) return false;

		$group=cache_read('membergroup'.$groupid.'.cache.php',RETENG_ROOT.'data/cache_module/');
		$grade=cache_read('membergrade'.$gradeid.'.cache.php',RETENG_ROOT.'data/cache_module/');
		if(!$group || !$grade) return false;
		
		$group=explode(',',$group['postcatid']);
		$grade=explode(',',$grade['postcatid']);

		return ((in_array($catid,$group) || in_array(0,$group)) && (in_array($catid,$grade) || in_array(0,$grade)))?true:false;
	}

	function catviewcheck($catid,$groupid=4,$gradeid=10)
	{
		$groupid=intval($groupid);
		$gradeid=intval($gradeid);
		if(!$gradeid || !$gradeid) return false;

		$group=cache_read('membergroup'.$groupid.'.cache.php',RETENG_ROOT.'data/cache_module/');
		$grade=cache_read('membergrade'.$gradeid.'.cache.php',RETENG_ROOT.'data/cache_module/');
		if(!$group || !$grade) return false;
		
		$group=explode(',',$group['viewcatid']);
		$grade=explode(',',$grade['viewcatid']);

		return ((in_array($catid,$group) || in_array(0,$group)) && (in_array($catid,$grade) || in_array(0,$grade)))?true:false;
	}

	function modcheck($modid,$gradeid=10)
	{
		$gradeid=intval($gradeid);
		if(!$gradeid) return false;
		$grade=cache_read('membergrade'.$gradeid.'.cache.php',RETENG_ROOT.'data/cache_module/');
		if(!$grade) return false;
		$grade=explode(',',$grade['module']);
		return in_array($modid,$grade);
	}
	
	/*
		读取会员信息，优先从缓存读取
	*/
	function get($userid, $fields = '*' ,$more=false)
	{
		$userid = intval($userid);
		$baseinfo=$this->db->fetch_one("SELECT {$fields} FROM {$this->cache_table} WHERE {$this->cache_table}.`id`=".$userid);
		if(!$baseinfo) 
		{
			$baseinfo=$this->db->fetch_one("SELECT {$fields} FROM {$this->table} WHERE {$this->table}.`id`=".$userid);
		}
		
		if(!$more || !$baseinfo || !$baseinfo['modelid'])
		{	
			return $baseinfo;
		}
		else
		{
			$modelinfo=cache_read('model'.$baseinfo['modelid'].'.cache.php',RETENG_ROOT.'data/cache_module/');
			$moreinfo=$this->db->fetch_one("SELECT * FROM `".DB_NAME."`.`".DB_PRE.$modelinfo['table']."` WHERE `".DB_NAME."`.`".DB_PRE.$modelinfo['table']."`.`userid`=".intval($userid));
			return array_merge($baseinfo,$moreinfo);
		}
	}

	function getmore($userid, $fields = '*') // （仅）读取会员附加表信息
	{
		$userid = intval($userid);
		$baseinfo=$this->db->fetch_one("SELECT modelid FROM {$this->cache_table} WHERE {$this->cache_table}.`id`=".$userid);
		if(!$baseinfo) 
		{
			$baseinfo=$this->db->fetch_one("SELECT modelid FROM {$this->table} WHERE {$this->table}.`id`=".$userid);
		}
		
		$modelinfo=cache_read('model'.$baseinfo['modelid'].'.cache.php',RETENG_ROOT.'data/cache_module/');
		return $this->db->fetch_one("SELECT * FROM `".DB_NAME."`.`".DB_PRE.$modelinfo['table']."` WHERE `".DB_NAME."`.`".DB_PRE.$modelinfo['table']."`.`userid`=".intval($userid));
	}

	function getform($modelid,$default=array())
	{
		include RETENG_ROOT.'include/form.class.php';
		$form = new form('info');
		return $form->get($modelid,$default,'member');
	}
	
	/*
		QQ整合时使用
	*/
	function get_by_openid($openid,$fields='*')
	{
		$openid = trim($openid);
		return $this->db->fetch_one("SELECT {$fields} FROM $this->table WHERE $this->table.`openid`='{$openid}' LIMIT 1");
	}
	
	/*
		UC整合时使用
	*/
	function get_by_touserid($touserid,$fields='*')
	{
		$touserid = intval($touserid);
		return $this->db->fetch_one("SELECT {$fields} FROM $this->table WHERE $this->table.`touserid`=$touserid LIMIT 1");
	}

	function edit_password_username($username, $password,$md5=false)
	{
		if(!is_username($username)) return false;
		$password = $md5?$password:PWD($password);
		$this->db->update($this->table,array('password'=>$password),'username=\''.$username.'\'');
		$this->db->update($this->cache_table,array('password'=>$password),'username=\''.$username.'\'');

		return true;
	}

	function add($info)
	{
		$info['score']=5;
		$info['amount']=0;
		$info['logintime']=$info['regtime']=TIME;

		$r=cache_read('model'.$info['modelid'].'.cache.php',RETENG_ROOT.'data/cache_module/');

		if($r && $r['table'])
		{
			if($this->db->insert($this->table,$info,false))
			{	
				$insertid=$this->db->last_insert_id();
				$info['userid']=$insertid;
				$this->db->insert('`'.DB_NAME.'`.`'.DB_PRE.$r['table'].'`',$info,true);
				return $insertid;
			}
			return 0;
		}
		else
		{
			return 0;
		}
	}

	function set($userid, $data = array())
	{
		$userid = intval($userid);
		if ($userid < 1) return false;
		$this->db->update($this->cache_table, $data, "id=$userid");
		$this->db->update($this->table, $data, "id=$userid");
		return true;
	}

	/*
		正常使用
	*/

	function get_cache_userid($username)
	{
		if(!is_username($username)) 
		{
			return false;
		}
		$r = $this->db->fetch_one("SELECT id FROM $this->cache_table WHERE $this->cache_table.`username`='$username' LIMIT 1");
		return $r && $r['id']?$r['id']:false;
	}

	function get_userid($username)
	{
		if(!is_username($username)) 
		{
			return false;
		}
		$r = $this->db->fetch_one("SELECT $this->table.`id` FROM $this->table WHERE $this->table.`username`='$username' LIMIT 1");
		return $r && $r['id']?$r['id']:false;
	}

	function _exists($field, $value)
	{
		return $this->db->fetch_one("SELECT id FROM $this->table WHERE $this->table.`$field`='$value' LIMIT 0, 1");
	}

	function vipread($userid,$contentid,$arr=array())
	{
		global $_username,$module,$memlang;
		
		/*
			状态表
		*/
		$sql="SELECT * FROM $this->table_vipread WHERE $this->table_vipread.`contentid`=$contentid AND $this->table_vipread.`userid`=$userid";
		if(!$this->db->fetch_one($sql))
		{
			$this->set($userid,$arr);

			if(!$module->module_disabled('pay'))
			{
				/*
					用户财务日志
				*/

				include RETENG_ROOT.'pay/include/pay.class.php';
				$pay=new pay();
				
				$key=array_keys($arr);
				$log=array();
				$log['sn']=date('YmdHis',TIME).get_randstr(5);
				$log['username']=$_username;
				$log['ip']=IP;
				$log['manage']=0;
				$log['type']=$key[0];
				$log['amount']='-';
				$log['payment']=$memlang['vip-read'];
				$log['note']=$memlang['vip-read'];
				$log['time']=TIME;
				$log['status']=2;
				$pay->set_log($log);
			}

			$this->db->insert($this->table_vipread,array('contentid'=>$contentid,'userid'=>$userid),true);
		}
		return true;
	}

	function getpwd($username,$email)
	{
		global $RETENG,$memlang;
		if(!$username || !$email || !is_email($email) || !is_username($username))
		{
			$this->msg = $memlang['getpwd-user-noexists'];
			return false;
		}
		
		$userinfo=$this->get($this->get_userid($username));

		if(!$userinfo)
		{
			$this->msg = $memlang['getpwd-username-noexists'];
			return false;
		}

		if($userinfo['email']!=$email)
		{
			$this->msg = $memlang['getpwd-username-email'];
			return false;
		}
		
		/*
			设置新密码
		*/
		$newpwd=mt_rand(100000,999999);
		$this->set($userinfo['id'], array('password'=>PWD($newpwd)));
		require_once(RETENG_ROOT.'include/email.class.php');
		$sendemail=new email();

		$sendemail->send($userinfo['email'], $RETENG['site_name'].'找回密码操作',$userinfo['username'].'，您好，您的新密码已经重新设置为: '.$newpwd.', 请尽快登录会员中心修改密码! <a href="'.$RETENG['site_url'].'/member/index.php?file=login&action=login">点此登录!</a>',MAIL_USER);

		include RETENG_ROOT.'include/sms.class.php';
		$sendsms=new sms();
		$sendsms->sendSMS($userinfo['telephone'],$userinfo['username'].'，您好，您的新密码已经重新设置为: '.$newpwd.', 请尽快登录会员中心修改密码! -'.$RETENG['site_name']);

		return true;
	}

	function activate($verify,$id)
	{
		global $RETENG,$memlang;
		$userinfo=$this->get(intval($id));

		if(!$userinfo || !intval($id))
		{
			$this->msg = $memlang['activate-err'];
			return false;
		}

		if(md5(AUTH_KEY.$userinfo['id'].$userinfo['username'].$userinfo['password'].$userinfo['modelid'])!=$verify)
		{
			$this->msg = $memlang['activate-err2'];
			return false;
		}

		$this->set($userinfo['id'],array('level'=>1,'groupid'=>4));
		return true;
	}

	function smsactivate($smscheck)
	{
		global $RETENG,$memlang;
		$userinfo=$this->get($_SESSION['userid']);

		if(!$userinfo || !preg_match('/^[0-9]{4}$/',$smscheck))
		{
			$this->msg = $memlang['activate-err'];
			return false;
		}

		if($_SESSION['smscheck']==$smscheck)
		{
			$this->set($userinfo['id'],array('level'=>1,'groupid'=>4));
			return true;
		}	
	}

	function is_email($email)
	{
		return (($this->_exists('email',$email)&&!SAME_EMAIL_ENABLED) || !is_email($email))?false:true;
	}

	function register($modelid,$username,$password,$telephone,$email,$invitionaluser=0,$openid='')
	{
		global $RETENG,$memlang;
		$modelid=intval($modelid);

		if(!REGISTER_ENABLED)
		{
			$this->msg = $memlang['register-closed'];
			return false;
		}

		$modelinfo=cache_read('model'.$modelid.'.cache.php',RETENG_ROOT.'data/cache_module/');
		if(!$modelid || !$modelinfo)
		{
			$this->msg = $memlang['register-model-noexists'];
			return false;
		}

		if(!$modelinfo['register'])
		{
			$this->msg = $memlang['register-closed-model'].$modelinfo['name'].'!';
			return false;
		}

		if(!is_username($username))
		{
			$this->msg = $memlang['register-username-tips'];
			return false;
		}

		if(!is_pwd($password))
		{
			$this->msg = $memlang['register-pwd-tips'];
			return false;
		}

		if(AUDIT_TYPE==4 && !preg_match('/^((\(\d{3}\))|(\d{3}\-))?1[3-9][0-9]\d{8}?$|15[0-9]\d{8}?$/i',$telephone))
		{
			$this->msg = $memlang['register-err-telephone'];
			return false;
		}
		
		if($this->get_userid($username))
		{
			$this->msg = $memlang['register-err-userexists'];
			return false;
		}
		
		if(!$this->is_email($email))
		{
			$this->msg = $memlang['register-err-emailexists'];
			return false;
		}

		if($invitionaluser && !INVITIONAL)
		{
			$this->msg = $memlang['register-err-invitionaluser'];
			return false;
		}

		if(!SAME_IP_ENABLED)
		{
			$ip=$this->db->fetch_one("SELECT $this->table.`regtime` FROM $this->table WHERE $this->table.`loginip`='".IP."' LIMIT 0,1");
			if($ip && strtotime(date('Y-m-d',$ip['regtime']))==strtotime(date('Y-m-d',TIME)))
			{
				$this->msg = $memlang['register-err-ip'];
				return false;
			}
		}

		/*
			校验完毕，设置注册数组
		*/
		$info['openid']=preg_match('/^[0-9A-F]{32}$/',$info['openid'])?$openid:'';
		$info['modelid']=$modelid;
		$info['username']=$username;
		$info['telephone']=$telephone;
		$info['password']=PWD($password);
		$info['email']=$email;
		$info['logintime']=$info['regtime']=TIME; 
		$info['loginip']=IP;
		$info['expire']='';
		$info['groupid']=AUDIT_TYPE==1?4:3; //设置用户组
		$info['level']=AUDIT_TYPE==1?1:0;
		$info['gradeid']=10;
		$info['areaid']=CITY;
		$info['score']=5;
		$info['amount']=0;

		/*
			开始更新数据库
		*/
		$insertid=$this->db->insert($this->table,$info);
		if($insertid)
		{
			$this->db->insert('`'.DB_NAME.'`.`'.DB_PRE.$modelinfo['table'].'`',array('userid'=>$insertid));

			/*
				邀请注册的话则给相应会员以积分
			*/
			if($invitionaluser && INVITIONAL)
			{
				$this->db->query("UPDATE $this->table SET $this->table.`point`=$this->table.`point`+".intval(INVITIONAL)." WHERE $this->table.`id`=".intval($invitionaluser));
			}
			
			/*
				发送激活邮件
			*/
			if(AUDIT_TYPE=='3')
			{
				include RETENG_ROOT.'include/email.class.php';
				$sendemail=new email();

				$site_name=$RETENG['site_name'];
				$site_url=$RETENG['site_url'];
				$this->activateurl=$RETENG['site_url'].'member/index.php?file=login&action=activate&verify='.md5(AUTH_KEY.$insertid.$username.$info['password'].$modelid).'&id='.$insertid;

				$emailbody=stripslashes(file_get_contents(RETENG_ROOT.'member/template/audit_email.html'));
				$emailbody=str_replace('{$site_name}',$site_name,$emailbody);
				$emailbody=str_replace('{$site_url}',$site_url,$emailbody);
				$emailbody=str_replace('{$username}',$username,$emailbody);
				$emailbody=str_replace('{$email}',$email,$emailbody);
				$emailbody=str_replace('{$activateurl}',$this->activateurl,$emailbody);
				$sendemail->send($email, $RETENG['site_name'].$memlang['audit_email'],$emailbody,MAIL_USER);
				
			}

			if(AUDIT_TYPE=='4')
			{
				include RETENG_ROOT.'include/sms.class.php';
				$sendsms=new sms();

				$site_name=$RETENG['site_name'];
				$site_url=$RETENG['site_url'];
				$_SESSION['smscheck']=get_randstr(4);
				$_SESSION['userid']=$insertid;

				$smsbody=stripslashes(file_get_contents(RETENG_ROOT.'member/template/audit_sms.html'));
				$smsbody=str_replace('{$site_name}',$site_name,$smsbody);
				$smsbody=str_replace('{$site_url}',$site_url,$smsbody);
				$smsbody=str_replace('{$username}',$username,$smsbody);
				$smsbody=str_replace('{$email}',$email,$smsbody);
				$smsbody=str_replace('{$smscheck}',$_SESSION['smscheck'],$smsbody);
				$sendsms->sendSMS($telephone,$smsbody);
			}
			$this->cache_member($insertid);
			return true;
		}
		else
		{
			$this->db->mysql_delete($this->table,$insertid);
			$this->msg = 'Abnormal end';
			return false;
		}
	}

	function login($username,$password,$cookietime=0)
	{
		global $RETENG,$memlang;

		if(!is_username($username))
		{
			$this->msg = $memlang['login-err-username'];
			return false;
		}

		if(!is_pwd($password))
		{
			$this->msg = $memlang['login-err-pwd'];
			return false;
		}
	
		/*
			从缓存读取UserID ，如果该信息不存在则从 非缓存表读取，并更新缓存表
		*/
		$userid=$this->get_cache_userid($username);
		if(!$userid)
		{
			$userid=$this->get_userid($username);
			
		}
		
		if(!$userid)
		{
			$this->msg = $memlang['login-err-nousername'];
			return false;
		}
		else
		{
			$userinfo=$this->cache_member($userid);
		}
		
		if($userinfo['password']!=PWD($password))
		{
			$this->msg= $memlang['login-err-pwd'];
			return false;
		}

		/*
			检验用户状态
		*/
		if(!$userinfo['level'] || $userinfo['groupid']==3)
		{
			$this->msg=$memlang['login-err-status0'];
			return false;
		}

		/*
			用户顺利登陆，检验 升级时效, 并更新用户登陆IP、次数、登陆时间
		*/
		$userinfo['logintime']=TIME;
		$userinfo['logintimes']=$userinfo['logintimes']+1;
		$userinfo['loginip']=IP;
		if($_SESSION['openid'] && preg_match('/^[0-9A-F]{32}$/i',$_SESSION['openid']))
		{
			$userinfo['openid']=$_SESSION['openid'];
		}

		if($userinfo['level']==2 && $userinfo['expire'] && $userinfo['expire']< TIME && $userinfo['gradeid']>10)
		{
			$userinfo['expire']='';
			$userinfo['gradeid']=10;
			$userinfo['level']=1;
		}
		$this->db->update($this->table,$userinfo,'id='.$userid);
		$this->db->update($this->cache_table,$userinfo,'id='.$userid);

		/*
			设置并存储登陆Cookie信息
		*/
		if(!$cookietime)
		{
			$get_cookietime=get_cookie('cookietime');
		}
		$_cookietime=$cookietime?intval($cookietime):($get_cookietime?$get_cookietime:0);
		$cookietime=$_cookietime?TIME + $_cookietime:0;
		$retengcms_auth_key=md5(AUTH_KEY.$_SERVER['HTTP_USER_AGENT']);
		$retengcms_auth=retengcms_auth($userid."\t".PWD($password),'ENCODE',$retengcms_auth_key);
		set_cookie('auth',$retengcms_auth,$cookietime);
		set_cookie('cookietime',$_cookietime, $cookietime);
		return $userinfo;
	}

	function logout()
	{
		global $_userid;
		
		if($_userid)
		{
			/*
				清除缓存表数据
			*/
			$this->db->mysql_delete($this->cache_table,$_userid);
		}
		set_cookie('auth', '');
		set_cookie('cookietime', '');
		return true;
	}
}
