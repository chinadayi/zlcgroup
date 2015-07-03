<?php
/**
 公共函数
*/
function filterhtml($str,$type=4)
{
	$str=stripslashes($str);
	switch($type)
	{
		case '0': // 用 htmlspecialchars() 函数直接替换
			$str=htmlspecialchars($str);
			break;
		case '1': // 用 htmlspecialchars() 函数替换并除去连续空白字符
			$str=htmlspecialchars($str);
			break;
		case '2': // 用 htmlspecialchars() 函数替换并除去所有空白字符
			$str=htmlspecialchars($str);
			break;
		case '3': // 用 strip_tags() 函数替换并除去所有空白字符
			$str=strip_tags($str);
			break;
		default: // 去除 iframe,link,meta 等可能XSS的代码
			$str=preg_replace('/script/i','ｓｃｒｉｐｔ',$str);
			$str=preg_replace('/<[\/]?(link|ifra|fra|meta)[^>]*>/i','',$str);
			break;
	}
	return addslashes($str);
}

function batfilterhtml($str,$type=4)
{
	if(is_string($str))return filterhtml($str,$type);
	foreach($str as $key => $value)
	{
		$str[$key]=batfilterhtml($value,$type);
	}
	return $str;
}

// 根据栏目ID获取栏目名称
function catname($catid)
{
	$r=cache_read('cat'.intval($catid).'.cache.php',RETENG_ROOT.'data/cache_category/');
	return $r?$r['catname']:'未知栏目';
}

// 根据栏目ID获取栏目URL
function caturl($catid)
{
	global $RETENG;
	$r=cache_read('cat'.intval($catid).'.cache.php',RETENG_ROOT.'data/cache_category/');
	return $r?$r['url']:$RETENG['site_url'];
}

// 更多
function more($catid=0,$menu='更多',$style="")
{
	global $baselang;
	$style=$style?' class="'.$style.'" ':'';
	$menu=trim($menu);
	$r=cache_read('cat'.intval($catid).'.cache.php',RETENG_ROOT.'data/cache_category/');
	if(!$r || !$catid)return $baselang['undefined'];
	else{
		return '<a href="'.$r['url'].'" title="'.$r['catname'].'" '.$style.' target="_blank">'.($menu?$menu:$baselang['more']).'</a>';
	}
}

// 获取文件拓展名 
function get_fileext($file)
{
	return strtolower(substr(strrchr($file,'.'),1));
}

// 判断是否为图片，仅判断后缀
function is_image($file)
{
	return in_array(get_fileext($file),array('gif','jpg','jpeg','png','bmp'));
}

// 判断是否为视频，仅判断后缀
function is_vedio($file)
{
	return in_array(get_fileext($file),array('swf','flv'));
}

// 将一段文本转换成图片显示
function strtojpg($str,$width='100',$height='24')
{
	global $RETENG;
	$str=trim($str);
	if($str)
	{
		return '<img align="top" width="'.intval($width).'" height="'.intval($height).'" src="'.$RETENG['site_url'].'api/imcode/authcode.php?str='.urlencode(base64_encode($str)).'" />';
	}
	else
	{
		return $str;
	}
}

// 判断远程文件是否存在
function file_exists_url($url)
{
	if(substr($url,0,7)!='http://' && substr($url,0,6)!='ftp://')
	{
		return file_exists(RETENG_ROOT.$url);
	}

	if(extension_loaded('curl'))
	{
		$curl = curl_init($url); 
		curl_setopt($curl, CURLOPT_NOBODY, true); 
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
		$result = curl_exec($curl); 
		$feedback = false; 

		if ($result !== false)  
		{ 
			$statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);   
			if ($statusCode == 200) 
			{ 
				$feedback = true;    
			} 
		} 
		curl_close($curl); 
		return $feedback; 
	}
	else
	{
		$feedback=@get_headers($url);
		return stripos($feedback[0], '200') ? true : false;
	}
}

//获取一段文本内的所有图片地址
function get_images($str)
{
	preg_match_all('/<img(.+?)src=[\'\"]?([^\'\"]+)[\'\"]?/i',stripslashes($str),$matches,PREG_PATTERN_ORDER);
	$r=array();
	$t=$matches[2];

	foreach($t as $_t)
	{
		if(is_image($_t))$r[]=$_t;
	}
	return $r;
}
//远程获取图片的功能
function createthumb($img,$thumb=1,$thumb_width=100,$thumb_height=100,$ctype=1)
{
	global $RETENG;
	if(!in_array(get_fileext($img),array('jpg','gif','png','bmp','jpeg')))return $RETENG['site_url'].'images/nopic.gif';
	if(strtolower(substr($img,0,7))=='http://')
	{	
		if(!file_exists_url($img))return $RETENG['site_url'].'images/nopic.gif';
		$filename=basename($img);
		$randname=substr(md5($img),8,16).'.'.get_fileext($img);
		if($_userid){
			$userid=$_userid;
		}
		if(isset($_SESSION['admin_id']) && $_SESSION['admin_id'])
		{
			$userid=$_SESSION['admin_id'];
		}
		$userpath=retengcms_md5($userid).'/image/'.date('Ym',TIME).'/'; //2014-09-20 作废
		$save_path = RETENG_ROOT.'uploads/image';
		$save_url = RETENG_PATH.'uploads/image';
		
		if (!file_exists($save_path)) {
			mkdir($save_path);
		}
		if(!file_exists($save_url.$randname))
		{
			$file=@file_get_contents($img,true);
			if($file)
			{
				$fp=@fopen($save_path.$randname,'a');
				@fwrite($fp,$file);
				@fclose($fp);
			}
		}
		if(is_array(@getimagesize($save_path.$randname)))
		{
			$img=$save_url.$randname;
		}
		else
		{
			@unlink($save_path.$randname);
			return $RETENG['site_url'].'images/nopic.gif';
		}
		
	}
	if(!extension_loaded('gd') || !function_exists('imagecreate'))return $img;
	//添加图片水印
	if(WATERMARK_ENABLED)
	{
		$image_size=@getimagesize($save_path.$randname);
	
		if($image_size[0]>=WATERMARK_MINWIDTH &&$image_size[1]>=WATERMARK_MINHEIGHT)//添加水印条件
		{
			
			include RETENG_ROOT.'include/image.class.php';
			$image=new image();
			$image->watermark(RETENG_ROOT.$img,WATERMARK_POS,WATERMARK_FILE,WATERMARK_PCT,WATERMARK_WORDS,5,WATERMARK_COLOR);
		}
			
	}
	//ftp远程保存
	if(FTP && FTP_SERVER && FTP_USER && FTP_PWD)
	{
				$remotedir=FTP_DIR.'/'.$dir.'/';
				if($ftpobj->ftp_mkdir($remotedir))
				{
					$result=$ftpobj->ftp_upload($remotedir.basename($img),RETENG_ROOT.$img);
				}
				$ftpobj->ftp_close();
				@unlink(RETENG_ROOT.$img);
	}
	/*
		是否生成缩略图
	*/
	if($thumb)
	{
		$info=imageinfo($img);
		$thumb_w=intval($thumb_width)?intval($thumb_width):THUMB_WIDTH;
		$thumb_h=intval($thumb_width)?intval($thumb_width):THUMB_HEIGHT;
		
		if($ctype==1) // 按照比例生成缩略图
		{
			$scale=min(1,min($thumb_width/$info['width'],$thumb_height/$info['height'])); //按比例缩放
			$thumb_width=intval($info['width']*$scale);
			$thumb_height=intval($info['height']*$scale);
		}
		else // 按照固定宽高生成缩略图
		{
			$thumb_width=intval($thumb_width);
			$thumb_height=intval($thumb_height);
		}
		$createfunc='imagecreatefrom'.($info['type']=='jpg'?'jpeg':$info['type']);
		$im=$createfunc($img);
		$thumb_im=$info['type']!='gif' && function_exists('imagecreatetruecolor')?imagecreatetruecolor($thumb_width,$thumb_height):imagecreate($thumb_width,$thumb_height);
		imagecopyresampled($thumb_im,$im,0,0,0,0,$thumb_width,$thumb_height,$info['width'],$info['height']);
		if($info['type']=='gif' || $info['type']=='png')
		{
			$bgcolor=imagecolorallocate($thumb_im,0,255,0);
			imagecolortransparent($thumb_im,$bgcolor);
		}
		$imagefunc='image'.($info['type']=='jpg'?'jpeg':$info['type']);
		$thumbname='thumb_'.$info['name'].'_'.$thumb_width.'x'.$thumb_height.'.'.$info['type'];
		$imagefunc($thumb_im,$info['path'].$thumbname);
		imagedestroy($im);
		imagedestroy($thumb_im);
		return $info['path'].$thumbname;
	}
	else
	{
		return $img;
	}
}

// 获取图片信息
function imageinfo($img)
{
	$imginfo=$info=array();
	$t=basename($img);
	$t=explode('.',$t);
	$info['name']=$t[0];
	$info['size']=filesize($img);
	$imginfo=getimagesize($img);
	$info['width']=$imginfo[0];
	$info['height']=$imginfo[1];
	$info['width_height']=$imginfo[3];
	$info['mime']=$imginfo['mime'];
	unset($imginfo);
	$imginfo=pathinfo($img);
	$info['path']=$imginfo['dirname'].'/'; 
	$info['type']=strtolower($imginfo['extension']); //图片拓展名，不含'.'
	unset($imginfo);
	return $info;
}
function retengecho($str)
{
	return $str;
}
function add_alt($str,$alt='')
{
	return addslashes(preg_replace('/<img(.+)(alt=[\'\"]?[^\'\"]*[\'\"]?)/i','<img\\1alt="'.$alt.'"',stripslashes($str)));
}

function txt_urlencode($t,$str)
{
	return $t."\"".urlencode($str)."\"";
}

function txt_urldecode($t,$str)
{
	return $t."\"".urldecode($str)."\"";
}

function txt_urlencode2($t,$str)
{
	return $t.urlencode($str).'</a>';
}

function txt_urldecode2($t,$str)
{
	return $t.urldecode($str).'</a>';
}

// 当前页面地址
function getcururl()
{
	$cur='';
	if(isset($_SERVER['REQUEST_URI']))$cur=$_SERVER['REQUEST_URI'];
	else if(isset($_SERVER['PHP_SELF']) && isset($_SERVER['argv']))$cur=$_SERVER['PHP_SELF'].'?'.$_SERVER['argv'][0];
	else $cur=$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
	return strip_tags($cur);
}

// 前一个页面地址
function getpreurl()
{
	return isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] ? mysql_real_escape_string(strip_tags($_SERVER['HTTP_REFERER'])):'';
}

function retengcms_stripslashes($str)
{
	if(!is_array($str))return stripslashes($str);
	foreach($str as $key => $value)
	{
		$str[$key]=retengcms_stripslashes($value);
	}
	return $str;
}

function retengcms_addslashes($str)
{
	if(!is_array($str))return addslashes($str);
	foreach($str as $key=>$value)
	{
		$str[$key]=retengcms_addslashes($value);
	}
	return $str;
}

function retengcms_htmlspecialchars($str)
{
	if(!is_array($str))return htmlspecialchars($str);
	foreach($str as $key=>$value)
	{
		$str[$key]=retengcms_htmlspecialchars($value);
	}
	return $str;
}


// 增强的 str_split()函数 (适合中文)
function strsplit($str,$split_length=1,$charcode='GBK')
{
	$split_length=intval($split_length)>0?intval($split_length):1;

	if(strtoupper($charcode)=='GBK')
	{
		$str=iconv("GBK", "UTF-8", $str);
		preg_match_all('/.{'.$split_length.'}|[^\x00]{1,'.$split_length.'}$/us', $str, $ar);
		if($ar[0])foreach($ar[0] as $key => $value)
		{
			$ar[0][$key]=iconv("UTF-8", "GBK//IGNORE", $value);
		}
	}
	else
	{
		preg_match_all('/.{'.$split_length.'}|[^\x00]{1,'.$split_length.'}$/us', $str, $ar);
	}
	return $ar[0];
}

function sub_string($string, $length, $dot='')
{
	$string=trim($string);
	$strlen = strlen($string);
	if($strlen <= $length) return $string;
	$string = str_replace(array('&nbsp;', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), array(' ', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'), $string);
	$strcut = '';
	$n = $tn = $noc = 0;
	while($n < $strlen)
	{
		$t = ord($string[$n]);
		if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
			$tn = 1; $n++; $noc++;
		} elseif(194 <= $t && $t <= 223) {
			$tn = 2; $n += 2; $noc += 2;
		} elseif(224 <= $t && $t < 239) {
			$tn = 3; $n += 3; $noc += 2;
		} elseif(240 <= $t && $t <= 247) {
			$tn = 4; $n += 4; $noc += 2;
		} elseif(248 <= $t && $t <= 251) {
			$tn = 5; $n += 5; $noc += 2;
		} elseif($t == 252 || $t == 253) {
			$tn = 6; $n += 6; $noc += 2;
		} else {
			$n++;
		}
		if($noc >= $length) break;
	}
	if($noc > $length) $n -= $tn;
	$strcut = substr($string, 0, $n);
	$strcut = str_replace(array('&', '"', "'", '<', '>'), array('&amp;', '&quot;', '&#039;', '&lt;', '&gt;'), $strcut);
	return $strcut.$dot;
}

// 获取IP地址
function getIp()
{
	$ip='未知IP';

	if(!empty($_SERVER['HTTP_CLIENT_IP']))
	{
		return is_ip($_SERVER['HTTP_CLIENT_IP'])?$_SERVER['HTTP_CLIENT_IP']:$ip;
	}
	elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
	{
		return is_ip($_SERVER['HTTP_X_FORWARDED_FOR'])?$_SERVER['HTTP_X_FORWARDED_FOR']:$ip;
	}
	else
	{
		return is_ip($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:$ip;
	}
}

function is_ip($str)
{
	$ip = explode('.',$str);
	for($i=0;$i<count($ip);$i++)
	{  
		if($ip[$i]>255)
		{  
			return false;  
		}  
	}  
	return preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/',$str);  
}

/*
	隐藏Ip
*/
function hideip($ip,$key=4)
{
	if(!is_ip($ip) || $key>4)return 'Unkonwn';
	$ip=explode(".",$ip);
	$ip[$key-1]='*';
	return implode(".",$ip);
}

// 返回结果集数量
function get_cache_counts($sql,$ttl=0)
{
	global $db,$T;
	$id = md5($sql);
	$ttl=intval($ttl)?intval($ttl):CACHE_COUNT_TTL;

	if(!isset($T['count'][$id]))
	{
		if($ttl)
		{
			$r=$db->fetch_one("SELECT `count`,`updatetime` FROM `".DB_PRE."counts` WHERE `id`='$id'");
			if(!$r||$r['updatetime']<TIME-$ttl)
			{
				$r=$db->fetch_one($sql);
				$T['count'][$id] = $r['count'];
				$db->query("REPLACE INTO `".DB_PRE."counts`(`id`, `count`, `updatetime`) VALUES('$id', '".$r['count']."', '".TIME."')",true);
			}
		}
		else
		{
			$r=$db->get_one($sql);
		}
		$T['count'][$id]=$r['count'];
	}
	return $T['count'][$id];
}

// 栏目分页
function listpage($catid,$listsize=5,$page=0)
{
	global $baselang;
	$catid=intval($catid);
	$page=intval($page)>0?intval($page):1;

	$data=array();
	if($catid)
	{
		$catinfo=getcatinfo($catid);
		$r=cache_read('cat-listsize'.$catid.'.cache.php',RETENG_ROOT.'data/cache_template/');
		$row=$r && intval($r[$catid])?intval($r[$catid]):$catinfo['listnum'];

		$listurlrule=(isset($catinfo['listurlrule']) && $catinfo['listurlrule']) ?$catinfo['listurlrule']:'{catdir}list_{page}'.HTMLEXT;
		$listurlrule=str_replace('{tid}',$catid,$listurlrule);
		$listurlrule=str_replace('{sitedir}',SITEDIR.'/',$listurlrule);
		$listurlrule=str_replace('{catdir}',$catinfo['catdir'],$listurlrule);
		$listurlrule=str_replace('\\','/',$listurlrule);
		$listurlrule=str_replace('//','/',$listurlrule);

		$totalcount=get_cache_counts("SELECT COUNT(*) AS count FROM `".DB_PRE."content` WHERE `".DB_PRE."content`.`catid` IN (".implode(',',get_childrencatid($catid)).")"); 
		if(!$totalcount)
		{
			$data['totalcount']=0;
			$data['pageno']=1;
			$data['page']=1;
			$data['index']='';
			$data['pagelist']='';
			$data['next']='';
			$data['end']='';
		}
		else
		{
			$pageno=ceil($totalcount/$row);
			$page=max(1,min($page,$pageno));
			$data['totalcount']=$totalcount;
			$data['pageno']=$pageno;
			$data['page']=$page;
			$data['index']=$page==1?'':'<li><a href="'.$catinfo['url'].'">'.$baselang['firstpage'].'</a></li>';

			$pagearray=range(1,$pageno);
			$pagearray=array_slice($pagearray,max(0,($page/$listsize < 1?0:floor($page/$listsize)*$listsize)-1) ,$listsize);
			$querystring=array();

			if($catinfo['catishtml']==0) //动态
			{
				if($page==1)
				{
					$data['pre']='';
				}
				else
				{
					$data['pre']='<li><a href="'.$catinfo['url'].'&page='.max(1,$page-1).'">'.$baselang['prepage'].'</a></li>';
				}

				if($page==$pageno)
				{
					$data['next']='';
				}
				else
				{
					$data['next']='<li><a href="'.$catinfo['url'].'&page='.min($pageno,$page+1).'">'.$baselang['nextpage'].'</a></li>';
				}

				if($pageno>1)
				{
					foreach($pagearray as $_page)
					{
						if($page==$_page)
						{
							$querystring[]='<li class="active"><a href="#">'.$_page.'</a></li>';
						}
						else
						{
							$querystring[]='<li><a href="'.$catinfo['url'].'&page='.max($_page,1).'">'.max($_page,1).'</a></li>';
						}
					}
				}
				$data['pagelist']=implode(' ',$querystring);
				$data['end']=$page==$pageno?'':'<li><a href="'.$catinfo['url'].'&page='.$pageno.'">'.$baselang['endpage'].'</a><li>';
			}
			else //静态或者伪静态
			{
				if($page==1)
				{
					$data['pre']='';
				}
				else
				{
					$data['pre']='<li><a href="'.str_replace('{page}',max(1,$page-1),$listurlrule).'">'.$baselang['prepage'].'</a></li>';
				}
				
				if($pageno>1)
				{
					foreach($pagearray as $_page)
					{
						if($page==$_page)
						{
							$querystring[]='<li>'.$_page.'</li>';
						}
						else
						{
							$querystring[]='<li><a href="'.str_replace('{page}',max($_page,1),$listurlrule).'">'.max($_page,1).'</a></li>';
						}
					}
				}

				$data['pagelist']=implode(' ',$querystring);

				if($page==$pageno)
				{
					$data['next']='';
				}
				else
				{
					$data['next']='<li><a href="'.str_replace('{page}',min($pageno,$page+1),$listurlrule).'">'.$baselang['nextpage'].'</a></li>';
				}

				$data['end']=$page==$pageno?'':'<li><a href="'.str_replace('{page}',$pageno,$listurlrule).'">'.$baselang['endpage'].'</a></li>';
			}
		}
	}
	return $data;
}

// 分页函数
function getpages($number,$page,$pagesize,$ishtml=0,$align='right',$catid=0)
{
	global $RETENG,$baselang;
	$rand=mt_rand(100,999);
	$pagenum=max(1,ceil($number/$pagesize));
	$prepage=max(($page-1),1);
	$nextpage=max(1,min(($page+1),$pagenum));

	if(!$ishtml) // 动态
	{
		
		$cururl=preg_replace('/([&\?]?)(page=[0-9]+)([&\?]?)/i','\\1',getcururl());
		$strlen=strlen($cururl)-1;
		$flag=(boolean)(substr(strrchr($cururl,'/'),1));
		if(substr($cururl,-1,1)=='&')
		{
			$cururl=$flag?substr($cururl,0,$strlen).'&page=':substr($cururl,0,$strlen).'?page=';
		}
		elseif(substr($cururl,-1,1)=='?')
		{
			$cururl=substr($cururl,0,$strlen).'?page=';
		}
		else{
			if(strpos($cururl,'?')===false && strpos($cururl,'&')===false)$flag=false;
			$cururl=$flag?$cururl.'&page=':$cururl.'?page=';
		}
		$pselect='<select name="pageto" id="pagetoselect'.$rand.'" onchange="window.location.href=\''.$cururl.'\'+document.getElementById(\'pagetoselect'.$rand.'\').value">';
		for($i=1;$i<=intval($pagenum);$i++)
		{
			$pselect.='<option value="'.$i.'">'.$baselang['start'].$i.$baselang['page'].'</option>';
		}
		$pselect.='</select><script language="javascript">{document.getElementById(\'pagetoselect'.$rand.'\').value='.$page.'}</script>';
		return '<div align="'.$align.'">&nbsp;'.$baselang['total'].'：<b>'.$number.'</b> &nbsp;
						<a href="'.$cururl.'1">'.$baselang['firstpage'].'</a>&nbsp;<a href="'.$cururl.$prepage.'">'.$baselang['prepage'].'</a>&nbsp;
						<a href="'.$cururl.$nextpage.'">'.$baselang['nextpage'].'</a>&nbsp;
						<a href="'.$cururl.$pagenum.'">'.$baselang['endpage'].'</a>&nbsp;'.$baselang['totalpage'].'：<b><font color="#ff0000">'.$page.'</font>/'.$pagenum.'</b> '.$pselect.'</div>';	
	}
}

function set_cookie($var,$value='',$time=0)
{
	$time = $time > 0 ? $time : ($value == '' ? TIME - 3600 : 0);
	$secure=$_SERVER['SERVER_PORT']=='443'?true:false;
	$var = COOKIE_PRE.$var;
	$_COOKIE[$var] = $value;
	if(is_array($value))
	{
		foreach($value as $k=>$v)
		{
			setcookie($var.'['.$k.']',$v,$time,COOKIE_PATH,COOKIE_DOMAIN,$secure);
		}
	}
	else
	{
		setcookie($var,$value,$time,COOKIE_PATH,COOKIE_DOMAIN,$secure);
	}
}

function retengcms_auth($str,$operation='ENCODE',$key='')
{
	$key=$key?$key:AUTH_KEY;
	$str=$operation == 'ENCODE'?$str:base64_decode($str);
	$len=strlen($key);
	$code='';
	for($i=0; $i<strlen($str); $i++){
		$k=$i%$len;
		$code.=$str[$i]^$key[$k];
	}
	$code=$operation=='DECODE'?$code:base64_encode($code);
	return $code;
}


function get_cookie($var)
{
	$var = COOKIE_PRE.$var;
	return isset($_COOKIE[$var])?$_COOKIE[$var]:false;
}

function getpos($catid=0,$separator='')
{
	global $RETENG;
	$r=cache_read('cat'.$catid.'.cache.php',RETENG_ROOT.'data/cache_category/');
	$url=' <a href="'.$r['url'].'" title="'.$r['catname'].'">'.$r['catname'].'</a> ';
	if(!$r || !$r['parentid']) 
	{
		return $url;
	}
	else
	{
		return getpos($r['parentid'],$separator).$separator.$url;
	}
}

// 获取当前位置
function get_pos($catid=0,$separator='')
{
	global $RETENG,$baselang;
	$catid=intval($catid);
	if(!$catid)return ' <a href="'.$RETENG['site_url'].'" title="'.$RETENG['site_name'].'">'.$baselang['index'].'</a> ';
	$separator=htmlspecialchars($separator);
	$separator=$separator?$separator:SEPARATOR;
	$pos=getpos($catid,$separator);	
	return ' <a href="'.$RETENG['site_url'].'" title="'.$RETENG['site_name'].'">'.$baselang['index'].'</a> '.$separator.' '.$pos;
}

// 读取缓存 
function cache_read($cachename,$path='')
{
	$cachename=str_replace('/','',$cachename);
	$cachename=str_replace('\\','',$cachename);
	$path=empty($path)?CACHE_PATH:$path;
	$cachefile=$path.$cachename;
	if(!file_exists($cachefile))return false;
	return @include $cachefile;
}

// 写入缓存
function cache_write($cachename,$array=array(),$path='')
{
	if(!is_array($array))return false;
	$path=empty($path)?CACHE_PATH:$path;
	$cachefile=$path.$cachename;
	
	$array="<?php\n//".date('Y-m-d H:i:s',time())."\nreturn ".var_export($array,true).";\n?>";
	$strlen=file_put_contents($cachefile,$array);

	@chmod($cachefile,0777);
	return $strlen;
}

// 删除缓存
function cache_delete($cachename,$path='')
{
	$path=empty($path)?CACHE_PATH:$path;
	if($cachename=='*') // 所有缓存文件及文件夹
	{
		rmdirs($path);
	}
	else if($cachename=='*.*') // 所有缓存文件
	{
		 rmfiles($path);
	}
	else // 指定文件
	{
		$cachefile=$path.$cachename;
		return @unlink($cachefile);
	}
}

// 删除文件夹下的所有文件
function rmfiles($path)
{
	if(!file_exists($path))return true;
	$path = get_path($path);
	$list = glob($path.'*.*');
	foreach($list as $v)
	{
		@unlink($v);
	}
	return true;
}

//递归创建文件夹
function makedir($dirname) 
{	
	@chdir(RETENG_ROOT);
	if(file_exists($dirname) || !$dirname)return true;
	$dirname=strtolower(preg_replace('/[^0-9a-zA-Z_\-\/]/i','',str_replace('\\','/',$dirname)));
	$dirname=explode('/',$dirname);
	$reteng_name='./';
	foreach($dirname as $childdir)
	{
		$reteng_name.=$childdir.'/';
		if(!file_exists($reteng_name) && !empty($childdir))
		{
			@mkdir($reteng_name);
			@chmod($reteng_name,0777);
		}
	}
	return true;
}

// 递归删除文件及文件夹
function rmdirs($path)
{
	$path=str_replace('\\','/',$path);
	$path=str_replace('//','/',$path);

	if(!file_exists($path))return true;
	if(is_dir($path))
	{
		if(file_exists(str_replace('//','/',$path.'/rm.lock')))return false;
	}

	else
	{
		if(file_exists(dirname($path).'/rm.lock'))return false;
	}

	if(is_dir($path))
	{
		$path = get_path($path);
		$list = glob($path.'*');
		foreach($list as $v)
		{
			is_dir($v) ? rmdirs($v) : @unlink($v);
		}
		return rmdir($path);
	}
	else
	{
		return unlink($path);
	}
}

// 格式化目录路径
function get_path($path)
{
	$path = str_replace('\\', '/', $path);
	if(substr($path,-1) != '/') $path = $path.'/';
	return $path;
}

// 生成html
function create_html($file)
{
	global $RETENG,$LANG;
	$data=ob_get_contents();
	ob_clean();
	$path=dirname($file);
	if(substr($path,0,strlen(RETENG_ROOT))==RETENG_ROOT)
	{
		$path=substr($path,strlen(RETENG_ROOT));
	}
	/*
		makedir($path);
	*/
	$strlen=file_put_contents($file,$data);
	@chmod($file,0777);
	return $strlen;
}

// 调用模板函数
function template($tlpname,$mod='dy',$folder='',$issystem=false,$tpath='')
{
	/*
		只有常规模板才能被预览!
	*/
	$mod=trim($mod)=='dy'?'':trim($mod).'/';
	$folder=trim($folder)?trim($folder).'/':'';
	if(!$issystem)
	{	if(empty($tpath))
		{
			$project=TPL_NAME;
		}else
		{
			$project=$tpath;
		}
		//echo file_exists(TPL_ROOT.$project.'/'.$mod.$folder);
		$project=file_exists(TPL_ROOT.$project.'/'.$mod.$folder)?$project:'default';	
	}
	else
	{
		$project='system';
	}

	require_once (RETENG_ROOT.'include/template.func.php');
	$compliedfile=TPL_CACHEPATH.$project.'/'.$mod.$folder.$tlpname.'.tlp.php';
	if(!file_exists(TPL_CACHEPATH.$project.'/'.$mod))@mkdir(TPL_CACHEPATH.$project.'/'.$mod,0777);
	if(!file_exists(TPL_CACHEPATH.$project.'/'.$mod.$folder))@mkdir(TPL_CACHEPATH.$project.'/'.$mod.$folder,0777);
	if(!file_exists(TPL_ROOT.$project.'/'.$mod.$folder.$tlpname.'.htm'))
	{
		exit('路径：“'.TPL_ROOT.$project.'/'.$mod.$folder.'”下的文件：'.$tlpname.'.htm'.'不存在或者不完整,无法预览!');
	}

	if(!file_exists($compliedfile) || @filemtime(TPL_ROOT.$project.'/'.$mod.$folder.$tlpname.'.htm') > @filemtime($compliedfile))
	{
		template_complie($tlpname,$project,$mod,$folder);
	}
	return $compliedfile;
}

// 字符串转换为数组
function string2array($str)
{
	if(disablefunc('eval'))exit('函数eval被禁用,可能无法正常使用本系统!');
	if($str=='') return array();
	if(is_array($str))return $str; // 2011-09-13  是数组的话直接返回
	@eval("\$array = $str;");
	return $array;
}

// 设置配置文件
function cache_config($cachename='common.cache.php',$array=array(),$path='')
{
	if(!is_array($array))return false;
	$path=empty($path)?RETENG_ROOT.'data/':$path;
	$cachefile=$path.$cachename;
	$array="<?php\n\$RETENG=".var_export($array,true).";\n?>";
	$strlen=file_put_contents($cachefile,$array);
	@chmod($cachefile,0777);
	return $strlen;
}

// 检查函数是否出于安全原因而被禁用
function disablefunc($func)
{
	return in_array($func,array_map('trim',explode(',',ini_get('disable_functions'))));
}

// 系统错误提示
function fatal_error($msg,$errno='')
{
	$msg=DEBUG?strip_tags($msg,'<br><p><a>'):'系统管理员屏蔽了错误信息!';
	global $RETENG;
	include template('system_syserror','','',true);
	exit();
}

// 常规带跳转操作提示 
function showmsg($msg='',$url='',$timeout=1000)
{
	global $RETENG;
	if(!$url)$url='javascript:history.back();';
	include template('system_back','','',true);
	exit('<script>setTimeout("redirect(\''.$url.'\');",'.$timeout.');</script>');
}

// 404 不存在提示
function show404($msg='',$url='',$timeout=10000)
{
	global $RETENG;
	header('HTTP/1.1 404 Not Found');
	header("status: 404 Not Found");
	if(!$url)
	{
		$url=$RETENG['site_url'];
	}
	$expire=$timeout/1000;
	include template('system_404','','',true);
	exit('<script>setTimeout("redirect(\''.$url.'\');",'.$timeout.');</script>');
}

// 常规不带跳转操作提示 
function showmsg_nourl($msg='')
{
	global $RETENG;
	$url='javascript:history.back();';
	include template('system_noback','','',true);
	exit();
}

// 去除空白字符[\r\n\t\s]
function trim_str($str)
{
	return preg_replace('/[\r\n\t\s]+/','',$str);
}

// 密码加密[双层md5加密]
function PWD($pwd)
{
	return md5(md5(PASSWORD_KEY).PASSWORD_KEY.md5(trim($pwd)));
}

// 根据链接地址获取域名
function getRootDomain($url)
{
	$ohurl=$ohip=array();
	$url = $url."/"; 
	preg_match("/((\w*):\/\/)?\w*\.?([\w|-]*\.(com.cn|net.cn|gov.cn|org.cn|com|net|cn|org|asia|tel|mobi|me|tv|biz|cc|name|info))\//i", $url, $ohurl); 

	if(!isset($ohurl[3]) || $ohurl[3] == '')
	{ 
		preg_match("/((\d+\.){3}\d+)\//", $url, $ohip); 
		return isset($ohip[1])?$ohip[1]:'';
	} 
	return $ohurl[3]; 
}

// 获取浏览器类型及版本 2014-08-16 兼容IE11.0
function explorer_version()
{
	global $baselang;
	if(strpos($_SERVER["HTTP_USER_AGENT"],"MSIE") > 0)
	{
         preg_match("/MSIE\s+([^;)]+)+/i", $_SERVER["HTTP_USER_AGENT"], $old_ie);
         $exp[0] = "Internet Explorer ";
         $exp[1] = $old_ie[1];
		return $exp[0].$exp[1];
	}
	else if(strpos($_SERVER['HTTP_USER_AGENT'],"Firefox/") > 0)
	{
         preg_match("/Firefox\/([^;)]+)+/i", $_SERVER['HTTP_USER_AGENT'], $b);
         $exp[0] = "Firefox ";
         $exp[1] = $b[1];
		 return $exp[0].$exp[1];
	}
	else if(strpos($_SERVER["HTTP_USER_AGENT"], "Chrome") > 0)
	{
		 preg_match("/Chrome\/([\d\.]+)/", $_SERVER['HTTP_USER_AGENT'], $google);
         $exp[0] = "Google Chrome ";
         $exp[1] = $google[1];  //获取google chrome的版本号
		return $exp[0].$exp[1];
	}
	else if(strpos($_SERVER["HTTP_USER_AGENT"],"Safari"))
	{
		return  "Safari";
	}
	else if(strpos($_SERVER["HTTP_USER_AGENT"],"Opera"))
	{
		return "Opera";
	}
	else if(strpos($_SERVER['HTTP_USER_AGENT'],'rv:')>0 && stripos($_SERVER['HTTP_USER_AGENT'],'Gecko')>0){
         preg_match("/rv:([\d\.]+)/", $_SERVER['HTTP_USER_AGENT'], $IE);
         $exp[0] = "Internet Explorer ";
         $exp[1] = $IE[1];
		 return $exp[0].$IE[1];
	}
	else
	{
		return $baselang['unkonwnbrowser'];
	}
}

//使用键名比较计算数组的差集
function n_array_diff($a1,$a2)
{
	if(function_exists('array_diff_key'))return array_diff_key($a1,$a2);
	else
	{
		$a1=array_flip($a1);
		$a2=array_flip($a2);
		return array_flip(array_diff($a1,$a2));
	}
}

// 获取一个父结点的所有子节点ID $flag=true 时 只返回最终的子结点ID 否则返回所有的子结点ID
function get_childrenid($db,$table,$parentid,$flag=false)
{
	$parentid=intval($parentid);
	$result=array();
	$r=$db->fetch_all("SELECT `$table`.`id` FROM `$table` WHERE `$table`.`parentid`=$parentid");
	if($r)
	{
		foreach($r as $_r)
		{
			if($flag)
			{
				if(!$db->fetch_one("SELECT `$table`.`id` FROM `$table` WHERE `$table`.`parentid`=".intval($_r['id'])))
				{
					$result[]=intval($_r['id']);
				}
			}
			else
			{
				$result[]=intval($_r['id']);
			}
			$result=get_childrenid($db,$table,$_r['id'],$flag);
		}
	}
	$result[]=$parentid;
	return array_unique($result);
}

// 获取级联菜单枚举值名称
function get_selectmenu($js='area',$enumid=0)
{
	global $baselang;
	$r=cache_read('stepselect_enum'.$js.'.cache.php',RETENG_ROOT.'data/c/');
	return $r && isset($r[$enumid])?$r[$enumid]:'不限';
}

// 级联菜单
function js_selectmenu($js='area',$table='areaid', $name='info', $default='0') 
{
	global $baselang;
	$table=preg_replace('/[^a-z0-9_]+/i','',$table);
	if(!file_exists(RETENG_ROOT.'data/cache_stepselect/'.$js.'.js'))return '';
	$result='<input type="hidden" value="'.$default.'" id="'.$table.'" name="'.$table.'" /><input type="hidden" value="'.$default.'" id="'.$name.'_id_'.$table.'" name="'.$name.'['.$table.']" /><select id="'.$table.'_top_select" name="'.$table.'_top_select" onchange="get_'.$js.'self_select(\''.$name.'\',\''.$table.'\',this.value)"></select><select id="'.$table.'_self_select" name="'.$table.'_self_select" onchange="get_'.$js.'son_select(\''.$name.'\',\''.$table.'\',this.value)"></select><select id="'.$table.'_son_select" onchange="get_'.$js.'_value(\''.$name.'\',\''.$table.'\',this.value)" name="'.$table.'_son_select"></select><script language="javascript">var stepselect="'.$table.'";</script> <a href="javascript:void(0);" onclick="javascript:reset_'.$js.'selectnemu();">'.$baselang['reset'].'</a>
<script language="javascript" src="'.SITE_URL.'data/cache_stepselect/'.$js.'.js"></script>';
	$enums=cache_read('stepselect_enum'.$js.'.cache.php',RETENG_ROOT.'data/c/');

	if($default && array_key_exists($default,$enums))
	{
		$result.='<script language="javascript">document.getElementById("'.$table.'_top_select").options[0]=new Option("'.$enums[$default].'",'.$default.'); document.getElementById("'.$table.'_top_select").disabled="disabled";document.getElementById("'.$table.'_top_select").value='.$default.';</script>';
	}

	return $result;
}


/*
	获取级联菜单信息
*/
function selectmenuinfo($type='area',$parentid=0,$isall=false,$row="0")
{
	include_once dirname(__FILE__).'/admin/stepselect.class.php';
	$stepselect= new stepselect();
	return $stepselect->enuminfo($type,$parentid,$isall,$row);
}

function selectmenusearch($type='area',$parentid=0)
{
	$result=array();
	$parentid=intval($parentid);

	if(!$parentid)
	{
		$result=cache_read('stepselect_enum'.$type.'.cache.php',RETENG_ROOT.'data/c/');
		foreach($result as $key =>$val)
		{
			$r=cache_read('stepselect_enum'.$type.$key.'.cache.php',RETENG_ROOT.'data/c/');
			if($r['parentid']==0)
			{
				unset($result[$key]);
			}
		}
	}
	else
	{
		$r=selectmenuinfo($type,$parentid);

		if(!$r)
		{
			$r=cache_read('stepselect_enum'.$type.$parentid.'.cache.php',RETENG_ROOT.'data/c/');
			$r=selectmenuinfo($type,$r['parentid']);
		}
		foreach($r as $_r)
		{
			$result[$_r['id']]=$_r['name'];
		}
	}
	return $result;
}

function getparentid($catid)
{
	$r=getcatinfo($catid);
	return $r?$r['parentid']:0;
}

// 获取栏目所有信息 返回数组
function getcatinfo($catid)
{
	if(!cat_exists($catid))
	{
		return false;
	}
	$r1=cache_read('cat'.intval($catid).'.cache.php',RETENG_ROOT.'data/cache_category/');
	$r1['expand']=$r1['expand']?string2array($r1['expand']):array();
	if($r1['expand'])foreach($r1['expand'] as $key => $value)
	{
		$r1['_'.$key]=htmlspecialchars($value);
	}
	$r2=cache_read('cat_setting'.intval($catid).'.cache.php',RETENG_ROOT.'data/cache_category/');
	return array_merge($r1,$r2);
}

// 获取栏目配置 返回数组
function getcatsetting($catid)
{
	return cache_read('cat_setting'.intval($catid).'.cache.php',RETENG_ROOT.'data/cache_category/');
}

//判断是否是最终子栏目
function isfinalcatid($catid)
{
	$r=cache_read('finalcatid.cache.php',RETENG_ROOT.'data/cache_category/');
	return in_array(intval($catid),$r);
}

// 判断栏目是否有子栏目
function ishaschildren($catid)
{
	return cache_read('cat_parent'.intval($catid).'.cache.php',RETENG_ROOT.'data/cache_category/');
}

// 判断栏目ID是否存在
function cat_exists($catid=0)
{
	return intval($catid) && cache_read('cat'.intval($catid).'.cache.php',RETENG_ROOT.'data/cache_category/');
}

// 判断模型ID是否存在
function model_exists($modelid=0)
{
	return intval($modelid) && cache_read('model'.intval($modelid).'.cache.php',RETENG_ROOT.'data/c/');
}


// 获取制定模型ID 的聚合字段 ，返回数组
function get_model_field_array($modelid,$fieldid)
{
	$r=cache_read('model'.$modelid.'_fields.cache.php',RETENG_ROOT.'data/c/');
	if($r)foreach($r as $key => $_r)
    {
			if($_r['id']==$fieldid){
				$data_array=$_r;
			}
	}
	return $data_array;
}
function get_model_field_form($modelid,$fieldid,$fieldform)
{
	$r=get_model_field_array($modelid,$fieldid);
	if($r)return $r[$fieldform];
}
function get_model_field_options($modelid,$fieldid)
{
	$r=get_model_field_form($modelid,$fieldid,'options');
	if($r)
	{
		$rr=explode("\r\n",$r);
		if($rr)foreach($rr as $v)
		{
			$varray=explode("|",$v);
			$data_array[]=$varray;
		}
	}
	return $data_array;
}

/**
	获取所有栏目ID
*/
function getchildrencatid($catid)
{
	$t_catid[]=$catid;
	$r=cache_read('cat_parent'.$catid.'.cache.php',RETENG_ROOT.'data/cache_category/');
	if($r)foreach($r as $_r)
	{
		$t_catid[]=getchildrencatid($_r['id']);
	};
	return implode(',',$t_catid);
}

// 根据当前栏目ID获取其下面的所有子栏目,返回一个数组
function get_childrencatid($catid)
{
	return explode(',',getchildrencatid($catid));
}
//上一级栏目的id
function catparentid($catid)
{
	global $RETENGCMS;
	$r=cache_read('cat'.intval($catid).'.cache.php',RETENG_ROOT.'data/cache_category/');
	return $r?$r['parentid']:'0';
}

// 获得顶级ID
function gettopparentid($catid)
{
	global $gid; 
	$getid=catparentid($catid);
		if($getid!=0){
					$r=cache_read('cat'.intval($getid).'.cache.php',RETENG_ROOT.'data/cache_category/');
					$gid=$r['id'];
					gettopparentid($gid);
				}
	return $gid;
}
/*
	用户模板标记的函数
*/
function getCatid($catid)
{
	$catid=intval($catid);
	//if(!isfinalcatid($catid))return 'catid='.intval($catid);
	//else
	//{
		$r=cache_read('finalcatid.cache.php',RETENG_ROOT.'data/cache_category/');
		$t_catid[]=implode(',',get_childrencatid($catid));
		$catid=array_unique(explode(',',implode(',',$t_catid)));
		$catid=array_intersect($r,$catid);
		$catid=$catid?$catid:array(0);
		sort($catid);
		return 'catid IN('.implode(',',$catid).')';
	//}
}
//bbcode

function bbcode($content)
{
	if(empty($content))return '';
	$content=htmlspecialchars($content);
	return preg_replace('/face:([0-9a-z_]+)\)/i','<img src="'.SITE_URL.'images/face/\\1.gif" border="0" />',$content);
}

//执行插件钩子

function do_hook($tag,$args='')
{
	$result='';
	$plugin=RETENG_ROOT.PLUGINS.'/'.$tag.'/'.$tag.'.php';
	if(file_exists($plugin))
	{
		$result=call_user_func($tag,$args);
	}
	return $result;
}

/*
	获取热门关键字
*/
function hotkeywords($type='hot',$num=10,$pre='',$next='&nbsp;')
{
	global $db,$RETENG;
	$result='';

	$r= $db->fetch_all("SELECT * FROM `".DB_PRE."keywords` ORDER BY `".DB_PRE."keywords`.`".($type=='hot'?'counts':'weight')."` DESC LIMIT 0,$num");
	
	if($r)
	{
		foreach($r as $_r)
		{
			$result.=$pre.'<a href="'.$RETENG['site_url'].'search/index.php?modelid=all&k='.urlencode($_r['keywords']).'" target="_blank">'.$_r['keywords'].'</a>'.$next;
		}
	}
	return $result;
}

/*
	获取指定长度关键字
*/
function get_randstr($len=10)
{
	$str='';
	for($i=0;$i<$len;$i++)
	{
		$str.=mt_rand(0,9);
	}
	return $str;
}

/*
	表情列表
*/
function facelist($pre='&nbsp;',$next='&nbsp;',$textid='c_content')
{
	$str='';
	$files=glob(RETENG_ROOT.'images/face/*.gif');
	if($files)foreach($files as $file)
	{
		if(file_exists($file))
		{
			$str.=$pre.'<img style="cursor:pointer" src="'.SITE_URL.'images/face/'.basename($file).'" onclick="document.getElementById(\''.$textid.'\').value=document.getElementById(\''.$textid.'\').value+\'face:'.basename($file,'.gif').')\'" />'.$next;
		}
	}
	return $str;
}

/*
	模型自定义搜索字段
*/
function searchfields($catid,$modelid=0)
{
	global $areaid;
	$areaid=intval($areaid);

	$str='';
	$tstr='';
	$modelid=intval($modelid);
	if(!$modelid)
	{
		$catinfo=getcatinfo(intval($catid));
		$modelid=$catinfo['modelid'];
	}

	if($modelid)
	{
		$_G=array('modelid','catid');
		$r=cache_read('model'.$modelid.'_fields.cache.php',RETENG_ROOT.'data/c/');
		if($r)
		{
			foreach($r as $_r)
			{
				if($_r['form']=='select' || $_r['form']=='radio'  || $_r['form']=='checkbox' || substr($_r['form'],0,11)=='selectmenu_')
				{
					$_G[]=$_r['enname'];
				}
			}

			$m=0;
			foreach($r as $_r)
			{
				$options=array();

				if($_r['form']=='select' || $_r['form']=='radio'  || $_r['form']=='checkbox' || substr($_r['form'],0,11)=='selectmenu_')
				{
					$fileds=cache_read('model_fields'.$_r['id'].'.cache.php',RETENG_ROOT.'data/c/');
					if(substr($_r['form'],0,11)!='selectmenu_')
					{
						$options=explode("\r\n",$fileds['options']);
					}
					else
					{
						//$js=cache_read('stepselect_enum'.substr($_r['form'],11).'.cache.php',RETENG_ROOT.'data/c/');
						$js=selectmenusearch(substr($_r['form'],11),$areaid);
						foreach($js as $key => $value)
						{
							$options[]=$key.'|'.$value;
						}
					}

					if($options)
					{
						$tstr='';
						$str.=($m?'<br />':'').'<span>'.$_r['name'].'：</span>';
						foreach($options as $i => $option)
						{
							if($option)
							{
								$querystring=array();
								$v=explode('|',$option);
								if($_GET)
								{
									if(!isset($_GET['modelid']))$_GET['modelid']=$modelid;
									if(!isset($_GET['catid']))$_GET['catid']=$catid;
									if(!isset($_GET['page']))$_GET['page']=1;
									foreach($_GET as $key => $val)
									{
										if(in_array($key,$_G) && $key!=$fileds['enname'])
										{
											$querystring[]=$key.'='.urlencode($val);
										}
									}
								}
								else
								{
									if($modelid)
									{
										$querystring[]='modelid='.intval($modelid);
									}
								}
								if($i==0)
								{
									$tstr.='<a href="search/index.php?'.implode('&',$querystring).'&'.$fileds['enname'].'=">'.(!isset($_GET[$fileds['enname']]) || empty($_GET[$fileds['enname']])?'<font class="redbg">':'').'不限'.(!isset($_GET[$fileds['enname']]) || empty($_GET[$fileds['enname']])?'</font>':'').'</a>&nbsp;&nbsp;';
								}

								$tstr.='<a href="search/index.php?'.implode('&',$querystring).'&'.$fileds['enname'].'='.urlencode($v[0]).'">'.(isset($_GET[$fileds['enname']]) && $_GET[$fileds['enname']]==$v[0]?'<font class="redbg">':'').$v[1].(isset($_GET[$fileds['enname']]) && $_GET[$fileds['enname']]==$v[0]?'</font>':'').'</a>&nbsp;&nbsp;';
							}
						}
						$str.=$tstr;
						$m++;
					}
				}
			}
		}
	}
	return $str;
}

/*
	多字段, 多图, 附件
*/
function morefield($mores,$limit="4") // 多字段调用 
{
	$result=$r=$t=array();
	if(!$mores)return $t;
	$t=explode("`",$mores);
	$i=1;
	if($t)foreach($t as $k => $_t)
	{
		if($_t && $i<=intval($limit))
		{
			$r=explode("|",$_t);
			$result[$k]['name']=$r[0];
			$result[$k]['url']=$r[1];
			$i++;
		}
	}
	return $result;
}

/*
	执行自定义函数
*/
function retengcms_call_user_func($function,$parameter,$extra='')
{
	$para=array();
	$parameter=preg_replace('/\"\s+\"/i','""',$parameter);
	$parameter=explode(" ",$parameter);

	if($parameter)
	{
		foreach($parameter as $val)
		{
			preg_match('/([0-9a-z_]+)\s*=\s*([^\s]+)/i',$val,$matches);
			$para[$matches[1]]=filterpara($matches[2]);
		}
	}

	if($extra)
	{
		preg_match('/([0-9a-z_]+)\s*=\"([^\"]+)\"/i',$extra,$matches);
		$para[$matches[1]]=filterpara($matches[2]);
	}
	return call_user_func($function,$para);
}

/*
	过滤参数
*/
function filterpara($para)
{
	return str_replace(array('\'','"'),'',stripslashes($para));
}

function is_email($email)
{
	if(!$email)return false;
	if(strlen(trim_str($email))>80)return false;
	return preg_match('/^\w+@\w+\.[0-9a-z\._\-]+$/i',trim_str($email));
}

function is_url($url)
{
	if(strlen(trim_str($url))>200)return false;
	return preg_match('/^http:\/\/\w+?.{4,200}$/i',trim_str($url));
}

function is_phone_fax($phone)
{
	if(strlen(trim_str($phone))>80)return false;
	return preg_match('/^[0-9\-\(\)]{3,50}$/i',trim_str($phone));
}

function is_postcode($postcode)
{
	if(strlen(trim_str($postcode))>10)return false;
	return preg_match('/^[0-9\-]{4,10}$/i',trim_str($postcode));
}

function retengcms_md5($str)
{
	return substr(md5($str),8,16);
}

function pageinfo($id)
{
	global $db;
	$r=$db->fetch_one("SELECT * FROM ".DB_PRE."page WHERE id=".intval($id));
	return $r['content'];
}

function ip2area($ip) 
{
	if(!preg_match("/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/", $ip)) 
	{
		return 'Unknown';
	}

	$fd = @fopen(RETENG_ROOT.'include/dict/ipdata.dat', 'rb');
	
	if(!$fd)
	{
		return 'Unknown';
	}

	$ip = explode('.', $ip);
	$ipNum = $ip[0] * 16777216 + $ip[1] * 65536 + $ip[2] * 256 + $ip[3];

	$DataBegin = fread($fd, 4);
	$DataEnd = fread($fd, 4);
	$ipbegin = implode('', unpack('L', $DataBegin));
	if($ipbegin < 0) $ipbegin += pow(2, 32);
	$ipend = implode('', unpack('L', $DataEnd));
	if($ipend < 0) $ipend += pow(2, 32);
	$ipAllNum = ($ipend - $ipbegin) / 7 + 1;

	$BeginNum = 0;
	$EndNum = $ipAllNum;

	while($ip1num > $ipNum || $ip2num < $ipNum) 
	{
		$Middle= intval(($EndNum + $BeginNum) / 2);

		fseek($fd, $ipbegin + 7 * $Middle);
		$ipData1 = fread($fd, 4);
		if(strlen($ipData1) < 4)
		{
			fclose($fd);
			return 'System Error';
		}
		$ip1num = implode('', unpack('L', $ipData1));
		if($ip1num < 0) $ip1num += pow(2, 32);

		if($ip1num > $ipNum) 
		{
			$EndNum = $Middle;
			continue;
		}

		$DataSeek = fread($fd, 3);
		if(strlen($DataSeek) < 3) 
		{
			fclose($fd);
			return 'System Error';
		}
		$DataSeek = implode('', unpack('L', $DataSeek.chr(0)));
		fseek($fd, $DataSeek);
		$ipData2 = fread($fd, 4);
		if(strlen($ipData2) < 4) 
		{
			fclose($fd);
			return 'System Error';
		}
		$ip2num = implode('', unpack('L', $ipData2));
		if($ip2num < 0) $ip2num += pow(2, 32);

		if($ip2num < $ipNum) 
		{
			if($Middle == $BeginNum) 
			{
				fclose($fd);
				return 'Unknown';
			}
			$BeginNum = $Middle;
		}
	}

	$ipFlag = fread($fd, 1);
	if($ipFlag == chr(1)) 
	{
		$ipSeek = fread($fd, 3);
		if(strlen($ipSeek) < 3) 
		{
			fclose($fd);
			return 'System Error';
		}
		$ipSeek = implode('', unpack('L', $ipSeek.chr(0)));
		fseek($fd, $ipSeek);
		$ipFlag = fread($fd, 1);
	}

	if($ipFlag == chr(2)) 
	{
		$AddrSeek = fread($fd, 3);
		if(strlen($AddrSeek) < 3) 
		{
			fclose($fd);
			return 'System Error';
		}
		$ipFlag = fread($fd, 1);
		if($ipFlag == chr(2)) 
		{
			$AddrSeek2 = fread($fd, 3);
			if(strlen($AddrSeek2) < 3) 
			{
				fclose($fd);
				return 'System Error';
			}
			$AddrSeek2 = implode('', unpack('L', $AddrSeek2.chr(0)));
			fseek($fd, $AddrSeek2);
		} 
		else 
		{
			fseek($fd, -1, SEEK_CUR);
		}

		while(($char = fread($fd, 1)) != chr(0))
			$ipAddr2 .= $char;

		$AddrSeek = implode('', unpack('L', $AddrSeek.chr(0)));
		fseek($fd, $AddrSeek);

		while(($char = fread($fd, 1)) != chr(0))
			$ipAddr1 .= $char;
	} 
	else 
	{
		fseek($fd, -1, SEEK_CUR);
		while(($char = fread($fd, 1)) != chr(0))
			$ipAddr1 .= $char;

		$ipFlag = fread($fd, 1);
		if($ipFlag == chr(2)) 
		{
			$AddrSeek2 = fread($fd, 3);
			if(strlen($AddrSeek2) < 3) 
			{
					fclose($fd);
					return 'System Error';
			}
			$AddrSeek2 = implode('', unpack('L', $AddrSeek2.chr(0)));
			fseek($fd, $AddrSeek2);
		} 
		else 
		{
			fseek($fd, -1, SEEK_CUR);
		}
		while(($char = fread($fd, 1)) != chr(0))
			$ipAddr2 .= $char;
	}
	fclose($fd);

	if(preg_match('/http/i', $ipAddr2)) 
	{
		$ipAddr2 = '';
	}
	$ipaddr = "$ipAddr1 $ipAddr2";
	$ipaddr = preg_replace('/CZ88\.NET/is', '', $ipaddr);
	$ipaddr = preg_replace('/^\s*/is', '', $ipaddr);
	$ipaddr = preg_replace('/\s*$/is', '', $ipaddr);
	if(preg_match('/http/i', $ipaddr) || $ipaddr == '') 
	{
		$ipaddr = 'Unknown';
	}

	return iconv('GBK','utf-8//IGNORE',$ipaddr);
}

function deletebutton($contentid)
{
	global $RETENG;
	return '<link href="'.SITE_URL.'images/css/dialog.css" rel="stylesheet" type="text/css" /><script language="javascript" type="text/javascript" src="images/js/dialog.js"></script>
<script language="javascript" type="text/javascript" src="images/js/system.js"></script><a href="javascript:void(0);" onclick="javascript:openDialog(\'删除信息\',\''.SITE_URL.'api/check/delete.php?contentid='.intval($contentid).'\',325,70);">删除</a> ';
}

function loadmap($map,$width="550",$height="450",$api="myMap")
{
	include_once RETENG_ROOT.'api/map/map_api_'.MAPAPI.'.php';
	return loadmap_api($map,$width,$height,$api);
}



function editor($fieldname,$value='',$fieldid)
{
			return '
			<textarea name="'.$fieldname.'" id="retengcms_'.$fieldid.'"  style="width:800px;height:200px;" >'.$value.'</textarea>
			<script type="text/javascript">
			   
				var '.$fieldid.'ue = UE.getEditor(\'retengcms_'.$fieldid.'\',{allowDivTransToP:false});
				 
			</script>';
	}
function sueditor($fieldname,$value='',$fieldid)
{
			return '
			<textarea name="'.$fieldname.'" id="retengcms_'.$fieldid.'"  style="width:800px;height:200px;" >'.$value.'</textarea>
			<script type="text/javascript">
			   
			var '.$fieldid.'ue = UE.getEditor(\'retengcms_'.$fieldid.'\',{
			toolbars: [["fullscreen","Source","undo","redo","unlink","link","selectall","insertimage","bold","italic","underline","backcolor","removeformat","autotypeset"]],
		    autoClearinitialContent:true,
            wordCount:false,
            elementPathEnabled:false,
            initialFrameHeight:300,
			allowDivTransToP:false});
			</script>';
}

//创建变量
function createform($type,$varname,$varvalue)
{
		switch($type)
		{
			case "string":
				return '
					<input type="text" name="mem['.$varname.']" size="40" value="'.htmlspecialchars($varvalue).'" />
				';
			break;
			case "number":
				return '
					<input type="text" name="mem['.$varname.']" size="8" value="'.htmlspecialchars($varvalue).'" />
				';
			break;
			case "bool":
				$checked="";
				$unchecked="";
				if(htmlspecialchars($varvalue))
				{
					$checked="checked='checked'";
				}else
				{
					$unchecked="checked='checked'";
				}
				return '
					是<input type="radio" name="mem['.$varname.']" '.$checked.' value="1" />
					否<input type="radio" name="mem['.$varname.']" '.$unchecked.' value="0" />
				';
			break;
			case "bstring":
				return '
					<textarea name="mem['.$varname.']" cols="60" rows="5">'.htmlspecialchars($varvalue).'</textarea>
				';
			break;
			case "editor":
				return '
				<textarea name="mem['.$varname.']" id="ed_'.$varname.'"   style="width:690px;height:200px;" >'.$varvalue.'</textarea>
			    <script type="text/javascript">
				  var '.$varname.'ue = UE.getEditor(\'ed_'.$varname.'\');
			     </script>';
			break;
			case "sueditor":
				return '
				<textarea name="mem['.$varname.']" id="ed_'.$varname.'"   style="width:690px;height:200px;" >'.$varvalue.'</textarea>
			    <script type="text/javascript">
				  var '.$varname.'ue = UE.getEditor(\'ed_'.$varname.'\',{
				toolbars: [["fullscreen","Source","undo","redo","unlink","link","selectall","insertimage","bold","italic","underline","backcolor","removeformat","autotypeset"]],
		    autoClearinitialContent:true,
            wordCount:false,
            elementPathEnabled:false,
            initialFrameHeight:100,
			allowDivTransToP:false}
				  );
			     </script>';
			break;	
			
			case "image":
				return '
					<script type="text/plain" id="reteng_'.$varname.'" name="'.$varname.'"></script>
					<script type="text/javascript">
    					var '.$varname.' = new UE.ui.Editor();
						'.$varname.'.render("reteng_'.$varname.'");
       					'.$varname.'.ready(function(){
        				'.$varname.'.setDisabled();
        				'.$varname.'.setHide();//隐藏编辑器
        				'.$varname.'.addListener("beforeInsertImage",function(t,arg){ //侦听图片上传
         				$("#image_api_'.$varname.'").attr("value",arg[0].src);//将地址赋值给相应的input
         				})
    				 }) 
    				function upImage'.$varname.'(){  
        				var my'.$varname.'= '.$varname.'.getDialog("insertimage");
        				my'.$varname.'.open();     //打开dialog
  						}
					</script>
					<input type="text" id="image_api_'.$varname.'" name="mem['.$varname.']" size="45" value="'.$varvalue.'" /> 
					<input type="button" style="padding:1px" value="点击上传" onclick="upImage'.$varname.'();"/>';
			break;
		}
}
//检查模型是否安装
function md_installed($module)
{
		$r=cache_read('module'.$module.'.cache.php',RETENG_ROOT.'data/c/');
		return $r && $module?true:false;
}
?>