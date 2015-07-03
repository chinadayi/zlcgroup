<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(9,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>添加内容</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script src="images/js/jquery.min.js" charset=utf-8></script>
<script src="images/js/check.func.js"></script>

<script type="text/javascript" charset=utf-8 src="ueditor/ueditor.config.js" ></script>
<script type="text/javascript" charset=utf-8 src="ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset=utf-8 src="ueditor/lang/zh-cn/zh-cn.js" ></script>

<script language="javascript" src="admin/template/js/css.js"></script>
<script language="javascript" type="text/javascript">
$(document).ready(function(){
	checkForm(0);
	$("#info_template").val('<?php echo $catinfo['setting']['temparticle'];?>');
});
$(function () {
	$(".tab a").each(function () {
		$(this).click(function () {
			$(".tab a").each(function(){
				$(this).attr('class','');
				$("#tab_" + $(this).attr('id')).css('display','none');
			});
			$(this).attr('class', 'on');
			$("#tab_" + $(this).attr('id')).css('display','block');

		});
	});
});
</script>
</head>
<body>
<div id="wrap">
	<div class="tab">
	<ul>
		<li><a href="javascript:void(0);" class="on" id="1"><?php echo $lang['CONTENT-LANG-3'];?></a></li>
		<li><a href="javascript:void(0);" id="2"><?php echo $lang['CONTENT-LANG-4'];?></a></li>
	</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		如果点击 <font style="background:#2782D6; color:#fff; padding:3px">保存内容</font> 时提交不了，仔细检查下是不是某项没有填写正确。
		</fieldset>
	<form action="" method="post" name="myform" enctype="multipart/form-data">		
	<input type="hidden" name="do_submit" value="1" />
	<input type="hidden" name="info[catid]" value="<?php echo $catid;?>" />
		<table width="100%">
		<tr><td>
			
			<div id="tab_1">
			<table class="sub" width="98%" cellpadding="0" cellspacing="0">
				<?php if($forms)foreach($forms as $val){ ?>
				<tr>
					<td width="130" align="right" valign="top"><?php echo $val['setting'];?> <?php echo $val['name'];?>：</font></td>
					<td>
					<?php echo $val['form'];?> <?php echo $val['unit']?$val['unit']:'';?>
					<span><?php echo $val['tips'];?></span>
					</td>
				</tr>
				<?php }?>
				<tr>
					<td width="130" align="right" valign="top">点击：</td>
					<td>
					<input type="text" name="info[clicks]" value="<?php echo mt_rand(100,200);?>" size="4" /> 次
					</td>
				</tr>
			</table>
			</div>
		
			<div id="tab_2" style="display:none">
			<table class="sub" width="98%">
				<tr>
					<td width="130" align="right" valign="top">转向链接：</td>
					<td>
					<label style="color:#ff0000"><input type="text" name="info[url]" id="info_url" disabled="disabled" size="35" />&nbsp;&nbsp;<input type="checkbox" style="border:0px" name="info[islink]" value=1 onclick="javascript:if(this.checked)document.getElementById('info_url').disabled='';else document.getElementById('info_url').disabled='disabled';" /> 转向链接<br />如果使用转向链接则点击标题就直接跳转而内容设置无效</label>
					</td>
				</tr>
				<tr>
					<td width="130" align="right" valign="top">内容模板：</td>
					<td>
					<select name="info[template]" id="info_template">
					<?php 
						if($template)foreach($template as $_template)
						{
							if(substr(basename($_template),0,8)=='article_')
							{
								echo '<option value="'.basename($_template,'.htm').'">'.basename($_template).'</option>';
							}
						}
					?>
					</select>
					
					</td>
				</tr>
			</table>
			</div>

			</td>
		</tr>
		<tr>
			<td align="center">
			<input type="button" onfocus="blur();" name="1" value="保存内容" class="button" onclick="this.form.target='_self';this.form.action='?file=content&action=add';doSubmit(this);" />
			<input type="button" onfocus="blur();" name="2" value="预览内容" class="button" onclick="checkEditor();this.form.action='?file=content&action=preview';this.form.target='_blank';this.form.submit();" style="margin-left:10px" />
			<input type="button" onfocus="blur();" name="3" value="取消返回" class="button" onclick="javascript:history.back();" style="margin-left:10px" />
			</td>
		</tr>
	</table>
	</form>
	</div>
</div>
</body>

</html>

