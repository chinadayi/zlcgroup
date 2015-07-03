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
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="javascript:void(0);" class="on"><?php echo $lang['LEFT-TEMPLATE-5'];?></a></li>			
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		1：通过数据调用可以方便的调用所有数据； 2：更多帮助文档请参看http://doc.reteng.org/
	</fieldset>	
		
		<table cellspacing="0" class="sub" width="98%" style="width:98%; margin:0px auto">
				<tr>
				<td colspan="2" height="30" style="padding-left:10px">
				(父)栏目ID：  
				<select id="categoryid">
					<option value="0">按变量读取</option>
					<?php $options->catoptions();?>
				</select>
				<span style="color:#FF3300"> 当调用类型为下级栏目时，该项是指父栏目ID；当调用类型为同级栏目时，该项是指栏目ID。</span>
				</td></tr>
				<tr>
				<td colspan="2" height="30" style="padding-left:10px">
				读取条数：  
				<input type="text" id="number"  size="5" value="10" /> 条 			
				</td></tr>
				<tr>
				<td colspan="2" height="30" style="padding-left:10px">
				栏目类型：
				<input type="checkbox" id="type1"  checked="checked"/>一般栏目
				<input type="checkbox" id="type2" />单页栏目
				<input type="checkbox" id="type3" />功能模块
				</td></tr>
				<tr>
				<td colspan="2" height="30" style="padding-left:10px">
				调用类型：  
				<select id="typeid">
					<option value="top">顶级栏目</option>
					<option value="son">下级栏目</option>
					<option value="self">同级栏目</option>
				</select>
				
				</td></tr>
				
				<tr>
				  <td colspan="2" style="padding-left:10px">
				 显示模板：<br />
				 <textarea cols="120" rows="13" style="font-family:'宋体'" id="tlpid"><a href="{field:url}" target="_blank">{field:catname}</a></textarea>
				  </td></tr>
				<tr>
				  <td height="40" colspan="2" align="center">
				 <input type="button" onclick="get_tag();" value="生成栏目调用标记" class="button" />
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
				var type='';
				var parentid=$('#categoryid').val()!=0?$('#categoryid').val():'$catid';
				type=$('#type1').attr('checked')==true?type+'1':type;
				type=$('#type2').attr('checked')==true?type+',2':type;
				type=$('#type3').attr('checked')==true?type+',3':type;
				$('#resultid').val('{reteng:category parentid="'+parentid+'" row="'+$('#number').val()+'" mod="'+type+'" type="'+$('#typeid').val()+'"}\n'+$('#tlpid').val()+'\n{/reteng:category}\n');
				$('#msg').html('↓将以下代码贴到模板的对应位置');
			}
		</script>
	</div>
</div>
</body>
</html>
