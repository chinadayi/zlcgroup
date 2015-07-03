<?php
/**
* 上传文件 会进行mime安全检查
* 使用方法
* $upload= new upload();
* $file=$upload->uploadfile(表单名,路径,保存名称,允许的文件类型,允许的大小上限[字节]);
*/
set_time_limit(0);

class upload
{
	private $savepath; // 保存路径
	private $error; // 错误类型
	private $alowexts; //文件类型
	
	function __construct() // 进行mime类型等安全检查...
	{
		$allowmime=cache_read('mime.dict',RETENG_ROOT.'include/dict/');
		$this->alowexts=$allowtype=explode('|',strtolower(UPLOAD_FTYPE));
		$filekey = array('name', 'type', 'tmp_name', 'size');
		$imtypes = array
		(
			"image/pjpeg", "image/jpeg", "image/gif", "image/png", 
			"image/xpng", "image/wbmp", "image/bmp"
		);
		foreach($_FILES as $key => $value)
		{
			foreach($filekey as $k)
			{
				if(!isset($_FILES[$key][$k]))
				{
					$this->error=11;
					$this->error();
				}
			}
			$_file_name=$_FILES[$key]['name'];
			$_file_type=preg_replace('#[^0-9a-z\./]#i', '', $_FILES[$key]['type']);
			$_file_tmp_name=str_replace("\\\\", "\\", $_FILES[$key]['tmp_name']);
			
			if(!$this->isuploadedfile($_file_tmp_name))
			{
				$this->error=6;
				$this->error();
			}
			
			if(in_array(strtolower(trim($_file_type)), $imtypes))
			{
				if (!is_array(@getimagesize($_file_tmp_name)))
				{
					$this->error=11;
					$this->error();
				}
			}

			// 文件安全性检查..
			$fileext=get_fileext($_file_name);

			if(!in_array($fileext,$allowtype))
			{
				$this->error=10;
				$this->error();
			}
			$allowmime[$fileext]=is_array($allowmime[$fileext])?$allowmime[$fileext]:array($allowmime[$fileext]);
			if(!isset($allowmime[$fileext]) || ($_file_type!=$allowmime[$fileext] && !in_array($_file_type,$allowmime[$fileext])))
			{
				$this->error=11;
				//$this->error();
			}		
		}
	}
	
	function upload()
	{
		$this->__construct();
	}

	public function uploadfile($inputname='file', $savepath = 'data/attached/', $savename = '', $alowexts = array(),$maxsize = 1024000) // 返回文件名称
	{
		$this->alowexts = $alowexts;

		// 设置文件名
		$fileext=strtolower(get_fileext($_FILES[$inputname]['name']));

		// 检查文件类型
		if(!in_array($fileext,$alowexts))
		{
			$this->error=10;
			$this->error();
		}

		$savename=$savename?$savename:time().mt_rand(10000,99999);
		$savename=$savename.'.'.$fileext;

		// 检查文件大小
		$maxsize=min($maxsize,intval(UPLOAD_SIZE));
		$_file_size=preg_replace('#[^0-9]#','',$_FILES[$inputname]['size']);
		if($_file_size > $maxsize)
		{
			$this->error=2;
			$this->error();
		}

		// 设置并检查存储路径
		$savepath=str_replace('\\','/',$savepath);
		$this->savepath=substr($savepath,-1)=='/'?$savepath:$savepath.'/'; // 路径名以/结尾
		if(!is_writeable($this->savepath))
		{
			$this->error=9;
			$this->error();
		}
		
		// 上传 返回文件路径
		if(!$_FILES[$inputname]["error"])
		{
			if(move_uploaded_file($_FILES[$inputname]["tmp_name"],$this->savepath.$savename) || @copy($_FILES[$inputname]["tmp_name"],$this->savepath.$savename))
			{
				@chmod($this->savepath.$savename, 0777);
				@unlink($_FILES[$inputname]["tmp_name"]);
				return $savename;
			}
			else
			{
				$this->error=$_FILES[$inputname]["error"];
				$this->error();
			}
		}
		else
		{
			$this->error=$_FILES[$inputname]["error"];
			$this->error();
		}
	}

	private function isuploadedfile($file) // 去掉系统自带的反斜线
	{
		return (is_uploaded_file($file) || is_uploaded_file(str_replace('\\\\','\\',$file))); 
	}

	private function error()
	{
		global $lang;
		$upload_error=array(0 => $lang['UPLOAD_ERR_OK'],
							1 => $lang['UPLOAD_ERR_INI_SIZE'],
							2 => $lang['UPLOAD_ERR_SIZE'],
							3 => $lang['UPLOAD_ERR_INI_SIZE'],
							4 => $lang['UPLOAD_ERR_FORM_SIZE'],
							5 => $lang['UPLOAD_ERR_PARTIAL'],
							6 => $lang['UPLOAD_ERR_NO_FILE'],
							7 => $lang['UPLOAD_ERR_NO_TMP_DIR'],
							8 => $lang['UPLOAD_ERR_CANT_WRITE'],
							9 => $lang['UPLOAD_ERR_DIRCANT_WRITE'],
							10 => '只允许上传'.implode(',',$this->alowexts).'类型的文件!',
							11 => $lang['UPLOAD_ERR_TYPE']
						);
		exit('<script language="javascript">alert("'.$upload_error[$this->error].'");history.back();</script>');
	}
}
?>