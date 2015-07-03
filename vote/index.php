<?php
	include str_replace("\\", '/',substr(dirname(__FILE__),0,-5)).'/include/common.inc.php';
	if($module->module_disabled('vote'))
	{
		show404('该模块已被管理员禁用!');
	}

	$langdir=$childsite['site_dir']?$childsite['site_dir']:'zh-cn';
	$langfile=RETENG_ROOT.'vote/data/lang/'.$langdir.'/lang.inc.php';
	if(!file_exists($langfile))
	{
		$langfile=RETENG_ROOT.'vote/data/lang/zh-cn/lang.inc.php';
	}
	
	include $langfile;
	include dirname(__FILE__).'/include/template.func.php';
	include dirname(__FILE__).'/include/vote.class.php';
	$voteobj=new vote();

	$action=isset($action)?$action:'index';
	switch($action)
	{
		case 'post':
			$voteitem=isset($voteitem)?$voteitem:'';
			$voteobj->dopost($voteitem,$id);
			break;
		default:
			$reteng_postion='<a href="'.$RETENG['site_url'].'">'.$votelang['website'].'</a> > '.(isset($id)?' <a href="'.$RETENG['site_url'].'vote/index.php">'.$votelang['vote-list'].'</a> > '.$votelang['vote-view']:$votelang['vote-list']);
			if(isset($id))
			{
				$id=intval($id);
				$data=vote_options($id);
				if(!$id || !$data)
				{
					show404($votelang['msg-vote-none']);
				}
				extract($data);
				include template('show','vote');
			}
			else
			{
				include template('index','vote');
			}
			break;
	}
?>
