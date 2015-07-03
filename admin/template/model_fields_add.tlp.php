<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(16,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>模型管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
			<li><a href="?file=model&action=fields&id=<?php echo $modelid;?>"><?php echo $lang['LEFT-MODULE-13'];?></a></li>
			<li><a href="javascript:void(0);" class="on"><?php echo $lang['LEFT-MODULE-14'];?></a></li>
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		1：字段名称用于在数据库建立字段,由数字、字母、下划线组成!
	</fieldset>
	<form action="" method="post" name="myform">
	<input type="hidden" name="do_submit" value="1" />
	<input type="hidden" name="info[modelid]" value="<?php echo $modelid;?>" />
	<table cellspacing="0" class="sub" width="100%">
		<tr>
			<td width="190" align="right">字段别名：</td>
			<td width="762">
			<input type="text" name="info[name]" datatype="limit" min="1" max="64" class="input" size="16" />
			<span><font color="#FF0000">*</font> </span>
		  </td>
		</tr>
		<tr>
			<td width="190" align="right">字段名称：</td>
			<td>
			<input type="text" name="info[enname]"  id="enname" onblur="$.get('?file=model&action=chkfieldname&modelid=<?php echo $modelid;?>',{data:this.value},function(data){if(data=='yes'){alert('该字段名已经存在，请更换!');$('#enname').val('');$('#enname').focus();}});" datatype="table" class="input" size="16" />
			<span><font color="#FF0000">*</font> 用于在数据库建立字段,由数字、字母、下划线组成! </span>
			</td>
		</tr>
		<tr>
			<td width="190" align="right" valign="top">字段类型：</td>
			<td>
			<ul>
				<li><input type="radio" class="radio" name="info[form]" checked="checked" value="text" />单行文本(text)</li>				
				<li><input type="radio" class="radio" name="info[form]" value="password" />密 码 框(password)</li>
				<li><input type="radio" class="radio" name="info[form]" value="textarea" />多行文本(textarea)</li>
				<li><input type="radio" class="radio" name="info[form]" value="number" />数 字 型(number)</li>
				<li><input type="radio" class="radio" name="info[form]" value="radio" />单选按钮(radio)</li>
				<li><input type="radio" class="radio" name="info[form]" value="checkbox" />多选按钮(checkbox)</li>
				<li><input type="radio" class="radio" name="info[form]" value="select" />下 拉 框(select)</li>
				<li><input type="radio" class="radio" name="info[form]" value="video" />媒体文件(video)</li>
				<li><input type="radio" class="radio" name="info[form]" value="style" />颜色字体(style)</li>
				<li><input type="radio" class="radio" name="info[form]" value="image" />单张图片(image)</li>
				<li><input type="radio" class="radio" name="info[form]" value="images" />多张图片(images)</li>
				<li><input type="radio" class="radio" name="info[form]" value="attachment" />附件下载(attachment)</li>
				<li><input type="radio" class="radio" name="info[form]" value="datetime" />日期时间(datetime)</li>
				<li><input type="radio" class="radio" name="info[form]" value="copyfrom" />稿件来源(copyfrom)</li>
				<li><input type="radio" class="radio" name="info[form]" value="author" />文章作者(author)</li>
			  	<li><input type="radio" class="radio" name="info[form]" value="baidueditor" />编 辑 器(ueditor)</li>
				<li><input type="radio" class="radio" name="info[form]" value="simpleueditor" />简单编辑器</li>
				<li><input type="radio" class="radio" name="info[form]" value="ip" />发布者IP(ip)</li>
				<li><input type="radio" class="radio" name="info[form]" value="map" />地图标注(map)</li>
				<li><input type="radio" class="radio" name="info[form]" value="more" />多选项(more)</li>
                <li><input type="radio" class="radio" name="info[form]" value="color" />颜色块</li>
				<?php
				if($selectmenu)foreach($selectmenu as $_selectmenu)
				{
					echo '<li><input type="radio" class="radio" name="info[form]" value="selectmenu_'.$_selectmenu['table'].'" />'.$_selectmenu['name'].'(级联菜单)</li>';
				}				
				?>
			  </ul>
			</td>
		</tr>
		<tr>
			<td width="190" align="right">字段长度：</td>
			<td>
			<input type="text" name="info[length]" value="255" size="10" />
			<span>如果字段类型为小数时,用 "," 表示小数位数。如:8,5</span>
			</td>
		</tr>
		<tr>
			<td width="190" align="right">选项值：</td>
			<td>
			<textarea name="info[options]" cols="60" rows="6"><?php echo "选项值|选项\n选项值|选项";?></textarea>
			<span>1：当表单类型为单选、多选、下拉单时必填!2：当为编辑器类型时该选项可选值为：'Standard','Basic','Textarea'!</span>
			</td>
		</tr>
		<tr>
			<td width="190" align="right">表单提示：</td>
			<td>
			<input type="text" name="info[tips]" datatype="limit" min="0" max="80" class="input" size="28" />
			</td>
		</tr>
		<tr>
			<td width="190" align="right">计量单位：</td>
			<td>
			<input type="text" name="info[unit]" datatype="limit" min="0" max="32" size="10" />
			<span>如：个，元，吨等，没有请留空 </span>
			</td>
		</tr>
		<tr>
			<td width="190" align="right">模板CSS：</td>
			<td>
			<input type="text" name="info[css]" datatype="limit" min="0" max="32" size="10" />
			</td>
		</tr>
		<tr>
			<td width="190" align="right">数据校验：</td>
			<td>
			<select name="info[regex]">
				<option value="">不进行校验</option>
				<option value="limit">常用正则</option>
				<option value="limit3_50">3-50个字符</option>
				<option value="userName">用户名</option>
				<option value="usePsw">用户密码</option>
				<option value="number">数字</option>
				<option value="integer">整数</option>
				<option value="english">字母</option>
				<option value="chinese">中文</option>
				<option value="email">E-mail</option>
				<option value="qq">QQ</option>
				<option value="url">超级链接</option>
				<option value="mobile">手机号码</option>
				<option value="phone">电话号码</option>
				<option value="ip">IP地址</option>	
			</select>
			</td>
		</tr>
		<tr>
			<td width="190" align="right">默认值：</td>
			<td>
			<input type="text" name="info[default]" datatype="limit" min="0" max="255" size="28" />
			<br />
			<span>如果字段类型有多个默认值用 "," 分开!</span>	
			</td>
		</tr>
		<tr>
			<td width="190" align="right">不可删除：</td>
			<td>
			<input type="radio" name="info[cantdelete]" value="1" class="radio" /> 启用  <input type="radio" name="info[cantdelete]" value="0" class="radio" checked="checked" /> 关闭
			<span>启用后,该字段将不能被删除!</span>
			</td>
		</tr>
		<tr>
			<td width="190" align="right">使用权限：</td>
			<td>
			<input type="radio" name="info[adminonly]" value="3" class="radio" /> 仅后台可用  <?php if(!$module->module_disabled('member')){?><input type="radio" name="info[adminonly]" value="2" class="radio" checked="checked" /> 会员可用<?php }?> <input type="radio" name="info[adminonly]" value="1" class="radio" checked="checked" /> 游客可用
			<span>启用后,该字段仅管理员可访问!</span>
			</td>
		</tr>
		<tr class="bg2"><td></td><td><input type="button" class="button" onclick="doSubmit(this);" value="添加字段" /> <input type="button" class="button" onclick="window.location.href='?file=model&action=fields&id=<?php echo $modelid;?>'" value="取消返回" /></td></tr>
	</table>
	</form>

	</div>
</div>
</body>
</html>
