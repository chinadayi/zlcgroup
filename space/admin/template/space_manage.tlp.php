<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('space',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>空间管理</title>
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
			<li><a href="javascript:void(0);" class="on">空间管理</a></li>
			<li><a href="?mod=space&file=space&action=tagspace">空间调用</a></li>
			<li><a href="?mod=space&file=space&action=tag">留言调用</a></li>
		</ul>
	</div>
	<div class="main">
		<div class="search">
			<form action="?" method="get" name="search">
			<input type="hidden" name="mod" value="<?php echo isset($mod)?$mod:'space';?>"> 
			<input type="hidden" name="file" value="<?php echo isset($file)?$file:'space';?>"> 
			<input type="hidden" name="action" value="<?php echo isset($action)?$action:'manage';?>"> 
				<fieldset>
					<legend>搜索空间</legend>
						空间名称：
						<input type="text" name="k" size="35" value="<?php echo isset($k) && !empty($k)?htmlspecialchars(stripslashes($k)):'';?>" />
						<input type="submit" class="button" value="开始查找" />
				</fieldset>
			</form>
		</div>
		<table cellspacing="0" class="datalist" id="list" width="98%">
		<tr>			
			<th width="9%" class="firstcol">反选</th>
			<th width="40%">空间名称</th>
			<th width="20%">开通时间</th>
			<th width="15%">状态</th>
			<th width="16%">推荐</th>
		</tr>
		<form action="" method="post" name="myform">
		<input type="hidden" name="do_submit" value="1" />
		<?php if($result){foreach($result as $val){?>
		<tr>
		  <td width="9%" align="center"><input type="checkbox" name="id[]" value="<?php echo $val['id'];?>" class="checkbox" /></td>
		  <td width="40%" align="center"><a href="space/index.php?id=<?php echo $val['id'];?>" target="_blank"><?php echo $val['name'];?></a></td>
		  <td width="20%" align="center"><?php echo date('Y-m-d H:i:s',$val['opentime']);?></td>
			<td width="15%" align="center"><?php echo !$val['syslock']?'正常 <a href="'.ADMIN_FILE.'?mod=space&file=space&action=lock&lock=1&id='.$val['id'].'"><u>关闭</u></a>':'关闭 <a href="'.ADMIN_FILE.'?mod=space&file=space&action=lock&lock=0&id='.$val['id'].'"><u>开通</u></a>';?> </td>
			<td width="16%" align="center"><?php echo $val['index']?'推荐 <a href="'.ADMIN_FILE.'?mod=space&file=space&action=index&index=0&id='.$val['id'].'"><u>普通</u></a>':'普通 <a href="'.ADMIN_FILE.'?mod=space&file=space&action=index&index=1&id='.$val['id'].'"><u>推荐</u></a>';?> </td>
		</tr>
		<?php }?>
		<tr>
			<td align="center"><input type="checkbox" name="chkall2" value="1" class="checkbox" onclick="check_all(this)" /></td>
			<td colspan="4">
			<input type="button" onclick="this.form.action='?mod=space&file=space&action=unlock';this.form.submit();" class="submit" value="开通空间" />
			<input type="button" onclick="this.form.action='?mod=space&file=space&action=lock';this.form.submit();" class="submit" value="关闭空间" />
			</td>
		</tr>
		</form>
		<?php }else{?>
		<tr><td colspan="5">目前尚未开通任何空间...</td></tr>	
		<?php }?>
		<tr><td colspan="5"><?php echo $space->pagestring;?></td></tr>
		</table>
	</div>
</div>
</body>
</html>
