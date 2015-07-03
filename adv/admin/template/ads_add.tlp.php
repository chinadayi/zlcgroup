<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('ads',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>广告管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script src="images/js/check.func.js"></script>
<script language="javascript" src="admin/template/js/css.js"></script>
<script language="javascript" type="text/javascript">
$(document).ready(function(){
	checkForm(0);
});
function chooseTbody(tbodyId)
{
	if(tbodyId!=1 && tbodyId!=2)
	{
		$("#imageurl").attr('disabled',true);
		$("#flashurl").attr('disabled',true);
	}
	else
	{
		$("#imageurl").attr('disabled',false);
		$("#flashurl").attr('disabled',false);
	}
	
	if(tbodyId==1)
	{
		$("#imageurl").attr('disabled',false);
		$("#flashurl").attr('disabled',true);
	}
	if(tbodyId==2)
	{
		$("#imageurl").attr('disabled',true);
		$("#flashurl").attr('disabled',false);
	}
	$("#table tbody").hide();
	$("#tbody_"+tbodyId).show();
}
</script>
</head>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="?mod=adv&file=ads&action=manage&adsposid=<?php echo $adsposid;?>">广告管理</a></li>
			<li><a href="javascript:void(0);" class="on">添加广告</a></li>			
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend>操作提示</legend>
		1：广告名称不能为空； 2：链接URL必须以http://开头。
	</fieldset>
	<form action="" method="post" name="myform" enctype="multipart/form-data">
	<input type="hidden" name="do_submit" value="1" />
	<input type="hidden" name="info[adsposid]" value="<?php echo $adsposid;?>" />
	<table cellspacing="0" class="sub">
		<tr>
			<td width="80" align="right">广告名称：</td>
			<td>
			<input type="text" name="info[name]" datatype="limit"  min="2" max="25" />
			</td>
		</tr>
		<tr>
			<td width="80" align="right">广告类型：</td>
			<td>
			<input type="radio" name="info[type]" value="1" checked="checked" onclick="chooseTbody(1);" />图片   &nbsp;
			<input type="radio" name="info[type]" value="2"  onclick="chooseTbody(2);"/>FLASH &nbsp;
			<input type="radio" name="info[type]" value="3"  onclick="chooseTbody(3);"/>文本[支持代码] &nbsp;
			<input type="radio" name="info[type]" value="4"  onclick="chooseTbody(4);"/>文字链 &nbsp;
			</td>
		</tr>
		<tr>
			<td align="right">广告内容：</td>
			<td style="line-height:3em">
			<table id="table">
				<tbody id="tbody_1">
				<tr><td>上传图片：<input type="file" name="imageurl" id="imageurl" /></td></tr>
				<tr><td>图片提示：<input type="text" name="info[alt]" datatype="limit"  min="0" max="80" /></td></tr>
				<tr><td>链接地址：<input type="text" name="info[linkurl]" size="45" datatype="url" value="http://"/></td></tr>
				</tbody>
				<tbody id="tbody_2" style="display:none">
				<tr><td>上传FLASH：<input type="file" name="flashurl" id="flashurl" disabled="disabled"/></td></tr>
				<tr><td>背景透明：
				<input type="radio"  name="info[wmode]" value="transparent" checked="checked"/>是  
				<input type="radio"  name="info[wmode]" value=""/>否
				</td></tr>
				</tbody>
				<tbody id="tbody_3" style="display:none">
				<tr><td><textarea name="info[text]" cols="60" rows="5" ></textarea></td></tr>
				</tbody>
				<tbody id="tbody_4" style="display:none">
				<tr><td>链接内容：<input type="text" name="info[code]" datatype="limit"  min="0" max="80" /></td></tr>
				<tr><td>链接地址：<input type="text" name="info[text_link]" size="45" datatype="url" value="http://" /></td></tr>
				</tbody>
				<tbody id="tbody_5" style="display:none">
				<tr><td><textarea name="info[code2]" datatype="limit" min="0" max="255" cols="60" rows="5" ></textarea></td></tr>
				</tbody>
			</table>
			</td>
		</tr>
		<tr>
			<td align="right">开始日期：</td>
			<td>
			<input type="text" name="info[fromdate]" id="table_name" value="<?php echo date('Y-m-d');?>" />
			</td>
		</tr>
		<tr>
			<td align="right">到期日期：</td>
			<td>
			<input type="text" name="info[todate]" id="table_name" value="<?php echo date('Y-m-d',time()+24*30*3600);?>" />
			</td>
		</tr>
		<tr>
			<td align="right">是否启用：</td>
			<td>
			<input type="radio" value="1" checked="checked" name="info[ispassed]" />启用
			<input type="radio" value="0" name="info[ispassed]" />待审
			</td>
		</tr>
		<tr>
			<td align="right">广告介绍：</td>
			<td>
			<textarea name="info[introduce]" datatype="limit" min="0" max="255" cols="60" rows="5" ></textarea> 
			</td>
		</tr>
		<tr class="bg2"><td></td><td><input type="button" class="button" onclick="doSubmit(this);" value="保存广告" /> <input type="button" class="button" onclick="window.location.href='<?php echo ADMIN_FILE;?>?mod=adv&file=ads&action=manage&adsposid=<?php echo $adsposid;?>'" value="取消返回" /></td></tr>
	</table>
	</form>

	</div>
</div>
</body>
</html>
