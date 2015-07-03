<?php
/*
	感谢 cnfuxin 提供部分代码
	更新 2012-05-30 22:41
*/
	define('RETENG_ROOT', str_replace("\\", '/',substr(dirname(__FILE__),0,-7)));
	require_once RETENG_ROOT.'include/common.inc.php';
	$action=empty($action)?'files':trim($action);
	switch($action)
	{
		case 'distancepole':
			$window=isset($config)?'opener':'parent';
			$alert=isset($config)?'alert("地图标注成功!");':'';
			if(intval($x*$y) && is_numeric($x) && is_numeric($y))
			{
				echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>标注到地图</title> 
<script src="'.RETENG_PATH.'images/js/jquery.min.js"></script>
<style>
body,form,input{font-size:12px}
</style>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.3"></script>
</head>

<body>
<div id="myMap" style="position:relative; width:470px; height:340px;"></div>

<script type="text/javascript">
var map = new BMap.Map("myMap");                        // 创建Map实例
map.centerAndZoom(new BMap.Point( '.$x.', '.$y.' ), 16);     // 初始化地图,设置中心点坐标和地图级别
map.addControl(new BMap.NavigationControl());               // 添加平移缩放控件
map.addControl(new BMap.ScaleControl());                    // 添加比例尺控件
map.addControl(new BMap.OverviewMapControl());              //添加缩略地图控件
map.enableScrollWheelZoom();                  // 启用滚轮放大缩小。
map.enableKeyboard();                         // 启用键盘操作。
map.addEventListener("click", function(e){
var y=e.point.lat;
var x=e.point.lng;
$(window.'.$window.'.document).find("form[@name=\'myform\'] #'.$id.'").val(x+","+y);
'.$alert.'
});

</script>

</body>
</html>
';
			}
			else
			{
				echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>标注到地图 - Powered by DayuCMS</title> 
<style>
body,form,input{font-size:12px}
</style>
<script src="'.RETENG_PATH.'images/js/jquery.min.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.3"></script>
</head>

<body>
<div id="myMap" style="position:relative; width:470px; height:340px;"></div>

<script type="text/javascript">
var map = new BMap.Map("myMap");                        // 创建Map实例
map.centerAndZoom(new BMap.Point( '.MAP.' ), 16);     // 初始化地图,设置中心点坐标和地图级别
map.addControl(new BMap.NavigationControl());               // 添加平移缩放控件
map.addControl(new BMap.ScaleControl());                    // 添加比例尺控件
map.addControl(new BMap.OverviewMapControl());              //添加缩略地图控件
map.enableScrollWheelZoom();                  // 启用滚轮放大缩小。
map.enableKeyboard();                         // 启用键盘操作。
map.addEventListener("click", function(e){
var y=e.point.lat;
var x=e.point.lng;
$(window.'.$window.'.document).find("form[@name=\'myform\'] #'.$id.'").val(x+","+y);
'.$alert.'
});

</script>

</body>
</html>
';
			}
			exit();
			break;
		default:
			break;
	}

	function loadmap_api($map,$width="550",$height="450",$api="myMap")
	{
		return '<div id="'.$api.'" style="width:'.$width.'px; height:'.$height.'px; clear:both"></div><script type="text/javascript" src="http://api.map.baidu.com/api?v=1.3"></script>
		<script type="text/javascript">
			var map = new BMap.Map("myMap");
			var point = new BMap.Point('.$map.');
			map.centerAndZoom(point, 16);
			map.addControl(new BMap.NavigationControl());               // 添加平移缩放控件
			map.addControl(new BMap.ScaleControl());                    // 添加比例尺控件
			map.addControl(new BMap.OverviewMapControl());              //添加缩略地图控件
			map.enableScrollWheelZoom();                  // 启用滚轮放大缩小。
			map.enableKeyboard();                         // 启用键盘操作。
			var marker = new BMap.Marker(point);  // 创建标注
			map.addOverlay(marker);              // 将标注添加到地图中
			marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
		</script>';
	}
?>