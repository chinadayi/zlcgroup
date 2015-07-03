<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>发布点管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script language="javascript" src="admin/template/js/css.js"></script>
</head>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="javascript:void(0);" class="on">发布点管理</a></li>
			<li><a href="?file=sitecrowd&action=issue_add">添加发布点</a></li>
		</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		暂无操作提示!
		</fieldset>
		<table cellspacing="0" class="datalist" id="list" width="98%">
		<tr>
			<th width="8%" class="firstcol">发布点ID</th>
			<th width="16%">发布点名称</th>
			<th width="23%">服务器地址</th>
			<th width="12%">用户名</th>
			<th width="15%">主目录</th>
			<th width="26%">管理操作</th>
		</tr>
		<?php if($result){foreach($result as $val){?>
		<tr>
			<td align="center"><?php echo $val['issueid'];?></td>
			<td align="center"><?php echo $val['issuename'];?></td>
			<td align="center"><?php echo $val['ftphost'];?></td>
			<td align="center"><?php echo $val['ftpuser'];?></td>
			<td align="center"><?php echo $val['ftpdir']?$val['ftpdir']:'/';?></td>
			<td align="center"><a href="<?php echo ADMIN_FILE;?>?file=sitecrowd&action=issue_edit&id=<?php echo $val['issueid'];?>"><u>修改</u></a> | <a onclick="if(!confirm('确实要删除发布点[ <?php echo $val['issuename'];?> ]？'))return false;" href="<?php echo ADMIN_FILE;?>?file=sitecrowd&action=issue_delete&id=<?php echo $val['issueid'];?>"><u>删除</u></a></td>
		</tr>
		<?php }?>
		<?php }else{?>
		<tr><td colspan="6">目前尚未添加任何发布点...</td></tr>	
		<?php }?>
		<tr>
			<td colspan="6"><?php echo $sitecrowdobj->pagestring;?></td>
		</tr>
		</table>
	</div>
</div>
</body>
</html>