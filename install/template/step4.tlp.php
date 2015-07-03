<?php
	!defined('RETENG_INSTALL') && exit('Access Denied!');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="template/images/style.css" />
<title><?php echo RETENG_VERSION;?> 安装向导</title>
<script language="JavaScript" src="../images/js/jquery.min.js"></script>
<script language="javascript" type="text/javascript">
var step = 0;
var interval = 200; // 间隔时间
function showmessage(message) 
{
	step++;
	setTimeout(function()
	{
		document.getElementById('notice').innerHTML += message;
		document.getElementById('notice').scrollTop = 100000000;
	},step * interval);	
}
</script>
</head>
<body>
<div class="main">
	<div class="sidebar">
		<div class="logo" title="<?php echo RETENG_VERSION;?> 安装向导"><a href="http://cms.reteng.org/" target="_blank"></a></div>
		<div class="step">
			<ul class="done">
				<li class="statusdot"></li>
				<li class="name">1、软件使用授权许可协议</li>
			</ul>
			<ul class="done">
				<li class="statusdot"></li>
				<li class="name">2、环境以及文件目录权限检查</li>
			</ul>
			<ul class="done">
				<li class="statusdot"></li>
				<li class="name">3、数据库连接参数设置</li>
			</ul>
			<ul class="current">
				<li class="statusdot"></li>
				<li class="name">4、执行数据库安装</li>
			</ul>
			<ul>
				<li class="statusdot"></li>
				<li class="name">5、完成安装</li>
			</ul>
		</div>
	</div>
	<div class="main">
		<div class="version">程序版本：<?php echo RETENG_VERSION,'&nbsp;',RETENG_RELEASE;?></div>
		<div class="bg_center">
			<div class="bg_left">
				<div class="bg_right">
					<div class="content">
					<form id="install" action="index.php?" method="post">
					<input type="hidden" name="step" value="5">
					<?php
					echo '<div id="notice"></div>';
					$result = true;
	
					foreach($sqls as $i=>$sql)
					{
						if($config['db_pre']!='retengcms_')
						{
							$sql=str_replace('retengcms_',$config['db_pre'],$sql);
						}
						if(substr($sql, 0, 12) == 'CREATE TABLE')
						{ 
							$tname = preg_replace("/CREATE TABLE `([a-z0-9_]+)` .*/is","\\1",$sql); 
							if($db->query($sql,true))
							{
								jsmessage('<ol>正在创建数据表：'.$tname.' &nbsp; … &nbsp;&nbsp;&nbsp; <img src="template/images/ok.png" /></ol>');
							} 
							else 
							{
								$result = false;
								jsmessage('<ol><font color="#FF0000">正在创建数据表：'.$tname.' &nbsp; … &nbsp;&nbsp;&nbsp; </font><img src="template/images/not.png" /></ol>');
							}
						}
						else 
						{ 
							$db->query($sql,true); 
						}						
					}
					//安装模型
					/*include RETENG_ROOT.'include/module.class.php';
					$md=new module();
					foreach($module as $k)
					{
						if($md->installimport($k))
						{
							jsmessage('<ol>'.$k.'模块安装成功。</ol>');
						}else
						{
							jsmessage('<ol><font color="#FF0000">'.$k.'模块不存在，稍后请到官方网站上下载，进行后台安装。</font></ol>');
						}	
					}
					*/
					if($admin_founders=$db->insert($config['db_pre'].'admin',$admin,true))
					{
						$config['admin_founders']=$admin_founders;
						if(file_exists(RETENG_ROOT.'member/') && file_exists(RETENG_ROOT.'member/include/member.class.php'))
						{
							$member['id']=$admin_founders;
							if($userid=$db->insert($config['db_pre'].'member',$member,true))
							{
								$db->insert($config['db_pre'].'regular',array('userid'=>$userid),true);
								jsmessage('<ol>网站创始人信息创建成功… &nbsp;&nbsp;&nbsp; <img src="template/images/ok.png" /></ol>');
							}
							else
							{
								$result=false;
							}
						}
						else
						{
							jsmessage('<ol>网站创始人信息创建成功… &nbsp;&nbsp;&nbsp; <img src="template/images/ok.png" /></ol>');
						}
					}
					else
					{
						$result=false;
					}
					
					if($db->insert($config['db_pre'].'sitecrowd',$sitecrowd,true) && $db->update($config['db_pre'].'config',array('value'=>$config['site_url']),'varname=\'childsite_url\' AND siteid=1'))
					{
						jsmessage('<ol>默认站点建立成功… &nbsp;&nbsp;&nbsp; <img src="template/images/ok.png" /></ol>');
					}	
					else
					{
						$result=false;
					}
					
					if(set_config($config))
					{
						jsmessage('<ol>网站配置文件更新成功… &nbsp;&nbsp;&nbsp; <img src="template/images/ok.png" /></ol>');
					}	
					else
					{
						$result=false;
					}
					
					if($result)
					{
						jsmessage('<ol><font color="#000000">数据库安装成功，请继续下一步安装。</font></ol>');
					} 
					else 
					{
						jsmessage('<ol><font color="#FF0000">数据库没有正确安装或是安装过程中出现异常，请检查连接参数设置是否正确。</font></ol>');
					}
					?>
					<div id="status"><table width="100%"><tr><td height="80" align="center"><img src="template/images/loading.gif" align="absmiddle" /> 正在执行数据库安装...</td></tr></table></div>
					<script type="text/javascript">
					var table = '<table width="100%"><tr>';
					table+='<td width="80" height="80">&nbsp;</td>';
					table+='<td align="right"><input type="button" onClick="javascript:history.back(-1);" value="上一步" class="btn" /></td>';
					table+='<td align="left"><input type="submit" value="锁定安装" class="btn" /></td>';
					table+='<td width="80">&nbsp;</td>';
					table+='</tr></table>';
					setInterval(function()
					{
						document.getElementById('status').innerHTML = table;
					},step * interval);
					</script>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="foot">&copy; 2014 ReTengCMS 热腾网 </div>
</body>
</html>
