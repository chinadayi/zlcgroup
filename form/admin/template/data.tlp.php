<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('form',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>表单管理</title>
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
			<li><a href="?mod=form&file=form&action=manage">自定义表单</a></li>
			<li><a href="javascript:void(0);" class="on">表单数据</a></li>
		</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		如需对表单进行操作，别忘了选择该表单。
		</fieldset>
		<form action="" method="post" name="myform">
		<input type="hidden" name="do_submit" value="1" />
		<input type="hidden" name="formid" value="<?php echo $formid;?>" />
		<table width="100%" cellspacing="0" class="datalist" id="list">
		<tr>
		  	<th width="8%" class="firstcol">反选</th>
			<?php foreach($fieldslist as $r){?>
			<th><?php echo $r['name'];?></th>
			<?php }?>
			<th width="8%">详情</th>
		</tr>
		<?php if($result){foreach($result as $val){?>
		<tr>
			<td align="center"><input type="checkbox" checked="checked" name="id[]" value="<?php echo $val['id'];?>" class="checkbox" /></td>
			<?php foreach($fieldslist as $r){?>
			<td align="center"><a href="form/index.php?action=show&contentid=<?php echo $val['id'];?>&id=<?php echo $formid;?>" target="_blank"><?php echo sub_string(strip_tags($val[$r['enname']]),40,'...');?></a></td>
			<?php }?>
			<td width="8%" align="center">
			<a href="form/index.php?action=show&contentid=<?php echo $val['id'];?>&id=<?php echo $formid;?>" target="_blank">查看</a>
			</td>
		</tr>
		<?php }?>
		<td width="8%" align="center">
		  <input type="checkbox" name="chkall2" value="1" checked="checked" class="checkbox" onclick="check_all(this)" /></td>
		<td colspan="<?php echo sizeof($fieldslist)+1;?>">
		<input type="button" value="删 除" class="button" name="do_delete" class="dosubmit" onclick="if(confirm('确定进行删除操作吗？')){this.form.action='?mod=form&file=form&action=delete_data';this.form.submit();}" />
		</td>
		</tr>
		<?php }else{?>
		<tr><td colspan="<?php echo sizeof($fieldslist)+2;?>">目前尚未添加任何内容...</td></tr>	
		<?php }?>
		<tr>
			<td colspan="<?php echo sizeof($fieldslist)+2;?>"><?php echo $formobj->pagestring;?></td>
		</tr>
	  </table>
	  </form>
	</div>
</div>
</body>
</html>
