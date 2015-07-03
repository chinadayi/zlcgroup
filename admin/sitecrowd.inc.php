<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	$action=empty($action)?'manage':trim($action);

	switch($action)
	{
		/*
			站点操作
		*/
		case 'manage':
			$result=$sitecrowdobj->datalist();
			include admin_tlp('sitecrowd_manage');
			break;
		case 'add':
			if(isset($do_submit)) 
			{
				$info['site_dir']=str_replace('\\','/',$info['site_dir']);
				$info['site_dir']=str_replace('//','/',$info['site_dir']);

				if(!preg_match('/^[a-z0-9_\/]{1,30}$/i',$info['site_dir']))
				{
					showmsg('站点目录由1-30位字母、数字、下划线组成！');
				}

				$info['site_dir']=$info['site_dir']=='/'?'':$info['site_dir'];

				if(file_exists(RETENG_ROOT.$info['site_dir']))
				{
					showmsg('站点目录已经存在！');
				}

				if($sitecrowdobj->add($info))
				{
					showmsg($lang['RETURN_SUCEESS'].'<script language="javascript">self.top.document.frames("topFrame").location.reload();self.top.document.frames("leftFrame").location.reload();</script>');
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}

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
			$tlp_name='<select name="info[tlp_name]">';
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
				发布点列表
			*/
			$issuelist=$sitecrowdobj->issuelist();
			include admin_tlp('sitecrowd_add');
			break;
		case 'edit':
			if(isset($do_submit)) 
			{
				$info['site_dir']=str_replace('\\','/',$info['site_dir']);
				$info['site_dir']=str_replace('//','/',$info['site_dir']);

				if(!preg_match('/^[a-z0-9_\/]{1,30}$/i',$info['site_dir']))
				{
					showmsg('站点目录由1-30位字母、数字、下划线组成！');
				}

				$info['site_dir']=$info['site_dir']=='/'?'':$info['site_dir'];

				if(file_exists(RETENG_ROOT.$info['site_dir']) && $oldsite_dir!=$info['site_dir'])
				{
					showmsg('站点目录已经存在！');
				}
				
				if($sitecrowdobj->edit($info,$oldsite_dir,$id))
				{
					showmsg($lang['RETURN_SUCEESS'].'<script language="javascript">self.top.document.frames("topFrame").location.reload();self.top.document.frames("leftFrame").location.reload();</script>');
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$crowdinfo=$sitecrowdobj->sitecrowdinfo($id);
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

			$maparea=array_map('intval',explode(',',$crowdinfo['map']));
			$mapx=$maparea[0];
			$mapy=$maparea[1];

			/*
				模板列表
			*/
			$tlp_name='<select name="info[tlp_name]">';
			$alls=glob(TPL_ROOT.'*');
			$files=glob(TPL_ROOT.'*.*');
			$results=array_diff($alls,$files);
			$projectinfo=cache_read('template.inc.php',TPL_ROOT);
			foreach($results as $_results)
			{
				if(basename($_results)!='system')
				{
					$selected=$crowdinfo['tlp_name']==basename($_results)?'selected="selected"':'';
					$tlp_name.='<option value="'.basename($_results).'" '.$selected.'>'.(isset($projectinfo[basename($_results)])?$projectinfo[basename($_results)]:basename($_results)).'('.basename($_results).')</option>';
				}
			}
			$tlp_name.='</select>';

			/*
				发布点列表
			*/
			$issueid=explode(',',$crowdinfo['issueid']);

			$issuelist=$sitecrowdobj->issuelist();
			include admin_tlp('sitecrowd_edit');
			break;
		case 'delete':
			if($sitecrowdobj->delete($id))
			{
				showmsg($lang['RETURN_SUCEESS'].'<script language="javascript">self.top.document.frames("topFrame").location.reload();self.top.document.frames("leftFrame").location.reload();</script>');
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'setting':
			if($sitecrowdobj->setdefaultsite($id))
			{
				showmsg($lang['RETURN_SUCEESS'].'<script language="javascript">self.top.document.frames("topFrame").location.reload();self.top.document.frames("leftFrame").location.reload();</script>');
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		/*
			发布点管理
		*/
		case 'issue':
			$result=$sitecrowdobj->issuelist();
			include admin_tlp('issue_manage');
			break;
		case 'issue_add':
			if(isset($do_submit)) 
			{
				if($sitecrowdobj->issueadd($info))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			include admin_tlp('issue_add');
			break;
		case 'issue_edit':
			if(isset($do_submit)) 
			{
				if($sitecrowdobj->issueedit($info,$id))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$issueinfo=$sitecrowdobj->issueinfo($id);
			include admin_tlp('issue_edit');
			break;
		case 'issue_delete':
			if($sitecrowdobj->issuedelete($id))
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
