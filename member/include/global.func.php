<?php
/**
	* 会员公共函数
*/

function is_username($username)
{
	return (in_array($username,explode('|',FORBIDDEN_NAME)) || !preg_match('/^[\x80-\xff_a-zA-Z0-9]{1,60}$/i',trim($username)))?false:true;
}


function is_pwd($str)
{
	if(!$str)return false;
	if(strlen(trim_str($str))>30)return false;
	return preg_match('/^[a-z0-9_]{3,30}$/i',trim_str($str));
}

function member_tlp($tlp,$mod='dc')
{
	$mod=preg_replace('/[^a-z]/i','',$mod);
	if($mod=='dc')
	{
		$tlpfile=RETENG_ROOT.'member/template/'.$tlp.'.tlp.php';
	}
	else
	{
		$tlpfile=RETENG_ROOT.$mod.'/member/template/'.$tlp.'.tlp.php';
	}
	!file_exists($tlpfile) && show404('模板文件'.$tlpfile.'不存在!');
	return $tlpfile;
}

function uc_call($func, $params=null)
{
    restore_error_handler();

    if (!function_exists($func))
    {
		include substr(dirname(__FILE__),0,-8).'/uc_client/client.php';
    }

    $res = call_user_func_array($func, $params);
    set_error_handler('exception_handler');

    return $res;
}

function uc_post($url, $limit = 0, $post = '', $cookie = '', $ip = '', $timeout = 15, $block = true)
{
	$return = '';
	$matches = parse_url($url);
	$host = $matches['host'];
	$path = $matches['path'] ? $matches['path'].($matches['query'] ? '?'.$matches['query'] : '') : '/';
	$port = !empty($matches['port']) ? $matches['port'] : 80;
	
	if($post) {
		$out = "POST $path HTTP/1.1\r\n";
		$out .= "Accept: */*\r\n";
		$out .= "Referer: ".SITE_URL."\r\n";
		$out .= "Accept-Language: zh-cn\r\n";
		$out .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
		$out .= "Host: $host\r\n" ;
		$out .= 'Content-Length: '.strlen($post)."\r\n" ;
		$out .= "Connection: Close\r\n" ;
		$out .= "Cache-Control: no-cache\r\n" ;
		$out .= "Cookie: $cookie\r\n\r\n" ;
		$out .= $post ;
	} else {
		$out = "GET $path HTTP/1.1\r\n";
		$out .= "Accept: */*\r\n";
		$out .= "Referer: ".SITE_URL."\r\n";
		$out .= "Accept-Language: zh-cn\r\n";
		$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
		$out .= "Host: $host\r\n";
		$out .= "Connection: Close\r\n";
		$out .= "Cookie: $cookie\r\n\r\n";
	}
	$fp = @fsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);
	if(!$fp) 	return '';
	
	stream_set_blocking($fp, $block);
	stream_set_timeout($fp, $timeout);
	@fwrite($fp, $out);
	$status = stream_get_meta_data($fp);
	
	if($status['timed_out']) return '';	
	while (!feof($fp))
	{
			if(($header = @fgets($fp)) && ($header == "\r\n" ||  $header == "\n"))  break;				
	}
	
	$stop = false;
	while(!feof($fp) && !$stop)
	{
		$data = fread($fp, ($limit == 0 || $limit > 8192 ? 8192 : $limit));
		$return .= $data;
		if($limit) 
		{
			$limit -= strlen($data);
			$stop = $limit <= 0;
		}
	}
	@fclose($fp);
	return $return;
}

/*
	QQ整合登陆
*/
function get_url_contents($url)
{
	if (ini_get("allow_url_fopen") == "1" && extension_loaded('open_ssl'))
	{
		return file_get_contents($url);
	}
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);   
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_URL, $url);
	$result =  curl_exec($ch);
	curl_close($ch);

	return $result;
}

function get_user_info($access_token,$app_id,$openid)
{
	$get_user_info = "https://graph.qq.com/user/get_user_info?"
	. "access_token=" . $access_token
	. "&oauth_consumer_key=" . $app_id
	. "&openid=" . $openid
	. "&format=json";

	$info = get_url_contents($get_user_info);
	$arr = json_decode($info, true);

	return $arr;
}

function jsondecode($data)
{
	if(function_exists('json_decode'))
	{
		return json_decode($data);
	}
	else
	{
		include_once dirname(__FILE__).'/json.class.php';
		$json = new Services_JSON();
		return $json->decode($data);
	}
}
?>
