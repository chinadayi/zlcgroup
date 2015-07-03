<?php
	!defined('MEMBER_CENTER') && exit('Access Denied!');	
	$action=isset($action)?$action:'login';
	session_start();
	
	switch($action)
	{
		case 'login':
			if($_userid) 
			{
				header('location:index.php');
				exit();
			}

			if(isset($do_submit) && $do_submit)
			{
				$forwardurl=isset($forwardurl)?$forwardurl:get_cookie('http_referer');
				$forwardurl=strpos(strtolower($forwardurl),'&action=logout')?'':$forwardurl;
				$url=$forwardurl?$forwardurl:(getpreurl()?getpreurl():$RETENG['site_url'].'member/index.php');

				if(LOGIN_CHECKCODE_ENABLED && ($_SESSION['checkcode']!=$chkcode || !$_SESSION['checkcode']))
				{
					showmsg($memlang['err-checkcode']);
				}

				if(UC)
				{
					$action = 'login';
					require dirname(__FILE__).'/api/passport_server_ucenter.php';
					$member->edit_password_username($username, $password);
				}
				else
				{
					$code='';
				}

				$userinfo=$member->login($username,$password,$cookietime);
				if(!$userinfo)
				{
					showmsg($member->msg);
				}
				else
				{
					$_userid=$userinfo['id'];
					$modelid=$userinfo['modelid'];
					unset($_SESSION['checkcode']);
					set_cookie('http_referer','');
					showmsg($memlang['login-ok'].$code,$url);
				}
			}
			$http_referer=isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] ?$_SERVER['HTTP_REFERER']:'';
			if(substr($http_referer,0,strlen(SITE_URL))!=SITE_URL || strpos($http_referer,'&action=logout'))
			{
				$http_referer='';
			}
			set_cookie('http_referer',$http_referer);
			$ischeckcode=LOGIN_CHECKCODE_ENABLED?true:false;
			include member_tlp('login');
			break;
		case 'register':
			$url=isset($forwardurl)?$forwardurl:(getpreurl()?getpreurl():$RETENG['site_url'].'member/index.php');

			if($_userid) 
			{
				header('location:index.php');
				exit();
			}

			if(!REGISTER_ENABLED)
			{
				showmsg($memlang['register-closed'],$url);
			}


			if(isset($do_submit) && $do_submit)
			{
				if(REG_CHECKCODE_ENABLED && ($_SESSION['checkcode']!=$chkcode || !$_SESSION['checkcode']))
				{
					showmsg($memlang['err-checkcode']);
				}
				
				if(!isset($regagreement))
				{
					showmsg($memlang['register-err-rule']);
				}

				if($pwd!=$pwdconfirm)
				{
					showmsg($memlang['register-err-pwd2']);
				}

				$invitionaluser=INVITIONAL?intval($invitionaluser):0;

				/*	
					开始注册动作 2011-09-24 23:11
				*/
				if(UC)
				{
					$url=$url?$url:$forwardurl;
					$password=trim($pwd);
					@extract($registerinfo);
					require dirname(__FILE__).'/api/passport_server_ucenter.php';
					showmsg($memlang['register-ok'].$code,$url);
				}
				else
				{
					if(!isset($userid) || !$userid)
					{
						$userid=$member->register($registerinfo['modelid'],$registerinfo['username'],$pwd,$registerinfo['telephone'],$registerinfo['email'],$invitionaluser,$registerinfo['openid']);
					}

					if(!isset($userid) || !$userid)
					{
						showmsg($member->msg);
					}
					else
					{	
						$url=isset($forwardurl)?$forwardurl:(getpreurl()?getpreurl():$RETENG['site_url'].'member/index.php');

						if(AUDIT_TYPE=='1')
						{
							$member->login($registerinfo['username'],$pwd);
							include member_tlp('audit_pass');
							exit();
						}
						elseif(AUDIT_TYPE=='2')
						{
							include member_tlp('audit_admin');
							exit();
						}
						elseif(AUDIT_TYPE=='3')
						{
							$emailhost=explode('@',$registerinfo['email']);
							$emailhost='http://mail.'.$emailhost[1];
							include member_tlp('audit_email');
							exit();
						}
						elseif(AUDIT_TYPE=='4')
						{
							include member_tlp('audit_sms');
							exit();
						}
					}
				}
			}
			$http_referer=isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] ?$_SERVER['HTTP_REFERER']:'';
			if(substr($http_referer,0,strlen(SITE_URL))!=SITE_URL || strpos($http_referer,'&action=logout'))
			{
				$http_referer='';
			}
			set_cookie('http_referer',$http_referer);

			$ischeckcode=REG_CHECKCODE_ENABLED?true:false;

			$r=cache_read('model.cache.php',RETENG_ROOT.'data/cache_module/');
			$membermodel='';			
			foreach($r as $i => $_r)
			{				
				$membermodel.='<label><input type="radio"'.($i==0?' checked="checked"':'').' name="registerinfo[modelid]" value="'.$_r['id'].'" />'.$_r['name'].'</label>&nbsp;&nbsp;';
			}
			
			include member_tlp('register');
			break;
		case 'qqbind':
			include member_tlp('qqbind');
			break;
		case 'smscodecheck':
			exit($_SESSION['smscheck']==$data && preg_match('/^[0-9]{4}$/',$data)?'ok':'err');
			break;
		case 'smsactivate':
			$result=$member->smsactivate($smscheck);
			if(!$result)
			{
				showmsg($memlang['activate-err2']);
			}
			else
			{
				showmsg($memlang['activate-ok'],SITE_URL.'member/index.php?file=login&action=login');
			}
			break;
		case 'getpwd':
			if($_userid) 
			{
				header('location:index.php');
				exit();
			}

			if($do_submit)
			{
				if($_SESSION['checkcode']!=$chkcode || !$_SESSION['checkcode'])showmsg($memlang['err-checkcode']);
				$result=$member->getpwd($username,$email);
				if(!$result)
				{
					showmsg($member->msg);
				}
				else
				{
					showmsg($memlang['getpwd-ok']);
				}
			}
			include member_tlp('getpwd');
			break;
		case 'activate':
			$result=$member->activate($verify,$id);
			if(!$result)
			{
				showmsg($member->msg);
			}
			else
			{
				showmsg($memlang['activate-ok'],SITE_URL.'member/index.php?file=login&action=login');
			}
			break;
		case 'logout':
			$member->logout();
			$url=$ucsynlogout='';
			if(UC)
			{
				$action = 'logout';
				require dirname(__FILE__).'/api/passport_server_ucenter.php';
			}

			$forwardurl=getpreurl() && getpreurl()!=$RETENG['site_url'].'member/index.php'?getpreurl():$RETENG['site_url'].'member/index.php?file=login&action=login';
			$url=$url?$url:$forwardurl;
			showmsg($memlang['logout-ok'].$ucsynlogout,$url);
			break;
		case 'regcheckusername':
			exit($member->get_userid($data)?'yes':'no');
			break;
		case 'regcheckcode':
			exit($_SESSION['checkcode']==trim($data)?'yes':'no');
			break;
	}
?>
