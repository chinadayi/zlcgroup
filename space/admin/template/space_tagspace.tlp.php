<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('space',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>数据调用</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
</head>
<style type="text/css">
body,table,tr,td,input{font-family:"宋体"}
</style>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="?mod=space&file=space&action=manage">空间管理</a></li>
			<li><a href="javascript:void(0);" class="on">空间调用</a></li>
			<li><a href="?mod=space&file=space&action=tag">留言调用</a></li>			
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend>操作提示</legend>
		1：通过内容调用可以方便的调用所有内容数据； 2：更多帮助文档请参看http://doc.retengcms.com/
	</fieldset>	
		
		<table cellspacing="0" class="sub">
				<tr>
				<td colspan="2" height="30" style="padding-left:10px">
				读取条数：  
				<input type="text" id="number"  size="5" value="10" /> 条 
				&nbsp;&nbsp;列表分页：<input type="checkbox" class="checkbox" id="page" value="1" />是
				只读取推荐的空间： 
				<input type="checkbox" id="isindex" value="1" />是
				</td></tr>
				<tr>
				  <td colspan="2" style="padding:10px">
				  读取字段：模板调用方法<br /> 
				  <span style="color:#0000FF"> 空间名称： {field:name} 空间LOGO： {field:logo} 空间Banner： {field:banner} ： 访问次数: {field:visits} <br />开通日期： {date('Y-m-d H:i:s',field:opentime)} </span>
				  <br />
				 显示模板：<br />
				 <textarea cols="120" id="tlpid" rows="13" style="font-family:'宋体'"><img src="{field:logo}" /> 空间名称：{field:name} 开通日期：{date('Y-m-d H:i:s',field:opentime)}  访问次数: {field:visits}<br /></textarea>
				  </td></tr>
				<tr>
				  <td height="40" colspan="2" align="center">
				 <input type="button" onclick="get_tag();" value="生成空间调用标记" class="button" />
				</td></tr>
				<tr>
				  <td colspan="2" style="padding-left:10px">
				  输出结果<br />
				  <span id="msg" style="color:#ff0000; font-family:'宋体'"></span><br />
				 <textarea cols="120" rows="13" id="resultid" style="font-family:'宋体'"></textarea>
				  </td></tr>
				  <tr>
				  	<td colspan="2" height="100"></td>
				  </tr>
			</table>
		<script language="javascript">
			function get_tag()
			{
				var isindex=$('#isindex').attr('checked')==true?1:0;
				var page=$('#page').attr('checked')==true?'$page':0;
				var pagestr=$('#page').attr('checked')==true?'{$reteng_page}':'';
				$('#resultid').val('{reteng:space row="'+$('#number').val()+'" page="'+page+'" isindex="'+isindex+'"}\n'+$('#tlpid').val()+'\n{/reteng:space}\n'+pagestr);
				$('#msg').html('↓将以下代码贴到模板的对应位置');
			}
		</script>
	</div> 
</div>
</body>
</html>
