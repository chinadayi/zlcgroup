    <div class="footer">
        <div class="footer_nav">
		<a href="/">网站首页</a>
		<?php $_DATA=get_category_data(0,0,0,0,array (
  0 => 1,
  1 => 2,
  2 => 4,
),'top',8,3);$loopcatid=$catid;foreach($_DATA as $no => $r)if(is_array($r)){$catid=$r["id"];?>
		&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?php echo $r['url'];?>"><?php echo $r['catname'];?></a>
		<?php } $catid=isset($loopcatid)?$reteng_catid:0;unset($_DATA);?>
		</div>
        <div class="copyright"><?php echo $RETENG['copyright'];?>&nbsp;<a href="http://www.zlcgroup.com" target="_blank" title="中联创技术支持">Powered by ZLCGroup </a><br/><?php echo $RETENG['icpno'];?></div>
    </div>