<?php
	!defined('MEMBER_CENTER') && exit('Access Denied!');	
	$action=isset($action)?$action:'edit';
	switch($action)
	{
		case 'editphoto':
			if(isset($do_submit)) 
			{
				if(!$uptype)
				{
					if(!preg_match('/^[a-z0-9\.\/_]{20,40}$/i',$info['facephoto']) || !file_exists(RETENG_ROOT.$info['facephoto']) || !in_array(get_fileext($info['facephoto']),array('gif','jpg','jpeg','bmp','png')))
					{
						showmsg($memlang['photo-noexists']);
					}
				}
				else
				{
					if(file_exists(RETENG_ROOT.$info['image']) && in_array(get_fileext($info['image']),array('gif','jpg','jpeg','bmp','png')))
					{
						$info['facephoto']=trim($info['image']);
					}
				}
				$member->set($_userid, array('facephoto'=>trim($info['facephoto'])));
				showmsg($lang['RETURN_SUCEESS'],$RETENG['site_url'].'member/index.php?file=user&action=editphoto');
			}
			$photolist=glob(RETENG_ROOT.'member/images/face/*.*');
			require RETENG_ROOT.'/include/form.class.php';
			$form=new form();
			include member_tlp('user_editphoto');
			break;
		case 'edit':
			if(isset($do_submit)) 
			{
				unset($info['id'],$info['touserid'],$info['modelid'],$info['groupid'],$info['gradeid'],$info['honorid'],$info['password'],$info['amount'],$info['point'],$info['level'],$info['expire']);

				include RETENG_ROOT.'include/data.input.class.php';
				$datainput = new data_input($_modelid,'member');
				$info=$datainput->filter($info);

				$member->set($_userid, $info);
				
				$_modelid=$_modelid?$_modelid:1;
				$r=cache_read('model'.$_modelid.'.cache.php',RETENG_ROOT.'data/cache_module/');

				if($member->getmore($_userid,'userid'))
				{
					$db->update(DB_PRE.$r['table'],$info,'userid='.$_userid);
				}
				else
				{
					$info['userid']=$_userid;
					$db->insert(DB_PRE.$r['table'],$info,true);
				}	
				if(UC)
				{
					$username = $_username;
					$email = $info['email'];
					$password = $_password;
					$action = 'edit';
					require RETENG_ROOT.'member/api/passport_server_ucenter.php';
				}
				
				showmsg($lang['RETURN_SUCEESS'],$RETENG['site_url'].'member/index.php?file=user&action=edit');
			}	
			$modelinfo=cache_read('model.cache.php',RETENG_ROOT.'data/cache_module/');
			$info=$member->get($_userid,'*',true);
			$forms=$member->getform($info['modelid'],$info);
			include member_tlp('user_edit');
			break;
		case 'editpsw':
			if(isset($do_submit)) 
			{
				$info=$member->get($_userid,'password');
				if(PWD($old_password)!=$info['password'])
				{
					showmsg($memlang['err-pwd-old']);
				}

				if($new_password!=$chk_password)
				{
					showmsg($memlang['err-pwd-confirm']);
				}

				if(!is_pwd($new_password))
				{
					showmsg($memlang['err-pwd']);
				}
				
				if(UC)
				{
					$username = $_username;
					$email = $_email;
					$action = 'editpwd';
					require RETENG_ROOT.'member/api/passport_server_ucenter.php';
				}
				$member->set($_userid,array('password'=>PWD($new_password)));
				showmsg($lang['RETURN_SUCEESS'],$RETENG['site_url'].'member/index.php?file=user&action=editpsw');
			}
			include member_tlp('user_editpsw');
			break;
		case 'upgrade':
			if(isset($do_submit)) 
			{
				$expire=intval($expire)>0?intval($expire):1;
				$gradeid=intval($gradeid)>=intval($_gradeid)?intval($gradeid):intval($_gradeid);
				$r=cache_read('membergrade'.$gradeid.'.cache.php',RETENG_ROOT.'data/cache_module/');
				if(UPGRADEMETHOD=='point')
				{
					if($_point < $r['point']*$expire)
					{
						showmsg($memlang['point-buy-err1']);
					}
					else
					{
						$start=intval($_expire)?intval($_expire):TIME;
						$member->set($_userid,array('point'=>($_point-$r['point']*$expire),'gradeid'=>$gradeid,'level'=>2 ,'expire'=>$start+$expire*31*24*3600));
					}
				}

				if(UPGRADEMETHOD=='amount')
				{
					if($_amount < $r['amount']*$expire)
					{
						showmsg($memlang['point-buy-err1']);
					}
					else
					{
						$start=intval($_expire)?intval($_expire):TIME;
						$member->set($_userid,array('amount'=>($_amount-$r['amount']*$expire),'gradeid'=>$gradeid,'level'=>2 ,'expire'=>$start+$expire*31*24*3600));
					}
				}
				showmsg($lang['RETURN_SUCEESS'],$RETENG['site_url'].'member/index.php?file=user&action=upgrade');
			}
			$r=cache_read('membergrade.cache.php',RETENG_ROOT.'data/cache_module/');
			include member_tlp('user_upgrade');
			break;
		case 'collect':
			if(isset($do_submit)) 
			{
				if(!isset($id) || !$id)showmsg($lang['RETURN_NOSELECT']);
				$id=array_map('intval',$id);
				foreach($id as $_id)
				{
					$db->query("DELETE FROM `".DB_PRE."collect` WHERE `".DB_PRE."collect`.`id`=$_id AND `".DB_PRE."collect`.`userid`=$_userid",true);
				}
				showmsg($lang['RETURN_SUCEESS']);
			}
			include RETENG_ROOT.'include/datalist.class.php';
			$datalist = new datalist();
			$where="`userid`={$_userid}";
			$orderby="id DESC";
			$page=max(isset($page)?intval($page):1,1);
			$result=$datalist->getlist(DB_PRE.'collect',$where,$orderby,$page,20);
			$pagestring=$datalist->pagestring;
			include member_tlp('user_collect');
			break;
		case 'add_collect':
			if(!$verify || $verify!=md5(AUTH_KEY.$id.md5($title).$url) || !is_numeric($id))
			{
				exit('Access Denied!');
			}

			if(!$_userid)showmsg($memlang['login-first'],$RETENG['site_url'].'member/index.php?file=login');
			$info=array();
			$info['id']=intval($id);
			$info['userid']=$_userid;
			$info['title']=$title;
			$info['url']=$url;
			$info['time']=TIME;
			$db->insert(DB_PRE.'collect',$info,true);
			showmsg($lang['RETURN_SUCEESS']);
			break;
		default:
			show404($memlang['err-404']);
			break;
	}
?>
