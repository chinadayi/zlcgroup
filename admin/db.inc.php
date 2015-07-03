<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(4,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
	$action=empty($action)?'export':trim($action);
	require RETENG_ROOT.'include/admin/db.class.php';
	$dbobj=new db();
	switch($action)
	{
		case 'export':
			if(isset($do_submit)) 
			{
				if((!isset($name) ||!$name) && (!isset($page) || !$page))showmsg('请选择要备份的数据表!');
				if(isset($name) && $name)
				{
					cache_write('bakup_table.cache_tmp'.$_userid.'.php',$name,RETENG_ROOT.'data/tmp/');
				}
				else{
					$name=cache_read('bakup_table.cache_tmp'.$_userid.'.php',RETENG_ROOT.'data/tmp/');
				}

				$sql='';
				$tableid=isset($tableid)?$tableid-1:0;
				$tablecounts=count($name);
				$start=isset($start)?intval($start):0;

				for($i=$tableid;$i<$tablecounts && strlen($sql)<$sizelimit*1000;$i++)
				{				
					if(!$start)
					{
						$r=$db->fetch_one("SHOW CREATE TABLE `{$name[$i]}`"); 
						$sql.="DROP TABLE IF EXISTS `{$name[$i]}`;\n";
						$sql.=$r['Create Table'].";\n";
					}
					$numrows=$offset=5;

					while(strlen($sql)<$sizelimit*1000 && $numrows==$offset)  
					{
						$tmp_r=$db->fetch_all("SELECT * FROM `{$name[$i]}` LIMIT {$start},{$offset}");
						if($tmp_r)foreach($tmp_r as $val_r)
						{
							$val_r=array_map('mysql_escape_string',$val_r);
							foreach($val_r as $t_k => $t_v)
							{
								$val_r[$t_k]='\''.$t_v.'\'';
							}
							$sql.="REPLACE INTO `{$name[$i]}` VALUES(".implode(',',$val_r).");\n";
						}
						$numrows=count($tmp_r);
						$start+=$offset;
						$startrow=$start;
					}
					$start=0;
				}

				if(trim($sql))
				{
					$tableid=$i;
					$page=isset($page)?$page:1;
					$rand=isset($rand)?$rand:mt_rand(10000,99999);	
					@file_put_contents(RETENG_ROOT.'data/bakup/database_'.strtolower(RETENG_VERSION.'_'.RETENG_RELEASE).'_bakup_'.date('Ymd').'_'.$rand.'_'.$page.'.sql',$sql);
					showmsg('卷号为'.date('Ymd').'_'.$rand.'_'.$page.'的备份文件写入成功!',$RETENG['admin_file'].'?file=db&action=export&do_submit=1&tableid='.$tableid.'&page='.($page+1).'&rand='.$rand.'&sizelimit='.$sizelimit.'&start='.$startrow);
				}
				else
				{
					cache_delete('bakup_table.cache_tmp'.$_userid.'.php',RETENG_ROOT.'data/tmp/');
					showmsg('数据库备份成功!',$RETENG['admin_file'].'?file=db&action=export');
				}
			}
			$result=$dbobj->datalist();
			include admin_tlp('db_export');			
			break;
		case 'import':
			if(isset($do_submit))
			{
				if(isset($mytime) && $mytime && $volume && $no)
				{
					$filepath=RETENG_ROOT.'data/bakup/database_'.strtolower(RETENG_VERSION.'_'.RETENG_RELEASE).'_bakup_'.$mytime.'_'.$volume.'_'.$no.'.sql';
					if(file_exists($filepath))
					{
						$sqls=file_get_contents($filepath);
						$sqls=explode(";\n",trim($sqls));
						foreach($sqls as $sql)
						{
							$db->query($sql,true);
						}
						showmsg('卷'.$volume.'_'.$no.' 导入成功, 程序自动继续导入...',ADMIN_FILE.'?file=db&action=import&do_submit=1&mytime='.$mytime.'&volume='.$volume.'&no='.($no+1));
					}
					else
					{
						$c->cache_all();
						showmsg('数据库还原成功!',ADMIN_FILE.'?file=db&action=import');
					}
					
				}
				else
				{
					$r=explode('_',$filename);
					if(strtolower($r[1].'_'.$r[2])!=strtolower(RETENG_VERSION.'_'.RETENG_RELEASE))
					{
						showmsg('数据备份文件与当前系统版本不一致, 无法导入!',ADMIN_FILE.'?file=db&action=import');
					}
					showmsg('准备工作结束，开始还原数据...',ADMIN_FILE.'?file=db&action=import&do_submit=1&mytime='.$r[4].'&volume='.$r[5].'&no=1');
				}		
			}

			$r=glob(RETENG_ROOT.'data/bakup/*.sql');

			$result=array();
			foreach($r as $k => $v)
			{
				$tarray=explode('_',substr(strrchr($v,'/'),1));
				$tarray=explode('.',$tarray[4]);
				$key=$tarray[0];
				$result[$k]['filename']=substr(strrchr($v,'/'),1);
				$result[$k]['filesize']=round((filesize($v)/1024)/1024,2).' M';
				$result[$k]['mtime']=date('Y-m-d H:i:s',filemtime($v));
				$result[$k]['volume']=$key;
			}
			ksort($result);
			include admin_tlp('db_import');
			break;
		case 'delete':
			if(!$name)showmsg('请选择要删除的备份文件!');
			foreach($name as $filename)
			{
				@unlink(RETENG_ROOT.'data/bakup/'.$filename);
			}
			showmsg('成功删除备份文件!','?file=db&action=import');
			break;
		case 'down':
			$filepath=RETENG_ROOT.'data/bakup/'.$filename;
			$filesize=sprintf("%u", filesize($filepath));
			$filetype=get_fileext($filename);
			if(ob_get_length() !== false) @ob_end_clean();
			header('Pragma: public');
			header('Last-Modified: '.gmdate('D, d M Y H:i:s') . ' GMT');
			header('Cache-Control: no-store, no-cache, must-revalidate');
			header('Cache-Control: pre-check=0, post-check=0, max-age=0');
			header('Content-Transfer-Encoding: binary');
			header('Content-Encoding: none');
			header('Content-type: '.$filetype);
			header('Content-Disposition: attachment; filename="'.$filename.'"');
			header('Content-length: '.$filesize);
			readfile($filepath);
			exit;
			break;
		case 'repair':
			if(isset($do_submit))
			{
				$manage=$operation=='repair'?'修复':'优化';
				if(!$name)showmsg('请选择要'.$manage.'的数据表!');

				
				foreach($name as $table)
				{
					$db->query("{$operation} TABLE `{$table}`");
				}
				showmsg('数据表'.$manage.'完毕!');
			}
			$result=$db->get_table_status(DB_NAME);
			foreach($result as $key => $value)
			{
				if(substr($value['Name'],0,strlen(DB_PRE))==DB_PRE)
				$result[$key]=$value;
				else unset($result[$key]);
			}
			include admin_tlp('db_repair');
			break;
		case 'sql':
			if(isset($do_submit))
			{
				$sqls=explode(";",trim($sqls));
				if($sqls)
				{
					foreach($sqls as $sql)
					{
						$sql=str_replace('retengcms_',DB_PRE,trim($sql));
						if($sql)
						{
							$db->query(stripslashes($sql),true);
						}
					}
				}
				showmsg('SQL执行完毕!');
			}
			include admin_tlp('db_sql');
			break;
	}
?>
