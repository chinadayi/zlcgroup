<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('link',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>友链管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script type="text/javascript" src="admin/template/js/admin.js"></script>
<script language="javascript" src="admin/template/js/css.js"></script>
</head>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="?mod=link&file=link&action=manage&typeid=<?php echo $typeid;?>" class="on">友链管理</a></li>
			<li><a href="?mod=link&file=link&action=add&typeid=<?php echo $typeid;?>">添加友链</a></li>			
		</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend>操作提示</legend>
		1：链接URL必须以http://开头
		</fieldset>
		<table cellspacing="0" class="datalist" id="list">
		<tr>			
			<th width="5%" class="firstcol">排序</th>
			<th width="18%">链接名称</th>
			<th width="33%">链接URL</th>
			<th width="11%">链接类型</th>
			<th width="13%">状态</th>
			<th width="10%">推荐</th>
			<th width="10%">管理</th>
		</tr>
		<form action="" method="post" name="myform">
		<input type="hidden" name="do_submit" value="1" />
		<?php if($result){foreach($result as $val){?>
		<tr>
			<td width="5%" align="center"><input type="text" size="4" name="orderby[<?php echo $val['id'];?>]" value="<?php echo $val['orderby'];?>" /></td>
			<td width="18%" align="center"><input type="text" size="25" name="name[<?php echo $val['id'];?>]" value="<?php echo $val['name'];?>" /></td>
			<td width="33%" align="center"><input type="text" size="45" name="url[<?php echo $val['id'];?>]" value="<?php echo $val['url'];?>" /></td>
			<td width="11%" align="center"><?php echo $val['logo']?'<img src="'.$val['logo'].'" width="55" />':'文字连接';?></td>
			<td width="13%" align="center"><?php echo !$val['disabled']?'已通过 <a href="'.ADMIN_FILE.'?mod=link&file=link&action=disabled&disabled=1&id='.$val['id'].'"><u>待审</u></a>':'未通过 <a href="'.ADMIN_FILE.'?mod=link&file=link&action=disabled&disabled=0&id='.$val['id'].'"><u>审核</u></a>';?> </td>
			<td width="10%" align="center"><?php echo $val['isindex']?'推荐 <a href="'.ADMIN_FILE.'?mod=link&file=link&action=isindex&isindex=0&id='.$val['id'].'"><u>普通</u></a>':'普通 <a href="'.ADMIN_FILE.'?mod=link&file=link&action=isindex&isindex=1&id='.$val['id'].'"><u>推荐</u></a>';?> </td>
			<td width="10%" align="center"><a href="<?php echo ADMIN_FILE;?>?mod=link&file=link&action=edit&id=<?php echo $val['id'];?>"><u>修改</u></a> <a href="<?php echo ADMIN_FILE;?>?mod=link&file=link&action=delete&id=<?php echo $val['id'];?>"><u>删除</u></a></td>
		</tr>
		<?php }?>
		<tr>
			<td colspan="7">
			<input type="button" onclick="this.form.submit();" class="submit" value="批量修改" />
			</td>
		</tr>
		</form>
		<?php }else{?>
		<tr><td colspan="7">目前尚未添加任何友链...</td></tr>	
		<?php }?>
		<tr><td colspan="7"><?php echo $flink->pagestring;?></td></tr>
		</table>
	</div>
</div>
</body>
</html>
