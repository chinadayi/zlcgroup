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
			<li><a href="?mod=gather&file=gather&action=task" class="on">服务端任务管理</a></li>
			<li><a href="?mod=gather&file=gather&action=addtask">添加计划任务</a></li>
	

		</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		<b style="color:#FF0000">注意事项</b>：开启服务端计划任务必须要求服务器的配置是apache,否则会失效。服务端计划任务一旦开启，将一直在服务端运行，可能比较消耗服务器内存，建议vps或者虚拟主机不要使用，
		<br />
		<span style="padding-left:10px">
		<input type="button" class="button" onclick="location.href='?mod=gather&file=gather&action=starttask'" value="<?php echo $task==true?"关闭计划任务":"开启计划任务"?>" />
		</span>
		</fieldset>
		<table cellspacing="0" class="datalist" id="list" width="100%">
		<tr>
			<th width="7%" class="firstcol">选择</th>
			<th width="14%">标题</th>
			<th width="14%">状态</th>
			<th width="10%">执行次数</th>
			<th width="36%">URL</th>
			<th width="19%">最后执行时间</th>
		  </tr>
		<form action="" method="post" name="myform">
		<input type="hidden" name="do_submit" value="1" />
		<input type="hidden" name="id" value="<?php echo $id;?>" />
		<?php if($result){foreach($result as $key => $val){?>
		<tr>
			<td align="center"><input type="checkbox" class="checkbox" name="id[]" checked="checked" value="<?php echo $val['id'];?>" /></td>
			<td><?php echo sub_string($val['name'],40,'...');?></td>
			<td><div align="center"><?php  echo $val['status']==0? "等待中…": "执行中…";?></div></td>
			<td><div align="center"><?php echo $val['count'];?></div></td>
			<td><?php echo $val['url'];?></td>
			<td><div align="center"><?php echo $val['updatetime'];?></div></td>
		  </tr>
		<?php }?>
		<tr>
			<td width="7%" align="center">
			 <input type="checkbox" name="chkall2" value="1" class="checkbox" checked="checked" onclick="check_all(this)" />	 	  </td>
			<td colspan="5" align="left" style="padding-left:10px">
			<input type="button" onclick="if(confirm('确实要删除指定内容?')){this.form.action='?mod=gather&file=gather&action=deletetask';this.form.submit();}" class="submit" value="删除数据" /></td>
		</tr>
		</form>
		<?php }else{?>
		<tr><td colspan="6">目前尚未发现任何临时内容...</td></tr>	
		<?php }?>
		<tr>
			<td colspan="6"><?php echo $gather->pagestring;?></td>
		</tr>
		</table>
	</div>
</div>
</body>
</html>
