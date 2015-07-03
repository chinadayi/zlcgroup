<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(10,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $lang['LEFT-TEMPLATE-4'];?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
</head>
<style type="text/css">
body,table,tr,td,input{font-family:"宋体"}
</style>
<body>
<div id="css1" style="display:none">
<?php 
echo '·<a href="{field:url}" title="{field:title}" target="_blank">{sub_string(field:title,20)}</a>{date("m-d",field:updatetime)}<br/>';
?>
</div>
<div id="css2" style="display:none">
<?php 
echo '·[{getCategoryname(field:catid)}] <a href="{field:url}" title="{field:title}" target="_blank">{sub_string(field:title,20)}</a>{date("m-d",field:updatetime)}<br/>';
?>
</div>
<div id="css3" style="display:none">
<?php 
echo '<table border=0 cellspacing=2 cellpadding=0 width="98%">
<tbody>
<tr>
<td align=middle><a href="{field:url}" title="{field:title}" target="_blank"><img src="{field:thumb}" alt="{field:title}" width="120" height="100" /></a></td></tr>
<tr>
<td align=middle><a href="{field:url}" title="{field:title}" target="_blank">{sub_string(field:title,20)}</a></td></tr></tbody></table>';
?>
</div>
<div id="css4" style="display:none">
<?php 
echo '<table border=0 cellspacing=2 cellpadding=2 width="100%">
<tbody>
<tr>
<td rowspan=2 width="30%" align=middle><a href="{field:url}" title="{field:title}" target="_blank"><img src="{field:thumb}" alt="{field:title}" width="120" height="100" /></a></td>
<td width="70%"><a href="{field:url}" title="{field:title}" target="_blank">{sub_string(field:title,20)}</a></td></tr>
<tr>
<td>{field:description}</td></tr></tbody></table>';
?>
</div>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="javascript:void(0);" class="on"><?php echo $lang['LEFT-TEMPLATE-6'];?></a></li>			
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		1：通过数据调用可以方便的调用所有内容数据； 2：更多帮助文档请参看http://doc.reteng.org/
	</fieldset>	
		
		<table cellspacing="0" class="sub" style="width:98%; margin:0px auto">
				 <tr>
				  <td colspan="2" style="padding-left:10px">
				  显示样式：<br />
				<img src="admin/template/images/001.gif" /><input type="radio" class="radio" name="tag[tlp]" checked="checked" onclick="$('#tlpid').val($('#css1').html().replace('<BR>','<BR />').toLowerCase());$('#thumb').attr('checked',false);" />
				&nbsp;&nbsp;&nbsp;&nbsp;
				<img src="admin/template/images/002.gif" /><input type="radio" class="radio" name="tag[tlp]" onclick="$('#tlpid').val($('#css2').html().replace('<BR>','<BR />').toLowerCase());$('#thumb').attr('checked',false);" />
				&nbsp;&nbsp;&nbsp;&nbsp;
				<img src="admin/template/images/003.gif" /><input type="radio" class="radio" name="tag[tlp]" onclick="$('#tlpid').val($('#css3').html().replace('<BR>','<BR />').toLowerCase());$('#thumb').attr('checked',true);" />
				&nbsp;&nbsp;&nbsp;&nbsp;
				<img src="admin/template/images/004.gif" /><input type="radio" class="radio" name="tag[tlp]" onclick="$('#tlpid').val($('#css4').html().replace('<BR>','<BR />').toLowerCase());$('#thumb').attr('checked',true);" />
				</td></tr>
				<tr>
				   <td colspan="2" height="30" style="padding-left:10px">调用栏目ID：
				  <select id="catid" style="width:150px" multiple="multiple" size="10">
					  <option value="$catid" selected="selected">根据当前栏目读取</option>
					  <option value="all">不限栏目</option>
					  <?php $options->catoptions();?>
				  </select>
				  <font color="#FF0000">*根据当前栏目读取只适用于栏目页，内容页模板，不适用于首页模板</font>		  
				  </td>
				</tr>
				  <tr>
				   <td colspan="2" height="30" style="padding-left:10px">含有关键字：
				  <input type="text" id="keyword" size="20" value="" />
				  <font color="#FF0000">*多个关键字用英文逗号 "," 隔开</font>
				  <input type="checkbox" class="checkbox" onclick="if(this.checked)document.getElementById('keyword').value='$keywords'; else document.getElementById('keyword').value=''" value="1" />读取内容页相关内容  
				  </td>
				</tr>
				  <tr>
				  <td colspan="2" height="30" style="padding-left:10px">只读取有图片的内容： 
				<input type="checkbox" class="checkbox" id="thumb" value="1" />是
				</td></tr>
				 <tr>
				  <td colspan="2" height="30" style="padding-left:10px">				
				内容读取条数：  
				<input type="text" id="number" size="2" value="10" /> 条
				忽略前 <input type="text" id="limit" size="2" value="0" /> 条信息  
				</td></tr>
				<tr>
				   <td colspan="2" height="30" style="padding-left:10px">内容页推荐位： 
				<?php echo $posid_select;?>
				</td></tr>
				<tr>
				   <td colspan="2" height="30" style="padding-left:10px">显示排序方式：
				<select id="orderby">
					<option value="id" >ID</option>
					<option value="updatetime" >更新时间</option>
					<option value="inputtime" >发布时间</option>
					<option value="orderby" >排序</option>
					<option value="clicks" >点击</option>
					<option value="comments" >评论</option>
				</select>
				<select id="orderbyway">
					<option value="ASC" >升序</option>
					<option value="DESC" selected>降序</option>
				</select>
				</td></tr>
				<tr>
				  <td colspan="2" style="padding-left:10px">
				  读取字段：模板调用方法<br /> 
				  <table width="100%" cellspacing="0" cellpadding="0">
				  	<tr>		
						<td style="color:#0000ff">栏目ID： {field:catid}</td>
						<td style="color:#0000ff">栏目名称： {catname(field:catid)}</td>
					</tr>
					<tr>
						<td style="color:#0000ff">内容ID： {field:id}</td>
						<td style="color:#0000ff">内容标题： {field:title}</td>
						<td style="color:#0000ff">内容摘要： {field:description} </td>
						<td style="color:#0000ff">发布日期： {date('Y-m-d H:i:s',field:inputtime)} </td>
					</tr>
					<tr>
						<td style="color:#0000ff">用户ID： {field:userid}</td>
						<td style="color:#0000ff">用 户 名： {field:username} </td>
						<td style="color:#0000ff">内容链接： {field:url}</td>
						<td style="color:#0000ff">点 击 数： {field:clicks}</td>
						
					</tr>
					<tr>
						<td style="color:#0000ff">关键字： {field:keywords} </td>
						<td style="color:#0000ff">评 论 数： {field:comments}</td>
						<td style="color:#0000ff">缩略图： {field:thumb}</td>
						<td style="color:#0000ff">更新日期： {date('Y-m-d H:i:s',field:updatetime)}</td>
					</tr>
					<tr>
				 	 <td colspan="4" height="30">同时读取自定义的字段： 
					<input type="checkbox" class="checkbox" id="ismore" value="1" />是
					<font color="#FF0000">*如果您想读取除了以上列出的字段外的自定义字段，请勾选此项。调用方法：{field:字段名}</font>	
					</td></tr>
				  </table>

				 显示模板：<br />
				 <textarea cols="120" id="tlpid" rows="13" style="font-family:'宋体'">·<a title="{field:title}" href="{field:url}" target="_blank">{sub_string(field:title,20)}</a>{date("m-d",field:updatetime)}<br /></textarea>
				  </td></tr>
				  <tr>
				  <td colspan="2" align="center">
				 <input type="button" onclick="get_tag();" value="生成调用标记" class="button" />
				  </td></tr>
				  <tr>
				  <td colspan="2" style="padding-left:10px">
				  输出结果<br />
				  <span id="msg" style="color:#ff0000; font-family:'宋体'"></span><br />
				 <textarea cols="120" rows="13" id="resultid" style="font-family:'宋体'"></textarea>
				  </td></tr>
			</table>
		<script language="javascript">
			function get_tag()
			{
				var withthumb=$('#thumb').attr('checked')==true?1:0;
				var ismore=$('#ismore').attr('checked')==true?1:0;
				$('#resultid').val('{reteng:content catid="'+$('#catid').val()+'" posid="'+$('#posid').val()+'" row="'+$('#number').val()+'" limit="'+$('#limit').val()+'" withthumb="'+withthumb+'" orderby="'+$('#orderby').val()+'" orderbyway="'+$('#orderbyway').val()+'" keyword="'+$('#keyword').val()+'" ismore="'+ismore+'"}\n'+$('#tlpid').val()+'\n{/reteng:content}\n');
				$('#msg').html('↓将以下代码贴到模板的对应位置');
			}
		</script>
	</div>
</div>
</body>
</html>
