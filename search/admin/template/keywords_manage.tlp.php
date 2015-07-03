<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('search',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>关键词管理</title>
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
			<li><a href="javascript:void(0);" class="on">关键词管理</a></li>
		</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		如需对关键词进行操作，别忘了选择该关键词。
		</fieldset>
		<table cellspacing="0" class="datalist" id="list" width="98%">
		<tr>
			<th width="8%" class="firstcol">反选</th>
			<th width="49%">关键词</th>
			<th width="22%">热度</th>
			<th width="21%">权重</th>
		</tr>
		<form action="" method="post" name="myform">
		<input type="hidden" name="do_submit" value="1" />
		<?php if($result){foreach($result as $val){?>
		<tr>
		  <td width="8%" align="center"><input type="checkbox" checked="checked" name="id[]" value="<?php echo $val['id'];?>" class="checkbox" /></td>
			<td width="49%" align="center"><input type="text" size="25" name="keywords[<?php echo $val['id'];?>]" value="<?php echo $val['keywords'];?>"/></td>
		  <td width="22%" align="center"><input type="text" size="6" name="counts[<?php echo $val['id'];?>]" value="<?php echo $val['counts'];?>"/></td>
		  <td width="21%" align="center"><input type="text" size="6" name="weight[<?php echo $val['id'];?>]" value="<?php echo $val['weight'];?>" /></td>
		</tr>
		<?php }?>
		<tr>
			<td width="8%" align="center">
		  <input type="checkbox" name="chkall2" checked="checked" value="1" class="checkbox" onclick="check_all(this)" /></td>
			<td colspan="3" align="left">
			<input type="radio" name="do" value="edit" class="radio" checked="checked" /><label for="delete">修改</label>
			<input type="radio" name="do" value="delete" class="radio" /><label for="delete">删除</label>
			<input type="button" onclick="this.form.submit();" class="submit" value="执行操作" />
			</td>
		</tr>
		</form>
		<?php }else{?>
		<tr><td colspan="4">目前尚未添加任何关键词...</td></tr>	
		<?php }?>
		<tr>
			<td colspan="4"><?php echo $keyobj->pagestring;?></td>
		</tr>
		</table>
	</div>
</div>
</body>
</html>
