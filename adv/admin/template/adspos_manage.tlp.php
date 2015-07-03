<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('ads',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>广告位管理</title>
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
			<li><a href="javascript:void(0);" class="on">广告位管理</a></li>
			<li><a href="?mod=adv&file=ads&action=adspos_add">添加广告位</a></li>			
		</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend>操作提示</legend>
		1：广告位名称不能为空
		</fieldset>
		<table cellspacing="0" class="datalist" id="list" width="98%">
		<tr>			
			<th width="22%" class="firstcol">广告位名称</th>
			<th width="43%">调用代码</th>
			<th width="11%">价格</th>
			<th width="11%">状态</th>
			<th width="13%">管理</th>
		</tr>
		<form action="" method="post" name="myform">
		<input type="hidden" name="do_submit" value="1" />
		<?php if($result){foreach($result as $val){?>
		<tr>
			<td width="22%" align="center"><input type="text" size="25" name="name[<?php echo $val['id'];?>]" value="<?php echo $val['name'];?>"  /></td>
		  <td width="43%" align="center"><input type="text" size="55"  ondblclick="javascript:copy('<?php echo htmlspecialchars('<script language="javascript" src="{$RETENG[site_url]}adv/api/adv.js.php?id='.$val['id'].'&siteid={$RETENG[\'site_id\']}"></script>');?>');" readonly="1" value="<?php echo htmlspecialchars('<script language="javascript" src="{$RETENG[\'site_url\']}adv/api/adv.js.php?id='.$val['id'].'&siteid={$RETENG[\'site_id\']}"></script>');?>"  /></td>
			<td width="11%" align="center"><input type="text" size="4" name="price[<?php echo $val['id'];?>]" value="<?php echo $val['price'];?>"  /> 元/月</td>
			<td width="11%" align="center"><?php echo $val['ispassed']?'已启用 <a href="'.ADMIN_FILE.'?mod=adv&file=ads&action=adspos_lock&ispassed=0&id='.$val['id'].'"><u>待审</u></a>':'未启用 <a href="'.ADMIN_FILE.'?mod=adv&file=ads&action=adspos_lock&ispassed=1&id='.$val['id'].'"><u>审核</u></a>';?> </td>
			<td width="13%" align="center"><a href="<?php echo ADMIN_FILE;?>?mod=adv&file=ads&action=adspos_edit&id=<?php echo $val['id'];?>"><u>编辑</u></a> <a href="<?php echo ADMIN_FILE;?>?mod=adv&file=ads&action=adspos_delete&id=<?php echo $val['id'];?>" onclick="if(!confirm('确定删除?点击确定继续!'))return false;"><u>删除</u></a> <a href="<?php echo ADMIN_FILE;?>?mod=adv&file=ads&action=manage&adsposid=<?php echo $val['id'];?>"><u>广告</u></a></td>
		</tr>
		<?php }?>
		<tr>
			<td colspan="5">
			&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" onclick="this.form.submit();" class="submit" value="批量修改" />
			</td>
		</tr>
		</form>
		<?php }else{?>
		<tr><td colspan="5">目前尚未添加任何广告位...</td></tr>	
		<?php }?>
		<tr><td colspan="5"><?php echo $ads->pagestring;?></td></tr>
		</table>
	</div>
</div>
</body>
</html>
