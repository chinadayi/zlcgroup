<?php
include('../../include/common.inc.php');
session_start();
!$_userid && (!isset($_SESSION['admin_id']) || !$_SESSION['admin_id']) && exit('浏览权限不足!');
if($_userid)
	{
		$userid=$_userid;
	}
	
	if(isset($_SESSION['admin_id']) && $_SESSION['admin_id'])
	{
		$userid=$_SESSION['admin_id'];
	}
$userpath=retengcms_md5($userid).'/image';   //已经不使用。2014-08-16

//文件保存目录路径
$savedir='uploads/image';
$save_path = RETENG_ROOT. 'uploads/image';
//文件保存目录URL
$save_url =  RETENG_PATH.'uploads/image';	


return array(

    //图片上传允许的存储目录
    'imageSavePath' => array (
       $save_url
    )

);
