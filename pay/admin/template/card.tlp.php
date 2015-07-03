<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('pay',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>点卡管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script type="text/javascript" src="admin/template/js/admin.js"></script>
<script language="javascript" src="admin/template/js/css.js"></script>
<script language="javascript" type="text/javascript">
$(document).ready(function(){
	$("#enabled").val('<?php echo isset($enabled)?$enabled:1;?>');
});
</script>
</head>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="javascript:void(0);" class="on">点卡管理</a></li>
			<li><a href="?mod=pay&file=pay&action=card_add">生成点卡</a></li>			
		</ul>
	</div>
	<div class="main">
		<div class="search">
			<form action="" method="get" name="search">
			<input type="hidden" name="mod" value="<?php echo $mod;?>"> 
			<input type="hidden" name="file" value="<?php echo $file;?>"> 
			<input type="hidden" name="action" value="<?php echo $action;?>"> 
				<fieldset>
					<legend>查找点卡</legend>
						搜索条件：
						<select name="enabled" id="enabled">
							<option value="1" selected="selected">未使用</option>
							<option value="2">已使用</option>
						</select>
						&nbsp;&nbsp;
						卡号：
						<input type="text" name="k" size="35" value="<?php echo $k?htmlspecialchars(stripslashes($k)):'';?>" />
						<input type="submit" class="button" value="开始查找" />
				</fieldset>
			</form>
		</div>
		<table cellspacing="0" class="datalist" id="list" width="98%">
		<tr>
			<th width="5%" class="firstcol">选择</th>
			<th width="21%">卡号</th>
			<th width="8%">类型</th>
            <th width="8%">价格</th> 
			<th width="8%">包含钱数</th>
            <th width="11%">使用有效期</th>
			<th width="10%">生成者</th>
			<th width="10%">使用者</th>
			<th width="11%">生成IP</th>
			<th width="8%">状态</th>
		</tr>
		<form action="" method="post" name="myform">
		<input type="hidden" name="do_submit" value="1" />
		<?php if($result){foreach($result as $val){?>
		<tr>
			<td align="center"><input type="checkbox" class="checkbox" name="id[]" value="<?php echo $val['id'];?>" /></td>
			<td align="center" style="padding-left:5px"><?php echo $val['cardid'];?></td>
			<td align="center"><?php echo $val['type'];?></td>
			<td align="center"><?php echo $val['price'];?> 元</td>
			<td align="center"><?php echo $val['amount'];?> 元</td>
			<td align="center"><?php echo date('Y-m-d',$val['expire']);?></td>
			<td align="center"><?php echo $val['inputer'];?></td>
			<td align="center"><?php echo $val['username'];?></td>
			<td align="center"><?php echo $val['ip'];?></td>
			<td align="center" style="padding:5px"><?php if($val['expire']<TIME){echo '<font color="#FF3300">已失效</font>';}else{echo $val['status']==1?'未使用':($val['status']==3?'<font color="#FF3300">已失效</font>':'<font color="#999999">已使用</font>');}?></td>
		</tr>
		<?php }?>
		<tr>
			<td width="5%" align="center">
			<input type="checkbox" name="chkall2" value="1" class="checkbox" onclick="check_all(this)" />
		  </td>
			<td colspan="9">
			<input type="button" onclick="this.form.submit();" class="submit" value="删除点卡" />
			</td>
		</tr>
		</form>
		<?php }else{?>
		<tr><td colspan="10">目前尚未生成任何点卡...</td></tr>	
		<?php }?>
		<tr>
			<td colspan="10"><?php echo $pay->pagestring;?></td>
		</tr>
		</table>
	</div>
</div>
</body>
</html>
