<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('link',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
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
<div id="css1" style="display:none">
<a title="{field:introduce}" href="{field:url}" target="_blank">{field:name}</a>&nbsp;
</div>
<div id="css2" style="display:none">
<a title="{field:introduce}" href="{field:url}" target="_blank"><img src="{field:logo}" width="80" height="36" alt="{field:name}" /></a>&nbsp;
</div>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="javascript:void(0);" class="on">友链调用</a></li>			
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
				链接类型： 
				<select id="typeid" multiple="multiple" size="10"> 
				<?php
				if($typeinfo)foreach($typeinfo as $type)
				{
					echo '<option value="'.$type['id'].'" selected="selected">'.$type['name'].'(ID:'.$type['id'].')</option>';
				}
				?>
				</select>
				<span>按住 Ctrl 可多选!</span>
				</td></tr>
				<tr>
				<td colspan="2" height="30" style="padding-left:10px">
				含有LOGO：
				<input type="radio" class="radio"  name="tag[tlp]" checked="checked"  onclick="$('#tlpid').val($('#css1').html().replace('<BR>','<BR />').toLowerCase());$('#withlogo').val(0);" />所有链接 <input type="radio" class="radio" name="tag[tlp]" onclick="$('#tlpid').val($('#css2').html().replace('<BR>','<BR />').toLowerCase());$('#withlogo').val(1);" /> Logo链接
				<input type="hidden" id="withlogo" value="0" />
				</td></tr>
				<tr>
				<td colspan="2" height="30" style="padding-left:10px">
				读取条数：  
				<input type="text" id="number"  size="5" value="10" /> 条 
				&nbsp;&nbsp;只读取推荐的友链：<input type="checkbox" class="checkbox" id="isindex" value="1" />是
				</td></tr>
				<tr>
				  <td colspan="2" style="padding:10px">
				  读取字段：模板调用方法<br /> 
				  <span style="color:#0000FF"> 链接名称： {field:name}  链接URL： {field:url}<br /> 
				  链接LOGO： {field:logo} 链接说明： {field:introduce} 添加日期： {date('Y-m-d H:i:s',field:addtime)}</span>
				  <br />
				 显示模板：<br />
				 <textarea cols="120" id="tlpid" rows="13" style="font-family:'宋体'"><a title="{field:introduce}" href="{field:url}" target="_blank">{field:name}</a>&nbsp;</textarea>
				  </td></tr>
				<tr>
				  <td height="40" colspan="2" align="center">
				 <input type="button" onclick="get_tag();" value="生成友链调用标记" class="button" />
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
				var typeid=$("#typeid").val()==null?'all':$("#typeid").val();
				$('#resultid').val('{reteng:flink row="'+$('#number').val()+'" withlogo="'+$('#withlogo').val()+'" isindex="'+isindex+'" typeid="'+typeid+'"}\n'+$('#tlpid').val()+'\n{/reteng:flink}\n');
				$('#msg').html('↓将以下代码贴到模板的对应位置');
			}
		</script>
	</div>
</div>
</body>
</html>
