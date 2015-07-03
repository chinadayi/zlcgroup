<?php
/**
* 中国短信网PHP HTTP接口 发送短信
* @copyright	(C) 2009-2012 中国短信网
* @lastmodify	2012-05-27 17:03

* 使用方法
	$mobile	 = '13912341234,13312341234,13512341234,02122334444';	//号码
	$content = '中国短信网PHP HTTP接口';		//内容
	//即时发送
	$res = sendSMS($mobile,$content);

	//定时发送
	$time = '2010-05-27 12:11';
	$res = sendSMS($mobile,$content,$time);
*/
class sms
{
	public $msg=array();

	function sms()
	{
		$this->__construct();
	}

	function __construct()
    {
		global $baselang;
		$this->msg=array(
							'100'=>$baselang['sms-status-100'],
							'101'=>$baselang['sms-status-101'],
							'102'=>$baselang['sms-status-102'],
							'103'=>$baselang['sms-status-103'],
							'104'=>$baselang['sms-status-104'],
							'105'=>$baselang['sms-status-105'],
							'106'=>$baselang['sms-status-106'],
							'107'=>$baselang['sms-status-107'],
							'108'=>$baselang['sms-status-108'],
							'109'=>$baselang['sms-status-109'],
							'110'=>$baselang['sms-status-110'],
							'111'=>$baselang['sms-status-111'],
							'112'=>$baselang['sms-status-112'],
							'120'=>$baselang['sms-status-120']
						);
	}

	function sendSMS($mobile,$content,$time='',$mid='')
	{
		$http = 'http://http.c123.com/tx/';
		$data = array
			(
				'uid'=>PHONE_USERNAME,
				'pwd'=>strtolower(md5(PHONE_PWD)),
				'mobile'=>$mobile,				//号码
				'content'=>$content,			//内容
				'time'=>'2010-05-27 12:11',		//定时发送
				'mid'=>$mid						//子扩展号
			);
		return trim($this->postSMS($http,$data));
	}

	function postSMS($url,$data='')
	{
		$row = parse_url($url);
		$host = $row['host'];
		$port = $row['port'] ? $row['port']:80;
		$file = $row['path'];
		while (list($k,$v) = each($data)) 
		{
			$post .= rawurlencode($k)."=".rawurlencode($v)."&";	//转URL标准码
		}
		$post = substr( $post , 0 , -1 );
		$len = strlen($post);
		$fp = @fsockopen( $host ,$port, $errno, $errstr, 10);
		if (!$fp) 
		{
			return "$errstr ($errno)\n";
		} 
		else 
		{
			$receive = '';
			$out = "POST $file HTTP/1.1\r\n";
			$out .= "Host: $host\r\n";
			$out .= "Content-type: application/x-www-form-urlencoded\r\n";
			$out .= "Connection: Close\r\n";
			$out .= "Content-Length: $len\r\n\r\n";
			$out .= $post;		
			fwrite($fp, $out);
			while (!feof($fp)) 
			{
				$receive .= fgets($fp, 128);
			}
			fclose($fp);
			$receive = explode("\r\n\r\n",$receive);
			unset($receive[0]);
			return implode("",$receive);
		}
	}
}
?>