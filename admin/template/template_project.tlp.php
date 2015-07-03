<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(11,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $lang['LEFT-TEMPLATE-1'];?></title>
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
			<li><a href="javascript:void(0);" class="on"><?php echo $lang['LEFT-TEMPLATE-1'];?></a></li>
			<li><a href="?file=template&action=manage"><?php echo $lang['LEFT-TEMPLATE-2'];?></a></li>	
		</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		如果您需要增加一个模板方案，只需通过FTP在<?php echo basename(TPL_ROOT);?>/ 目录下建立一个以字母，数字，下划线组成的文件夹即可。
		</fieldset>
		<table cellspacing="0" class="datalist" id="list" width="98%">
		<tr>
			<th width="21%" class="firstcol">方案名称</th>
			<th width="14%">模板目录</th>
			<th width="18%">修改时间</th>
			<th width="13%">当前模板</th>
			<th width="34%">管理</th>
		</tr>
		<form action="" method="post" name="myform">
		<input type="hidden" name="do_submit" value="1" />
		<?php if($result){foreach($result as $val){?>
		<tr>
	      <td width="21%" align="center"><input type="text" size="20" name="name[<?php echo $val['dir'];?>]" value="<?php echo $val['name'];?>" /></td>
			<td width="14%" align="center"><?php echo $val['dir'];?></td>
			<td width="18%" align="center"><?php echo $val['mtime'];?></td>
			<td width="13%" align="center"><?php echo $val['isdefault']?'√':'&nbsp;';?></td>
			<td width="34%" align="center"><a href="<?php echo ADMIN_FILE;?>?file=template&action=manage&project=<?php echo $val['dir'];?>">模板管理</a>&nbsp; &nbsp;<a href="<?php echo ADMIN_FILE;?>?file=template&action=add&project=<?php echo $val['dir'];?>">添加模板</a>&nbsp; &nbsp;<?php if(!$val['isdefault']){?><a href="<?php echo ADMIN_FILE;?>?file=template&action=delete_project&project=<?php echo $val['dir'];?>" onclick="if(!confirm('您确定要删除模板方案【<?php echo $val['dir'];?>】吗？'))return false;">删除</a><?php }else{echo '<font color="#999999">删除</font>';}?>&nbsp; &nbsp;<a href="<?php echo ADMIN_FILE;?>?file=template&action=preview&project=<?php echo $val['dir'];?>" target="_blank"><?php echo get_cookie('project')==$val['dir']?'<font color="#FF0000">':'';?>预览<?php echo get_cookie('project')==$val['dir']?'</font>':'';?></a><?php echo get_cookie('project')==$val['dir']?'<font color="#FF0000">':'';?></td>
		</tr>
		<?php }?>
		<tr>
			<td colspan="5" align="left">
			&nbsp;&nbsp;&nbsp;<input type="button" onclick="this.form.submit();" class="submit" value="修改名称" />
			</td>
		</tr>
		</form>
		<?php }else{?>
		<tr><td colspan="5">目前尚未添加任何模板方案...</td></tr>	
		<?php }?>
		</table>
	</div>
</div>
</body>
</html>
