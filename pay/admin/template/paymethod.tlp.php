<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('pay',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>支付配置</title>
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
			<li><a href="javascript:void(0);" class="on">支付配置</a></li>
			<li><a href="?mod=pay&file=pay&action=paymethod_button">支付按钮</a></li>	
		</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend>操作提示</legend>
		在线支付的具体参数配置请详细仔细提供商。
		</fieldset>
		<table cellspacing="0" class="datalist" id="list" width="98%">
		<tr>
			<th width="11%" class="firstcol">支付方式名称</th>
			<th width="9%">在线支付</th>
			<th width="9%">插件作者</th>
			<th width="8%">手续费</th>
			<th width="40%">支付方式描述</th>
			<th width="9%">状态</th>
			<th width="14%">操作</th>
		</tr>
		<?php if(isset($result)){foreach($result as $val){?>
		<tr>
			<td width="11%" align="center"><?php echo $val['name'];?></td>
			<td width="9%" align="center"><?php echo $val['is_online']?'<font color="#FF3300">在线支付</font>':'线下支付';?></td>
			<td width="9%" align="center"><?php echo $val['author'];?></td>
			<td width="8%" align="center"><?php echo $val['fee'];?></td>
			<td width="40%" align="left"><?php echo $val['desc'];?></td>
			<td width="9%" align="center"><?php echo $val['enabled']?'已启用 <a href="'.ADMIN_FILE.'?mod=pay&file=pay&action=paymethod_enabled&enabled=0&id='.$val['id'].'"><u>禁用</u></a>':'<font color="#666666">已禁用</font> <a href="'.ADMIN_FILE.'?mod=pay&file=pay&action=paymethod_enabled&enabled=1&id='.$val['id'].'"><u>启用</u></a>';?> </td>
			<td width="14%" align="center"><a href="?mod=pay&file=pay&action=paymethod_edit&id=<?php echo $val['id'];?>">配置参数</a> | <a href="?mod=pay&file=pay&action=paymethod_button&payment=<?php echo $val['id'];?>">支付按钮</a></td>
		</tr>
		<?php }?>
		<?php }else{?>
		<tr><td colspan="7">目前尚未安装任何支付方式...</td></tr>	
		<?php }?>
		</table>
	</div>
</div>
</body>
</html>
