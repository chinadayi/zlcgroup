<?php
	function get_fileext($file)
	{
		return strtolower(substr(strrchr($file,'.'),1));
	}

	// 判断是否为图片，仅判断后缀
	function is_image($file)
	{
		return in_array(get_fileext($file),array('gif','jpg','jpeg','png','bmp'));
	}

	if (isset($_POST["PHPSESSID"])) {
		session_id($_POST["PHPSESSID"]);
	}
	
	session_start();

	$image_id = isset($_GET["id"]) ? preg_replace('/[^a-z0-9:\.\/\\\\-]/i','',$_GET["id"]) : false;
	$image_id=str_replace('..','',$image_id);
	if(!is_image($image_id) || !$image_id)
	{
		header("Content-type: image/jpeg") ;
		header("Content-length: " . filesize("../../images/nopic.gif"));
		flush();
		readfile("../../images/nopic.gif");
		exit(0);
	}
	if ($image_id === false) 
	{
		header("HTTP/1.1 500 Internal Server Error");
		echo "No ID";
		exit(0);
	}

	/*if (substr($image_id,0,7)!='http://' && !file_exists($image_id)) 
	{
		header("HTTP/1.1 404 Not found");
		exit(0);
	}

	if(substr($image_id,0,7)!='http://')
	{
		header("Content-type: image/jpeg") ;
		header("Content-length: " . filesize($image_id));
		flush();
		readfile( $image_id);
	}
	else
	{
		header('location:'.$image_id);
	}*/
	header('location:'.$image_id);
	exit(0);
?>

