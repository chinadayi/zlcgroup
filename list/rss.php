<?php

require substr(dirname(__FILE__),0,-4).'/include/common.inc.php';

$head['title'] = $RETENG['site_name'].'-'.$RETENG['meta_title'];
$head['keywords'] = $RETENG['meta_keywords'];
$head['description'] = $RETENG['meta_description'];
$reteng_url=$RETENG['site_url'];

include template('index','rss');
	
	exit();
?>
