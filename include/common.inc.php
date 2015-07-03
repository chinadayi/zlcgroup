<?php
/**
	 common公用文件
*/
error_reporting (E_ALL & ~E_NOTICE & ~E_WARNING);

define('RETENG_ROOT', str_replace("\\", '/', substr(dirname(__FILE__), 0, -7)));
define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());

if(PHP_VERSION < '5.3')
{
	set_magic_quotes_runtime(0);
}
else
{
	ini_set('magic_quotes_runtime',0);
}
unset($LANG, $HTTP_ENV_VARS, $HTTP_POST_VARS, $HTTP_GET_VARS, $HTTP_POST_FILES, $HTTP_COOKIE_VARS,$baselang);

include_once(RETENG_ROOT.'data/config.inc.php');
header("Content-type:text/html;charset=utf-8");
date_default_timezone_set('Etc/GMT-'.TIMEDF);
define('TIME',time());

/*
	Zip优化
*/
if(GZIP && extension_loaded('zlib') && function_exists('ob_gzhandler') && function_exists('ob_start'))
{
	ob_start('ob_gzhandler');
}
else
{
	ob_start();
}

include_once('global.func.php');
include_once('extends.func.php');
define('IP',getIp());
define('IPADDRESS',ip2area(IP));
define('CURURL',getcururl());
$lang=cache_read('lang.inc.php',RETENG_ROOT.'data/lang/'.LANG.'/');

/*
	数据库
*/
include_once('mysql.class.php');
$db=new mysql();
$db->connect(DB_HOST,DB_USER,DB_PSW,DB_NAME,DB_PCONNECT,DB_CHARSET);

/*
	站群
*/
if(defined('RETENGCMS_FLAG'))
{
	$siteid=get_cookie('adminsiteid') && intval(get_cookie('adminsiteid'))?intval(get_cookie('adminsiteid')):1;
}
else
{
	$siteid=isset($_GET['siteid']) && intval($_GET['siteid'])?intval($_GET['siteid']):(get_cookie('siteid') && intval(get_cookie('siteid'))?intval(get_cookie('siteid')):1);
}

include_once('sitecrowd.class.php');
$sitecrowdobj=new sitecrowd();
$reteng_allcrowd=$allcrowd=$sitecrowdobj->allcrowd();
$childsite=$sitecrowdobj->sitecrowdinfo($siteid);
define('SITEID',$childsite?$siteid:1);
if(!$childsite)
{
	$childsite=$sitecrowdobj->sitecrowdinfo(1);
}

define('SITEDIR',$childsite['site_dir']);
set_cookie('siteid',SITEID);
$baselangdir=SITEDIR?SITEDIR:'zh-cn';
$baselangfile=RETENG_ROOT.'data/lang/'.$baselangdir.'/baselang.inc.php';
$baselangfile=file_exists($baselangfile)?$baselangfile:RETENG_ROOT.'data/lang/zh-cn/baselang.inc.php';
include $baselangfile;

/*
	FTP
*/
include_once('ftp.class.php');

if(FTP && FTP_SERVER && FTP_USER && FTP_PWD)
{
	$ftpobj = new ftp();
	$ftpobj->connect(FTP_SERVER,FTP_USER,FTP_PWD,FTP_PORT,FTP_TIMEOUT,SSL,PASV);
}

/*
	SESSION
*/
include_once('session_'.SESSION_STORAGE.'.class.php');
$session=new session();

/*
	缓存类
*/
include_once('cache_'.CACHE_STORAGE.'.class.php');
$cache=new cache();

/*
	上传类
*/
include_once('upload.class.php');
$upload=new upload();

include_once(RETENG_ROOT.'data/common.cache.php');

/*
	获取自定义变量
*/

$r=$db->fetch_all("SELECT * FROM `".DB_PRE."config` WHERE `".DB_PRE."config`.`siteid`=".intval(SITEID));

if($r)
{
	foreach($r as $_r)
	{
		$RETENG[$_r['varname']]=$_r['value'];
		if($_r['system'] && $_r['groupid']==1 && !defined(strtoupper($_r['varname'])))
		{
			define(strtoupper($_r['varname']),$_r['value']);
		}
	}
}
$RETENG['tlp_path']=RETENG_PATH.'template/'.TPL_NAME.'/';
$RETENG['tlp_name']=TPL_NAME;
$RETENG['retengcms_path']=RETENG_PATH;
$RETENG['site_id']=SITEID;
$RETENG['site_dir']=SITEDIR;
//define('TLP_NAME',TPL_NAME);

if(!defined(TLP_NAME))
{
	define('TLP_NAME',TPL_NAME);
}

if($_REQUEST)
{
	foreach($_REQUEST as $key => $value)
	{
		if(isset($$key))
		{
			unset($_REQUEST[$key]);
		}
	}

	if(MAGIC_QUOTES_GPC)
	{
		$_REQUEST = retengcms_stripslashes($_REQUEST);
		if($_COOKIE) $_COOKIE = retengcms_stripslashes($_COOKIE);
	}
	else
	{
		$_POST = retengcms_addslashes($_POST);
		$_GET = retengcms_addslashes($_GET);
		$_COOKIE = retengcms_addslashes($_COOKIE);
		extract($_POST,EXTR_SKIP);
		extract($_GET,EXTR_SKIP);
		extract($_COOKIE,EXTR_SKIP);
	}
	extract($db->escape($_REQUEST),EXTR_SKIP);
	if($_COOKIE) $db->escape($_COOKIE);
}

/*
	模块对象
*/
include_once('module.class.php');
$module=new module();

$_userid=0;
$_username='游客/Tourist';
$_groupid=2;
$_gradeid=10;
$_roleid=0;
$_areaid=intval(get_cookie('areaid'));
$_areaid=$_areaid?$_areaid:CITY;

/*
	$install 变量: 判断模块是否安装的数组
*/
$install=array();
$modules=$module->module_list();
if($modules)
{
	foreach($modules as $mods)
	{
		$parse_file=RETENG_ROOT.$mods['folder'].'/include/template.func.php';
		if(file_exists($parse_file))
		{
			include_once $parse_file;
		}

		if(!$module->module_disabled($mods['folder']))
		{
			$install[$mods['folder']]=true;
		}
		else
		{
			$install[$mods['folder']]=false;
		}
	}
}
$_userid=0;

if($install['member']) // 检查是否安装了会员模块
{
	include_once(RETENG_ROOT.'member/data/config.inc.php');
	include_once(RETENG_ROOT.'member/api/templateinfo.func.php');
	$_username=$baselang['tourist'];
	$_groupid=2;
	$_gradeid=10;
	$_level=0;
	$_expire=0;
	$_facephoto='member/images/nophoto.gif';
	$retengcms_auth=get_cookie('auth');
	if($retengcms_auth)
	{
		$auth_key=md5(AUTH_KEY.$_SERVER['HTTP_USER_AGENT']);
		list($_userid,$_password)=explode("\t", retengcms_auth($retengcms_auth, 'DECODE', $auth_key));
		$_userid=intval($_userid);
		$sql_cache_member="SELECT * FROM `".DB_PRE."member_cache` WHERE `id`=$_userid";
		$sql_member="SELECT * FROM `".DB_PRE."member` WHERE `id`=$_userid";
		$r = $db->fetch_one($sql_cache_member);

		if(!$r)
		{
			$r=$db->fetch_one($sql_member);
		}

		if($r && $r['password']===$_password)
		{
			if($r['groupid']==3 || $r['level']==0)
			{
				set_cookie('auth', '');
				showmsg($lang['MEMBER_LOGIN_ERR-1']);
			}
			extract($r,EXTR_PREFIX_ALL,'');
			$_message=max(0,$_message);
		}
		else
		{
			$_userid=0;
			$_username='';
			$_groupid=2;
			set_cookie('auth','');
		}
		unset($r,$retengcms_auth,$retengcms_auth_key,$_password,$sql_member);
	}
}

/*
	插件
*/
require RETENG_ROOT.'include/admin/plugins.class.php';
$plugins=new plugins();

$T=array();
?>