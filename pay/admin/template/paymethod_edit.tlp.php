<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('pay',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>支付方式管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script src="images/js/check.func.js"></script>
<script language="javascript" src="admin/template/js/css.js"></script>
<script language="javascript" type="text/javascript">
	$(document).ready(function(){
		checkForm(0);
	});
</script>
</head>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="?mod=pay&file=pay&action=paymethod">支付方式</a></li>
			<li><a href="javascript:void(0);" class="on">详细配置</a></li>			
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend>操作提示</legend>
		在线支付的具体参数配置请详细仔细提供商。
	</fieldset>
	<form action="" method="post" name="myform">
	<input type="hidden" name="do_submit" value="1" />
	<input type="hidden" name="id" value="<?php echo $info['id'];?>" />
	<table cellspacing="0" class="sub">
		<tr>
			<td width="120" align="right">支付方式名称：</td>
			<td>
				<input type="text" name="info[name]" size="25" value="<?php echo $info['name'];?>" datatype="limit"  min="2" max="80" />
			</td>
		</tr>
		<tr>
			<td align="right">支付手续费用：</td>
			<td>
			<input type="text" name="info[fee]" datatype="double" value="<?php echo $info['orderby'];?>" size="4" /> 元
			</td>
		</tr>
		<tr>
			<td align="right">支付方式排序：</td>
			<td>
			<input type="text" name="info[orderby]" datatype="number" value="<?php echo $info['orderby'];?>" size="4" />
			</td>
		</tr>
		<tr>
			<td align="right">支付方式描述：</td>
			<td>
			<textarea name="info[desc]" datatype="limit" min="0" max="255" cols="50" rows="5"><?php echo $info['desc'];?></textarea>
			</td>
		</tr>
		<?php if($info['code']=='alipay'){?>
		<tr>
			<td align="right">支付宝帐户：</td>
			<td>
			<input type="text" name="config[alipay_account]" value="<?php echo $info['config']['alipay_account'];?>" datatype="limit"  min="0" max="80" />
			</td>
		</tr>
		<tr>
			<td align="right">交易安全校验码：</td>
			<td>
			<input type="text" name="config[alipay_key]" value="<?php echo $info['config']['alipay_key'];?>" datatype="limit" size="40"  min="0" max="80" />
			</td>
		</tr>
		<tr>
			<td align="right">合作者身份ID：</td>
			<td>
			<input type="text" name="config[alipay_partner]" value="<?php echo $info['config']['alipay_partner'];?>" datatype="limit"  min="0" max="80" />
			</td>
		</tr>
		<tr>
			<td align="right">支付接口类型：</td>
			<td>
			<select name="config[service_type]">
				<option value="0"  <?php echo $info['config']['service_type']==0?'selected="selected"':'';?>  >纯担保交易接口</option>
				<option value="1"  <?php echo $info['config']['service_type']==1?'selected="selected"':'';?>>标准实物双接口</option>
				<option value="2"  <?php echo $info['config']['service_type']==2?'selected="selected"':'';?>>即时到账接口</option>
			</select>
			</td>
		</tr>
		<?php }?>
		<tr class="bg2"><td></td><td><input type="button" class="button" onclick="doSubmit(this);" value="确定配置" /> <input type="button" class="button" onclick="window.location.href='<?php echo ADMIN_FILE;?>?mod=pay&file=pay&action=paymethod'" value="取消返回" /></td></tr>
	</table>
	</form>

	</div>
</div>
</body>
</html>
