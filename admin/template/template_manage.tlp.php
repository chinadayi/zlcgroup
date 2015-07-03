<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(12,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $lang['LEFT-TEMPLATE-2'];?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
			<li><a href="?file=template&action=project"><?php echo $lang['LEFT-TEMPLATE-1'];?></a></li>
			<li><a href="javascript:void(0);" class="on"><?php echo $lang['LEFT-TEMPLATE-2'];?></a></li>
		</ul>
	</div>
	<div class="main">
		<div class="search">
			<form action="?" method="get" name="search">
				<input type="hidden" name="file" value="template"> 
				<input type="hidden" name="action" value="manage">
				<input type="hidden" name="project" value="<?php echo $project;?>">
				<input type="hidden" name="class" value="<?php echo $class;?>">
				<fieldset>
				<legend>搜索模板</legend>
				模板名称：
				<input type="text" name="k" size="35" value="<?php echo isset($k) && $k?htmlspecialchars(stripslashes($k)):'';?>" />
				<input type="submit" class="button" value="开始查找" />
				</fieldset>
			</form>
			
			<ul style="width:750px; clear:both; padding-left:8px">
				<li style="width:90px; float:left; padding:4px"><input type="button" onclick="window.location.href='<?php echo ADMIN_FILE;?>?file=template&action=manage&project=<?php echo $project;?>&class=&page=<?php echo isset($page)?intval($page):1;?>'" class="button" style="width:80px; font-size:12px" value="常规模板" /></li>
				<?php
				if($classarray)foreach($classarray as $_classarray)
				{
					echo "\n".'<li style="width:90px; float:left; padding:4px"><input type="button" onclick="window.location.href=\''.ADMIN_FILE.'?file=template&action=manage&project='.$project.'&class='.basename($_classarray).'&page='.(isset($page)?intval($page):1).'\'"  class="button" style="width:80px; font-size:12px" value="'.basename($_classarray).'" /></li>'."\n";
				}
				?>
			</ul>
			 <span style="padding-left:10px; color:#FF0000">* 常规模板是指首页模板、栏目模板、内容模板、单页模板等可由用户自定义的模板.</span>
		</div>
		<table cellspacing="0" class="datalist" id="list" width="98%">
		<tr>
			<th width="18%" class="firstcol">模板名称</th>
			<th width="22%" >文件名</th>
			<th width="26%" >模板嵌套代码</th>
			<th width="18%" >修改时间</th>
			<th width="16%" >管理</th>
		</tr>
		<form action="" method="post" name="myform">
		<input type="hidden" name="do_submit" value="1" />
		<input type="hidden" name="project" value="<?php echo $project;?>" />
		<input type="hidden" name="class" value="<?php echo $class;?>" />
		<?php if($result){foreach($result as $val){?>
		<tr>
			<td width="18%" align="center"><input type="text" size="14" name="name[<?php echo $val['template'];?>]" value="<?php echo $val['name'];?>" /></td>
			<td width="22%" align="center"><a href="<?php echo ADMIN_FILE;?>?file=template&action=edit&project=<?php echo $project;?>&class=<?php echo $class;?>&page=<?php echo $page?$page:0;?>&template=<?php echo $val['template'];?>"><?php echo $val['template'];?>.htm</a></td>
		  <td width="26%" align="center"><input type="text" readonly="1" title="双击复制到剪切板" ondblclick="javascript:copy('<?php echo '{tlp '.$val['template'].'}';?>');" size="30" value="<?php echo '{tlp '.$val['template'].'}';?>" /></td>
			<td width="18%" align="center">&nbsp;<?php echo $val['mtime'];?></td>
			<td width="16%" align="center">
			<a href="<?php echo ADMIN_FILE;?>?file=template&action=edit&project=<?php echo $project;?>&class=<?php echo $class;?>&page=<?php echo $page?$page:0;?>&template=<?php echo $val['template'];?>">HTML编辑</a>&nbsp;
			&nbsp;
			<a href="javascript:confirmUrl('您确定要删除模板【<?php echo $val['template'].'.htm';?>】吗?','<?php echo ADMIN_FILE;?>?file=template&action=delete&project=<?php echo $project;?>&class=<?php echo $class;?>&template=<?php echo $val['template'];?>')">删除</a></td>
		</tr>
		
		<?php }?>
		<tr>
			<td colspan="5" align="left">
			&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" onclick="this.form.submit();" class="submit" value="修改名称" />
			</td>
		</tr>
		</form>
		<?php }else{?>
		<tr><td colspan="5">该模板方案下尚未添加任何模板...</td></tr>	
		<?php }?>
		<tr>
			<td colspan="5" style="text-align:right; padding-right:8px" height="50"><?php echo $tempobj->pagestring;?></td>
		</tr>
		</table>
	</div>
</div>
</body>
</html>
