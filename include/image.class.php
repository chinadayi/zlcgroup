<?php
/**
* 图片加水印类
*/
class image
{
	public $info=array();
	function __construct()
	{
		!extension_loaded('gd') && exit("服务器环境不支持GD库");
		return true;
	}
	function image()
	{
		$this->__construct();
	}
	function watermark($image,$pos=9,$watermarkimg='images/watermark.png',$pct=65,$text='',$w_font=5,$w_color='#FF0000')
	{
		$imageinfo=$this->info($image);
		$source_w=$imageinfo['width'];
		$source_h=$imageinfo['height'];
		$imagecreatefunc='imagecreatefrom'.($imageinfo['type']=='jpg'?'jpeg':$imageinfo['type']);
		$imagecreatefunc='imagecreatefrom'.($imageinfo['type']=='bmp'?'wbmp':($imageinfo['type']=='jpg'?'jpeg':$imageinfo['type']));

		$im=$imagecreatefunc($image);
		$text=$text?$text:WATERMARK_WORDS;
		if(!empty($watermarkimg) && file_exists($watermarkimg)) //添加图片水印
		{
			$iswaterimage=true;
			$watermarkinfo=$this->info($watermarkimg);
			$width=$watermarkinfo['width'];
			$height=$watermarkinfo['height'];
			$watermarkcreatefunc='imagecreatefrom'.($watermarkinfo['type']=='jpg'?'jpeg':$watermarkinfo['type']);
			$watermark_im=$watermarkcreatefunc($watermarkimg);
		}
		else //添加文字水印
		{
			$iswaterimage=false;
			if(!empty($w_color) && strlen($w_color)==7)
			{
				$r=hexdec(substr($w_color,1,2));
				$g=hexdec(substr($w_color,3,2));
				$b=hexdec(substr($w_color,5,2));
			}
			$temp = imagettfbbox(ceil($w_font*2.5), 0, 'fonts/elephant.ttf', $text);
			$width = $temp[2] - $temp[6];
			$height = $temp[3] - $temp[7];
			unset($temp);
		}
		switch($pos)
		{
			case 0:
				$wx = mt_rand(0,($source_w - $width));
				$wy = mt_rand(0,($source_h - $height));
				break;
			case 1:
				$wx = 5;
				$wy = 5;
				break;
			case 2:
				$wx = ($source_w - $width) / 2;
				$wy = 5;
				break;
			case 3:
				$wx = $source_w - $width-5;
				$wy = 5;
				break;
			case 4:
				$wx = 5;
				$wy = ($source_h - $height) / 2;
				break;
			case 5:
				$wx = ($source_w - $width) / 2;
				$wy = ($source_h - $height) / 2;
				break;
			case 6:
				$wx = $source_w - $width-5;
				$wy = ($source_h - $height) / 2;
				break;
			case 7:
				$wx = 5;
				$wy = $source_h - $height-5;
				break;
			case 8:
				$wx = ($source_w - $width) / 2;
				$wy = $source_h - $height-5;
				break;
			default:
				$wx = $source_w - $width-5;
				$wy = $source_h - $height-5;
				break;
		}
		if($iswaterimage)
		{
			if($imageinfo['type'] == 'png') {
				imagecopy($im, $watermark_im, $wx, $wy, 0, 0, $width, $height);
			} else {
				imagecopymerge($im, $watermark_im, $wx, $wy, 0, 0, $width, $height, $pct);
			}
		}
		else
		{
			imagestring($im,$w_font,$wx,$wy,$text,imagecolorallocate($im,$r,$g,$b));
		}
		$imagefunc='image'.($imageinfo['type']=='jpg'?'jpeg':$imageinfo['type']);
		$imagefunc='image'.($imageinfo['type']=='bmp'?'wbmp':($imageinfo['type']=='jpg'?'jpeg':$imageinfo['type']));
		$imagefunc($im,$image);
		imagedestroy($im);
		return true;
	}

	function info($image)
	{
		$info=array();
		$t=basename($image);
		$t=explode('.',$t);
		$info['name']=$t[0];
		$info['size']=filesize($image);
		$imageinfo=getimagesize($image);
		$info['width']=$imageinfo[0];
		$info['height']=$imageinfo[1];
		$info['width_height']=$imageinfo[3];
		$info['mime']=$imageinfo['mime'];
		unset($imageinfo);
		$imageinfo=pathinfo($image);
		$info['path']=$imageinfo['dirname'].'/'; 
		$info['type']=strtolower($imageinfo['extension']);
		unset($imageinfo,$name);
		$this->info=$info;
		return $info;
	}
}
?>