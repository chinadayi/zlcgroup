<?php
/**
	Plugins Name:手机号码归属地查询插件UTF-8
	Plugins Description:手机号码归属地查询插件，模板调用方法 {telephoneaddress(手机号码)}
	Plugins Author:ReTengCMS官方
	Plugins Url:http://www.reteng.org
	Plugins Version:V1.523
**/
function telephoneaddress($phone,$code='GBK')
{
	global $baselang;
	$phone = trim($phone);

	if(!preg_match('/[0-9]{11}/i',$phone))
	{
		return $baselang['wrong-phone']; 
	}

	if(extension_loaded('curl'))
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://webservice.webxml.com.cn/WebServices/MobileCodeWS.asmx/getMobileCodeInfo');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "mobileCode=".$phone."&userId=");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$data = curl_exec($ch);
		curl_close($ch);
	}
	else
	{
		$data=file_get_contents('http://webservice.webxml.com.cn/WebServices/MobileCodeWS.asmx/getMobileCodeInfo?mobileCode='.$phone.'&userId=');
	}
	
	$data = simplexml_load_string($data);

	if (strpos($data, 'http://'))
	{ 
		return $baselang['nodata'];
	} 
	else 
	{ 
		$data=iconv('UTF-8',$code.'//IGNORE',trim($data));
		$data=explode(':',str_replace('：',':',$data));
		return isset($data[1]) && trim($data[1])?$data[1]:$baselang['nodata']; 
	}
}
?>
