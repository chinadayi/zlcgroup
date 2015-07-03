<?php
	include('../../include/common.inc.php');
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
	
	switch($action)
	{
		case 'list_image':
			$i=1;
			if(!$userid)
			{
				if(isset($dir)&&$dir)$dir=str_replace('\\','/',$dir);
			}
			else
			{
				$dir=(isset($dir)&&$dir)?$dir:retengcms_md5($userid).'/';
			}
			
			$dir=substr($dir,0,16)==retengcms_md5($userid)?$dir:retengcms_md5($userid).''.$dir;
			$dir=str_replace('//','/',str_replace('\\','/',$dir));

			if(FTP && FTP_SERVER && FTP_USER && FTP_PWD)
			{
				$back='<li><a href="?action=list_image&objid='.$objid.'"><img src="'.RETENG_PATH.'images/dir.jpg" /><br />/</a></li>';
				$realdir=isset($dir)&&$dir?FTP_DIR.'/'.$dir:FTP_DIR;
				$list=$ftpobj->nlist($realdir);
				$parentdir=isset($dir)&&$dir?trim($dir).'/':'';
				$parentdir=str_replace('//','/',$parentdir);
			}
			else
			{
				if(!$userid)
				{
					$back=isset($dir)&&$dir?'<li><a href="?action=list_image&objid='.$objid.'"><img src="'.RETENG_PATH.'images/dir.jpg" /><br />根目录</a></li>':'';
				}
				else
				{
					$back=(!isset($dir)||($dir!=retengcms_md5($userid).'/'))?'<li><a href="?action=list_image&objid='.$objid.'"><img src="'.RETENG_PATH.'images/dir.jpg" /><br />根目录</a></li>':'';
				}

				if(!$userid)
				{
					$realdir=isset($dir)&&$dir?RETENG_ROOT.'data/attached/'.$dir:RETENG_ROOT.'data/attached/';
				}
				else
				{
					$realdir=isset($dir)&&$dir?RETENG_ROOT.'data/attached/'.$dir:RETENG_ROOT.'data/attached/'.md5($userid).'/';
				}

				$list=glob($realdir.'*');
				$parentdir=isset($dir)&&$dir?trim($dir).'/':'';
				$parentdir=str_replace('//','/',$parentdir);
			}
			echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>浏览服务器</title>
<style type="text/css">
body,input{font-family: "Microsoft YaHei","宋体",Verdana, Arial, Helvetica, sans-serif;font-size:12px; padding:0px}
a{text-decoration:none; color:#000000; font-size:12px}
a:active{blr:expression(this.onFocus=this.blur())}
a:focus {
	outline:none;
	-moz-outline:none;
}
form{padding:0px; margin:0px}
.listdiv{width:450px; margin:5px auto; clear:both; overflow:hidden;font-size:12px; margin-top:0px}
.listdiv ul{width:450px; clear:both; margin:0px auto; padding:0px; list-style:none; overflow:hidden}
.listdiv ul li{width:80px; height:85px; float:left; margin:2px 4px; text-align:center; line-height:20px; font-size:12px; overflow:hidden}
.listdiv ul li img{border:#ccc 1px solid; padding:2px; width:74px; height:55px}
</style>
<script type="text/javascript" src="'.RETENG_PATH.'images/js/jquery.min.js"></script>
<script language="javascript">
function setPic(objid,value,imgid)
{
	$("img").css({border:"#cccccc 1px solid"});
	$("#"+imgid).css({border:"#ff3300 1px solid"});
	$(window.parent.document).find("form[@name=\'myform\'] #"+objid).val(value);
}
</script>
</head>
<body style="magin:0px; padding:0px">
<div class="listdiv">

<form action="?action=upload_image" enctype="multipart/form-data" method="post" name="postform">
<input type="hidden" value="'.$objid.'" name="objid" />
上传图片: <input type="file" name="file" onchange="this.form.submit();" />
<input type="submit" value="开始上传" />
加水印: <input type="checkbox" name="watermark" value="1" style="border:0px" />
</form>
<br />
<ul>'.$back;
			foreach($list as $files)
			{
				if(FTP && FTP_SERVER && FTP_USER && FTP_PWD)
				{
					if(is_image($files) || !get_fileext($files))
					{
						echo !get_fileext($files)?'<li><a href="?action=list_image&objid='.$objid.'&dir='.$parentdir.basename($files).'/"><img src="'.RETENG_PATH.'images/dir.jpg" /><br />'.sub_string(basename($files),10,'...').'</a></li>':'<li><a href="javascript:setPic(\''.$objid.'\',\''.FTP_URL.'/'.$dir.$files.'\',\'img_'.$i.'\');"><img src="'.FTP_URL.'/'.$dir.$files.'" id="img_'.$i.'" /><br />'.sub_string(basename($files),10,'...').'</a></li>';
						$i++;
					}
				}
				else
				{
					if(is_image($files) || is_dir($files))
					{
						echo is_dir($files)?'<li><a href="?action=list_image&objid='.$objid.'&dir='.$parentdir.basename($files).'/"><img src="'.RETENG_PATH.'images/dir.jpg" /><br />'.sub_string(basename($files),10,'...').'</a></li>':'<li><a href="javascript:setPic(\''.$objid.'\',\'data/attached/'.$parentdir.basename($files).'\',\'img_'.$i.'\');"><img src="'.RETENG_PATH.'data/attached/'.$parentdir.basename($files).'" id="img_'.$i.'" /><br />'.sub_string(basename($files),10,'...').'</a></li>';
						$i++;
					}
				}
			}	
			echo '</ul>
</div>
</body>
</html>';
			exit();
			break;
		case 'list_vedio':
			$i=1;
			if(!$userid)
			{
				if(isset($dir)&&$dir)$dir=str_replace('\\','/',$dir);
			}
			else
			{
				$dir=(isset($dir)&&$dir)?$dir:retengcms_md5($userid).'/';
			}
			
			$dir=substr($dir,0,16)==retengcms_md5($userid)?$dir:retengcms_md5($userid).''.$dir;
			$dir=str_replace('//','/',str_replace('\\','/',$dir));

			if(FTP && FTP_SERVER && FTP_USER && FTP_PWD)
			{
				$back='<li><a href="?action=list_vedio&objid='.$objid.'"><img src="'.RETENG_PATH.'images/dir.jpg" /><br />根目录</a></li>';
				$realdir=isset($dir)&&$dir?FTP_DIR.'/'.$dir:FTP_DIR;
				$list=$ftpobj->nlist($realdir);
				$parentdir=isset($dir)&&$dir?trim($dir).'/':'';
				$parentdir=str_replace('//','/',$parentdir);
			}
			else
			{
				if(!$userid)
				{
					$back=isset($dir)&&$dir?'<li><a href="?action=list_vedio&objid='.$objid.'"><img src="'.RETENG_PATH.'images/dir.jpg" /><br />根目录</a></li>':'';
				}
				else
				{
					$back=(!isset($dir)||($dir!=retengcms_md5($userid).'/'))?'<li><a href="?action=list_vedio&objid='.$objid.'"><img src="'.RETENG_PATH.'images/dir.jpg" /><br />/</a></li>':'';
				}

				if(!$userid)
				{
					$realdir=isset($dir)&&$dir?RETENG_ROOT.'upload/media/'.$dir:RETENG_ROOT.'upload/media/';
				}
				else
				{
					$realdir=isset($dir)&&$dir?RETENG_ROOT.'upload/media/'.$dir:RETENG_ROOT.'upload/media/'.md5($userid).'/';
				}

				$list=glob($realdir.'*');
				$parentdir=isset($dir)&&$dir?trim($dir).'/':'';
				$parentdir=str_replace('//','/',$parentdir);
			}
			echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>浏览服务器</title>
<style type="text/css">
body,input{font-family: "Microsoft YaHei","宋体",Verdana, Arial, Helvetica, sans-serif;font-size:12px; padding:0px}
a{text-decoration:none; color:#000000; font-size:12px}
a:active{blr:expression(this.onFocus=this.blur())}
a:focus {
	outline:none;
	-moz-outline:none;
}
form{padding:0px; margin:0px}
.listdiv{width:450px; margin:5px auto; clear:both; overflow:hidden;font-size:12px; margin-top:0px}
.listdiv ul{width:450px; clear:both; margin:0px auto; padding:0px; list-style:none; overflow:hidden}
.listdiv ul li{width:80px; height:85px; float:left; margin:2px 4px; text-align:center; line-height:20px; font-size:12px; overflow:hidden}
.listdiv ul li img{border:#ccc 1px solid; padding:2px; width:74px; height:55px}
</style>
<script type="text/javascript" src="'.RETENG_PATH.'images/js/jquery.min.js"></script>
<script language="javascript">
function setVedio(objid,value,imgid)
{
	$("img").css({border:"#cccccc 1px solid"});
	$("#"+imgid).css({border:"#ff3300 1px solid"});
	$(window.parent.document).find("form[@name=\'myform\'] #"+objid).val(value);
}
</script>
</head>
<body style="magin:0px; padding:0px">
<div class="listdiv">

<form action="?action=upload_video" enctype="multipart/form-data" method="post" name="postform">
<input type="hidden" value="'.$objid.'" name="objid" />
上传媒体文件: <input type="file" name="file" onchange="this.form.submit();" />
<input type="submit" value="开始上传" />
</form>
<br />
<ul>'.$back;
			foreach($list as $files)
			{
				if(FTP && FTP_SERVER && FTP_USER && FTP_PWD)
				{
					if(in_array(get_fileext($files),array('swf','flv','mp3','rm','wav','avi','mpg','mpeg')) || !get_fileext($files))
					{
						echo !get_fileext($files)?'<li><a href="?action=list_vedio&objid='.$objid.'&dir='.$parentdir.basename($files).'/"><img src="'.RETENG_PATH.'images/dir.jpg" /><br />'.sub_string(basename($files),10,'...').'</a></li>':'<li><a href="javascript:setVedio(\''.$objid.'\',\''.FTP_URL.'/'.$dir.$files.'\',\'img_'.$i.'\');"><img src="'.RETENG_PATH.'images/ext/'.get_fileext($files).'.png" id="img_'.$i.'" /><br />'.sub_string(basename($files),10,'...').'</a></li>';
						$i++;
					}
				}
				else
				{
					if(get_fileext($files)!='db' || is_dir($files))
					{
						echo is_dir($files)?'<li><a href="?action=list_vedio&objid='.$objid.'&dir='.$parentdir.basename($files).'/"><img src="'.RETENG_PATH.'images/dir.jpg" /><br />'.sub_string(basename($files),10,'...').'</a></li>':'<li><a href="javascript:setVedio(\''.$objid.'\',\'upload/media/'.$parentdir.basename($files).'\',\'img_'.$i.'\');"><img src="'.RETENG_PATH.'images/ext/'.get_fileext($files).'.png" id="img_'.$i.'" /><br />'.sub_string(basename($files),10,'...').'</a></li>';
					}
				}
			}	
			echo '</ul>
</div>
</body>
</html>';
			exit();
			break;
		case 'upload_image':
			if(!$userid)
			{
				$dir=date('Y-m-d',TIME);		
			}
			else
			{
				$dir=retengcms_md5($userid).'/'.date('Y-m-d',TIME);
				@mkdir(RETENG_ROOT.'data/attached/'.retengcms_md5($userid).'/');
			}

			@mkdir(RETENG_ROOT.'data/attached/'.$dir.'/');
			$file='data/attached/'.$dir.'/'.$upload->uploadfile('file',RETENG_ROOT.'data/attached/'.$dir.'/','',array('jpg','jpeg','gif','png','bmp'));
			if(isset($watermark) && $watermark)
			{
				include RETENG_ROOT.'include/image.class.php';
				$image=new image();
				$image->watermark(RETENG_ROOT.$file,WATERMARK_POS,WATERMARK_FILE,WATERMARK_PCT,WATERMARK_WORDS,5,WATERMARK_COLOR);
			}
			if(FTP && FTP_SERVER && FTP_USER && FTP_PWD)
			{
				$remotedir=FTP_DIR.'/'.$dir.'/';
				if($ftpobj->ftp_mkdir($remotedir))
				{
					$result=$ftpobj->ftp_upload($remotedir.basename($file),RETENG_ROOT.$file);
				}
				$ftpobj->ftp_close();
				@unlink(RETENG_ROOT.$file);
			}
			if($result)
			{
				$file=FTP_URL.'/'.$dir.'/'.basename($file);
			}
			exit('<script type="text/javascript" src="'.RETENG_PATH.'images/js/jquery.min.js"></script>
<script language="javascript">
function setPic(objid,value)
{
	$(window.parent.document).find("form[@name=\'myform\'] #"+objid).val(value);
}
</script><script language="javascript">eval("javascript:setPic(\''.$objid.'\',\''.$file.'\');alert(\'上传成功!\');");</script>');
			break;
		case 'upload_video':
			if(!$userid)
			{
				$dir='/file/'.date('Ymd',TIME);		
			}
			else
			{
				$dir=retengcms_md5($userid).'/file/'.date('Ymd',TIME);
				@mkdir(RETENG_ROOT.'data/attached/'.retengcms_md5($userid).'/file/');
			}
			@mkdir(RETENG_ROOT.'data/attached/'.$dir.'/');
			$file=RETENG_PATH.'data/attached/'.$dir.'/'.$upload->uploadfile('file',RETENG_ROOT.'data/attached/'.$dir.'/','',array('flv','swf','mp3','rm','wav','avi','mpg','mpeg'));
			$result=false;
			if(FTP && FTP_SERVER && FTP_USER && FTP_PWD)
			{
				$remotedir=FTP_DIR.'/'.$dir.'/';
				if($ftpobj->ftp_mkdir($remotedir))
				{
					$result=$ftpobj->ftp_upload($remotedir.basename($file),RETENG_ROOT.$file);
				}
				$ftpobj->ftp_close();
				@unlink(RETENG_ROOT.$file);
			}
			if($result)
			{
				$file=FTP_URL.'/'.$dir.'/'.basename($file);
			}
			exit('<script type="text/javascript" src="'.RETENG_PATH.'images/js/jquery.min.js"></script>
<script language="javascript">
function setPic(objid,value)
{
	$(window.parent.document).find("form[@name=\'myform\'] #"+objid).val(value);
}
</script><script language="javascript">eval("javascript:setPic(\''.$objid.'\',\''.$file.'\');alert(\'上传成功!\');");</script>');
			break;
		default:
			exit('Access Denied!');
			break;
	}
?>
