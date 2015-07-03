<?php
function createthumb1($img,$thumb_width,$thumb_height,$ctype="1")
{	
		if($img=="")
		{
			echo RETENG_PATH."images/nophoto.gif";
		}
		else
		{
		$info=imageinfo(RETENG_ROOT.$img);
		switch ($info['mime']) { 
				case "image/gif": 
					$infotype="gif"; 
				break; 
				case "image/jpeg": 
					$infotype="jpeg";  
				break; 
				case "image/png": 
					$infotype="png"; 
					break; 
				case "image/bmp": 
				$infotype="bmp"; 
				break; 
		} 
		$thumbname='thumb_'.$info['name'].'_'.$thumb_width.'x'.$thumb_height.'.'.$infotype;

		if(!file_exists($info['path'].$thumbname))
		{	

				$dst_h=$thumb_height;
				$dst_w=$thumb_width;
				$src_h=$info['height'];
				$src_w=$info['width'];
				$dst_scale = $dst_h/$dst_w; //目标图像长宽比
			    $src_scale = $src_h/$src_w; // 原图长宽比
				if($src_scale>=$dst_scale)
				{  
					// 过高
					$w = intval($src_w);
					$h = intval($dst_scale*$w);
					$x = 0;
					$y = ($src_h - $h)/3;
				}
				else
				{ 
				// 过宽
					$h = intval($src_h);
					$w = intval($h/$dst_scale);
					$x = ($src_w - $w)/2;
					$y = 0;
				}
				$thumb_width=intval($w);
				$thumb_height=intval($h);
				
			$scale = $dst_w/$w;
			$final_w = intval($w*$scale);
			$final_h = intval($h*$scale);
			
			$createfunc='imagecreatefrom'.($infotype=='jpg'?'jpeg':$infotype);
			$im=$createfunc(RETENG_ROOT.$img);
			if($infotype=='png'){
				imagesavealpha($im,true);
			}
			$thumb_im=$infotype!='gif' && function_exists('imagecreatetruecolor')?imagecreatetruecolor($w,$h):  imagecreate($w,$h);
			if($infotype=='png')
			{
				imagealphablending($thumb_im,false);
				imagesavealpha($thumb_im,true);
				
			}
			//imagecopy($thumb_im,$im,0,0,0,0,$src_w,$src_h);
			$bg=imagecolorallocate($thumb_im, 255, 255, 255);
			imagefill($thumb_im,0,0,$bg);
			imagecopy($thumb_im,$im,0,0,0,0,$src_w,$src_h);
			$thumb_im2=imagecreatetruecolor($dst_w, $dst_h);
			imagecopyresampled($thumb_im2,$thumb_im,0,0,0,0,$final_w+1,$final_h+1,$thumb_width,$thumb_height);
			
			$imagefunc='image'.($infotype=='jpg'?'jpeg':$infotype);
			$imagefunc($thumb_im2,$info['path'].$thumbname);
			imagedestroy($im);
			imagedestroy($thumb_im);
			imagedestroy($thumb_im2);
		}
		echo str_replace(RETENG_ROOT,"",$info['path']).$thumbname;
		}
		
}


function DateDiff($interval, $date1, $date2="") { 
    
    // @See: It gets the number of the seconds in the one of the 2nd period day interval.
	if(!$date2)
	{
		$date2=time();
	}
    $time_difference = $date2 - $date1; 
    switch ($interval) {
     
        case "w": $retval = bcdiv($time_difference, 604800); break; 
        case "d": $retval = bcdiv($time_difference, 86400);  break; 
        case "h": $retval = bcdiv($time_difference, 3600);   break; 
        case "n": $retval = bcdiv($time_difference, 60);     break; 
        case "s": $retval = $time_difference;                break; 
    } 
    
    return $retval;

}

function geturlfile($url)
	{
		$url=trim($url);
		$content='';
		if(extension_loaded('curl'))
		{
			$ch=curl_init();
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
			curl_setopt($ch,CURLOPT_HEADER,0);
			$content=curl_exec($ch);
			curl_close($ch);
		}
		else
		{
			$content=file_get_contents($url);
		}
		return trim($content);
}
function cwrite($cachename,$string,$path='')
{
	$path=empty($path)?CACHE_PATH:$path;
	$cachefile=$path.$cachename;
	@file_put_contents($cachefile,$string);
	@chmod($cachefile,0777);
	return RETENG_PATH."data/cache/".$cachename;
}
function jsonapi($url)
{
	$string=geturlfile($url);
	if($string)
	{
		$array=json_decode($string,true);
	}
	return $array;
	
}
function getkeywords($keywords)
{
	$keywords=str_replace(',','|',str_replace('，','|',str_replace(' ','|',trim($keywords))));	
	$arraykey=explode('|',$keywords);
	return $arraykey;
}

?>