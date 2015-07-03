<?php
/**
* 生成验证码

* 类用法
* $checkcode=new checkcode();
* $checkcode->create_image();
* //取得验证
* $_SESSION['code']=$checkcode->get_code();
*/

class checkcode
{
	// 验证码宽度
	public $width=90;

	// 验证码高度
	public $height=35;
	
	// 验证码字体
	private $font;

	// 验证码字体颜色
	public $font_color;

	// 随机数
	private $charset='abcdefghkmnprstuvwyz123456789'; 

	// 设置背景色
	public $bgcolor='#EDF7FF';

	// 验证码字符数
	public $code_len=4;

	// 字体大小
	public  $font_size=18;

	// 验证码值
	public $code='ABCD';

	// 图像对象
	private $im;


	// 构造函数 设置字体路径
	function __construct()
	{
		$this->font=RETENG_ROOT.'include/fonts/big.ttf';
	}

	// 生成随机验证码
	protected function create_code()
	{
		$code='';
		if(function_exists('imagecreate'))
		{
			$len=strlen($this->charset)-1;
			for($i=0;$i<$this->code_len;$i++)
			{
				$code.=$this->charset[mt_rand(0,$len)];
			}
		}
		else
		{
			$code='abcd';
		}
		$this->code=$code;
	}

	// 获取验证码
	public function get_code()
	{
		return strtolower($this->code);
	}
	
	// 生成图片
	public function create_image()
	{
		header("pragma:no-cache\r\n");
		header("Cache-Control:no-cache\r\n");
		header("Expires:0\r\n");
		$code=$this->create_code();
		if(function_exists('imagecreate'))
		{
			header("content-type:image/png\r\n");
			$imagecreatefunc=function_exists('imagecreatetruecolor')?'imagecreatetruecolor':'imagecreate';
			$this->im=$imagecreatefunc($this->width,$this->height);

			// 字体颜色
			if(!$this->font_color) 
			{
				$this->font_color=imagecolorallocate($this->im,mt_rand(0,156),mt_rand(0,156),mt_rand(0,156));
			} 
			else 
			{
				$this->font_color=imagecolorallocate($this->im,hexdec(substr($this->font_color,1,2)),hexdec(substr($this->font_color,3,2)), hexdec(substr($this->font_color,5,2)));
			}

			// 填充背景色
			$bgcolor=imagecolorallocate($this->im,hexdec(substr($this->bgcolor,1,2)),hexdec(substr($this->bgcolor,3,2)),hexdec(substr($this->bgcolor,5,2)));
			imagefilledrectangle($this->im,0, $this->height,$this->width,0,$bgcolor);

			//添加杂色弧度
			imagesetthickness($this->im,3);
			$xpos=($this->font_size*2)+mt_rand(-5,5);
			$width=$this->width/2.66+mt_rand(3,10);
			$height=$this->font_size*2.14;
		
			if(mt_rand(0,100)%2==0) 
			{
			  $start=mt_rand(0,66);
			  $ypos=$this->height/2-mt_rand(10,30);
			  $xpos+=mt_rand(5,15);
			} 
			else
			{
			  $start=mt_rand(180,246);
			  $ypos=$this->height/2+mt_rand(10,30);
			}
			$end=$start+mt_rand(75,110);
			imagearc($this->im,$xpos,$ypos,$width,$height,$start,$end,$this->font_color);

			// 打印字符
			$x=$this->width/$this->code_len;
			for($i=0; $i<$this->code_len; $i++) 
			{
				imagettftext($this->im,$this->font_size,mt_rand(-30,30),$x*$i+mt_rand(0,5),$this->height/1.4,$this->font_color,$this->font,$this->code[$i]);
			}

			// 输出图像
			imagepng($this->im);

			// 释放内存
			imagedestroy($this->im);
		}
		else
		{
			header('Content-Type:image/jpeg');
			$fp=fopen(RETENG_ROOT.'images/vdcode.jpg','rb');
			echo fread($fp,filesize(RETENG_ROOT.'images/vdcode.jpg'));
			fclose($fp);
			exit();
		}
	}
}
?>