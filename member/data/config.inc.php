<?php
	define('REGISTER_ENABLED', '1'); //是否开放注册，只对前台有效
	define('AUDIT_TYPE', '2'); //会员注册方式
	define('DETAILS_NEEDED', '1'); //必须完善详细资料才能发布信息
	define('ACTIVELINKTIME', 24); ///激活链接有效期
	define('REG_CHECKCODE_ENABLED', '1'); //会员注册是否使用验证码
	define('LOGIN_CHECKCODE_ENABLED', '1'); //会员登录是否使用验证码
	define('SAME_EMAIL_ENABLED', '1'); //允许同一邮箱注册
	define('SAME_IP_ENABLED', '1'); //允许同一IP注册
	define('IS_FORBIDDEN_AREA', '0'); //用户注册、登陆地区限制
	define('FORBIDDEN_AREA', '327'); //用户注册、登陆地区限制
	define('FORBIDDEN_NAME', ''); //禁止注册会员名
	define('INVITIONAL', 0); //邀请注册
	define('TOPPOINT', 5); //推荐加亮一篇信息扣除点数
	define('AMOUNTTOPOINT', 0.1);//AMOUNTTOPOINT
	define('UPGRADEMETHOD', 'amount'); //会员升级方式
	define('QQAPI', 1); //是否开放QQ一键登录
	define('QQAPIID', '100254711');//QQ一键登录应用ID
	define('QQAPPKEY', 'af6a0a85275b610020318c6330c26dd0'); //QQ一键登录应用KEY
?>
