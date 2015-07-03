<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(6,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>添加栏目</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script src="images/js/jquery.min.js"></script>
<script src="images/js/check.func.js"></script>
<!--编辑器引用文件-->
<script type="text/javascript" charset=utf-8 src="ueditor/ueditor.config.js" ></script>
<script type="text/javascript" charset=utf-8 src="ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset=utf-8 src="ueditor/lang/zh-cn/zh-cn.js" ></script>

<script language="javascript" src="admin/template/js/css.js"></script>
<script language="javascript" type="text/javascript">
var temparr= new Array();
<?php
	if($model)foreach($model as $_model)
	{
		echo 'temparr['.$_model['id'].']="'.$_model['table'].'";';
	}
	
?>
temparr[-1]="page";
$(document).ready(function(){checkForm(0);setTlp(<?php echo $modelid;?>);});
$(document).ready(function(){$("#parentid").val(<?php echo isset($parentid)?intval($parentid):0;?>);$("#modelid").val(<?php echo $modelid;?>);$("#urlrule").val('<?php echo isset($parentsetting['setting']['urlrule'])?$parentsetting['setting']['urlrule']:'{sitedir}html/{Y}{M}/a{cid}'.HTMLEXT;?>');});
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

function CheckTypeDir(){
  var upinyin = document.getElementById('upinyin');
  var tpobj = document.getElementById('catdir');
  if(upinyin.checked) tpobj.style.display = "none";
  else tpobj.style.display = "";
}

function setTlp(modelid)
{
	if(modelid==-1){
		document.getElementById('showcontent').style.display=""; 
		document.getElementById('showpost').style.display="none";
		$("#tab_2").empty();
		$("#tab_2").append($("#aa1").html());
	    $('#tempindex').val('index_'+temparr[modelid]);
	    $('#templist').val('single_'+temparr[modelid]);
	    $('#temparticle').val('article_'+temparr[modelid]);

	}else
	{
		document.getElementById('showcontent').style.display="none";
		document.getElementById('showpost').style.display=""; 
		$("#tab_2").empty();
		$("#tab_2").append($("#aa2").html());
	    $('#tempindex').val('index_'+temparr[modelid]);
	    $('#templist').val('list_'+temparr[modelid]);
	    $('#temparticle').val('article_'+temparr[modelid]);
	}
}

var i = 2;

function option_add()
{
	var data='<tr id="option'+i+'"><td width="200"  align="right"><font color="#FF0000">+ </font><input type="text" name="info[extendkey][]" datatype="table" size="6" />：</td><td><input type="text" name="info[extendvalue][]" size="35" /> <a href="javascript:void(0);" onclick="option_del('+i+')"><u>删除</u></a></td></tr>';
	$('#option_define').append(data);
	i++;
	return true;
}

function option_del(i)
{
	$('#option'+i).remove();
	return true;
}

function shownav(id)
{
	if(id==1)
	{
		document.getElementById('shownav').style.display="none";
	}
	else{
		document.getElementById('shownav').style.display="";
	}
}
</script>
</head>
<body>
<div id="wrap">
	<div class="tab">
	<ul>
		<li><a href="javascript:void(0);" class="on" id="1"><?php echo $lang['CATEGORY-LANG-1'];?></a></li>
		<li><a href="javascript:void(0);" id="2"><?php echo $lang['CATEGORY-LANG-2'];?></a></li>
		<li><a href="javascript:void(0);" id="3">自定义字段</a></li>
		<li><a href="javascript:void(0);" id="4">SEO设置</a></li>
	</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		如果点击 <font style="background:#2782D6; color:#fff; padding:3px">保存栏目</font> 时提交不了，仔细检查下是不是某项没有填写正确。
		</fieldset>
	<form action="" method="post" name="myform" enctype="multipart/form-data">		
	<input type="hidden" name="do_submit" value="1" />
		<table width="100%">
		<tr><td>
			
			<div id="tab_1">
			<table class="sub">
				<tr>
					<td width="200" align="right">上级栏目：</td>
					<td>
					<select name="info[parentid]" id="parentid">
						<option value="0">作为一级栏目</option>
						<?php $options->catoptions();?>
					</select>					</td>
				</tr>
				
				<tr>
					<td width="200" align="right">栏目名称：</td>
					<td><input type="text" name="info[catname]" datatype="limit"  min="1" max="30" size="25" /></td>
				</tr>
				
				<tr>
					<td width="200" align="right">栏目图片：</td>
					<td><?php echo $form->image('image',isset($parentsetting['image'])?$parentsetting['image']:'');?></td>
				</tr>
				<tr>
					<td width="200" align="right">外部链接： </td>
					<td>
					启用<input type="checkbox" <?php echo isset($parentsetting['type']) && $parentsetting['type']==4?'checked="checked"':'';?> name="info[type]" value="4" /> 链接URL <input type="text" name="info[url]"  size="35" />					</td>
				</tr>
				<tr>
					<td width="200" align="right">内容模型：</td>
					<td>
					<select name="info[modelid]" id="modelid" onchange="setTlp(this.value)">
						<?php 
							if($model)foreach($model as $_model)
							{
								if($_model['siteid']==SITEID)
								{
									echo '<option value="'.$_model['id'].'">'.$_model['name'].'|'.$_model['table'].'</option>';
								}
							}
						?>
						<option value="-1">单页|page</option>
					</select>
					<a href="?file=model&action=manage" target="_blank"><u>管理模型</u></a>					</td>
				</tr>
				<tr>
					<td width="200" align="right">栏目目录：</td>
					<td>分站目录：<a href="javascript:void(0);" onclick="$('#catdir').val('{sitedir}');"><u>{sitedir}</u></a>  父栏目目录：<a href="javascript:void(0);" onclick="$('#catdir').val('{parcatdir}');"><u>{parcatdir}</u></a><br /><input id="catdir" type="text" value="<?php echo $parentid?'{parcatdir}':'{sitedir}';?>" name="info[catdir]"  /> <input name="cnspell" type="checkbox" id="upinyin" value="1" onClick="CheckTypeDir()" />拼音</td>
				</tr>
				<tr id="showcontent" style="display:none">
					<td width="200" align="right"  >单页内容： </td>
					<td>
				 
				<?php echo editor('info[content]','','editor_content')?>					</td>
				</tr>
				<tr id="showpost">
					<td width="200" align="right">是否支持投稿：</td>
				  <td>
					<input type="radio" class="radio"  name="info[ispost]" value="1" <?php echo !isset($parentsetting['ispost']) || $parentsetting['ispost']?' checked="checked"':'';?> />启用
					&nbsp;&nbsp;
					<input type="radio" class="radio"  name="info[ispost]" value="0" <?php echo isset($parentsetting['ispost']) && !$parentsetting['ispost']?' checked="checked"':'';?> />禁用					
					</td>
				</tr>
				<tr>
					<td width="200" align="right">作为导航菜单：</td>
					<td>
					<input type="radio"  class="radio" name="info[ismenu]" value="1" <?php echo !isset($parentsetting['ismenu']) || $parentsetting['ismenu']?' checked="checked"':'';?> onclick="shownav('0');"/>启用
					&nbsp;&nbsp;
					<input type="radio"  class="radio" name="info[ismenu]" value="0" <?php echo isset($parentsetting['ismenu']) && !$parentsetting['ismenu']?' checked="checked"':'';?> onclick="shownav('1');"/>禁用
					<span>仅对一级栏目有效!</span>					</td>
				</tr>
				
				<tr id="shownav">
					<td width="200" align="right">导航分组：</td>
					<td>
			          <label>
			          <input name="info[navtype][]" type="checkbox" id="navtype" value="1" checked="checked" />
			          顶部导航 
			          <input name="info[navtype][]" type="checkbox" id="navtype" value="2" checked="checked" />
主导航 
<input name="info[navtype][]" type="checkbox" id="navtype" value="3" checked="checked" />
底部导航 </label></td>
				</tr>
			</table>
			</div>
		
			<div id="tab_2" style="display:none">
			
			</div>
			
			
			<div id="tab_3" style="display:none">
			<table class="sub">
				<tr>
				<td colspan="2" style="padding-left:130px">
				<span><font color="#FF0000"> * 自定义字段模板嵌套调用方法 {field:_字段名}</font></span>
				</td>
				</tr>
				<tr>
				<td width="200" align="right">字段名：</td>
				<td>
				字段值
				</td>
				</tr>
				<tr>
					<td width="200"  align="right"><font color="#FF0000">+ </font><input type="text" name="info[extendkey][]" datatype="table" size="6" />：</td>
					<td>
					<input type="text" name="info[extendvalue][]" size="35" />
					<input type="button" value="增加自定义字段" class="button" onclick="option_add()" />
					</td>
				</tr>
				<tbody id="option_define"></tbody>
			</table>
			</div>
			
			<div id="tab_4" style="display:none">
			
			<table class="sub">
				<tr>
					<td width="200" align="right">meta_title：</td>
					<td><input type="text" name="info[setting][meta_title]" size="45" value="<?php echo isset($parentsetting['setting']['meta_title'])?$parentsetting['setting']['meta_title']:'';?>" datatype="limit" min="0" max="200" /> <span>针对搜索引擎设置的标题</span></td>
				</tr>
				<tr>
					<td width="200" align="right">meta_keywords：</td>
					<td><input type="text" name="info[setting][meta_keywords]" value="<?php echo isset($parentsetting['setting']['meta_keywords'])?$parentsetting['setting']['meta_keywords']:'';?>" size="55" datatype="limit" min="0" max="200" /> <span>多个关键字用 , 隔开</span></td>
				</tr>
				<tr>
					<td width="200" align="right">meta_description： </td>
					<td>
					<textarea name="info[setting][meta_description]" datatype="limit" min="0" max="255" cols="60" rows="5" ><?php echo isset($parentsetting['setting']['meta_description'])?$parentsetting['setting']['meta_description']:'';?></textarea>					</td>
				</tr>
			</table>
			</div>
			</td>
		</tr>
		<tr>
			<td><input type="button" onfocus="blur();" value="保存栏目" class="button" onclick="doSubmit(this);" style="margin-left:160px" /></td>
		</tr>
	</table>
	</form>
	</div>
<div style="display:none" id="aa1">
<table class="sub">
				<tr>
					<td width="200" align="right">绑定二级域名： </td>
					<td>
					<input type="text" name="info[domain]" size="35" />
					<span>如不绑定请留空, 如需绑定请以http://开头, 仅支持一级栏目 ！</span>					</td>
				</tr>
				<tr>
					<td width="200" align="right">单页页发布选项：</td>
					<td>
<input type="radio" class="radio"  name="info[setting][catishtml]" value="1" <?php echo !isset($parentsetting['setting']['catishtml']) && !$parentsetting['setting']['catishtml']==1?' checked="checked"':'';?>  />生成静态
					&nbsp;&nbsp;
<input type="radio" class="radio"  name="info[setting][catishtml]" value="0" <?php echo isset($parentsetting['setting']['catishtml']) || $parentsetting['setting']['catishtml']?' checked="checked"':'';?> />使用动态
					</td>
				</tr>
				
				<tr>
					<td width="200" align="right" valign="top">单页列表URL命名规则：</td>
					<td>
					<input type="text" name="info[setting][urlrule]" value="<?php echo isset($parentsetting['setting']['urlrule'])?$parentsetting['setting']['urlrule']:'{sitedir}html/{Y}{M}/a{cid}'.HTMLEXT;?>" size="46" id="urlrule" />
					 <a href="javascript:void(0);" onClick="$('#listurlrulebl').toggle();"><img src="images/help.gif" border="0" /></a>
					<span id="listurlrulebl" style="display:none">
					<br />
					支持变量:<br />{tid} 栏目ID<br />{page} 列表的页码 <br />{catdir} 栏目目录<br />{sitedir} 分站目录					</span>					</td>
				</tr>
				
				<tr id="l3">
					<td width="200"  align="right">单页模板： </td>
					<td>
					<select name="info[setting][templist]" id="templist">
					<?php 
						if($template)foreach($template as $_template)
						{
							if(substr(basename($_template),0,7)=='single_')
							{
								echo '<option value="'.basename($_template,'.htm').'">'.basename($_template).'</option>';
							}
						}
					?>
					</select>
					<input type="hidden" name="info[setting][islist]" value="1" />
        			</td>
				</tr>
				
</table>
</div>

<div style="display:none" id="aa2">
<table class="sub">
				<tr>
					<td width="200" align="right">绑定二级域名： </td>
					<td>
					<input type="text" name="info[domain]" size="35" />
					<span>如不绑定请留空, 如需绑定请以http://开头, 仅支持一级栏目 ！</span>
					</td>
				</tr>
				<tr>
					<td width="200" align="right">栏目页发布选项：</td>
					<td>
					<input type="radio" class="radio"  name="info[setting][catishtml]" value="1" <?php echo isset($parentsetting['setting']['catishtml']) && !$parentsetting['setting']['catishtml']==1?' checked="checked"':'';?>  />生成静态
					&nbsp;&nbsp;
					<input type="radio" class="radio"  name="info[setting][catishtml]" value="0" <?php echo !isset($parentsetting['setting']['catishtml']) || $parentsetting['setting']['catishtml']?' checked="checked"':'';?> />使用动态
					&nbsp;&nbsp;
					</td>
				</tr>
				<tr>
					<td width="200" align="right">文章页发布选项：</td>
					<td>
					<input type="radio" class="radio"  name="info[setting][ishtml]" value="1" <?php echo isset($parentsetting['setting']['ishtml']) && !$parentsetting['setting']['ishtml']==1?' checked="checked"':'';?>  />生成静态
					&nbsp;&nbsp;
					<input type="radio" class="radio"  name="info[setting][ishtml]" value="0" <?php echo !isset($parentsetting['setting']['ishtml']) || $parentsetting['setting']['ishtml']?' checked="checked"':'';?> />使用动态
					</td>
				</tr>
				<tr>
					<td width="200" align="right" valign="top">文章URL命名规则：</td>
					<td>
					<input type="text" name="info[setting][urlrule]" value="<?php echo isset($parentsetting['setting']['urlrule'])?$parentsetting['setting']['urlrule']:'{sitedir}html/{Y}{M}/a{cid}'.HTMLEXT;?>" size="46" id="urlrule" />
					 <a href="javascript:void(0);" onclick="$('#bianliang').toggle();"><img src="images/help.gif" border="0" /></a>
					<span id="bianliang" style="display:none">
					<br />
					支持变量:<br />
					{Y}、{M}、{D} 年月日<br />
{timestamp} INT类型的UNIX时间戳<br />
{cid} 文章ID<br />
{pinyin} 拼音+文章ID<br />
{py} 拼音部首+文章ID<br />
{catdir} 栏目目录 <br />
{sitedir} 分站目录 
					</span>
					</td>
				</tr>
				<tr>
					<td width="200" align="right" valign="top">栏目列表URL命名规则：</td>
					<td>
					<input type="text" name="info[setting][listurlrule]" value="<?php echo isset($parentsetting['setting']['listurlrule'])?$parentsetting['setting']['listurlrule']:'{catdir}list_{tid}_{page}'.HTMLEXT;?>" size="46" id="listurlrule" />
					 <a href="javascript:void(0);" onclick="$('#listurlrulebl').toggle();"><img src="images/help.gif" border="0" /></a>
					<span id="listurlrulebl" style="display:none">
					<br />
					支持变量:<br />{tid} 栏目ID<br />{page} 列表的页码 <br />{catdir} 栏目目录<br />{sitedir} 分站目录 
					</span>
					</td>
				</tr>
				<tr>
					<td width="200" align="right">栏目属性：</td>
				  <td>
					<input type="radio" class="radio" name="info[setting][islist]" value="1"  <?php echo !isset($parentsetting['setting']['islist']) || $parentsetting['setting']['islist']?' checked="checked"':'';?>/>最终列表栏目(允许在本栏目发布文档，并生成文档列表)<br />
					<input type="radio" class="radio" name="info[setting][islist]" value="0" <?php echo isset($parentsetting['setting']['islist']) && !$parentsetting['setting']['islist']?' checked="checked"':'';?>/>频道封面（栏目本身不允许发布文档)</td>
				</tr>
				<tr>
					<td width="200"  align="right">封面模板： </td>
					<td>
					<select name="info[setting][tempindex]" id="tempindex">
					<?php 
						if($template)foreach($template as $_template)
						{
							if(substr(basename($_template),0,6)=='index_')
							{
								echo '<option value="'.basename($_template,'.htm').'">'.basename($_template).'</option>';
							}
						}
					?>
					</select>
					</td>
				</tr>
				<tr>
					<td width="200"  align="right">列表模板： </td>
					<td>
					<select name="info[setting][templist]" id="templist">
					<?php 
						if($template)foreach($template as $_template)
						{
							if(substr(basename($_template),0,5)=='list_')
							{
								echo '<option value="'.basename($_template,'.htm').'">'.basename($_template).'</option>';
							}
						}
					?>
					</select>
					</td>
				</tr>
				<tr>
					<td width="200"  align="right">文章模板：</td>
					<td>
					<select name="info[setting][temparticle]" id="temparticle">
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


</div>
</body>
</html>
