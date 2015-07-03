<?php
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
<script language="javascript" src=" http://api.51ditu.com/js/maps.js "></script>
</head>

<body>
<div id="myMap" style="position:relative; width:470px; height:340px;"></div>

<script language="javascript">
	var maps = new LTMaps( "myMap" );
	maps. centerAndZoom ( new LTPoint( '.$x.', '.$y.' ) , 3 );
	var control = new LTStandMapControl();
	maps.addControl( control );  // 缩放工具条
	var control = new LTZoomInControl();
	maps.addControl( control );  //拉框放大控件
	var control = new LTMarkControl(); //标注控件
	maps.addControl( control );
	var marker1 = new LTMarker( new LTPoint( '.$x.', '.$y.' ) );
	maps.addOverLay( marker1 );
	function getPoi(){
	var poi = control.getMarkControlPoint();
	var y=poi.getLatitude();
	var x=poi.getLongitude();
	$(window.'.$window.'.document).find("form[@name=\'myform\'] #'.$id.'").val(x+","+y);
	'.$alert.'
}
LTEvent.addListener( control , "mouseup" , getPoi );
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
<script language="javascript" src=" http://api.51ditu.com/js/maps.js "></script>
</head>

<body>
<div id="myMap" style="position:relative; width:470px; height:340px;"></div>

<script language="javascript">
	var maps = new LTMaps( "myMap" );
	maps. centerAndZoom ( new LTPoint( '.MAP.' ) , 4 ); //地图定位
	var control = new LTStandMapControl();
	maps.addControl( control );  // 缩放工具条
	var control = new LTZoomInControl();
	maps.addControl( control );  //拉框放大控件
	var control = new LTMarkControl(); //标注控件
	maps.addControl( control );
	function getPoi(){
	var poi = control.getMarkControlPoint();
	var y=poi.getLatitude();
	var x=poi.getLongitude();
	$(window.'.$window.'.document).find("form[@name=\'myform\'] #'.$id.'").val(x+","+y);
	'.$alert.'
}
LTEvent.addListener( control , "mouseup" , getPoi );
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
		return '<div id="'.$api.'" style="width:'.$width.'px; height:'.$height.'px; clear:both"></div><script language="javascript" src="http://api.51ditu.com/js/maps.js "></script>
		<script language="javascript">
			var maps = new LTMaps( "myMap" );
			maps. centerAndZoom ( new LTPoint( '.$map.') , 3 );
			var control = new LTStandMapControl();
			maps.addControl( control );  // 缩放工具条
			var marker1 = new LTMarker( new LTPoint( {$map}) );
			maps.addOverLay( marker1 );
		</script>';
	}
?>