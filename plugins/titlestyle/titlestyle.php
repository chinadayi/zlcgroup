<?php
/**
	Plugins Name:标题加色加粗简化显示插件 UTF-8
	Plugins Description:标题加色加粗插件，适用于ReTengCMS 所有 UTF-8版本。模板调用方法 <a href="{field:url}" title="{field:title}"{title_style(field:style)}>{field:title}</a> （用于列表页）
	Plugins Author:ReTengCMS官方
	Plugins Url:http://www.reteng.org
**/

function title_style($style)
{
	$style=trim($style);
	if($style)
	{
		return ' style="'.$style.'"';
	}
	return '';
}
?>
