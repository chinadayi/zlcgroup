<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('gather',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>节点管理</title>
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
			<li><a href="javascript:void(0);" class="on">节点管理</a></li>
			<li><a href="?mod=gather&file=gather&action=import">导入规则</a></li>
			<li><a href="?mod=gather&file=gather&action=add">添加规则</a></li>			
		</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		如需对节点进行操作，别忘了选择该节点。
		</fieldset>
		<table cellspacing="0" class="datalist" id="list" width="100%">
		<tr>
			<th width="82" class="firstcol">选择</th>
			<th width="275">节点名称</th>
			<th width="170">针对模型</th>
			<th width="215">加入日期</th>
			<th width="239">最后采集日期</th>
			<th width="154">编码</th>
			<th width="166">网址数</th>
		</tr>
		<form action="" method="post" name="myform">
		<input type="hidden" name="do_submit" value="1" />
		<?php if($result){foreach($result as $key => $val){?>
		<tr>
		  <td width="82" align="center"><input type="radio" name="id" <?php if(!$key){?> checked="checked"<?php }?> value="<?php echo $val['id'];?>" class="checkbox" /></td>
		  <td width="275">[

		  <a href="?mod=gather&file=gather&action=addthistask&id=<?php echo $val['id'];?>&name=<?php echo $val['name'];?>" style="color:#FF0000">加入计划任务</a>

		  ]&nbsp;<a href="?mod=gather&file=gather&action=edit&id=<?php echo $val['id'];?>"><?php echo $val['name'];?></a></td>
			<td width="170" align="center"><?php echo $gather->getmodelname($val['modelid']);?></td>
			<td width="215" align="center"><?php echo date('Y-m-d',$val['addtime']);?></td>
			<td width="239" align="center"><?php echo $val['cotime']?date('Y-m-d',$val['cotime']):'从未采集';?></td>
			<td width="154" align="center"><?php echo strtoupper($val['code']);?></td>
			<td width="166" align="center"><?php echo $val['urlcounts'];?></td>
		</tr>
		<?php }?>
		<tr>
			<td colspan="7" align="left" style="padding-left:20px">
			<input type="radio" name="do" value="export" class="radio" /><label for="delete">导出</label>&nbsp;
			<input type="radio" name="do" value="do" class="radio" checked="checked" /><label for="delete">采集</label>&nbsp;
			<input type="radio" name="do" value="data" class="radio" /><label for="delete">数据</label>&nbsp;
			<input type="radio" name="do" value="truncate" class="radio" /><label for="delete">清空</label>&nbsp;
			<input type="radio" name="do" value="edit" class="radio" /><label for="delete">更改</label>&nbsp;
			<input type="radio" name="do" value="delete" class="radio" /><label for="delete">删除</label>&nbsp;
			<input type="button" onclick="this.form.submit();" class="submit" value="执行操作" />
			</td>
		</tr>
		</form>
		<?php }else{?>
		<tr><td colspan="7">目前尚未添加任何采集节点...</td></tr>	
		<?php }?>
		<tr>
			<td colspan="7"><?php echo $gather->pagestring;?></td>
		</tr>
		</table>
	</div>
</div>
</body>
</html>
