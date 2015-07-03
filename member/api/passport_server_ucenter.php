<?php
if($action == 'register')
{
	$uid = uc_call("uc_user_register", array($username, $password, $email));

	if($uid <= 0)
	{
		if($uid == -1)
		{
			showmsg('用户名不合法');
		}
		elseif($uid == -2)
		{
			showmsg('包含要允许注册的词语');
		}
		elseif($uid == -3)
		{
			showmsg('用户名已经存在');
		}
		elseif($uid == -4)
		{
			showmsg('Email 格式有误');
		}
		elseif($uid == -5)
		{
			showmsg('Email 不允许注册');
		}
		elseif($uid == -6)
		{
			showmsg('该 Email 已经被注册');
		}
		else
		{
			showmsg('请正确设置 UC或者关闭 UC');
		}

	}
	$userid = '';
	$r = $member->get_by_touserid($uid);
	if(!$r)
	{
		$r=cache_read('model'.$modelid.'.cache.php',RETENG_ROOT.'data/cache_module/');
		$registerinfo['modelid']=$modelid;
		$registerinfo['touserid'] = $uid;
		$registerinfo['password']=PWD($password);
		$registerinfo['logintime']=$registerinfo['regtime']=TIME; 
		$registerinfo['loginip']=IP;
		$registerinfo['expire']='';
		$registerinfo['groupid']=AUDIT_TYPE==1?4:3;
		$registerinfo['level']=AUDIT_TYPE==1?1:0;
		$registerinfo['gradeid']=10;
		$registerinfo['areaid']=CITY;
		$member->add($registerinfo);
	}
}
elseif ($action == 'login')
{
    $username = trim($username);
    $password = trim($password);
	$dircmsUsername=$username;
	$dircmsPassword=$password;

	list($uid, $username, $uc_password, $email) =  uc_call("uc_user_login", array($username, $password));

	if($uid==-1){
		$_userid = $member->get_userid($dircmsUsername);
		$_userInfo=$member->get($_userid, '`id`,`username`,`email`,`password`');
		if($_userInfo['id']>0){
			$md5_password = PWD($dircmsPassword);
			if($_userInfo['password'] != $md5_password)
			{
				if($_userInfo['password'] == substr($md5_password, 8, 16))
				{
					$uid = uc_call("uc_user_register", array($_userInfo['username'], $dircmsPassword, $_userInfo['email']));
					if($uid<=0){
						showmsg('用户不存在,或者被删除');
					}
				}
				else
				{
					showmsg('用户不存在,或者被删除');
					return FALSE;
				}
			}else{
				$uid = uc_call("uc_user_register", array($_userInfo['username'], $dircmsPassword, $_userInfo['email']));
				if($uid<=0){
					showmsg('用户不存在,或者被删除');
				}
			}
		}
		list($uid, $username, $uc_password, $email) =  uc_call("uc_user_login", array($dircmsUsername, $dircmsPassword));
	}
	if( $uid == -1 )
	{
		showmsg('用户不存在,或者被删除');
	}
	if($uid == '-2')
	{
		showmsg('登陆密码错误',$RETENG['site_url'].'member/index.php?file=login&action=login');
	}
    $code = uc_call('uc_user_synlogin', array($uid));
	
	$_userid=$retengcms_userid = $member->get_userid($username);
	$modelid=$member->get($_userid, 'modelid');
	$modelid=$modelid['modelid'];

	if($retengcms_userid<=0 && $uid > 0)
	{
		$r=cache_read('model'.$modelid.'.cache.php',RETENG_ROOT.'data/cache_module/');
		$registerinfo['username'] = $username;
		$registerinfo['email'] = $email;
		$registerinfo['modelid'] = 1;
		$registerinfo['touserid'] = $uid;
		$registerinfo['password']=PWD($password);
		$registerinfo['logintime']=$registerinfo['regtime']=TIME; 
		$registerinfo['loginip']=IP;
		$registerinfo['expire']='';
		$registerinfo['groupid']=AUDIT_TYPE==1?4:3; 
		$registerinfo['level']=AUDIT_TYPE==1?1:0; 
		$registerinfo['gradeid']=10;
		$registerinfo['areaid']=CITY;
		$member->add($registerinfo);

	}else if($retengcms_userid>0 && $uid > 0){
		$arr_member=array();
		$arr_member['touserid'] = $uid;
		$member->set($retengcms_userid,$arr_member);
	}
}
elseif ($action == 'logout')
{
    $ucsynlogout = uc_call('uc_user_synlogout', array());
}
elseif ($action == 'editpwd')
{
	uc_call("uc_user_edit", array($username, $old_password, $new_password, $email));
	if($ucresult == -1)
	{
		showmsg('旧密码不正确');
	}
	elseif($ucresult == -4)
	{
		showmsg('Email 格式有误');
	}
	elseif($ucresult == -5)
	{
		showmsg('Email 不允许注册');
	}
	elseif($ucresult == -6)
	{
		showmsg('该 Email 已经被注册');
	}
}
elseif ($action == 'edit')
{
	uc_call("uc_user_edit", array($username, '', $password, $email, 1));
}
?>
