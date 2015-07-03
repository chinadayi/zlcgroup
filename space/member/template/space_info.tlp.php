<?php
	!defined('MEMBER_CENTER') && exit('Access Denied!');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>会员中心</title>
<base href="<?php echo $RETENG['site_url'];?>" />
<link href="member/template/images/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="images/js/jquery.min.js" charset="utf-8"></script>
</head>
<body>
<div id="warp">
<?php include member_tlp('header');?>
<div class="container clearfix">
<?php include member_tlp('sidebar');?>

<div id="content">

<div class="tabs_header">
<ul class="tabs clearfix">
<li class="active"><a href="member/index.php?mod=space&file=space&action=info">空间设置</a></li>
</ul>
</div>
<div class="display">
<div class="tdline">
<form action="member/index.php?" method="post" name="myform">
<input type="hidden" name="do_submit" value="1" />
<input type="hidden" name="mod" value="<?php echo $mod;?>"> 
<input type="hidden" name="file" value="<?php echo $file;?>"> 
<input type="hidden" name="action" value="<?php echo $action;?>">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td width="19%" align="right">空间名称：</td>
		<td width="81%" align="left" valign="top" style="padding-left:10px">
		<input type="text" name="info[name]" value="<?php echo isset($info['name'])?$info['name']:'我的空间';?>" size="30" />
		</td>
	</tr>
	<tr>
		<td width="19%" align="right">空间LOGO：</td>
		<td width="81%" align="left" valign="top" style="padding-left:10px">
		<?php echo $form->image('logo',isset($info['logo'])?$info['logo']:$_facephoto);?>
		</td>
	</tr>
	<tr>
		<td width="19%" align="right">顶部Banner：</td>
		<td width="81%" align="left" valign="top" style="padding-left:10px">
		<?php echo $form->image('banner',isset($info['banner'])?$info['banner']:'');?>
		</td>
	</tr>
	<tr>
		<td width="19%" align="right">meta_keywords：</td>
		<td width="81%" align="left" valign="top" style="padding-left:10px">
		<input type="text" name="info[meta_keywords]" value="<?php echo isset($info['meta_keywords'])?$info['meta_keywords']:'';?>" size="30" />
		</td>
	</tr>
	<tr>
		<td width="19%" align="right">meta_description：</td>
		<td width="81%" align="left" valign="top" style="padding-left:10px">
		<textarea name="info[meta_description]" cols="50" rows="6"><?php echo isset($info['meta_description'])?$info['meta_description']:'';?></textarea>
		</td>
	</tr>
	
	<?php if($info){?>
	<tr>
		<td width="19%" align="right">空间状态：</td>
		<td width="81%" align="left" valign="top" style="padding-left:10px">
		<input type="radio" name="info[lock]" value="0" <?php echo isset($info['syslock']) && $info['syslock']?'disabled="disabled"':'';?> <?php echo isset($info['syslock']) &&!$info['lock'] && !$info['syslock']?' checked="checked"':'';?> />开通
		<input type="radio" name="info[lock]" value="1" <?php echo isset($info['syslock']) &&$info['syslock']?'disabled="disabled"':'';?> <?php echo isset($info['syslock']) &&$info['lock'] || $info['syslock']?' checked="checked"':'';?> />关闭
		
		<span style="color:#ff0000"><?php echo isset($info['syslock']) &&$info['syslock']?'您的空间由于违反空间协议已被管理员关闭!':'';?></span>
		</td>
	</tr>
	
	<?php }?>
	<tr><td align="center" colspan="2"><input type="submit"  <?php echo isset($info['syslock']) &&$info['syslock']?'disabled="disabled"':'';?> value="设 置" name="dosubmit" class="input_sub" />
		&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="清 除" name="doreset" class="input_sub" /></td></tr>&nbsp;&nbsp;&nbsp;&nbsp;
</table>
</form>
</div>
</div>
</div>


</div>
<?php include member_tlp('footer');?>
</div>
</body>
</html>
