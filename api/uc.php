<?php
/********************************************************************
 *                        UC整合通信文件
 *                        -------------------
 *
 *   $Id: member.class.php,v 1.0.0 2010-11-20 M Exp $
 ********************************************************************/
include substr(dirname(__FILE__),0,-4).'/member/include/common.inc.php';

define('UC_VERSION', '1.5.0');		//UCenter 版本标识
define('API_DELETEUSER', 1);		//用户删除 API 接口开关
define('API_RENAMEUSER', 1);		//用户改名 API 接口开关
define('API_UPDATEPW', 1);		//用户改密码 API 接口开关
define('API_GETTAG', 1);		//获取标签 API 接口开关
define('API_SYNLOGIN', 1);		//同步登录 API 接口开关
define('API_SYNLOGOUT', 1);		//同步登出 API 接口开关
define('API_UPDATEBADWORDS', 1);	//更新关键字列表 开关
define('API_UPDATEHOSTS', 1);		//更新域名解析缓存 开关
define('API_UPDATEAPPS', 1);		//更新应用列表 开关
define('API_UPDATECLIENT', 1);		//更新客户端缓存 开关
define('API_UPDATECREDIT', 1);		//更新用户积分 开关
define('API_GETCREDITSETTINGS', 1);	//向 UCenter 提供积分设置 开关
define('API_UPDATECREDITSETTINGS', 1);	//更新应用积分设置 开关

define('API_RETURN_SUCCEED', '1');
define('API_RETURN_FAILED', '-1');
define('API_RETURN_FORBIDDEN', '-2');

if(!UC)  exit('Ucenter client disabled !');
require substr(dirname(__FILE__),0,-4).'/member/uc_client/client.php';

parse_str(uc_authcode($code, 'DECODE', UC_KEY), $arr) ;

if(TIME - intval($arr['time']) > 3600) 	exit('Authracation has expiried');
if(empty($arr)) exit('Invalid Request');

$action = $arr['action'];
if ($action=='test') 	exit(API_RETURN_SUCCEED);

if ($action=='deleteuser')
{
	$uids = $arr['ids'];
	!API_DELETEUSER && exit(API_RETURN_FORBIDDEN);
	$db->query("DELETE FROM `".DB_NAME."`.`".DB_PRE."member` WHERE `".DB_NAME."`.`".DB_PRE."member`.`touserid` IN($uids)");
	$db->query("DELETE FROM `".DB_NAME."`.`".DB_PRE."member_cache` WHERE `".DB_NAME."`.`".DB_PRE."member_cache`.`touserid` IN($uids)");
	exit(API_RETURN_SUCCEED);
}
if($action=='updatepw')
{
	!API_UPDATEPW && exit(API_RETURN_FORBIDDEN);
	exit(API_RETURN_SUCCEED);
}

if($action == 'synlogin')
{
	$userid = $member->get_userid($arr['username']);
	$userinfo = $member->get($userid);
	if(!$userinfo){
		$uc_userinfo=uc_call('uc_get_user',array($arr['username'],0));
		if($uc_userinfo[0]>0){
			$arr_member['touserid'] = $uc_userinfo[0];
			$arr_member['username'] = $uc_userinfo[1];
			$arr_member['password'] = PWD($password) ;
			$arr_member['email'] = $uc_userinfo[2];
			$arr_member['modelid'] = 1;
			$arr_member['logintime']=$arr_memberinfo['regtime']=TIME; 
			$arr_member['loginip']=IP;
			$arr_member['expire']='';
			$arr_member['groupid']=AUDIT_TYPE==1?4:3; //设置用户组
			$arr_member['level']=AUDIT_TYPE==1?1:0; //设置用户组
			$arr_member['gradeid']=10;
			$arr_member['areaid']=CITY;
			$userid=$member->add($arr_member);
			$userid = $member->get_userid($arr['username']);
			$userinfo = $member->get($userid);
		}
	}
	if(!$userinfo){exit(0);}
	extract($userinfo);
	if(!$cookietime) $get_cookietime = 86400 * 365;
	$_cookietime = $cookietime ? intval($cookietime) : ($get_cookietime ? $get_cookietime : 0);
	$cookietime = $_cookietime ? TIME + $_cookietime : 0;
	$retengcms_auth_key = md5(AUTH_KEY.$_SERVER['HTTP_USER_AGENT']);
	$retengcms_auth = retengcms_auth($userid."\t".$password, 'ENCODE', $retengcms_auth_key);
    ob_clean() ;
    header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
	set_cookie('auth', $retengcms_auth, $cookietime);
	set_cookie('cookietime', $_cookietime, $cookietime);
	exit('1');
}

if($action=='updatecredit')
{
	$arr_credit = array(
        1 => '`point`',
        2 => '`amount`',
	);
	$credit = $arr['credit'];
	$creditField = $arr_credit[$credit];
	$amount=intval($arr['amount']);
	$uid = intval($arr['uid']);
	$userinfo = $member->get_by_touserid($uid);
	$username = $userinfo['username'];
	if(!$username || !$amount)  exit(API_RETURN_SUCCEED);
	$db->query("update `".DB_NAME."`.`".DB_PRE."member` set $creditField=$creditField+$amount where username='$username' ");
	$db->query("update `".DB_NAME."`.`".DB_PRE."member_cache` set $creditField=$creditField+$amount where username='$username' ");
	exit('1');
}

if($action=='synlogout')
{
	header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
	set_cookie('auth', '');
	set_cookie('cookietime', '');
}

if($action == 'getcreditsettings') 
{
	!API_GETCREDITSETTINGS && exit(API_RETURN_FORBIDDEN);
	$credits = array(
        1 => array('点数', '点'),
        2 => array('金钱', '元'),
	);
	echo uc_serialize($credits);
}

if($action == 'updateapps') 
{
	if(!API_UPDATEAPPS) {
		return API_RETURN_FORBIDDEN;
	}
	include_once substr(dirname(__FILE__),0,-4).'/member/uc_client/lib/xml.class.php';
	$post = xml_unserialize(file_get_contents('php://input'));

	$cachefile = substr(dirname(__FILE__),0,-4).'/member/uc_client/data/cache/apps.php';
	$fp = fopen($cachefile, 'w');
	$s = "<?php\r\n";
	$s .= '$_CACHE[\'apps\'] = '.var_export($post, TRUE).";\r\n";
	fwrite($fp, $s);
	fclose($fp);
	exit(API_RETURN_SUCCEED);
}

if($action == 'updatecreditsettings') {

	!API_UPDATECREDITSETTINGS && exit(API_RETURN_FORBIDDEN);
	$outextcredits = array();
	foreach($arr['credit'] as $appid => $credititems) {
		if($appid == UC_APPID) {
			foreach($credititems as $value) {
				$outextcredits[$value['appiddesc'].'|'.$value['creditdesc']] = array(
					'creditsrc' => $value['creditsrc'],
					'title' => $value['title'],
					'unit' => $value['unit'],
					'ratio' => $value['ratio']
				);
			}
		}
	}
	cache_write('creditsettings.php', $outextcredits);
	exit('1');
}
?>
