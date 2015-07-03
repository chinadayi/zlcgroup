<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('member',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
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
		以下配置针对前台会员注册、登陆等操作有效!
		</fieldset>
	<form action="" method="post" name="myform">		
	<input type="hidden" name="do_submit" value="1" /> 
		<table width="100%">
		<tr><td>
			<table class="sub">
				<tr>
					<td width="245"  align="right">是否开放新用户注册： </td>
					<td width="650">
					<input type="radio" class="radio" name="info[register_enabled]" value="1" <?php echo REGISTER_ENABLED==1?' checked="checked"':'';?>/>启用  
					<input type="radio" class="radio" name="info[register_enabled]" value="0" <?php echo REGISTER_ENABLED==0?' checked="checked"':'';?>/>关闭
				  </td>
				</tr>
				<tr>
					<td width="245"  align="right">注册认证方式： </td>
					<td>
					<input type="radio" class="radio" name="info[audit_type]" value="1" <?php echo AUDIT_TYPE==1?' checked="checked"':'';?>/>直接通过
					<input type="radio" class="radio" name="info[audit_type]" value="2" <?php echo AUDIT_TYPE==2?' checked="checked"':'';?>/>后台审核
					<input type="radio" class="radio" name="info[audit_type]" value="3" <?php echo AUDIT_TYPE==3?' checked="checked"':'';?>/>邮箱认证
					<input type="radio" class="radio" name="info[audit_type]" value="4" <?php echo AUDIT_TYPE==4?' checked="checked"':'';?>/>短信认证
					</td>
				</tr>
				<tr>
					<td width="245"  align="right">认证邮件：</td>
					<td>
					<textarea name="audit_email" rows="5" cols="60"><?php echo htmlspecialchars(stripslashes(file_get_contents(RETENG_ROOT.'member/template/audit_email.html')));?></textarea>
					</td>
				</tr>
				<tr>
					<td width="245"  align="right">认证短信：</td>
					<td>
					<textarea name="audit_sms" rows="5" cols="60"><?php echo htmlspecialchars(stripslashes(file_get_contents(RETENG_ROOT.'member/template/audit_sms.html')));?></textarea>
					</td>
				</tr>
				<tr>
					<td width="245"  align="right">激活链接有效期：</td>
					<td>
					<input type="text" name="info[activelinktime]" datatype="number" value="<?php echo ACTIVELINKTIME;?>" size="4" /> 小时
					</td>
				</tr>
				<tr>
					<td width="245"  align="right">同一邮箱是否可以多次注册： </td>
					<td>
					<input type="radio" class="radio" name="info[same_email_enabled]" value="1" <?php echo SAME_EMAIL_ENABLED==1?' checked="checked"':'';?>/>允许 
					<input type="radio" class="radio" name="info[same_email_enabled]" value="0" <?php echo SAME_EMAIL_ENABLED==0?' checked="checked"':'';?>/>禁止
					</td>
				</tr>
				<tr>
					<td width="245"  align="right">同IP当天是否可以多次注册： </td>
					<td>
					<input type="radio" class="radio" name="info[same_ip_enabled]" value="1" <?php echo SAME_IP_ENABLED==1?' checked="checked"':'';?>/>允许  
					<input type="radio" class="radio" name="info[same_ip_enabled]" value="0" <?php echo SAME_IP_ENABLED==0?' checked="checked"':'';?>/>禁止
					
					</td>
				</tr>
				<tr>
					<td width="245"  align="right">用户注册、登陆地区限制： </td>
					<td>
					<input type="radio" class="radio" <?php echo !is_file(RETENG_ROOT.'include/dict/ipdata.dat')?'disabled="disabled"':'';?> onclick="$('#forbidden_area_tr').show();" name="info[is_forbidden_area]" value="1" <?php echo IS_FORBIDDEN_AREA==1?' checked="checked"':'';?>/>开启  
					<input type="radio" class="radio" onclick="$('#forbidden_area_tr').hide();" name="info[is_forbidden_area]" value="0" <?php echo IS_FORBIDDEN_AREA==0 || !is_file(RETENG_ROOT.'include/dict/ipdata.dat')?' checked="checked"':'';?> />关闭 
					<?php echo !is_file(RETENG_ROOT.'include/dict/ipdata.dat')?'<font color="#ff0000">提示：纯真IP库不存在，<a href="http://cms.reteng.org/" target="_blank">点此获取</a> 纯真IP数据库并上传到 /include/dict/下!</font>':'';?>
					</td>
				</tr>
				<tr style="display:<?php echo IS_FORBIDDEN_AREA==0 || !is_file(RETENG_ROOT.'include/dict/ipdata.dat')?'none':'block';?>" id="forbidden_area_tr">
					<td width="245"  align="right">用户注册、登陆限制地区：</td>
					<td>
					<?php echo js_selectmenu('area','forbidden_area','info',FORBIDDEN_AREA);?>
					<span style="color:#FF0000">您当前IP的地址：<?php echo ip2area(IP);?></span>
					</td>
				</tr>
				<tr>
					<td width="245"  align="right">注册是否启用验证码： </td>
					<td>
					<input type="radio" class="radio" name="info[reg_checkcode_enabled]" value="1" <?php echo REG_CHECKCODE_ENABLED==1?' checked="checked"':'';?>/>启用
					<input type="radio" class="radio" name="info[reg_checkcode_enabled]" value="0" <?php echo REG_CHECKCODE_ENABLED==0?' checked="checked"':'';?>/>关闭
					</td>
				</tr>
				<tr>
					<td width="245"  align="right">登录是否启用验证码： </td>
					<td>
			<input type="radio" class="radio" name="info[login_checkcode_enabled]" value="1" <?php echo LOGIN_CHECKCODE_ENABLED==1?' checked="checked"':'';?>/>启用  
			<input type="radio" class="radio" name="info[login_checkcode_enabled]" value="0" <?php echo LOGIN_CHECKCODE_ENABLED==0?' checked="checked"':'';?>/>关闭
					</td>
				</tr>
				<tr>
					<td width="245"  align="right">是否开启邀请注册：</td>
					<td>
					<input type="text" name="info[invitional]" value="<?php echo INVITIONAL;?>" size="4" /> 点
					<span>0为关闭邀请注册</span>
					</td>
				</tr>
				<tr>
					<td width="245"  align="right">推荐加亮一篇信息扣除点数： </td>
					<td>
					<input type="text" name="info[toppoint]" value="<?php echo TOPPOINT;?>" size="4" /> 点
					</td>
				</tr>
				<tr>
					<td width="245"  align="right">会员升级方式： </td>
					<td>
					<input type="radio" class="radio" name="info[upgrademethod]" value="amount"<?php echo UPGRADEMETHOD=='amount'?' checked="checked"':'';?> />扣除资金
					<input type="radio" class="radio" name="info[upgrademethod]" value="point" <?php echo UPGRADEMETHOD=='point'?' checked="checked"':'';?> />扣除积分
					</td>
				</tr>
				<tr>
					<td width="245"  align="right">每个点数花费的价格(元)： </td>
					<td>
					<input type="text" name="info[amounttopoint]" value="<?php echo AMOUNTTOPOINT;?>" size="4" /> 元/点
					</td>
				</tr>
				<?php if($_userid==ADMIN_FOUNDERS){?>
				<tr>
					<td width="245"  align="right">注册用户名保留关键字：</td>
					<td>
					<textarea name="info[forbidden_name]" cols="50" rows="5"><?php echo FORBIDDEN_NAME;?></textarea>
					<span> 每个会员名用 |  分割开</span>
					</td>
				</tr>
				<?php }?>
				<tr>
					<td width="245"  align="right">必须完善详细资料才能发布信息： </td>
					<td>
					<input type="radio" class="radio" name="info[details_needed]" value="1" <?php echo DETAILS_NEEDED==1?' checked="checked"':'';?>/>允许 
					<input type="radio" class="radio" name="info[details_needed]" value="0" <?php echo DETAILS_NEEDED==0?' checked="checked"':'';?>/>禁止
					</td>
				</tr>
				<tr>
					<td width="245"  align="right">是否开启QQ同步登陆： </td>
					<td>
					<input type="radio" class="radio" name="info[qqapi]" value="1"<?php echo QQAPI?' checked="checked"':'';?> />开启
					<input type="radio" class="radio" name="info[qqapi]" value="0" <?php echo !QQAPI?' checked="checked"':'';?> />关闭
					</td>
				</tr>
				<tr>
					<td width="245"  align="right">QQ应用的APPID： </td>
					<td>
					<input type="text" name="info[qqapiid]" value="<?php echo QQAPIID;?>" size="12" />
					</td>
				</tr>
				<tr>
					<td width="245"  align="right">QQ应用的APPKEY： </td>
					<td>
					<input type="text" name="info[qqappkey]" value="<?php echo QQAPPKEY;?>" size="36" />
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
