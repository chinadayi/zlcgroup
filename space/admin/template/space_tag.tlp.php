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
			<li><a href="?mod=space&file=space&action=tagspace">空间调用</a></li>
			<li><a href="javascript:void(0);" class="on">留言调用</a></li>			
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend>操作提示</legend>
		1：通过内容调用可以方便的调用所有内容数据； 2：更多帮助文档请参看http://doc.reteng.org/
	</fieldset>	
		
		<table cellspacing="0" class="sub">
			<tr>
				<td colspan="2" height="30" style="padding-left:10px">
				空 间 ID：  
				<input type="text" id="spaceid"  size="5" value="0" />
				&nbsp;&nbsp;&nbsp;&nbsp;自动读取：<input type="checkbox" class="checkbox" onclick="if(this.checked)document.getElementById('spaceid').value='$id'; else document.getElementById('spaceid').value='0'" value="1" />是  &nbsp;&nbsp;<font color="#ff0000">* 0为不限空间ID</font>
				</td></tr>
				<tr>
				<td colspan="2" height="30" style="padding-left:10px">
				读取条数：  
				<input type="text" id="number"  size="5" value="10" /> 条 
				&nbsp;&nbsp;列表分页：<input type="checkbox" class="checkbox" id="page" value="1" />是
				</td></tr>
				<tr>
				  <td colspan="2" style="padding:10px">
				  读取字段：模板调用方法<br /> 
				  <span style="color:#0000FF"> 留言用户： {field:guestname} 用户ID： {field:guestid} 用户头像： {field:guestface} 留言内容： {field:content} <br />留言日期： {date('Y-m-d H:i:s',field:addtime)} 留言者IP： {field:ip} </span>
				  <br />
				 显示模板：<br />
				 <textarea cols="120" id="tlpid" rows="13" style="font-family:'宋体'"><div><span style="float:left">网友 [{field:guestname}]：</span><span style="float:right; color:#666">{date('Y-m-d H:i:s',field:addtime)}</span></div>
<div>{field:content}</div></textarea>
				  </td></tr>
				<tr>
				  <td height="40" colspan="2" align="center">
				 <input type="button" onclick="get_tag();" value="生成空间留言调用标记" class="button" />
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
				var page=$('#page').attr('checked')==true?'$page':0;
				var pagestr=$('#page').attr('checked')==true?'{$reteng_page}':'';
				$('#resultid').val('{reteng:space_guestbook spaceid="'+$('#spaceid').val()+'" row="'+$('#number').val()+'" page="'+page+'"}\n'+$('#tlpid').val()+'\n{/reteng:space_guestbook}\n'+pagestr);
				$('#msg').html('↓将以下代码贴到模板的对应位置');
			}
		</script>
	</div> 
</div>
</body>
</html>
