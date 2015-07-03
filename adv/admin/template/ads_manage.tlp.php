<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('ads',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>广告管理</title>
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
			<li><a href="javascript:void(0);" class="on">广告管理</a></li>
			<li><a href="?mod=adv&file=ads&action=ads_add&adsposid=<?php echo $adsposid;?>">添加广告</a></li>			
		</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend>操作提示</legend>
		1：广告名称不能为空
		</fieldset>
		<table cellspacing="0" class="datalist" id="list" width="98%">
		<tr>						
			<th width="15%" class="firstcol">广告名称</th>
			<th width="22%">所属广告位</th>
			<th width="17%">起始日期</th>
			<th width="16%">结束日期</th>
			<th width="10%">状态</th>
			<th width="12%">审核</th>
			<th width="8%">管理</th>
		</tr>
		<form action="" method="post" name="myform">
		<input type="hidden" name="do_submit" value="1" />
		<?php if($result){foreach($result as $val){?>
		<tr>
			<td width="15%" align="center"><input type="hidden" name="name[<?php echo $val['id'];?>]" value="<?php echo $val['name'];?>" /><?php echo $val['name'];?></td>
			<td width="22%" align="center"><?php echo $val['adspos'];?></td>
			<td width="17%" align="center"><input type="text" size="13" name="fromdate[<?php echo $val['id'];?>]" value="<?php echo date('Y-m-d',$val['fromdate']);?>" /></td>
			<td width="16%" align="center"><input type="text" size="13" name="todate[<?php echo $val['id'];?>]" value="<?php echo date('Y-m-d',$val['todate']);?>" /></td>
			<td width="10%" align="center"><?php echo $val['todate']>time()?'正常':'<font color="#FF3300">过期</font>';?></td>
			<td width="12%" align="center"><?php echo $val['ispassed']?'已审核 <a href="'.ADMIN_FILE.'?mod=adv&file=ads&action=ads_lock&ispassed=0&id='.$val['id'].'"><u>待审</u></a>':'待审核 <a href="'.ADMIN_FILE.'?mod=adv&file=ads&action=ads_lock&ispassed=1&id='.$val['id'].'"><u>审核</u></a>';?> </td>
			<td width="8%" align="center"><a href="<?php echo ADMIN_FILE;?>?mod=adv&file=ads&action=ads_edit&id=<?php echo $val['id'];?>"><u>修改</u></a>  <a href="<?php echo ADMIN_FILE;?>?mod=adv&file=ads&action=ads_delete&id=<?php echo $val['id'];?>" onclick="if(!confirm('确定删除?点击确定继续!'))return false;"><u>删除</u></a></td>
		</tr>
		<?php }?>
		<tr>
			<td colspan="7">
			<input type="button" onclick="this.form.submit();" class="submit" value="批量修改" />
			</td>
		</tr>
		</form>
		<?php }else{?>
		<tr><td colspan="7">目前尚未添加任何广告...</td></tr>	
		<?php }?>
		<tr><td colspan="7"><?php echo $ads->pagestring;?></td></tr>
		</table>
	</div>
</div>
</body>
</html>
