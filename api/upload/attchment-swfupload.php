<?php
	error_reporting (E_ALL & ~E_NOTICE & ~E_WARNING);
	// 获取文件拓展名 
	function get_fileext($file)
	{
		return strtolower(substr(strrchr($file,'.'),1));
	}

	if (isset($_POST["PHPSESSID"])) {
		session_id($_POST["PHPSESSID"]);
	}

	define('RETENG_ROOT', str_replace("\\", '/',substr(dirname(__FILE__),0,-10)));

	session_start();


	// check file
	if (!isset($_FILES["Filedata"]) || !is_uploaded_file($_FILES["Filedata"]["tmp_name"]) || $_FILES["Filedata"]["error"] != 0 || !in_array(get_fileext($_FILES["Filedata"]["name"]),array('rar','zip','gz','doc','docx','xls','txt','xlsx','pdf'))) 
	{
		echo "ERROR:invalid upload";
		exit(0);
	}	

	$fileName = time().mt_rand(1000,9999).'.'.get_fileext($_FILES["Filedata"]["name"]);
	move_uploaded_file($_FILES["Filedata"]["tmp_name"], RETENG_ROOT."data/attached/" . $fileName);

	echo $fileName ;
	exit(0);
?>
