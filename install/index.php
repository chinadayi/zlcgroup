<?php
/**
	* 安装程序 
	* @version		v1.0
	* @copyright	(C) 2014 热腾内容管理系统]
	* @lastmodify	2014-07-17
*/

define('RETENG_INSTALL',true);
//屏蔽脚本运行错误信息
//error_reporting (E_ALL & ~E_NOTICE & ~E_WARNING);
//设置运行环境
set_time_limit(0);
if(PHP_VERSION <'5.0')
{
	set_magic_quotes_runtime(0);
	exit('PHP版本过低，无法安装ReTengCMS!');
}
else
{
	ini_set('magic_quotes_runtime',0);
}
header("Content-type:text/html;charset=utf-8");

//设置根目录并检查是否重复安装
define('RETENG_ROOT',substr(dirname(__FILE__),0,-7));
if(file_exists(RETENG_ROOT.'data/retengcms.lock'))
{
	exit('您已经安装过ReTengCMS,如果需要重新安装, 请删除 ./data/retengcms.lock 文件!');
}

//引入安装程序运行所必需的文件
include(RETENG_ROOT.'data/config.inc.php');
include(RETENG_ROOT.'data/version.php');
include(RETENG_ROOT.'include/global.func.php');
include(RETENG_ROOT.'include/mysql.class.php');
include(RETENG_ROOT.'include/admin/global.func.php');


extract($_REQUEST);
$step=isset($step)?$step:1;
switch($step)
{
	case '2':
		//GD库检测
		if(function_exists('gd_info') && extension_loaded('gd'))
		{
			$gd_version = gd_info();
			$gd_version = preg_replace('/[^0-9.]/','',$gd_version['GD Version']);
		} 
		else 
		{
			$gd_version = 0; 
		}

		//所需函数检测
		$func_items = array('mysql_connect','file_get_contents','eval' ,'file_put_contents');

		//文件夹检测
		$folder_items = array(
				'data/',
				'data/config.inc.php',
				'data/common.cache.php',
				'data/version.php',
				'data/bakup/',
				'data/c/',
				'data/cache/',
				'data/cache_admin/',
				'data/cache_category/',
				'data/cache_module/',
				'data/cache_plugins/',
				'data/cache_stepselect/',
				'data/cache_template/',
				'data/sessions/',
				'data/tmp/',
				'html/'
		);
		if(file_exists(RETENG_ROOT.'member/') && file_exists(RETENG_ROOT.'member/include/member.class.php'))
		{
			$folder_items[]='member/data/';
		}

		$cantsubmit=0;

		if(PHP_VERSION < '5.0' || round($gd_version)< 2)
		{
			$cantsubmit=1;
		}
		break;
	case '4':
		$PHP_SELF=isset($_SERVER['PHP_SELF'])?$_SERVER['PHP_SELF']:(isset($_SERVER['SCRIPT_NAME'])?$_SERVER['SCRIPT_NAME']:$_SERVER['ORIG_PATH_INFO']);
		$retengcms_path=str_replace("\\","/",dirname($PHP_SELF));
		$retengcms_path=substr($retengcms_path,0,-8);
		$retengcms_path=strlen($retengcms_path)>1?$retengcms_path."/" : "/";

		/*
			定义数据库操作对象
		*/
		$db=new mysql();
		$db->connect($config['db_host'],$config['db_user'],$config['db_psw'],$config['db_name'],$config['db_pconnect'],'utf8');
		$sqlfile=$withdata && file_exists(RETENG_ROOT.'install/data/data.sql')?RETENG_ROOT.'install/data/data.sql':RETENG_ROOT.'install/data/nodata.sql';
		
		if(!file_exists($sqlfile))
		{
			exit('数据库安装文件丢失, 请重新下载ReTengCMS安装包! <a href="http://www.reteng.org/">http://www.reteng.org/</a>');
		}
		
		//获取当前域名(页面访问)地址
		$domain=getServerName().$retengcms_path;

		//获取SQL内容
		$sqls=str_replace('#install_websiteurl#',$domain,file_get_contents($sqlfile));
		$sqls=explode(";\n",trim($sqls));

		$timenow=time();
		//添加创始人账号
		$admin=array();
		$admin['username']=$username;
		$admin['password']= md5(md5($password_key).$password_key.md5(trim($password)));
		$admin['ip']=getIp();
		$admin['logintime']=$timenow;
		$admin['allowmultilogin']=1;
		$admin['disabled']=0;
		$admin['roleid']=1;
		
		if(file_exists(RETENG_ROOT.'member/') && file_exists(RETENG_ROOT.'member/include/member.class.php'))
		{
			//添加会员
			$member=array();
			$member['username']=$username;
			$member['password']= md5(md5($password_key).$password_key.md5(trim($password)));
			$member['level']=1;
			$member['expire']=0;
			$member['email']=$email;
			$member['loginip']=getIp();
			$member['regtime']=$member['logintime']=$timenow;
			$member['facephoto']='member/images/nophoto.gif';
			//$member['areaid']=CITY;
			$member['gradeid']=10;
			$member['groupid']=1;
			$member['modelid']=1;
		}

		//添加默认站点
		$sitecrowd=array();
		$sitecrowd['id']=1;
		$sitecrowd['site_name']='默认站点';
		$sitecrowd['site_url']=getServerName().$retengcms_path;
		$sitecrowd['site_dir']='/';
		$sitecrowd['issueid']='';
		$sitecrowd['tlp_name']='default';
		$sitecrowd['seo_title']='网站副标题';
		$sitecrowd['seo_description']='网站关键字';
		$sitecrowd['seo_keywords']='网站描述';
		$sitecrowd['system']=1;

		//配置文件
		$config['retengcms_path']=$retengcms_path;
		$config['password_key']=$password_key;
		$config['cookie_pre']=getrandstr();
		$config['auth_key']=getrandstr();
		$config['site_url']=getServerName().$retengcms_path;

		include(RETENG_ROOT.'data/common.cache.php');
		foreach($RETENG as $key=>$value)
		{
			if(!isset($config[$key]))$config[$key]=$value;
		}

		break;
	case '5':
		include(RETENG_ROOT.'include/common.inc.php');
		//网站缓存
		require RETENG_ROOT.'/include/c.class.php';
		$c= new c();
		if($c->cache_all());

		file_put_contents(RETENG_ROOT.'data/retengcms.lock',mt_rand(999999,1000000));
		break;
	case 'checkdb':
			if(!@mysql_connect($dbhost, $dbuser, $dbpw))
			{
				exit('2');
			}
			$server_info = mysql_get_server_info();
			if($server_info < '5.0') exit('6');
			if(!mysql_select_db($dbname))
			{
				if(!@mysql_query("CREATE DATABASE `$dbname`")) exit('3');
				mysql_select_db($dbname);
			}
			$tables = array();
			$db=new mysql();
			$db->connect($dbhost, $dbuser, $dbpw,$dbname,$tablepre,'utf8');
			$tables = $db->get_tables($dbname);

			if($tables && in_array($tablepre.'admin', $tables))
			{
				exit('0');
			}
			else
			{
				exit('1');
			}
			
			break;
}
include('template/step'.$step.'.tlp.php');
//定义安装所需函数
function check_iswriteable($path)
{
	if(!file_exists(RETENG_ROOT.$path))
	{
		return false;
	}

	if(is_dir(RETENG_ROOT.$path))
	{
		if(file_put_contents(RETENG_ROOT.$path.'install.test','ok'))
		{
			if(unlink(RETENG_ROOT.$path.'install.test'))
			{
				mkdir(RETENG_ROOT.$path.'test/');
				return rmdir(RETENG_ROOT.$path.'test/');
			}
			return false;
		}
	}
	else
	{
		$f = @fopen(RETENG_ROOT.$path,'a');
		if($f===false)
		{
			return false;
		}
		fclose($f);
		return true;
	}
	return false;
}

function jsmessage($msg) 
{
	echo '<script type="text/javascript">showmessage(\''.addslashes($msg).'\');</script>'."\r\n";
}

function getServerName() 
{
	$port=$_SERVER["SERVER_PORT"]=='80'?'':':'.$_SERVER["SERVER_PORT"];
	$ServerName = strtolower($_SERVER['SERVER_NAME']?$_SERVER['SERVER_NAME']:$_SERVER['HTTP_HOST']); 
	if(strpos($ServerName,'http://'))
	{   
		$ServerName=str_replace('http://','',$ServerName);
	}  
	return strpos($ServerName,':')?'http://'.$ServerName:'http://'.$ServerName.$port;
}

function getrandstr($strlen=10)
{
	$code='';
	$str='abcdefghkmnopqrstuvwyzABCDEFGHKLMNOPQRSTUVWYZ1234567890';
	$len=strlen($str)-1;
	for($i=0;$i<$strlen;$i++)
	{
		$code.=$str[mt_rand(0,$len)];
	}
	return $code;
}
?>