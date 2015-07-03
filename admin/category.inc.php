<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(6,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
	$action=empty($action)?'manage':trim($action);
	require RETENG_ROOT.'include/admin/category.class.php';
	$category=new category();
	switch($action)
	{
		case 'manage':
			if(isset($do_submit))
			{
				if($category->setordeyby($orderby))
				{
					showmsg($lang['RETURN_SUCEESS'].'<script language="javascript">self.top.document.frames("leftFrame").location.reload();</script>');
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
				break;
			}
			include admin_tlp('category_manage');
			break;
		case 'add':
			if(isset($do_submit))
			{
				/*
					权限检查
				*/
				if(!$check_admin->category_permission_check($_userid,$info['parentid']))showmsg_nourl($lang['RETURN_NOPRI']);

				/*

					检查栏目名称
				*/
				if(!$info['catname'])
				{
					showmsg($lang['CATEGORY-LANG-3']);
				}

				require_once RETENG_ROOT.'include/cnspell.class.php';
				$cnspellobj=new cnspell();

				/*

					检查栏目目录
				*/
				$info['catdir']=str_replace('{sitedir}/','{sitedir}',$info['catdir']);
				if($info['catdir']=='{parcatdir}' || $info['catdir']=='{sitedir}' || $info['catdir']=='{sitedir}')
				{
					$info['catdir']=$info['catdir'].$cnspellobj->getCnSpell($info['catname']);
				}

				if(isset($cnspell) && $cnspell==1)
				{
					$info['catdir']=$cnspellobj->getCnSpell($info['catname']);
				}
				else
				{
					if(!$info['catdir'] && (!isset($info['type']) || $info['type']!=4))
					{
						showmsg($lang['CATEGORY-LANG-4']);
					}
				}

				$info['catdir']=$info['catdir']?$info['catdir']:mt_rand(1,999);

				if(!empty($info['navtype']))
				{

					$info['navtype']=implode(',',$info['navtype']);
					//echo $info['navtype'];
					//exit();
				}
				if($info["ismenu"]==0)
				{
					$info['navtype']="";
				}
				if($info['modelid']==-1)$info['type']=2;

				/*
					添加栏目操作
				*/

				if($category->add($info))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
				break;
			}
			require RETENG_ROOT.'/include/options.class.php';
			$options=new options();

			$model=cache_read('model.cache.php',RETENG_ROOT.'data/c/');

			foreach($model as $key => $_model)
			{
				if($_model['siteid']!=SITEID)
				{
					unset($model[$key]);
				}
			}
			if(!$model)
			{
				showmsg('请先添加数据模型！',ADMIN_FILE.'?file=model&action=install','2000');
			}

			require RETENG_ROOT.'/include/form.class.php';
			$form=new form();

			$template=glob(RETENG_ROOT.'/template/'.TLP_NAME.'/*.htm');
			$parentsetting=array();
			if(isset($parentid))
			{
				$parentsetting=$category->catinfo($parentid);
			}
			$modelid=isset($parentsetting['modelid'])?intval($parentsetting['modelid']):1;
			include admin_tlp('category_add');
			break;
		case 'adds':
			if(isset($do_submit))
			{
				/*
					权限检查
				*/
				if(!$check_admin->category_permission_check($_userid,$info['parentid']))showmsg_nourl($lang['RETURN_NOPRI']);
				if(!empty($info['navtype']))
				{

					$info['navtype']=implode(',',$info['navtype']);
					//echo $info['navtype'];
					//exit();
				}

				if($info["ismenu"]==0)
				{
					$info['navtype']="";
				}
				/*

					检查栏目名称
				*/
				if(!$info['catnames'])
				{
					showmsg($lang['CATEGORY-LANG-3']);
				}

				if($category->adds($info))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
				break;
			}
			require RETENG_ROOT.'/include/options.class.php';
			$options=new options();

			$model=cache_read('model.cache.php',RETENG_ROOT.'data/c/');
			foreach($model as $key => $_model)
			{
				if($_model['siteid']!=SITEID)
				{
					unset($model[$key]);
				}
			}
			if(!$model)
			{
				showmsg('请先添加数据模型！',ADMIN_FILE.'?file=model&action=install','2000');
			}

			require RETENG_ROOT.'/include/form.class.php';
			$form=new form();

			$template=glob(RETENG_ROOT.'template/'.TLP_NAME.'/*.htm');

			$parentsetting=array();
			if(isset($parentid))
			{
				$parentsetting=$category->catinfo($parentid);
			}

			$modelid=isset($parentsetting['modelid'])?intval($parentsetting['modelid']):1;

			include admin_tlp('category_adds');
			break;
		case 'delete':
			/*
					权限检查
			*/
			if(!$check_admin->category_permission_check($_userid,$id))showmsg_nourl($lang['RETURN_NOPRI']);

			$category->delete($id);
			$category->cache();
			showmsg($lang['RETURN_SUCEESS']);
			break;
		case 'edit':
			if(isset($do_submit))
			{
				/*
					权限检查
				*/
				if(!$check_admin->category_permission_check($_userid,$id))showmsg_nourl($lang['RETURN_NOPRI']);

				/*

					检查栏目名称
				*/
				if(!$info['catname'])
				{
					showmsg($lang['CATEGORY-LANG-3']);
				}

				$info['catdir']=str_replace('{sitedir}/','{sitedir}',$info['catdir']);

				if(!empty($info['navtype']))
				{

					$info['navtype']=implode(',',$info['navtype']);
					//echo $info['navtype'];
					//exit();
				}
				if($info["ismenu"]==0)
				{
					$info['navtype']="";
				}
				if($info['modelid']==-1)$info['type']=2;

				/*
					编辑栏目操作
				*/

				if($category->edit($info,$id))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
				break;
			}
			require RETENG_ROOT.'/include/options.class.php';
			$options=new options();

			$model=cache_read('model.cache.php',RETENG_ROOT.'data/c/');
			foreach($model as $key => $_model)
			{
				if($_model['siteid']!=SITEID)
				{
					unset($model[$key]);
				}
			}
			if(!$model)
			{
				showmsg('请先添加数据模型！',ADMIN_FILE.'?file=model&action=install','2000');
			}

			require RETENG_ROOT.'/include/form.class.php';
			$form=new form();

			$template=glob(RETENG_ROOT.'template/'.TLP_NAME.'/*.htm');

			$r=array();
			if(isset($id))
			{
				$r=$category->catinfo($id);
			}

			$expand=$r['expand'];
			$modelid=isset($r['modelid'])?intval($r['modelid']):1;
			include admin_tlp('category_edit');
			break;
		case 'setismenu':
			/*
					权限检查
			*/
			if(!$check_admin->category_permission_check($_userid,$id))showmsg_nourl($lang['RETURN_NOPRI']);

			if($category->setismenu($id,$ismenu))
			{
				showmsg($lang['RETURN_SUCEESS']);
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'setispost':
			/*
					权限检查
			*/
			if(!$check_admin->category_permission_check($_userid,$id))showmsg_nourl($lang['RETURN_NOPRI']);

			$category->setispost($id,$ispost);
			$category->cache();
			showmsg($lang['RETURN_SUCEESS']);
			break;
		case 'sethtml':
			/*
					权限检查
			*/
			if(!$check_admin->category_permission_check($_userid,$id))showmsg_nourl($lang['RETURN_NOPRI']);

			$category->sethtml($id,$html);
			showmsg($lang['RETURN_SUCEESS']);
			break;
	}
?>
