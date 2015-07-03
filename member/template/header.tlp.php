<?php
	!defined('MEMBER_CENTER') && exit('Access Denied!');
?>
<script language="javascript" src="images/js/css.js"></script>
<script type="text/javascript" charset=utf-8 src="ueditor/ueditor.config.js" ></script>
<script type="text/javascript" charset=utf-8 src="ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset=utf-8 src="ueditor/lang/zh-cn/zh-cn.js" ></script>
<div id="header">
<div id="logo">
<h1><a href="member/index.php"><?php echo $memlang['member-center'];?></a></h1>
</div>
<div class="menu"><a href="<?php echo $RETENG['site_url'];?>" target="_blank"><?php echo $memlang['index'];?></a> <?php if($_groupid==1){?>| <a href="<?php echo ADMIN_FILE;?>" target="_blank"><?php echo $memlang['system-config'];?></a><?php }?></div>
<div id="nav">
<ul class="clearfix">
<li class="home"><a href="member/index.php"><?php echo $memlang['member-index'];?></a></li>
<li class="li"><a href="member/index.php?file=msg&action=inbox"><?php echo $memlang['message'];?></a></li>
<li><a href="member/index.php?file=user&action=edit"><?php echo $memlang['user-info'];?></a></li>
<li class="li"><a href="member/index.php?file=user&action=collect"><?php echo $memlang['collect'];?></a></li>
<li class="li"> &nbsp;&nbsp;&nbsp;<a href="<?php echo $RETENG['site_url'];?>" target="_blank"><?php echo $memlang['index'];?></a></li>
<li><a href="member/index.php?file=login&action=logout"><?php echo $memlang['logout'];?></a></li>
</ul>
</div>
</div>
