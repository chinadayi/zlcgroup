<?php

	@set_time_limit(0);
	include('../../include/common.inc.php');
	error_reporting (E_ALL & ~E_NOTICE & ~E_WARNING);
	ini_set('html_errors', '0');

	//include RETENG_ROOT.'data/config.inc.php';

	if (isset($_POST["PHPSESSID"])) {
		session_id($_POST["PHPSESSID"]);
	}

	session_start();
	!$_userid && (!isset($_SESSION['admin_id']) || !$_SESSION['admin_id']) && exit('浏览权限不足!');
	$userid=0;
	if($_userid)
	{
		$userid=$_userid;
	}
	
	if(isset($_SESSION['admin_id']) && $_SESSION['admin_id'])
	{
		$userid=$_SESSION['admin_id'];
	}

	// Check the upload
	
	if (!isset($_FILES["Filedata"]) || !is_uploaded_file($_FILES["Filedata"]["tmp_name"]) || $_FILES["Filedata"]["error"] != 0) {
		echo "ERROR:invalid upload";
		exit(0);
	}

	// Check the upload
	if (!is_array(@getimagesize($_FILES["Filedata"]["tmp_name"])))
	{
		echo "ERROR:invalid upload";
		exit(0);
	}

	if (!isset($_SESSION["file_info"])) {
		$_SESSION["file_info"] = array();
	}
	
	$fileName = time().mt_rand(1000,9999) .'.jpg';
	//$path=date('Y-m-d',time()).'/';
	if($_userid){
			$userid=$_userid;
		}
		if(isset($_SESSION['admin_id']) && $_SESSION['admin_id'])
		{
			$userid=$_SESSION['admin_id'];
		}
		$userpath=retengcms_md5($userid).'/image/'.date('Ymd',TIME).'/';
		$save_path = RETENG_ROOT.'data/attached/'.$userpath;
		$save_url = RETENG_PATH.'data/attached/'.$userpath;
		
		if (!file_exists($save_path)) {
			@mkdir($save_path);
	}
	
	move_uploaded_file($_FILES["Filedata"]["tmp_name"], $save_path. $fileName);

	// 加水印

	if(WATERMARK_ENABLED)
	{
		include RETENG_ROOT.'include/image.class.php';
		$image=new image();
		$image->watermark($save_path.$fileName,WATERMARK_POS,WATERMARK_FILE,WATERMARK_PCT,WATERMARK_WORDS,5,WATERMARK_COLOR);
	}

	if(FTP && FTP_SERVER && FTP_USER && FTP_PWD)
	{
		include(RETENG_ROOT.'include/ftp.class.php');
		$ftpobj = new ftp(FTP_SERVER,FTP_USER,FTP_PWD,FTP_PORT,FTP_TIMEOUT,SSL,PASV);
		$rand=date('Ym',time());
		$remotedir=FTP_DIR.'/'.$rand.'/';
		if($ftpobj->ftp_mkdir($remotedir))
		{
			$result=$ftpobj->ftp_upload($remotedir.basename($fileName),$save_path.$fileName);
		}
		$ftpobj->ftp_close();
		@unlink($save_path.$fileName);
		echo "FILEID:" . FTP_URL.'/'.$rand.'/'.$fileName;
	}
	else
	{
		echo "FILEID:" . $save_url.$fileName;
	}
	exit(0);
?>
