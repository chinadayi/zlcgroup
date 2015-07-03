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
$(document).ready(function(){
	$("#table tbody").hide();
	$("#tbody_<?php echo $info['type'];?>").show();
	if(<?php echo $info['type'];?>!=1 && <?php echo $info['type'];?>!=2)
	{
		$("#imageurl").attr('disabled',true);
		$("#flashurl").attr('disabled',true);
	}
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
		uploadimage(true);
	}
	if(tbodyId==2)
	{
		uploadflash(true);
	}
	$("#table tbody").hide();
	$("#tbody_"+tbodyId).show();
}

function uploadimage(flag)
{
	if(flag)
	{
		$("#imageurlhtml1").hide();
		$("#imageurlhtml").html("<input type='file' name='imageurl' id='imageurl' /> <a href='javascript:uploadimage(false);'><u>取消</u></a>");
	}
	else
	{
		$("#imageurlhtml1").show();
		$("#imageurlhtml").html("<a href='javascript:void(0);' onclick='uploadimage(true);'><u>上传</u></a>");
	}
}

function uploadflash(flag)
{
	if(flag)
	{
		$("#flashurlhtml1").hide();
		$("#flashurlhtml").html("<input type='file' name='flashurl' id='flashurl' /> <a href='javascript:uploadflash(false);'><u>取消</u></a>");
	}
	else
	{
		$("#flashurlhtml1").show();
		$("#flashurlhtml").html("<a href='javascript:void(0);' onclick='uploadflash(true);'><u>上传</u></a>");
	}
}
</script>
</head>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="?mod=adv&file=ads&action=manage&adsposid=<?php echo $info['adsposid'];?>">广告管理</a></li>
			<li><a href="?mod=adv&file=ads&action=ads_add&adsposid=<?php echo $info['adsposid'];?>">添加广告</a></li>
			<li><a href="javascript:void(0);" class="on">编辑广告</a></li>			
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend>操作提示</legend>
		1：广告名称不能为空； 2：链接URL必须以http://开头。
	</fieldset>
	<form action="" method="post" name="myform" enctype="multipart/form-data">
	<input type="hidden" name="do_submit" value="1" />
	<input type="hidden" name="id" value="<?php echo $id;?>" />
	<table cellspacing="0" class="sub">
		<tr>
			<td width="80" align="right">广告名称：</td>
			<td>
			<input type="text" name="info[name]" value="<?php echo $info['name'];?>" datatype="limit"  min="2" max="25" />
			</td>
		</tr>
		<tr>
			<td width="80" align="right">广告类型：</td>
			<td>
			<input type="radio" name="info[type]" value="1" <?php echo $info['type']==1?'checked="checked"':'';?> onclick="chooseTbody(1);" />图片   &nbsp;
			<input type="radio" name="info[type]" value="2" <?php echo $info['type']==2?'checked="checked"':'';?> onclick="chooseTbody(2);"/>FLASH &nbsp;
			<input type="radio" name="info[type]" value="3" <?php echo $info['type']==3?'checked="checked"':'';?> onclick="chooseTbody(3);"/>文本[支持代码] &nbsp;
			<input type="radio" name="info[type]" value="4" <?php echo $info['type']==4?'checked="checked"':'';?> onclick="chooseTbody(4);"/>文字链 &nbsp;
			</td>
		</tr>
		<tr>
			<td align="right">广告内容：</td>
			<td style="line-height:3em">
			<table id="table">
				<tbody id="tbody_1">
				<tr><td>上传图片：<span id="imageurlhtml1"><?php echo $info['imageurl'];?></span> <span id="imageurlhtml"><a href="javascript:void(0);" onclick="uploadimage(true);"><u>上传</u></a></span></td></tr>
				<tr><td>图片提示：<input type="text" name="info[alt]" value="<?php echo $info['alt'];?>" datatype="limit"  min="0" max="80" /></td></tr>
				<tr><td>链接地址：<input type="text" name="info[linkurl]" value="<?php echo $info['linkurl'];?>" size="45" datatype="url" value="http://"/></td></tr>
				</tbody>
				<tbody id="tbody_2" style="display:none">
				<tr><td>上传FLASH：<span id="flashurlhtml1"><?php echo $info['flashurl'];?></span> <span id="flashurlhtml"><a href="javascript:void(0);" onclick="uploadflash(true);"><u>上传</u></a></span></td></tr>
				<tr><td>背景透明：
				<input type="radio"  name="info[wmode]" value="transparent" <?php echo $info['wmode']=='transparent'?'checked="checked"':'';?>/>是  
				<input type="radio"  name="info[wmode]" value="" <?php echo $info['wmode']==''?'checked="checked"':'';?>/>否
				</td></tr>
				</tbody>
				<tbody id="tbody_3" style="display:none;">
				<tr><td><textarea name="info[text]" cols="60" rows="5" ><?php echo $info['text'];?></textarea></td></tr>
				</tbody>
				<tbody id="tbody_4" style="display:none">
				<tr><td>链接内容：<input type="text" name="info[code]" datatype="limit" value="<?php echo $info['code'];?>"  min="0" max="80" /></td></tr>
				<tr><td>链接地址：<input type="text" name="info[text_link]" size="45" datatype="url" value="<?php echo $info['text_link'];?>" /></td></tr>
				</tbody>
				<tbody id="tbody_5" style="display:none">
				<tr><td><textarea name="info[code2]" datatype="limit" min="0" max="255" cols="60" rows="5" ><?php echo $info['code'];?></textarea></td></tr>
				</tbody>
			</table>
			</td>
		</tr>
		<tr>
			<td align="right">开始日期：</td>
			<td>
			<input type="text" name="info[fromdate]" id="table_name" value="<?php echo date('Y-m-d',$info['fromdate']);?>" />
			</td>
		</tr>
		<tr>
			<td align="right">到期日期：</td>
			<td>
			<input type="text" name="info[todate]" id="table_name" value="<?php echo date('Y-m-d',$info['todate']);?>" />
			</td>
		</tr>
		<tr>
			<td align="right">是否启用：</td>
			<td>
			<input type="radio" value="1" <?php echo $info['ispassed']==1?'checked="checked"':'';?> name="info[ispassed]" />启用
			<input type="radio" value="0"<?php echo $info['ispassed']==0?'checked="checked"':'';?>  name="info[ispassed]" />待审
			</td>
		</tr>
		<tr>
			<td align="right">广告介绍：</td>
			<td>
			<textarea name="info[introduce]" datatype="limit" min="0" max="255" cols="60" rows="5" ><?php echo $info['introduce'];?></textarea> 
			</td>
		</tr>
		<tr class="bg2"><td></td><td><input type="button" class="button" onclick="doSubmit(this);" value="保存广告" /> <input type="button" class="button" onclick="window.location.href='<?php echo ADMIN_FILE;?>?mod=adv&file=ads&action=manage&adsposid=<?php echo $info['adsposid'];?>'" value="取消返回" /></td></tr>
	</table>
	</form>

	</div>
</div>
</body>
</html>
