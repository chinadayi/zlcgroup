<?php
	@set_time_limit(0);
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('gather',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
		$_SESSION['is_admin']=true;
	$_SESSION['admin_id']=1;
	$action=empty($action)?'manage':trim($action);
	require substr(dirname(__FILE__),0,-6).'/include/gather.class.php';
	$gather=new gather();
	require RETENG_ROOT.'/include/options.class.php';
	$options=new options();
	switch($action)
	{
		case 'manage':
			if(isset($do_submit))
			{
				if(!isset($id) || !$id)showmsg($lang['RETURN_NOSELECT']);
				switch($do)
				{
					case 'export':
						$export=$gather->export($id);
						include admin_tlp('export','gather');
						break;
					case 'delete':
						if($gather->delete($id))
						{
							showmsg($lang['RETURN_SUCEESS']);
						}
						else
						{
							showmsg($lang['RETURN_ERROR']);
						}
						break;
					case 'truncate':
						if($gather->truncate($id))
						{
							showmsg($lang['RETURN_SUCEESS']);
						}
						else
						{
							showmsg($lang['RETURN_ERROR']);
						}
						break;
					case 'do':
						$gatherinfo=$gather->gatherinfo($id);

						/*
							获取采集的域名
						*/
						$domain=parse_url($gatherinfo['listsetting']['regxurl']);
						$domain=$domain['scheme'].'://'.$domain['host'].'/';
						/*
							获取所有列表网址
						*/
						$listurls=$gather->test($gatherinfo);
						/*
							获取所有内容网址
						*/

						$conurls=cache_read(md5($gatherinfo['name']).'.cache.php',RETENG_ROOT.'data/tmp/');
						if(!$conurls && isset($m))
						{
							showmsg('所有内容采集完毕!',ADMIN_FILE.'?mod=gather&file=gather&action=manage');
						}
						if(!$conurls && !isset($m))
						{
							$con='';
							foreach($listurls as $listurl)
							{
								$pagecon=iconv($gatherinfo['code'], "GB2312//IGNORE", $gather->geturlfile($listurl));
								$con.=$gather->get_sub_content($pagecon,$gatherinfo['listsetting']['areastart'],$gatherinfo['listsetting']['areaend']);
							}

							$allurl=$gather->get_all_url($con);
							$conurls=$allurl['url'];

							/*
								过滤网址
							*/

							if($conurls)
							{
								foreach($conurls as $key => $conurl)
								{
									$conurl=strtolower($conurl);
									if(trim($gatherinfo['listsetting']['musthas']))
									{
										if(strpos($conurl,trim($gatherinfo['listsetting']['musthas']))===false)
										{
											unset($conurls[$key]);
										}
									}

									if(isset($conurls[$key]) && trim($gatherinfo['listsetting']['nothas']))
									{
										if(strpos($conurl,trim($gatherinfo['listsetting']['nothas']))!==false)
										{
											unset($conurls[$key]);
										}
									}
									if(isset($conurls[$key]) && substr($conurl,0,7)!='http://')
									{
										if(empty($gatherinfo['listsetting']['domain']) || trim($gatherinfo['listsetting']['domain'])=='http://')
										{
											$conurls[$key]='http://'.str_replace('//','/',substr($domain,7).$conurl);
										}
										else
										{
											$conurls[$key]=trim($gatherinfo['listsetting']['domain']).str_replace('../','',$conurl);
										}
									}
									//if($gather->checkdup('url',$conurls[$key])==1)
									//{
										//unset($conurls[$key]);
									//}
								}
							}
							if(!$conurls)
							{
								showmsg('无法获得内容链接,采集完成!可能原始网站不存在更新',ADMIN_FILE.'?mod=gather&file=gather&action=manage');
							}

							/*
								将列表缓存到文件
							*/
							cache_write(md5($gatherinfo['name']).'.cache.php',$conurls,RETENG_ROOT.'data/tmp/');
						}

						/*
							更新采集表信息
						*/
						$gather->update(array('cotime'=>TIME,'urlcounts'=>count($conurls)),$id);

						/*
							开始读取内容页并存储到数据库
						*/
						$nowurl=array_shift($conurls);
						cache_write(md5($gatherinfo['name']).'.cache.php',$conurls,RETENG_ROOT.'data/tmp/');
						$coninfo=array();

						$urlcontents=$gather->geturlfile($nowurl);


						if($urlcontents)
						{
							$coninfo['nodeid']=$id;
							$coninfo['url']=$nowurl;
							$coninfo['content']=iconv($gatherinfo['code'], "GB2312//IGNORE", trim($urlcontents));
							$coninfo['title']=$gather->get_sub_content($coninfo['content'],$gatherinfo['itemsetting']['title']['areastart'],$gatherinfo['itemsetting']['title']['areaend']);
							$gather->gathercon($coninfo);
							showmsg($coninfo['title'].' 采集中...',ADMIN_FILE.'?mod=gather&file=gather&action=manage&do_submit=1&do=do&m=1&id='.$id);
						}
						break;
					case 'data':
						header('location:?mod=gather&file=gather&action=content&nodeid='.$id);
						break;
					case 'edit':
						header('location:?mod=gather&file=gather&action=edit&id='.$id);
						break;
				}
				exit();
			}
			$result=$gather->datalist();
			include admin_tlp('gather','gather');
			break;
		case 'add':
			if(isset($do_submit))
			{
				$info['listsetting']['startid']=intval($info['listsetting']['startid']);
				$info['listsetting']['endid']=intval($info['listsetting']['endid']);
				/*
					检测规则
				*/
				$listurls=$gather->test($info);
				if(!$listurls)
				{
					exit('列表网址获取为空值, 规则不正确!');
				}
				/*
					保存规则信息
				*/
				if($gather->add($info))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$modelid=isset($modelid)?$modelid:1;
			$model=cache_read('model.cache.php',RETENG_ROOT.'data/c/');
			$fields=cache_read('model'.$modelid.'_fields.cache.php',RETENG_ROOT.'data/c/');
			include admin_tlp('add','gather');
			break;
		case 'edit':
			if(isset($do_submit))
			{
				$info=retengcms_stripslashes($info);
				$info['listsetting']['startid']=intval($info['listsetting']['startid']);
				$info['listsetting']['endid']=intval($info['listsetting']['endid']);
				/*
					检测规则
				*/
				$listurls=$gather->test($info);
				if(!$listurls)
				{
					exit('列表网址获取为空值, 规则不正确!');
				}
				/*
					保存规则信息
				*/
				if($gather->edit($info,$id))
				{
					showmsg($lang['RETURN_SUCEESS']);
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$gatherinfo=$gather->gatherinfo($id);
			$modelid=$gatherinfo['modelid'];
			$model=cache_read('model.cache.php',RETENG_ROOT.'data/c/');
			$fields=cache_read('model'.$modelid.'_fields.cache.php',RETENG_ROOT.'data/c/');
			include admin_tlp('edit','gather');
			break;
		case 'test':
			$listurls=$gather->test($info);
			if(!$listurls)
			{
				exit('列表网址获取为空值, 规则不正确!');
			}
			else
			{
				echo('列表网址获取列表:<br />');
				foreach($listurls as $listurl)
				{
					echo $listurl.'<br />';
				}
				exit('共'.count($listurls).'个列表网址!');
			}
			break;
		case 'import':
			if(isset($do_submit))
			{
				if($gather->import($importdata))
				{
					showmsg('规则导入成功!');
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			include admin_tlp('import','gather');
			break;
		case 'content':
			$id=isset($nodeid)?intval($nodeid):0;
			if($id)
			{
				$gatherinfo=$gather->gatherinfo($id);
			}
			$result=$gather->conlist($id);

			include admin_tlp('content','gather');
			break;
		case 'preview':
			$coninfo=$gather->coninfo($id);
			$modelid=$coninfo['modelid'];
			$model=cache_read('model.cache.php',RETENG_ROOT.'data/c/');
			$fields=cache_read('model'.$modelid.'_fields.cache.php',RETENG_ROOT.'data/c/');
			include admin_tlp('preview','gather');
			break;
		case 'createfunc':
			if(isset($do_submit))
			{
				if($gather->createfunc($nodeid,$func))
				{
					showmsg('自定义函数保存成功!');
				}
				else
				{
					showmsg($lang['RETURN_ERROR']);
				}
			}
			$id=intval($id);
			$funccontent="<?php\nfunction func(\$para)\n{\n\treturn \$para;\n}\n?>";
			if(file_exists(RETENG_ROOT.'gather/data/func/'.md5($id).'.func.php'))
			{
				$funccontent=file_get_contents(RETENG_ROOT.'gather/data/func/'.md5($id).'.func.php');
			}
			include admin_tlp('createfunc','gather');
			break;
		case 'deletecon':
			if(!isset($id) || !$id)showmsg($lang['RETURN_NOSELECT']);
			if($gather->deletecon($id))
			{
				showmsg('指定内容删除成功!');
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		case 'insert':
			if(!isset($m))
			{
				if(!isset($id) || !$id)showmsg($lang['RETURN_NOSELECT']);
				if(!isfinalcatid($movetocatid))showmsg('只有最终子栏目才能导入数据');
				cache_write('user'.$_userid.'-conid.cache.php',$id,RETENG_ROOT.'data/tmp/');
				showmsg('准备工作结束开始导入数据...','?mod=gather&file=gather&action=insert&nodeid='.$nodeid.'&m=1&movetocatid='.$movetocatid.'&total='.sizeof($id));
			}
			else
			{
				$ids=$id=cache_read('user'.$_userid.'-conid.cache.php',RETENG_ROOT.'data/tmp/');
				array_splice($ids,min(sizeof($id),5));
				$id=array_diff($id,$ids);
				cache_write('user'.$_userid.'-conid.cache.php',$id,RETENG_ROOT.'data/tmp/');
				if(!$ids)
				{
					cache_delete('user'.$_userid.'-conid.cache.php',RETENG_ROOT.'data/tmp/');
					showmsg('临时内容全部导入完毕!','?mod=gather&file=gather&action=content&nodeid='.$nodeid);
				}
				else
				{
					if($gather->insertcon($ids,$movetocatid))
					{
						showmsg('临时内容已导入'.(round(($total-count($id))/$total,1)*100).'%, 继续...','?mod=gather&file=gather&action=insert&m=1&movetocatid='.$movetocatid.'&total='.$total.'&nodeid='.$nodeid);
					}
					else
					{
						showmsg($lang['RETURN_ERROR']);
					}
				}
			}
			break;

		case 'task':
			require substr(dirname(__FILE__),0,-6).'/task_config.php';
			$id=isset($id)?intval($id):0;
		    $result=$gather->tasklist($id);
			include admin_tlp('task','gather');
			break;
		case 'addtask':
			include admin_tlp('addtask','gather');
		break;
		case 'savetask':
			$result=$gather->inserttask($info);
			showmsg('添加成功',"?mod=gather&file=gather&action=task");
		break;
		case 'deletetask':
			if(!isset($id) || !$id)showmsg($lang['RETURN_NOSELECT']);
			if($gather->deletetask($id))
			{
				showmsg('指定内容删除成功!');
			}
			else
			{
				showmsg($lang['RETURN_ERROR']);
			}
			break;
		break;
		case 'addthistask':
				if(!isset($id) || !$id)showmsg($lang['RETURN_NOSELECT']);
				$info['name']=$name;
				$info['url']='/gather/autogather.php?action=go&id='.$id;
				$result=$gather->inserttask($info);
				$info2['istask']=1;
				$result2=$gather->update($info2,$id);
				showmsg('添加成功',"?mod=gather&file=gather&action=task");
		break;
		case 'starttask':
			require substr(dirname(__FILE__),0,-6).'/task_config.php';
			if($task)
			{
				$str=fopen(substr(dirname(__FILE__),0,-6).'/task_config.php','w');
				$data = "<?php\r\n \$task=false;\r\n?>";
				fwrite($str,$data);
				ignore_user_abort(false); // 函数设置与客户机断开是否会终止脚本的执行
				set_time_limit(0); // 来设置一个脚本的执行时间为无限长
				showmsg('计划任务已经关闭',"?mod=gather&file=gather&action=task");
			}
			else
			{
				$str=fopen(substr(dirname(__FILE__),0,-6).'/task_config.php','w');
				$data = "<?php\r\n \$task=true;\r\n?>";
				fwrite($str,$data);
				echo "<iframe src='/gather/task.php' width=0 height=0></iframe>";
				showmsg('计划任务已经开启',"?mod=gather&file=gather&action=task");
			}
			break;
		case 'gathertask':
		break;

	}
?>
