<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head id="Head1">
<title><?php echo catname($catid);?>-<?php echo $RETENG[site_name];?></title>
<meta name="keywords" content="<?php echo $head[keywords];?>" />
<meta name="description" content="<?php echo $head[description];?>" />
<meta name="generator" content="ReTeng.Org" />
<meta name="author" content="ReTeng.Org" />
<meta name="copyright" content="2014 热腾网" />
<link rel="shortcut icon" href="/favicon.ico"/>
<link rel="bookmark" href="/favicon.ico"/>
<link rel="stylesheet" href="<?php echo $RETENG['retengcms_path'];?>skin/css/style.css" />
</head>
<body oncontextmenu="return false" ondragstart="return false" onSelectStart="return false">
<?php include template('header');?>
<div class="about_banner">
</div>
<div class="about_content">
	<div class="gykx">
		<div class="gykx_title">
			<img src="<?php echo $RETENG['retengcms_path'];?>skin/images/about_title.gif" />
		</div>
<?php echo $content;?>
	</div>
	<div class="gsxd">
		<ul>
			<li>
				<img src="<?php echo $RETENG['retengcms_path'];?>skin/images/about_img_01.jpg" /> <img src="<?php echo $RETENG['retengcms_path'];?>skin/images/about_ln.gif" /> 
				<p>
					追求卓越品质，提供完美服务<br />
客户至上，技术为本，诚实守信，服务取胜。
				</p>
			</li>
			<li>
				<img src="<?php echo $RETENG['retengcms_path'];?>skin/images/about_img_02.jpg" /> <img src="<?php echo $RETENG['retengcms_path'];?>skin/images/about_sm.gif" /> 
				<p>
					中联创将秉承开放、创新的发展理念，以满足客户的多层次需求为目标，实现客户价值。
				</p>
			</li>
			<li style="border-right:1px dotted #000;">
				<img src="<?php echo $RETENG['retengcms_path'];?>skin/images/about_img_03.jpg" /> <img src="<?php echo $RETENG['retengcms_path'];?>skin/images/about_zz.gif" /> 
				<p>
					致力于网络开发和企业信息化事业，实现企业信息化道路。 公司主营 短信群发，专业网页制作，专业软件开发。
				</p>
			</li>
		</ul>
	</div>
</div>     
<?php include template('footer');?>
</body>
</html>