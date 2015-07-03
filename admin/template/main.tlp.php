<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>管理首页</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script language="javascript" src="admin/template/js/css.js"></script>
</head>
<body oncontextmenu="return false" ondragstart="return false" onSelectStart="return false">
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="javascript:void(0);" class="on" onclick="$('#main-lang-1').toggle();"><?php echo $lang['MAIN-LANG-1'];?></a></li>			
		</ul>
	</div>
	<div class="main" id="main-lang-1">
	<table width="100%" border="0" cellspacing="1" cellpadding="0" class="mainlist">
		<tr><td width="47%">版本信息：<?php echo RETENG_VERSION;?>_<?php echo RETENG_RELEASE;?><span id="reteng"></span></td><td width="53%"></td></tr>
		<tr>
			<td width="47%">管理员登录用户名：
			<?php 
				if($_userid==ADMIN_FOUNDERS)
				{
					echo $_username.'['.$lang['ADMIN_FOUNDERS'].']';
				}
				else
				{
					echo $_username.'['.$admin->get_rolename($_roleid).']';
				}
			?> </td>
			<td width="53%">文件上传最大限制： <?php echo min(round(UPLOAD_SIZE/1024),substr(ini_get('post_max_size'),0,-1)*1024);?> KB</td>
		</tr>
		<tr>
			<td>服务器主机( IP )： <?php echo strtolower(substr(PHP_OS,0,3))=='win'?'Windows主机':'*unix主机';?>(<?php echo get_hostip();?>)</td>
			<td>当前站点物理路径： <?php echo str_replace('\\','/',$_SERVER['DOCUMENT_ROOT'].RETENG_PATH);?></td>
		</tr>
		<tr>
			<td>是否支持图形处理： <?php echo extension_loaded('gd')&&function_exists('imagecreate')?'支持GD图形处理库':'不支持GD图形处理库';?></td>
			<td>浏览器类型及版本： <?php echo explorer_version();?>  
</td>
		</tr>
		<tr>
			<td>是否支持压缩传输： <?php echo extension_loaded('zlib') && function_exists('ob_gzhandler')?'支持Gzip压缩传输':'不支持Gzip压缩传输';?></td>
			<td>PHP 和 MySQL版本： <?php echo 'PHP：'.PHP_VERSION.' &nbsp;/&nbsp;'.$db->version();?></td>
		</tr>
    </table>
	</div>
	<div class="tab">
		<ul>
			<li><a href="javascript:void(0);" class="on" onclick="$('#main-lang-1').toggle();">官方信息</a></li>			
		</ul>
	</div>
	<div class="main" id="main-lang-1">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="mainlist">
      <tr>
        <td><strong>技术支持</strong></td>
      </tr>
      <tr>
        <td>热腾网：<a href="http://www.reteng.org" target="_blank" style="text-decoration:none;">http://www.reteng.org/</a></td>
      </tr>
      <tr>
        <td>热腾CMS：<a href="http://cms.reteng.org" target="_blank" style="text-decoration:none;">http://cms.reteng.org</a></td>
      </tr>
      <tr>
        <td>帮助文档：<a href="http://doc.reteng.org" target="_blank" style="text-decoration:none;">http://doc.reteng.org</a></td>
      </tr>
    </table></td>
    <td width="50%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="mainlist">
      <tr>
        <td><strong>官方动态</strong></td>
      </tr>
      <tr>
        <td><div id="ntcd">
        <?php
        echo  geturlfile("http://cms.reteng.org/list/?id=16&siteid=1&temp=ajax_list_news2&do=ajax");
		?>
        
        </div></td>
      </tr>
    </table></td>
  </tr>
</table>

	</div>
</div>



</body>
</html>
