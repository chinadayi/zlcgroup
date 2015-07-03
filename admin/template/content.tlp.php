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
			<li><a href="?mod=gather&file=gather&action=manage">节点管理</a></li>
			<li><a href="?mod=gather&file=gather&action=add">添加规则</a></li>		
			<li><a href="javascript:void(0);" class="on">临时内容</a></li>	
		</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		如需对内容进行操作，别忘了选择该内容。
		</fieldset>
		<table cellspacing="0" class="datalist" id="list" width="100%">
		<tr>
			<th width="8%" class="firstcol">选择</th>
			<th width="10%">节点名称</th>
			<th width="31%">标题</th>
			<th width="51%">URL</th>
			
		</tr>
		<form action="" method="post" name="myform">
		<input type="hidden" name="do_submit" value="1" />
		<input type="hidden" name="nodeid" value="<?php echo $nodeid;?>" />
		<?php if($result){foreach($result as $key => $val){?>
		<tr>
			<td align="center"><input type="checkbox" class="checkbox" name="id[]" checked="checked" value="<?php echo $val['id'];?>" /></td>
			<td align="center"><?php echo $gather->gathername($val['nodeid']);?></td>
			<td><a href="?mod=gather&file=gather&action=preview&id=<?php echo $val['id'];?>"><?php echo sub_string($val['title'],40,'...');?></a></td>
			<td><a href="<?php echo $val['url'];?>" target="_blank"><?php echo $val['url'];?></a></td>
			
		</tr>
		<?php }?>
		<tr>
			<td width="8%" align="center">
			 <input type="checkbox" name="chkall2" value="1" class="checkbox" checked="checked" onclick="check_all(this)" />
	 	  </td>
			<td colspan="3" align="left" style="padding-left:10px">
			<input type="button" onclick="if(confirm('确实要删除指定内容?')){this.form.action='?mod=gather&file=gather&action=deletecon';this.form.submit();}" class="submit" value="删除数据" />
			<?php if($id){?>
			&nbsp;
			<input type="button" onclick="this.form.action='?mod=gather&file=gather&action=insert';this.form.submit();" class="submit" value="导入数据" />
			到栏目
			<select name="movetocatid">
				<?php $options->catoptions(0,array(),array(1),$gatherinfo['modelid']);?>
			</select>
			<?php }?>
			</td>
		</tr>
		</form>
		<?php }else{?>
		<tr><td colspan="4">目前尚未发现任何临时内容...</td></tr>	
		<?php }?>
		<tr>
			<td colspan="4"><?php echo $gather->pagestring;?></td>
		</tr>
		</table>
	</div>
</div>
</body>
</html>
