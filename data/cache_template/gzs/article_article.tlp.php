<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head id="Head1">
<title><?php echo $title;?>-<?php echo $reteng_catname;?>-<?php echo $RETENG['site_name'];?></title>
<meta name="keywords" content="<?php echo $keywords;?>" />
<meta name="description" content="<?php echo $description;?>" />
<meta name="generator" content="ReTeng.Org" />
<meta name="author" content="ReTeng.Org" />
<meta name="copyright" content="2014 热腾网" />
<link rel="shortcut icon" href="/favicon.ico"/>
<link rel="bookmark" href="/favicon.ico"/>
<link rel="stylesheet" href="<?php echo $RETENG['retengcms_path'];?>skin/css/style.css" />
</head>
<body oncontextmenu="return false" ondragstart="return false" onSelectStart="return false">
<?php include template('header');?>
        <div class="news_info">
            <h2><a href="javascript:void(0)"><?php echo $title;?></a><h2>
            <p><?php echo $content;?></p>
        </div>
<?php include template('footer');?>
</body>
</html>
