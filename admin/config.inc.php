<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(2,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
	$action=empty($action)?'config':trim($action);
	switch($action)
	{
		case 'config':
			if(isset($do_submit))
			{
				/*
					设置词语替换
				*/
				$db->insert(DB_PRE.'badwords',array('id'=>1,'badwords'=>trim($badwords)),true);

				/*
					获取地区
				*/
				$city_top_select=isset($_POST['city_top_select'])?$_POST['city_top_select']:'';
				$city_self_select=isset($_POST['city_self_select'])?$_POST['city_self_select']:'';
				$city_son_select=isset($_POST['city_son_select'])?$_POST['city_son_select']:'';

				if(isset($city_son_select) && $city_son_select)
				{
					$mem['city']=htmlspecialchars($city_son_select);
				}
				else if(isset($city_self_select) && $city_self_select)
				{
					$mem['city']=htmlspecialchars($city_self_select);
				}
				else  if(isset($city_top_select) && $city_top_select)
				{
					$mem['city']=htmlspecialchars($city_top_select);
				}
				
				$info['ftp_timeout']=max(intval($info['ftp_timeout']),90);

				if($info['admin_file']!=ADMIN_FILE && is_writeable(RETENG_ROOT.ADMIN_FILE))
				{
					if(rename(RETENG_ROOT.ADMIN_FILE,RETENG_ROOT.trim($info['admin_file'])))
					{
						set_config($info);
						showmsg_nourl('网站配置成功,后台访问地址已修改为 '.$RETENG['site_url'].$info['admin_file'].',请注意 !');
					}
					else
					{
						set_config($info);
						showmsg('网站配置成功,请通过FTP修改 '.ADMIN_FILE.'为 '.$info['admin_file'].'!');
					}
				}

				set_config($info);
				set_cookie('project','');
				
				if(!$mem['iscity'])
				{
					set_cookie('areaid','');
				}
				
				/*
					更新自定义变量值
				*/
				foreach($mem as $key =>$value)
				{
					$db->update(DB_PRE.'config',array('value'=>$value),"varname='{$key}' AND siteid=".SITEID);
				}

				/*
					更新站点信息
				*/
				$sitecrowd=$mem;
				$sitecrowd['tlp_name']=$mem['tpl_name'];
				$sitecrowd['seo_title']=$mem['meta_title'];
				$sitecrowd['seo_description']=$mem['meta_description'];
				$sitecrowd['seo_keywords']=$mem['meta_keywords'];
				unset($sitecrowd['site_name']);
				$db->update(DB_PRE.'sitecrowd',$sitecrowd,"id=".SITEID);

				/*
					更新模板缓存
				*/
				$c->cache_template();
				showmsg($lang['RETURN_SUCEESS']);
			}
			/*
				语言列表
			*/
			$langselect='<select name="info[lang]">';
			$tmp=cache_read('lang.inc.php',RETENG_ROOT.'data/lang/');
			foreach($tmp as $key=>$value)
			{
				$langarray[]=$value;
				$selected=LANG==$key?'selected="selected"':'';
				$langselect.='<option value="'.$key.'" '.$selected.'>'.$value.'('.$key.')</option>';
			}
			$langselect.='</select>';

			/*
				地图API列表
			*/
			$mapapi='<select name="info[mapapi]" id="mapapi">';
			$mapapis=glob(RETENG_ROOT.'api/map/map_api_*.php');
			$mapapis_list=array();
			foreach($mapapis as $_mapapis)
			{
				$selected=$RETENG['mapapi']==substr(basename($_mapapis),8,-4)?'selected="selected"':'';
				$mapapi.='<option value="'.substr(basename($_mapapis),8,-4).'" '.$selected.'>'.substr(basename($_mapapis),8,-4).'</option>';
				$mapapi_list[]=substr(basename($_mapapis),8,-4);
			}
			$mapapi_list='目前支持'.implode(',',$mapapi_list).'地图';
			$mapapi.='</select>';

			$maparea=array_map('intval',explode(',',$RETENG['map']));
			$mapx=$maparea[0];
			$mapy=$maparea[1];

			/*
				模板列表
			*/
			$tlp_name='<select name="mem[tpl_name]">';
			$alls=glob(TPL_ROOT.'*');
			$files=glob(TPL_ROOT.'*.*');
			$results=array_diff($alls,$files);
			$projectinfo=cache_read('template.inc.php',TPL_ROOT);
			foreach($results as $_results)
			{
				if(basename($_results)!='system')
				{
					$selected=$RETENG['tpl_name']==basename($_results)?'selected="selected"':'';
					$tlp_name.='<option value="'.basename($_results).'" '.$selected.'>'.(isset($projectinfo[basename($_results)])?$projectinfo[basename($_results)]:basename($_results)).'('.basename($_results).')</option>';
				}
			}
			$tlp_name.='</select>';
			
			/*
				词语替换
			*/
			$badwords=$db->fetch_one("SELECT `".DB_PRE."badwords`.`badwords` FROM `".DB_PRE."badwords` WHERE `".DB_PRE."badwords`.`id`=1");
			$badwords=$badwords['badwords'];

			/*
				获取拓展变量
			*/
			$expendvar=array();
			$r=$db->fetch_all("SELECT * FROM `".DB_PRE."config` WHERE `".DB_PRE."config`.`system`=0");
			foreach($r as $_r)
			{
				$expendvar[$_r['groupid']][]=$_r;
			}

			include admin_tlp('config');
			break;
		case 'config_add':
			if(isset($do_submit))
			{
				$info['siteid']=SITEID;
				$info=array_map('trim',$info);
				$info['varname']=strtolower(trim($info['varname']));
				if(!preg_match('/^[0-9a-z_]+$/i',$info['varname']))
				{
					showmsg('变量名称由2-30个英文，数字，下划线组成 !');
				}
				
				if(array_key_exists($info['varname'],$RETENG) || in_array($info['varname'],array('serial_number','retengcms_data','retengcms_path','site_name','tpl_name','lang','site_url','meta_title','meta_keywords','meta_description','separator','htmlext','iscity','city','timedf','mapapi','map','ishtml','copyright','icpno','upload_ftype','upload_size','upload_limit','ftp','ssl','ftp_server','mail_port','ftp_user','ftp_pwd','pasv','ftp_dir','ftp_url','ftp_timeout','watermark_enabled','watermark_words','watermark_color','watermark_pct','watermark_pos','watermark_file','mail_type','mail_server','mail_user','mail_pwd','mail_sign','uc','uc_api','uc_ip','uc_dbhost','uc_dbuser','uc_dbpw','uc_dbname','uc_dbtablepre','uc_dbcharset','uc_appid','uc_key','log_disabled','pagesize','gzip','cache_storage','session_storage','memcache_host','memcache_port','memcache_timeout','cache_ttl','searchttl','auth_key','admin_file','titlecheck','autocreateindex','autocreatecategory','htmlsize','autowyc','commentpass','tlp_name','db_host','db_user','db_psw','db_name','db_pre','db_pconnect','password_key','cookie_pre','admin_founders')))
				{
					showmsg('变量名称重复,请更换 !');
				}

				$db->insert(DB_PRE.'config',$info);
				showmsg($lang['RETURN_SUCEESS']);
			}	
			include admin_tlp('config_add');
			break;
		case 'config_delete':
			if($db->mysql_delete(DB_PRE.'config',$id,'id'))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
	}
?>
