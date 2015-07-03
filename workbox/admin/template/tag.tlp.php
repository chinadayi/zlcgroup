<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('workbox',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>数据调用</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script language="javascript" src="admin/template/js/css.js"></script>
</head>
<style type="text/css">
body,table,tr,td,input{font-family:"宋体"}
</style>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="javascript:void(0);" class="on">数据调用</a></li>			
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend>操作提示</legend>
		1：通过内容调用可以方便的调用所有内容数据； 2：更多帮助文档请参看http://doc.reteng.org/
	</fieldset>	
		
		<table cellspacing="0" class="sub" style="width:98%; margin:0px auto">
				<tr>
				<td colspan="2" height="30" style="padding-left:10px" valign="top">
				所属工具： 
				<select id="boxid"  size="1"> 
				<?php
				if($boxinfo)foreach($boxinfo as $type)
				{
					echo '<option value="'.$type['id'].'" selected="selected">'.$type['name'].'(ID:'.$type['id'].')</option>';
				}
				?>
				</select>
				</td></tr>
				<tr>
				<td colspan="2" height="30" style="padding-left:10px">
				读取条数：  
				<input type="text" id="number"  size="5" value="10" /> 条 
				</td></tr>
				<tr>
				  <td colspan="2" style="padding:10px">
				  读取字段：模板调用方法<br /> 
				  <span style="color:#0000FF"> 选项名称： {field:name}  链接地址： {field:url}<br /> 
				  选项LOGO： {field:image} </span>
				  <br />
				 显示模板：<br />
				 <textarea cols="120" id="tlpid" rows="13" style="font-family:'宋体'"><a href="{field:url}" target="_blank"><font color="{field:style}">{field:name}</font></a>&nbsp;</textarea>
				  </td></tr>
				<tr>
				  <td height="40" colspan="2" align="center">
				 <input type="button" onclick="get_tag();" value="生成调用标记" class="button" />
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
				$('#resultid').val('{reteng:tools row="'+$('#number').val()+'" boxid="'+$("#boxid").val()+'"}\n'+$('#tlpid').val()+'\n{/reteng:tools}\n');
				$('#msg').html('↓将以下代码贴到模板的对应位置');
			}
		</script>
	</div>
</div>
</body>
</html>
