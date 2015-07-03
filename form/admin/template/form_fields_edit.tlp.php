<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('form',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
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
		$('#regex').val('<?php echo $r['regex'];?>');
	});
</script>
</head>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="?mod=form&file=form&action=fields&id=<?php echo $formid;?>">字段管理</a></li>
			<li><a href="?mod=form&file=form&action=fields_add&formid=<?php echo $formid;?>">添加字段</a></li>
			<li><a href="javascript:void(0);" class="on">编辑字段</a></li>		
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		1：字段名称用于在数据库建立字段,由数字、字母、下划线组成!
	</fieldset>
	<form action="" method="post" name="myform">
	<input type="hidden" name="do_submit" value="1" />
	<input type="hidden" name="id" value="<?php echo $id;?>" />
	<input type="hidden" name="info[formid]" value="<?php echo $formid;?>" />
	<input type="hidden" name="info[enname]" value="<?php echo $r['enname'];?>" />
	<input type="hidden" name="info[deform]" value="<?php echo $r['form'];?>" />
	<table cellspacing="0" class="sub" width="100%">
		<tr>
			<td width="190" align="right">字段别名：</td>
			<td width="762">
			<input type="text" name="info[name]" datatype="limit" value="<?php echo $r['name'];?>" min="1" max="64" class="input" size="16" />
			<span><font color="#FF0000">*</font> </span>
		  </td>
		</tr>
		<tr>
			<td width="190" align="right">字段名称：</td>
			<td>
			<?php echo $r['enname'];?>
			</td>
		</tr>
		<tr>
			<td width="190" align="right" valign="top">表单类型：</td>
			<td>
			<ul>
				<li><input type="radio" <?php echo in_array($r['form'],array('title','style','thumb','keywords','description','posid','content','status','point','amount'))?' disabled="disabled"':'';?> class="radio" name="info[form]" <?php echo $r['form']=='text'?' checked="checked"':'';?> value="text" />单行文本(text)</li>				
				<li><input type="radio" <?php echo in_array($r['form'],array('title','style','thumb','keywords','description','posid','content','status','point','amount'))?' disabled="disabled"':'';?> class="radio" name="info[form]" <?php echo $r['form']=='password'?' checked="checked"':'';?> value="password" />密 码 框(password)</li>
				<li><input type="radio" <?php echo in_array($r['form'],array('title','style','thumb','keywords','description','posid','content','status','point','amount'))?' disabled="disabled"':'';?> class="radio" name="info[form]" <?php echo $r['form']=='textarea'?' checked="checked"':'';?> value="textarea" />多行文本(textarea)</li>
				<li><input type="radio" <?php echo in_array($r['form'],array('title','style','thumb','keywords','description','posid','content','status','point','amount'))?' disabled="disabled"':'';?> class="radio" name="info[form]" <?php echo $r['form']=='number'?' checked="checked"':'';?> value="number" />数 字 型(number)</li>
				<li><input type="radio" <?php echo in_array($r['form'],array('title','style','thumb','keywords','description','posid','content','status','point','amount'))?' disabled="disabled"':'';?> class="radio" name="info[form]" <?php echo $r['form']=='radio'?' checked="checked"':'';?> value="radio" />单选按钮(radio)</li>
				<li><input type="radio" <?php echo in_array($r['form'],array('title','style','thumb','keywords','description','posid','content','status','point','amount'))?' disabled="disabled"':'';?> class="radio" name="info[form]" <?php echo $r['form']=='checkbox'?' checked="checked"':'';?> value="checkbox" />多选按钮(checkbox)</li>
				<li><input type="radio" <?php echo in_array($r['form'],array('title','style','thumb','keywords','description','posid','content','status','point','amount'))?' disabled="disabled"':'';?> class="radio" name="info[form]" <?php echo $r['form']=='select'?' checked="checked"':'';?> value="select" />下 拉 框(select)</li>
				<li><input type="radio" <?php echo in_array($r['form'],array('title','style','thumb','keywords','description','posid','content','status','point','amount'))?' disabled="disabled"':'';?> class="radio" name="info[form]" <?php echo $r['form']=='video'?' checked="checked"':'';?> value="video" />媒体文件(video)</li>
				<li><input type="radio" <?php echo in_array($r['form'],array('title','style','thumb','keywords','description','posid','content','status','point','amount'))?' disabled="disabled"':'';?> class="radio" name="info[form]" <?php echo $r['form']=='style'?' checked="checked"':'';?> value="style" />颜色字体(style)</li>
				<li><input type="radio" <?php echo in_array($r['form'],array('title','style','thumb','keywords','description','posid','content','status','point','amount'))?' disabled="disabled"':'';?> class="radio" name="info[form]" <?php echo $r['form']=='image'?' checked="checked"':'';?> value="image" />单张图片(image)</li>
				<li><input type="radio" <?php echo in_array($r['form'],array('title','style','thumb','keywords','description','posid','content','status','point','amount'))?' disabled="disabled"':'';?> class="radio" name="info[form]" <?php echo $r['form']=='images'?' checked="checked"':'';?> value="images" />多张图片(images)</li>
				<li><input type="radio" <?php echo in_array($r['form'],array('title','style','thumb','keywords','description','posid','content','status','point','amount'))?' disabled="disabled"':'';?> class="radio" name="info[form]" <?php echo $r['form']=='attachment'?' checked="checked"':'';?> value="attachment" />附件下载(attachment)</li>
				<li><input type="radio" <?php echo in_array($r['form'],array('title','style','thumb','keywords','description','posid','content','status','point','amount'))?' disabled="disabled"':'';?> class="radio" name="info[form]" <?php echo $r['form']=='datetime'?' checked="checked"':'';?> value="datetime" />日期时间(datetime)</li>
				<li><input type="radio" <?php echo in_array($r['form'],array('title','style','thumb','keywords','description','posid','content','status','point','amount'))?' disabled="disabled"':'';?> class="radio" name="info[form]" <?php echo $r['form']=='copyfrom'?' checked="checked"':'';?> value="copyfrom" />稿件来源(copyfrom)</li>
				<li><input type="radio" <?php echo in_array($r['form'],array('title','style','thumb','keywords','description','posid','content','status','point','amount'))?' disabled="disabled"':'';?> class="radio" name="info[form]" <?php echo $r['form']=='author'?' checked="checked"':'';?> value="author" />文章作者(author)</li>
			  	<li><input type="radio" <?php echo in_array($r['form'],array('title','style','thumb','keywords','description','posid','content','status','point','amount'))?' disabled="disabled"':'';?> class="radio" name="info[form]" <?php echo $r['form']=='fckeditor'?' checked="checked"':'';?> value="fckeditor" />编 辑 器(fckeditor)</li>
				<li><input type="radio" <?php echo in_array($r['form'],array('title','style','thumb','keywords','description','posid','content','status','point','amount'))?' disabled="disabled"':'';?> class="radio" name="info[form]" <?php echo $r['form']=='ip'?' checked="checked"':'';?> value="ip" />发布者IP(ip)</li>
				<li><input type="radio" <?php echo in_array($r['form'],array('title','style','thumb','keywords','description','posid','content','status','point','amount'))?' disabled="disabled"':'';?> class="radio" name="info[form]" <?php echo $r['form']=='map'?' checked="checked"':'';?> value="map" />地图标注(map)</li>
				<li><input type="radio" <?php echo in_array($r['form'],array('title','style','thumb','keywords','description','posid','content','status','point','amount'))?' disabled="disabled"':'';?> class="radio" name="info[form]" <?php echo $r['form']=='more'?' checked="checked"':'';?> value="more" />多选项(more)</li>
				<?php
				if($selectmenu)foreach($selectmenu as $_selectmenu)
				{
					$checked='selectmenu_'.$_selectmenu['table']==$r['form']?' checked="checked"':'';
					echo '<li><input type="radio" disabled="disabled" class="radio" name="info[form]" '.$checked.' value="selectmenu_'.$_selectmenu['table'].'" />'.$_selectmenu['name'].'(级联菜单)</li>';
				}				
				?>
			  </ul>

			</td>
		</tr>
		<tr>
			<td width="190" align="right">字段长度：</td>
			<td>
			<input type="text" name="info[length]" value="<?php echo $r['length'];?>"  size="10" />
			<span>如果字段类型为数字型时,用 "," 表示小数位数。如:8,5</span>
			</td>
		</tr>
		<tr>
			<td width="190" align="right">选项值：</td>
			<td>
			<textarea name="info[options]" cols="60" rows="6"><?php echo $r['options'];?></textarea>
			<br />
			<span>1：当表单类型为单选、多选、下拉单时必填!2：当为编辑器类型时该选项可选值为：'Standard','Basic','Textarea'!</span>
			</td>
		</tr>
		<tr>
			<td width="190" align="right">表单提示：</td>
			<td>
			<input type="text" name="info[tips]" datatype="limit" value="<?php echo $r['tips'];?>" min="0" max="80" class="input" size="28" />
			</td>
		</tr>
		<tr>
			<td width="190" align="right">计量单位：</td>
			<td>
			<input type="text" name="info[unit]" datatype="limit" value="<?php echo $r['unit'];?>" min="0" max="32" size="10" />
			<span>如：个，元，吨等，没有请留空 </span>
			</td>
		</tr>
		<tr>
			<td width="190" align="right">模板CSS：</td>
			<td>
			<input type="text" name="info[css]" datatype="limit" value="<?php echo $r['css'];?>" min="0" max="32" size="10" />
			</td>
		</tr>
		<tr>
			<td width="190" align="right">数据校验：</td>
			<td>
			<select name="info[regex]" id="regex">
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
			<input type="text" name="info[default]" datatype="limit" min="0" max="255" value="<?php echo $r['default'];?>" size="28" />
			<span>如果字段类型有多个默认值用 "," 分开!</span>
			</td>
		</tr>
		<?php if(!$r['cantdelete']){?>
		<tr>
			<td width="190" align="right">不可删除：</td>
			<td>
			<input type="radio" name="info[cantdelete]" value="1" class="radio" <?php echo $r['cantdelete']?' checked="checked"':'';?> /> 启用  <input type="radio" name="info[cantdelete]" value="0" class="radio" <?php echo !$r['cantdelete']?' checked="checked"':'';?>  /> 关闭
			<span>启用后,该字段将不能被删除!</span>
			</td>
		</tr>
		<?php }?>
		<tr>
			<td width="190" align="right">使用权限：</td>
			<td>
			<input type="radio" name="info[adminonly]" value="3" class="radio" <?php echo $r['adminonly']==3?' checked="checked"':'';?> /> 仅后台可用  <?php if(!$module->module_disabled('member')){?><input type="radio" name="info[adminonly]" value="2" class="radio" <?php echo $r['adminonly']==2?' checked="checked"':'';?> /> 会员可用<?php }?> <input type="radio" name="info[adminonly]" value="1" class="radio" <?php echo $r['adminonly']==1?' checked="checked"':'';?> /> 游客可用
			<span>启用后,该字段仅管理员可访问!</span>
			</td>
		</tr>
		<tr class="bg2"><td></td><td><input type="button" class="button" onclick="doSubmit(this);" value="编辑字段" /> <input type="button" class="button" onclick="window.location.href='?mod=form&file=form&action=fields&id=<?php echo $formid;?>'" value="取消返回" /></td></tr>
	</table>
	</form>

	</div>
</div>
</body>
</html>
