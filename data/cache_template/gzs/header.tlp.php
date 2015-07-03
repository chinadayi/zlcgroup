        <div class="guding">
        <div class="head_bg">
            <div class=head>
                <div class="logo">
                    <h1><a href="/"><?php echo $RETENG['site_name'];?></a></h1>
                </div>
                <div class="phone">
                    咨询电话<br />
                    <?php echo $RETENG['telphone_one'];?><br />
                    <?php echo $RETENG['telphone_two'];?>
                </div>
                <div class="nav">
                    <ul>
					    <li><a href="/">网站首页</a></li>
					 <?php $_DATA=get_category_data(0,0,0,0,array (
  0 => 1,
  1 => 2,
  2 => 4,
),'top',8,2);$loopcatid=$catid;foreach($_DATA as $no => $r)if(is_array($r)){$catid=$r["id"];?>
                        <li><a href="<?php echo $r['url'];?>"><?php echo $r['catname'];?></a></li>
					 <?php } $catid=isset($loopcatid)?$reteng_catid:0;unset($_DATA);?>
					 <li style="background:none;"><a href="#"></a></li>
                    </ul>
                </div>
            </div>
        </div>
        </div>
<script src="<?php echo $RETENG['retengcms_path'];?>skin/js/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="<?php echo $RETENG['retengcms_path'];?>skin/js/helper.js" type="text/javascript"></script>
        <script type="text/javascript">
            var fileName = getUrl(),that;
            $(function() {
                change();
            });
        </script>