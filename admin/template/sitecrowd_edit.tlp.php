<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>站群管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script language="javascript" src="admin/template/js/css.js"></script>
<script src="images/js/check.func.js"></script>
<script language="javascript" type="text/javascript">
	$(document).ready(function(){
		checkForm(0);
	});
</script>
</head>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="?file=sitecrowd&action=manage">分站管理</a></li>
			<li><a href="javascript:void(0);" class="on">编辑站点</a></li>			
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		1：站点目录由1-30个字母、数字、下划线组成； 2：站点名称不能为空。
	</fieldset>
	<form action="" method="post" name="myform">
	<input type="hidden" name="do_submit" value="1" />
	<input type="hidden" name="oldsite_dir" value="<?php echo $crowdinfo['site_dir'];?>" />
	<input type="hidden" name="id" value="<?php echo $crowdinfo['id'];?>" />
	<table cellspacing="0" class="sub">
		<tr>
			<td width="200" align="right">站点名称：</td>
			<td><input type="text"  name="info[site_name]" value="<?php echo $crowdinfo['site_name'];?>" size="25" datatype="limit" min="1" max="80" /></td>
		</tr>
		<tr>
			<td width="200" align="right">站点目录：</td>
			<td>
			<input type="text"  name="info[site_dir]" value="<?php echo $crowdinfo['site_dir']?$crowdinfo['site_dir']:'/';?>" onchange="$('#site_url').val('<?php echo $sitecrowdobj->maindomain();?>'+this.value+'/')" datatype="limit" min="1" max="30" size="8" />
			<span>站点目录由1-30个字母、数字、下划线组成</span>
			</td>
		</tr>
		<tr>
			<td width="200" align="right">站点域名：</td>
			<td>
			<input type="text"  name="info[site_url]" id="site_url" value="<?php echo $crowdinfo['site_url'];?>" datatype="url" size="30" />
			<span>请填写完整URL地址，以"/"结尾</span>
			</td>
		</tr>
		<tr>
			<td width="200" align="right">默认模板：</td>
			<td><?php echo $tlp_name;?></td>
		</tr>
		<tr>
			<td width="200" align="right">站点副标题：</td>
			<td>
			<input type="text" name="info[seo_title]" value="<?php echo $crowdinfo['seo_title'];?>" size="50" />
			</td>
		</tr>
		<tr>
			<td width="200" align="right">站点关键字：</td>
			<td>
			<input type="text" name="info[seo_keywords]" value="<?php echo $crowdinfo['seo_keywords'];?>" size="50" />
			<span>设置Meta标签的关键字，用英文逗号分隔</span>
			</td>
		</tr>
		<tr>
			<td width="200" align="right">站点描述：</td>
			<td>
			<textarea name="info[seo_description]" cols="60" rows="5" ><?php echo $crowdinfo['seo_description'];?></textarea> 
			<span>设置Meta标签的描述信息</span>
			</td>
		</tr>
		<tr>
			<td width="200" align="right">导航分隔符： </td>
			<td>
			<input type="text" name="info[separator]" value="<?php echo $crowdinfo['separator'];?>" size="4" /> 
			<span>如：站点首页 <b><font color="#FF0000">&gt;</font></b> 新闻</span>
			</td>
		</tr>
		<tr>
		<td width="200"  align="right">HTML后缀：</td>
		<td>
		<input type="text" name="info[htmlext]" size="10" datatype="limit" min=1  max=30 value="<?php echo $crowdinfo['htmlext'];?>" />
		<span>HTML后缀不要经常修改!修改后请更新内容。</span>
		</td></tr>
		<tr>
		<td width="200"  align="right">只读取默认地区数据： </td>
		<td>
		<input type="radio" class="radio" name="info[iscity]" onclick="$('#iscity').show();" value="1" <?php echo $crowdinfo['iscity']?' checked="checked"':'';?> />启用
		<input type="radio" class="radio" name="info[iscity]" onclick="$('#iscity').hide();" value="0" <?php echo !$crowdinfo['iscity']?' checked="checked"':'';?> />关闭
		<span>开启后, 将自动读取默认地区数据，其他地区数据将不显示在前台。 </span>
		</td></tr>
		<tbody style="display:none" id="iscity">
		<tr>
		<td width="200"  align="right">默认地区名称： </td>
		<td>
		<?php echo js_selectmenu('area','city','info',$crowdinfo['city']);?>
		</td></tr>
		</tbody>
		<tr>
		<td width="200"  align="right">地图精准定位： </td>
		<td>
		<?php echo $mapapi;?>
		<input type="text" id="map_map" value="<?php echo $crowdinfo['map'];?>" onclick="alert('不可手动输入，请点击按钮标注地图!');" readonly="1" name="info[map]" size="20"  /> <input type="button" value="标注地图" onclick="javascript:window.open('api/map/map_api_'+$('#mapapi').val()+'.php?action=distancepole&x=<?php echo $mapx;?>&y=<?php echo $mapy;?>&id=map_map&config=1','upload','width=600,height=500');"  class="button"/>
		</td></tr>
		<tr>
			<td width="200" align="right">首页是否静态化： </td>
			<td>
			<input type="radio" class="radio" name="info[ishtml]" value="1" <?php echo $crowdinfo['ishtml']?' checked="checked"':'';?> />静态化
			  
			<input type="radio" class="radio" name="info[ishtml]" value="0" <?php echo !$crowdinfo['ishtml']?' checked="checked"':'';?> />动态
			</td>
		</tr>
		<tr>
			<td width="200" align="right">版权信息：</td>
			<td>
			<textarea name="info[copyright]" cols="60" rows="5" ><?php echo $crowdinfo['copyright'];?></textarea> 
			</td>
		</tr>			
		<tr>
			<td width="200" align="right">站点ICP备案序号：</td>
			<td>
			<input type="text" name="info[icpno]" value="<?php echo $crowdinfo['icpno'];?>"/>
			</td>
		</tr>
		<tr>
			<td width="200" align="right">发布点：</td>
			<td>
			<select name="info[issueid][]" size="5" multiple="multiple">
				<option value="" <?php if(!$crowdinfo['issueid']){?>selected="selected"<?php }?>>不使用发布点</option>
				<?php if(is_array($issuelist))foreach($issuelist as $issue){?>
				<option value="<?php echo $issue['issueid'];?>"<?php if(in_array($issue['issueid'],$issueid)){?> selected="selected"<?php }?>><?php echo $issue['issuename'];?></option>
				<?php }?>
			</select>
			<span>将站点发布到别的服务器上</span>
			</td>
		</tr>
		<tr class="bg2"><td></td><td><input type="button" class="button" onclick="doSubmit(this);" value="保存站点" /> <input type="button" class="button" onclick="window.location.href='<?php echo ADMIN_FILE;?>?file=sitecrowd&action=manage'" value="取消返回" /></td></tr>
	</table>
	</form>

	</div>
</div>
</body>
</html>
