<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('pay',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>充值记录</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script type="text/javascript" src="admin/template/js/admin.js"></script>
<script language="javascript" src="admin/template/js/css.js"></script>
<script language="javascript" type="text/javascript">
$(document).ready(function(){
	$("#field").val('<?php echo isset($field)?$field:'username';?>');
	$("#status").val('<?php echo isset($status)?$status:0;?>');
});
</script>
</head>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="javascript:void(0);" class="on">充值记录</a></li>		
		</ul>
	</div>
	<div class="main">
		<div class="search">
			<form action="?" method="get" name="search">
			<input type="hidden" name="mod" value="<?php echo $mod;?>"> 
			<input type="hidden" name="file" value="<?php echo $file;?>"> 
			<input type="hidden" name="action" value="<?php echo $action;?>"> 
				<fieldset>
					<legend>记录查找</legend>
						搜索条件：
						<select name="field" id="field">
							<option value="username">会员名</option>
							<option value="sn">支付号</option>
						</select>
						&nbsp;
						<select name="status" id="status">
							<option value=1>未到款</option>
							<option value=2>已到款</option>
						</select>
						&nbsp;&nbsp;
						关键字：
						<input type="text" name="k" size="35" value="<?php echo isset($k)?htmlspecialchars(stripslashes($k)):'';?>" />
						<input type="submit" class="button" value="开始查找" />
				</fieldset>
			</form>
		</div>
		<table cellspacing="0" class="datalist" id="list" width="98%">
		<tr>		
			<th width="5%" class="firstcol">选中</th>
			<th width="9%">会员名称</th>
			<th width="17%">支付号</th>
            <th width="10%">金额/点数</th> 
			<th width="9%">支付方式</th>
			<th width="6%">对象</th>
            <th width="6%">操作</th>
			<th width="20%">发生时间</th>
			<th width="11%">发生IP</th>
			<th width="7%">状态</th>
		</tr>
		<form action="" method="post" name="myform">
		<input type="hidden" name="do_submit" value="1" />
		<?php if($result){foreach($result as $val){?>
		<tr title="<?php echo strip_tags($val['note']);?>">
			<td align="center"><input type="checkbox" checked="checked" name="id[]" value="<?php echo $val['id'];?>" /></td>
            <td align="center" style="padding-left:5px"><?php echo $val['username'];?></td>
            <td align="center"><?php echo $val['sn'];?></td>
            <td align="center"><?php echo $val['amount'];?><?php echo $val['type']=='point'?'点':'元';?></td>
			<td align="center"><?php echo $val['payment'];?></td>
			<td align="center"><?php echo $val['type']=='point'?'点数':'金钱';?></td>
			<td align="center"><?php echo $val['manage']?'收入':'支出';?></td>
			<td align="center"><?php echo date('Y-m-d H:i:s',$val['time']);?></td>
            <td align="center"><?php echo $val['ip'];?></td>
            <td align="center"><?php echo $val['status']==2?'成功':'<font color="#ff0000">未完成</font>';?></span></td>
		</tr>
		<?php }?>
		<tr>
			<td width="5%" align="center">
		  <input type="checkbox" name="chkall2" value="1" checked="checked" class="checkbox" onclick="check_all(this)" /></td>
			<td colspan="9" align="left">
			<input type="button" onfocus="blur();" class="button" onclick="if(confirm('确实要删除所选充值记录?删除后不可恢复!')){this.form.submit();}"  value="删除记录" />
			</td>
		</tr>
		</form>
		<?php }else{?>
		<tr><td colspan="10">目前尚未发现充值记录...</td></tr>	
		<?php }?>
		<tr>
			<td colspan="10"><?php echo $pay->pagestring;?></td>
		</tr>
		</table>
	</div>
</div>
</body>
</html>
