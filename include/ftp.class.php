<?php
/**
 FTP类
*/
set_time_limit(0);

class ftp
{
	public $conn;

	function connect($host,$username,$password,$port = 21,$timeout = 90,$ssl_connect = false,$pasv = 0) 
	{
		if(!function_exists('ftp_connect'))
		{
			return false;
		}

        if($ssl_connect != false && function_exists('ftp_ssl_connect'))
		{
            $this->conn = ftp_ssl_connect($host,$port,$timeout);
        }
		else
		{
            $this->conn = ftp_connect($host,$port,$timeout);
        }

		if(!$this->conn)
		{
			return false;
		}

        if(!@ftp_login($this->conn,$username,$password)) 
		{
			return false;
		}
		else
		{
			$this->setpasv($pasv);
			return true;
		}
    }

	function ftp_upload($remote_file, $local_file, $mode = FTP_BINARY)
	{
		$remote_file = ftp::clear($remote_file);
		$local_file = ftp::clear($local_file);
		$mode = intval($mode);
		$fp = @fopen($local_file, 'rb');
		$result=@ftp_fput($this->conn, $remote_file, $fp, $mode);
		@fclose($fp);
		return $result;
	}
	
	function ftp_mkdir($directory)
	{
		$directory = ftp::clear($directory);
		$epath = explode('/', $directory);
		$dir = '';$comma = '';
		foreach($epath as $path) {
			$dir .= $comma.$path;
			$comma = '/';
			$return = @ftp_mkdir($this->conn, $dir);
			$this->ftp_chmod($dir);
		}
		return true;
	}

	function ftp_rmdir($directory) 
	{
		$directory = ftp::clear($directory);
		return @ftp_rmdir($this->conn, $directory);
	}

	function ftp_chmod($filename, $mod = 0777) 
	{
		$filename = ftp::clear($filename);
		if(function_exists('ftp_chmod')) {
			return @ftp_chmod($this->conn, $mod, $filename);
		} else {
			return @ftp_site($this->conn, 'CHMOD '.$mod.' '.$filename);
		}
	}

	function ftp_pwd() {
		return @ftp_pwd($this->conn);
	}

	function setpasv($pasv=0)
	{
		ftp_pasv($this->conn,intval($pasv));
	}

	function nlist($directory)
	{
		$directory = ftp::clear($directory);
		$list = @ftp_rawlist($this->conn, $directory);

		if(!$list) return false;
		$array = array();
		foreach($list as $l)
		{
			$l = preg_replace("/^.*[ ]([^ ]+)$/", "\\1", $l);
			if($l == '.' || $l == '..') continue;
			$array[] = $l;
		}
		return $array;
	}

	function ftp_get($local_file, $remote_file, $mode, $resumepos = 0) {
		$remote_file = ftp::clear($remote_file);
		$local_file = ftp::clear($local_file);
		$mode = intval($mode);
		$resumepos = intval($resumepos);
		return @ftp_get($this->conn, $local_file, $remote_file, $mode, $resumepos);
	}

	function ftp_delete($path) {
		$path = ftp::clear($path);
		return @ftp_delete($this->conn, $path);
	}
	
	function ftp_close()
	{
		return @ftp_close($this->conn);
	}

	function clear($str) {
		return str_replace(array( "\n", "\r", '..'), '', $str);
	}
}
?>