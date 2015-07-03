<?php
/**
	* 基于词典的汉字转拼音类

	* $cnspell = new cnspell();
	* echo $cnspell->getCnSpell('字符串','编码','是否取首字符');
*/
class cnspell
{
	private $cnspellstr;
	private $dictpath;

	function __construct()
	{
		$this->dictpath=RETENG_ROOT.'include/dict/cnspell.dict';
	}

	function cnspell()
	{
		$this->__construct();
	}
	
	function loaddict($path) // 加载词典
	{
		$this->dictpath=$path;
	}

	function getCnSpell($str, $code='UTF-8' ,$ishead=0) // 默认UTF-8编码
	{
		$this->cnspellstr=array();
		$restr = '';
		$str = $code=='GBK'?trim($str):iconv("UTF-8", "GBK//IGNORE", trim($str));
		$slen = strlen($str);

		if($slen < 2)
		{
			return $str;
		}

		$fp = fopen($this->dictpath, 'r');
		while(!feof($fp))
		{
			$line = trim(fgets($fp));
			$this->cnspellstr[$line[0].$line[1]] = substr($line, 3, strlen($line)-3);
		}
		fclose($fp);

		for($i=0; $i<$slen; $i++)
		{
			if(ord($str[$i])>0x80)
			{
				$c = $str[$i].$str[$i+1];
				$i++;
				if(isset($this->cnspellstr[$c]))
				{
					$restr .= $ishead ? $this->cnspellstr[$c][0]:$this->cnspellstr[$c];
				}
				else
				{
					$restr .= "_";
				}
			}
			else if( preg_match("/[a-z0-9]/i", $str[$i]) )
			{
				$restr .= $str[$i];
			}
			else
			{
				$restr .= "_";
			}
		}
		return $restr;
	}

	function __destruct()
	{
		unset($this->cnspellstr);
	}
}
?>