<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(14,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $lang['LEFT-MODULE-6'];?></title>
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
			<li><a href="javascript:void(0);" class="on"><?php echo $lang['LEFT-MODULE-6'];?></a></li>
			<li><a href="?file=module&action=import"><?php echo $lang['LEFT-MODULE-8'];?></a></li>
			<li><a href="?file=module&action=guide"><?php echo $lang['LEFT-MODULE-7'];?></a></li>
		</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		1:更多模块下载 http://www.reteng.org/
		</fieldset>
		<table cellspacing="0" class="datalist" id="list" width="98%">
		<tr>
			<th class="firstcol">反选</th>
			<th>排序</th>
			<th>模块名称</th>
			<th>模块简介</th>
		</tr>
		<form action="" method="post" name="myform">
		<input type="hidden" name="do_submit" value="1" />
		<?php 
			if($result){foreach($result as $key => $val){?>
		<tr>
			<td  width="6%" align="center"><input type="checkbox" name="id[]" value="<?php echo $val['id'];?>" class="checkbox" /></td>
			<td  width="6%" align="center"><input type="text" name="orderby[<?php echo $val['id'];?>]" value="<?php echo $val['orderby'];?>" size="4"/></td>
			<td  width="14%">[<?php echo $val['disabled']?'<font color="">已禁用</font>':'已启用';?>]<?php echo $val['name'];?></td>
			<td  width="74%">
			<?php echo strip_tags($val['description']);?>
			<br />
			<?php if($val['site']){?>模块作者：<?php echo $val['author'];?><?php }?> <?php if($val['site']){?>网址：<?php echo $val['site'];?><?php }?> <?php if($val['version']){?>版本：<?php echo $val['version'];?><?php }?>  <a href="?file=left&menu=module&path=<?php echo $val['folder'];?>" target="leftFrame"><u>管理模块</u></a>  <a href="?file=module&action=export&id=<?php echo $val['id'];?>"><u>导出模块</u></a>
			 <?php if($val['menu']){?><a href="<?php echo SITE_URL.$val['folder'];?>/" target="_blank"><u>访问模块</u></a><?php }?>
			 <a href="?file=module&action=set&id=<?php echo $val['id'];?>"><u><font color="#FF0000">配置</font></u></a>
			</td>
		</tr>
		<?php }?>
		<tr>
			<td width="8%" align="center">
			<input type="checkbox" name="chkall2" value="1" class="checkbox" onclick="check_all(this)" /></td>
			<td colspan="3" align="left">
			<input type="button" onclick="this.form.action='?file=module&action=setorderby';this.form.submit();" class="submit" value="设置排序" />
			<input type="button" onclick="this.form.action='?file=module&action=undisabled';this.form.submit();" class="submit" value="启用模块" />
			<input type="button" onclick="this.form.action='?file=module&action=disabled';this.form.submit();" class="submit" value="禁用模块" />
			<input type="button" onclick="this.form.action='?file=module&action=adminmenu&adminmenu=1';this.form.submit();" class="submit" value="添加后台头部导航" />
			<input type="button" onclick="this.form.action='?file=module&action=adminmenu&adminmenu=0';this.form.submit();" class="submit" value="添加到拓展功能" />
			<input type="button" onclick="if(confirm('确定要卸载指定模块?')){this.form.action='?file=module&action=delete';this.form.submit();}" class="submit" value="卸载模块" />
			</td>
		</tr>
		</form>
		<?php }else{?>
		<tr><td colspan="4">目前尚未安装任何模块...</td></tr>	
		<?php }?>
		<tr>
			<td colspan="4"><?php echo $module->pagestring;?></td>
		</tr>
		</table>
	</div>
</div>
</body>
</html>
