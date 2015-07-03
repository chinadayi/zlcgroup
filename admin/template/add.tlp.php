<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('gather',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>添加节点</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script src="images/js/jquery.min.js" charset=utf-8></script>
<script src="images/js/check.func.js"></script>
<script language="javascript" src="admin/template/js/css.js"></script>
<script language="javascript" type="text/javascript">
$(document).ready(function(){
	checkForm(0);
	$('#modelid').val(<?php echo isset($modelid)?$modelid:1;?>);
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
		<li><a href="javascript:void(0);" class="on" id="1">网址索引</a></li>
		<li><a href="javascript:void(0);" id="2">内容配置</a></li>
		<li><a href="javascript:void(0);" id="3">发布设置</a></li>
	</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		如果点击 <font style="background:#2782D6; color:#fff; padding:3px">保存规则</font> 时提交不了，仔细检查下是不是某项没有填写正确。
		</fieldset>
	<form action="" method="post" name="myform">		
	<input type="hidden" name="do_submit" value="1" />
	<input type="hidden" name="info[modelid]" value="<?php echo isset($modelid)?$modelid:1;?>" />
		<table width="100%">
		<tr><td>
			
			<div id="tab_1">
			<table class="sub" width="98%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="304" align="right">针对模型：</td>
					<td width="960">
					<select name="info[modelid]" id="modelid" onchange="self.location.href='<?php echo ADMIN_FILE;?>?mod=gather&file=gather&action=add&modelid='+this.value">
						<?php 
							if($model)foreach($model as $_model)
							{
								echo '<option value="'.$_model['id'].'">'.$_model['name'].'|'.$_model['table'].'</option>';
							}
						?>
					</select>
					<span>注意, 点击选择会刷新页面</span>
				  </td>
				</tr>
				<tr>
					<td width="304" align="right" valign="top">节点名称：</td>
					<td>
					<input type="text" name="info[name]"  size="24" datatype="limit"  min="1" max="30"/> 
					编码：
<input type="radio" name="info[code]" value="gb2312" checked='1'/>GB2312 
<input type="radio" name="info[code]" value="utf-8"/>UTF8 
<input type="radio" name="info[code]" value="big5"/>BIG5 
					</td>
				</tr>
				<tr>
					<td width="304" align="right" valign="top">当含有图片时：</td>
					<td>
<input type="radio" name="info[listsetting][downloadimg]" value="1" />下载到本地 
<input type="radio" name="info[listsetting][downloadimg]" value="0" checked='1' />不下载到本地 
					</td>
				</tr>
				<tr>
					<td width="304" align="right" valign="top">当标题重复时：</td>
					<td>
<input type="radio" name="info[listsetting][titlerepeat]" value="1" />覆盖 
<input type="radio" name="info[listsetting][titlerepeat]" value="3" checked='1'/>同时插入数据库 
					</td>
				</tr>
				<tr>
					<td width="304" align="right" valign="top">列表网址来源属性：</td>
					<td>
<input type="radio" name="info[listsetting][sourcetype]" value="batch" onclick="$('#batchtr').show();" checked='1'/>批量生成列表网址 
<input type="radio" name="info[listsetting][sourcetype]" onclick="$('#batchtr').hide();" value="hand"/>手工指定列表网址 
					</td>
				</tr>
				<tr id="batchtr">
					<td width="304" align="right" valign="top">批量生成地址设置：</td>
					<td>
					<input type="text" name="info[listsetting][regxurl]"  size="50" value="http://" /> 
					<br />
					<span>(如：http://www.reteng.org/news/list_(*).html，如果不能匹配所有网址，可以在手工指定网址的地方输入要追加的网址) </span>
					<br />
					(*)从
                  <input type="text" name="info[listsetting][startid]" size="2" value="1" />
                  到
                  <input type="text" name="info[listsetting][endid]" size="2" value="5" />
                  (填写页码或规律递增数字)&nbsp;
                  每页递增：
                  <input type="text" name="info[listsetting][addv]" size="2"  value="1" />
					</td>
				</tr>
				<tr>
					<td width="304" align="right" valign="top">手工指定网址：
					<br />
					<span>在指定了通配规则后有些不能匹配的网址也可以在这里指定。</span>
				  </td>
					<td>
					<textarea name="info[listsetting][addurls]" cols="55" rows="5"></textarea>
					</td>
				</tr>
				<tr>
					<td width="304" align="right" valign="top">包含有文章网址区域开始的HTML：					</td>
					<td>
					<textarea name="info[listsetting][areastart]" cols="55" rows="5"></textarea>
					</td>
				</tr>
				<tr>
					<td width="304" align="right" valign="top">包含有文章网址区域结束的HTML：					</td>
					<td>
					<textarea name="info[listsetting][areaend]" cols="55" rows="5"></textarea>
					</td>
				</tr>
				<tr>
					<td width="304" align="right" valign="top">内容附加网址：					</td>
					<td>
					<input type="text" name="info[listsetting][domain]" size="40" value="" />
					</td>
				</tr>
				<tr>
					<td width="304" align="right" valign="top">网址必须包含：					</td>
					<td>
					<input type="text" name="info[listsetting][musthas]" size="26" value="" />
					</td>
				</tr>
				<tr>
					<td width="304" align="right" valign="top">网址不能包含：					</td>
					<td>
					<input type="text" name="info[listsetting][nothas]" size="26" value="" />
					</td>
				</tr>
			</table>
			</div>
		
			<div id="tab_2" style="display:none">
			<table class="sub" width="98%">
				<?php foreach($fields as $field){ if(!$field['disabled']){?>
				<tr>
					<td width="200" align="right" valign="baseline"><b><?php echo $field['name'];?></b>：</td>
					<td>
					匹配信息 从 <textarea cols="25" rows="3" name="info[itemsetting][<?php echo $field['form'];?>][areastart]"></textarea> 到 <textarea name="info[itemsetting][<?php echo $field['form'];?>][areaend]" cols="25" rows="3"></textarea>
					<br />
					信息替换 将 <textarea cols="25" rows="3" name="info[itemsetting][<?php echo $field['form'];?>][search]"></textarea> 为 <textarea cols="25" rows="3" name="info[itemsetting][<?php echo $field['form'];?>][replace]"></textarea> <label><input type="checkbox" value="1" <?php echo ($field['form']=='content' || $field['form']=='editor')?'':'checked="checked"';?> <?php echo ($field['form']=='content' || $field['form']=='editor')?' disabled="disabled"':'';?> name="info[itemsetting][<?php echo $field['form'];?>][striptags]" />清除Html</label>
					<br />
					<span>替换代码通配符: (*) 多个替换条件间隔符:(|)</span>
					<br />
					字段默认值：<input type="text" name="info[itemsetting][<?php echo $field['form'];?>][default]" size="30" value="" />
					<br />
					自定义接口：<input type="text" name="info[itemsetting][<?php echo $field['form'];?>][func]" size="20" value="" />
					<br />
					<span>输入自定义的函数名(不要带括号，如日期转换成Linux时间戳的函数: strtotime) <a href="?mod=gather&file=gather&action=createfunc&id=<?php echo $id;?>" target="_blank"><font color="#0000FF"><u>自定义函数</u></font></a></span>
					</td>
				</tr>
				<?php }}?>
			</table>
			</div>
			<div id="tab_3" style="display:none">
			<table class="sub" width="98%">

				<tr>
					<td width="200" align="right" valign="baseline"><b>发布栏目</b>：</td>
					<td>

			<select name="info[listsetting][importid]">
				<?php $options->catoptions(0,array($gatherinfo['listsetting']['importid']),array(1),$gatherinfo['modelid']);?>
			</select>

					</td>
				</tr>
				<tr>
					<td width="200" align="right" valign="baseline"><b>自动采集间隔时间</b>：</td>
					<td>
					<input type="text" name="info[listsetting][intervaltime]" size="6" value="2" />小时
					</td>
				</tr>

			</table>
			</div>
			</td>
		</tr>
		<tr>
			<td align="center">
			<input type="button" onfocus="blur();" name="1" value="保存规则" class="button" onclick="this.form.target='_self';this.form.action='?mod=gather&file=gather&action=add&modelid=<?php echo isset($modelid)?$modelid:1;?>';doSubmit(this);" />
			<input type="button" onfocus="blur();" name="2" value="测试规则" class="button" onclick="this.form.action='?mod=gather&file=gather&action=test&modelid=<?php echo isset($modelid)?$modelid:1;?>';this.form.target='_blank';this.form.submit();" style="margin-left:10px" />
			<input type="button" onfocus="blur();" name="3" value="取消返回" class="button" onclick="javascript:history.back();" style="margin-left:10px" />
			</td>
		</tr>
	</table>
	</form>
	</div>
</div>
</body>
</html>
