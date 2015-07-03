<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('post',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>系统设置</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script src="images/js/jquery.min.js"></script>
<script language="javascript" src="admin/template/js/css.js"></script>
</head>
<body>
<div id="wrap">
	<div class="tab">
	<ul>
		<li><a href="javascript:void(0);" class="on">配置选项</a></li>
	</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		以下配置针对前台游客投稿操作有效!
		</fieldset>
	<form action="" method="post" name="myform">		
	<input type="hidden" name="do_submit" value="1" /> 
		<table width="100%">
		<tr><td>
			<table class="sub">
				<tr>
					<td width="245"  align="right">开放游客投稿： </td>
					<td width="650">
					<input type="radio" class="radio" name="info[post_enabled]" value="1" <?php echo POST_ENABLED==1?' checked="checked"':'';?>/>启用  
					<input type="radio" class="radio" name="info[post_enabled]" value="0" <?php echo POST_ENABLED==0?' checked="checked"':'';?>/>关闭
				  </td>
				</tr>
				<tr>
					<td width="245"  align="right">游客投稿地区限制： </td>
					<td>
					<input type="radio" class="radio" <?php echo !is_file(RETENG_ROOT.'include/dict/ipdata.dat')?'disabled="disabled"':'';?> onclick="$('#forbidden_area_tr').show();" name="info[post_is_forbidden_area]" value="1" <?php echo POST_IS_FORBIDDEN_AREA==1?' checked="checked"':'';?>/>开启  
					<input type="radio" class="radio" onclick="$('#forbidden_area_tr').hide();" name="info[post_is_forbidden_area]" value="0" <?php echo POST_IS_FORBIDDEN_AREA==0 || !is_file(RETENG_ROOT.'include/dict/ipdata.dat')?' checked="checked"':'';?> />关闭 
					<?php echo !is_file(RETENG_ROOT.'include/dict/ipdata.dat')?'<font color="#ff0000">提示：纯真IP库不存在，<a href="http://www.retengcms.com/download/ipdata.dat" target="_blank">点此获取</a> 纯真IP数据库并上传到 /include/dict/下!</font>':'';?>
					</td>
				</tr>
				<tr style="display:<?php echo POST_IS_FORBIDDEN_AREA==0 || !is_file(RETENG_ROOT.'include/dict/ipdata.dat')?'none':'block';?>" id="forbidden_area_tr">
					<td width="245"  align="right">游客投稿限制地区：</td>
					<td>
					<?php echo js_selectmenu('area','post_forbidden_area','info',POST_FORBIDDEN_AREA);?>
					<span style="color:#FF0000">您当前IP的地址：<?php echo ip2area(IP);?></span>
					</td>
				</tr>
				<tr>
					<td width="245"  align="right">投稿审核方式： </td>
					<td>
					<input type="radio" class="radio" name="info[post_verify_enabled]" value="0" <?php echo POST_VERIFY_ENABLED==0?' checked="checked"':'';?>/>直接通过
					<input type="radio" class="radio" name="info[post_verify_enabled]" value="1" <?php echo POST_VERIFY_ENABLED==1?' checked="checked"':'';?>/>后台审核
					</td>
				</tr>
				<tr>
					<td width="245"  align="right">开启验证码： </td>
					<td>
					<input type="radio" class="radio" name="info[post_checkcode_enabled]" value="1" <?php echo POST_CHECKCODE_ENABLED==1?' checked="checked"':'';?>/>启用 
					<input type="radio" class="radio" name="info[post_checkcode_enabled]" value="0" <?php echo POST_CHECKCODE_ENABLED==0?' checked="checked"':'';?>/>关闭
					</td>
				</tr>
				<tr>
					<td width="245"  align="right">开启验证问答： </td>
					<td>
					<input type="radio" class="radio" name="info[post_ask_enabled]" value="1" <?php echo POST_ASK_ENABLED==1?' checked="checked"':'';?>/>启用 
					<input type="radio" class="radio" name="info[post_ask_enabled]" value="0" <?php echo POST_ASK_ENABLED==0?' checked="checked"':'';?>/>关闭
					</td>
				</tr>	
				<tr>
					<td width="245"  align="right">验证回答问题：</td>
					<td>
					<textarea name="info[post_ask]" cols="40" rows="4"><?php echo POST_ASK;?></textarea>
					<span>多个问题用 | 隔开, 系统将随机选取一个问题</span>
					</td>
				</tr>
				<tr>
					<td width="245"  align="right">验证回答答案：</td>
					<td>
					<textarea name="info[post_answer]" cols="40" rows="4"><?php echo POST_ANSWER;?></textarea>
					<span>对应以上问题的答案, 每个答案用 | 隔开</span>
					</td>
				</tr>
				</table>		
			</td>
		</tr>
		<tr>
			<td colspan="2"><input type="button" onfocus="blur();" value="<?php echo $lang['SUBMIT_CONFIG_SAVE'];?>" class="button" onclick="this.form.submit();" style="margin-left:160px" /></td>
		</tr>
	</table>
	</form>
	</div>
</div>
</body>
</html>