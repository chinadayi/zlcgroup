<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(15,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $lang['LEFT-MODULE-10'];?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script language="javascript" src="admin/template/js/css.js"></script>
<script type="text/javascript" src="admin/template/js/admin.js"></script>
</head>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="javascript:void(0);" class="on"><?php echo $lang['LEFT-MODULE-10'];?></a></li>
		</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		1:开启过多的插件会对系统的运行速度造成一定的影响; 2 :安装插件只需将插件文件上传到插件目录即可!; 3 :卸载插件只需将插件目录删除即可!
		</fieldset>
		<table cellspacing="0" class="datalist" id="list" width="98%">
		<tr>
			<th class="firstcol">反选</th>
			<th>插件名称</th>
			<th>插件简介</th>
		</tr>
		<form action="" method="post" name="myform">
		<input type="hidden" name="do_submit" value="1" />
		<?php 
			if($result){foreach($result as $name => $actived){
			if(file_exists(RETENG_ROOT.PLUGINS.'/'.$name.'/'.$name.'.php'))
			{
			$info=$plugins->get_plugins_info($name);
		?>
		<tr>
		  <td  width="6%" align="center"><input type="checkbox" checked="checked" name="names[]" value="<?php echo $name;?>" class="checkbox" /></td>
			<td  width="27%"><?php echo $actived?'[已启用]':'[<font color="#666666">已禁用</font>]';?><?php echo $info['Plugins Name'];?></td>
			<td  width="67%"><?php echo htmlspecialchars($info['Plugins Description']);?>&nbsp;<p style="border-bottom:#ccc 1px solid;margin:5px 0px; height:1px"></p>
			<?php if($info['Plugins Author']){?>作者:<a href="<?php echo $info['Author Url']?'':'#';?>" target="_blank"><?php echo $info['Plugins Author'];?></a> | <?php }?>
			版本:<?php echo $info['Plugins Version'];?>
			<?php if(file_exists(RETENG_ROOT.PLUGINS.'/'.$name.'/'.'install.sql')){?> | <a title="安装此插件" href="?file=plugins&action=install&plugin=<?php echo $name;?>"><u>尚未安装</u></a><?php }?>
			<?php if(file_exists(RETENG_ROOT.PLUGINS.'/'.$name.'/'.'installed.sql') || (!file_exists(RETENG_ROOT.PLUGINS.'/'.$name.'/'.'install.sql') && !file_exists(RETENG_ROOT.PLUGINS.'/'.$name.'/'.'installed.sql'))){?> | <font color="#FF0000">已安装</font><?php }?>
			 | <a title="卸载此插件" href="?file=plugins&action=uninstall&plugin=<?php echo $name;?>"><u>卸载</u></a>
		  </td>
		</tr>
		<?php }}?>
		<tr>
			<td width="6%" align="center">
		  <input type="checkbox" name="chkall2" value="1" checked="checked" class="checkbox" onclick="check_all_bynames(this)" /></td>
			<td colspan="2" align="left">
			<input type="radio" name="do" value="active" class="radio" checked="checked" /><label for="delete">启用</label>
			<input type="radio" name="do" value="unactive" class="radio"/><label for="delete">禁用</label>
			<input type="button" class="submit" value="执行操作" onclick="if(confirm('确定执行所选操作?')){this.form.submit();}" />
			</td>
		</tr>
		</form>
		<?php }else{?>
		<tr><td colspan="3">目前尚未安装任何插件...</td></tr>	
		<?php }?>
		</table>
	</div>
</div>
</body>
</html>
