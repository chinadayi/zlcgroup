<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('pay',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>订单查询</title>
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
			<li><a href="javascript:void(0);" class="on">订单查询</a></li>		
		</ul>
	</div>
	<div class="main">
		<div class="search">
			<form action="?" method="get" name="search">
			<input type="hidden" name="mod" value="<?php echo $mod;?>"> 
			<input type="hidden" name="file" value="<?php echo $file;?>"> 
			<input type="hidden" name="action" value="<?php echo $action;?>"> 
				<fieldset>
					<legend>订单查找</legend>
						搜索条件：
						<select name="field" id="field">
							<option value="buyuser">用户名</option>
							<option value="sn">订单号</option>
						</select>
						&nbsp;
						<select name="status" id="status">
							<option value=0>未付款</option>
							<option value=1>已付款</option>
							<option value=2>未发货</option>
							<option value=3>已发货</option>
							<option value=4>交易完成</option>
							<option value=99>取消交易</option>
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
			<th width="15%">订单号</th>
            <th width="17%">订购产品</th> 
			<th width="9%">订单金额</th>
			<th width="10%">支付方式</th>
			<th width="11%">用户名</th>
            <th width="9%">订单状态</th>
			<th width="11%">发生时间</th>
			<th width="8%">发生IP</th>
			<th width="5%">详细</th>
		</tr>
		<form action="" method="post" name="myform">
		<input type="hidden" name="do_submit" value="1" />
		<?php if($result){foreach($result as $val){?>
		<tr title="产品<?php echo strip_tags($val['product']);?>订单">
			<td align="center"><input type="checkbox" name="id[]" value="<?php echo $val['id'];?>" /></td>
            <td align="center" style="padding-left:5px"><a href="?mod=pay&file=pay&action=showorder&id=<?php echo $val['id'];?>"><?php echo $val['sn'];?></a></td>
            <td align="center"><?php echo $val['product']?$val['product']:'不祥';?></td>
            <td align="center"><?php echo $val['amount'];?>元</td>
			<td align="center"><?php echo $pay->paymentname($val['payment']);?></td>
			<td align="center"><?php echo $val['buyuser'];?></td>
			<td align="center">
			<select name="status[<?php echo $val['id'];?>]">
				<option value="0" <?php echo $val['status']==0?' selected="selected"':'';?>>未付款</option>
				<option value="1" <?php echo $val['status']==1?' selected="selected"':'';?>>已付款</option>
				<option value="2" <?php echo $val['status']==2?' selected="selected"':'';?>>未发货</option>
				<option value="3" <?php echo $val['status']==3?' selected="selected"':'';?>>已发货</option>
				<option value="4" <?php echo $val['status']==4?' selected="selected"':'';?>>交易完成</option>
				<option value="99" <?php echo $val['status']==99?' selected="selected"':'';?>>取消交易</option>
			</select>
			</td>
			<td align="center"><?php echo date('Y-m-d H:i:s',$val['datetime']);?></td>
            <td align="center"><a href="http://www.ip38.com/index.php?ip=<?php echo $val['ip'];?>" title="查看IP地址" target="_blank"><?php echo $val['ip'];?></a></td>
            <td align="center"><a href="?mod=pay&file=pay&action=showorder&id=<?php echo $val['id'];?>">详情</a></span></td>
		</tr>
		<?php }?>
		<tr>
			<td width="5%" align="center">
		  <input type="checkbox" name="chkall2" value="1" class="checkbox" onclick="check_all(this)" /></td>
			<td colspan="9" align="left">
			<input type="button" class="button" onclick="if(confirm('确实要修改所选订单状态?')){this.form.action='<?php echo ADMIN_FILE;?>?mod=pay&file=pay&action=orderstatus';this.form.submit();}"  value="修改订单状态" />
			<input type="button" onfocus="blur();" class="button" onclick="if(confirm('确实要删除所选订单?删除后不可恢复!')){this.form.action='<?php echo ADMIN_FILE;?>?mod=pay&file=pay&action=order';this.form.submit();}"  value="删除订单" />
			</td>
		</tr>
		</form>
		<?php }else{?>
		<tr><td colspan="10">目前尚未发现订单记录...</td></tr>	
		<?php }?>
		<tr>
			<td colspan="10"><?php echo $pay->pagestring;?></td>
		</tr>
		</table>
	</div>
</div>
</body>
</html>
