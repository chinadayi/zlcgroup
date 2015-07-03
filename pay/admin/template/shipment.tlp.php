<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('pay',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>送货方式</title>
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
			<li><a href="javascript:void(0);" class="on">送货方式</a></li>		
		</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend>操作提示</legend>
		如需删除某个已经存在的送货方式, 将名字设置为空即可。
		</fieldset>
		<form action="" method="post" name="myform">
		<input type="hidden" name="do_submit" value="1" />
		<table cellspacing="0" class="datalist" id="list" width="98%">
		<tr>
			<th width="25%" class="firstcol">送货方式</th>
			<th width="15%">手续费</th>
			<th width="60%">简要描述</th>
		</tr>
		<?php if(isset($result)){foreach($result as $val){?>
		<input type="hidden" value="<?php echo $val['id'];?>" name="id[<?php echo $val['id'];?>]" />
		<tr>
			<td width="25%" align="center"><input type="text" size="20" value="<?php echo $val['name'];?>" name="name[<?php echo $val['id'];?>]" /></td>
			<td width="15%" align="center"><input type="text" size="6" value="<?php echo $val['fee'];?>" name="fee[<?php echo $val['id'];?>]" />元</td>
			<td width="60%" align="center"><textarea name="desc[<?php echo $val['id'];?>]" rows="2" cols="50"><?php echo $val['desc'];?></textarea></td>
		</tr>
		<?php }?>
		<?php }else{?>
		<tr><td colspan="3">目前尚未安装任何支付方式...</td></tr>	
		<?php }?>
		<tr><td colspan="3" align="center"><strong>增加一个支付方式：</strong></td></tr>	
		<tr>
		  <td width="25%" align="center"><input type="text" size="20" name="name[]" /></td>
		  <td width="15%" align="center"><input type="text" size="6" value="0.00" name="fee[]" />元</td>
		  <td width="60%" align="center"><textarea name="desc[]" rows="2" cols="50"></textarea></td>
		</tr>
		<tr><td colspan="3"><input type="submit" class="submit" value="提交配置" /></td></tr>
		</table>
		</form>
	</div>
</div>
</body>
</html>
