<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(14,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $lang['LEFT-MODULE-7'];?></title>
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
			<li><a href="<?php echo ADMIN_FILE;?>?file=module&action=manage"><?php echo $lang['LEFT-MODULE-6'];?></a></li>
			<li><a href="<?php echo ADMIN_FILE;?>?file=module&action=import"><?php echo $lang['LEFT-MODULE-8'];?></a></li>
			<li><a href="javascript:void(0);" class="on">配置模块</a></li>		
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		1:更多模块下载 http://www.reteng.org/ 
	</fieldset>
	<form action="" method="post" name="myform">
	<input type="hidden" name="do_submit" value="1" />
	<input type="hidden" name="id" value="<?php echo $id;?>" />
	<table cellspacing="0" class="sub" width="98%">
		<tr>
			<td width="254" align="right">模块名称：</td>
			<td width="1014">
			<input type="text" name="info[name]" datatype="limit" value="<?php echo $info['name'];?>" min="1" max="60" size="28" />
		  </td>
		</tr>
		<tr>
			<td align="right">模块文件夹：</td>
			<td>
			<input type="text" size="16" disabled="disabled" value="<?php echo $info['folder'];?>" />
			<span>不可更改!</span>
			</td>
		</tr>
		<tr>
			<td width="254" align="right">模块作者：</td>
			<td>
			<input type="text" name="info[author]" datatype="max" value="<?php echo $info['author'];?>" max="60" size="28" />
			</td>
		</tr>
		<tr>
			<td width="254" align="right">官方网址：</td>
			<td>
			<input type="text" name="info[site]" datatype="url" value="<?php echo $info['site'];?>" size="40" />
			</td>
		</tr>
		<tr>
			<td width="254" align="right">模块版本：</td>
			<td>
			<input type="text" name="info[version]" datatype="limit" value="<?php echo $info['version'];?>" min="1" max="10" size="16" />
			</td>
		</tr>
		<tr>
			<td width="254" align="right">前台可直接访问：</td>
			<td>
			<input type="radio" class="radio" name="info[menu]" value="1" <?php echo $info['menu']?'checked="checked"':'';?> />可访问
			<input type="radio" class="radio" name="info[menu]" value="0" <?php echo !$info['menu']?'checked="checked"':'';?> />不可访问
			</td>
		</tr>
		<tr>
			<td width="254" align="right">是否出现在会员中心：</td>
			<td>
			<input type="radio" class="radio" name="info[adminonly]" value="1" <?php echo $info['adminonly']?'checked="checked"':'';?> />不出现
			<input type="radio" class="radio" name="info[adminonly]" value="0" <?php echo !$info['adminonly']?'checked="checked"':'';?> />出现
			</td>
		</tr>
		<tr>
			<td width="254" align="right">后台导航位置：</td>
			<td>
			<input type="radio" class="radio" name="info[adminmenu]" value="1" <?php echo $info['adminmenu']?'checked="checked"':'';?> />头部菜单
			<input type="radio" class="radio" name="info[adminmenu]" value="0" <?php echo !$info['adminmenu']?'checked="checked"':'';?> />拓展功能菜单
			</td>
		</tr>
		<tr>
			<td width="254" align="right">管理员权限：</td>
			<td>
			<?php
				if($roleidarray)foreach($roleidarray as $_roleidarray)
				{
					$roleids=explode(',',$info['roleid']);
					$checked=in_array($_roleidarray['id'],$roleids)?' checked="checked"':'';
					echo '<input type="checkbox" name="info[roleid][]" '.$checked.' value="'.$_roleidarray['id'].'" border="0" />'.$_roleidarray['name'].'&nbsp;&nbsp;';
				}
			?>	
			</td>
		</tr>
		<?php if(!$module->module_disabled('member')){?>
		<tr>
			<td width="254" align="right">会员模型权限：</td>
			<td>
			<?php
				if($modelidarray)foreach($modelidarray as $_modelidarray)
				{
					$modelids=explode(',',$info['modelid']);
					$checked=in_array($_modelidarray['id'],$modelids)?' checked="checked"':'';
					echo '<input type="checkbox" name="info[modelid][]" '.$checked.' value="'.$_modelidarray['id'].'" border="0" />'.$_modelidarray['name'].'&nbsp;&nbsp;';
				}
			?>	
			</td>
		</tr>
		<?php }?>
		<tr>
			<td width="254" align="right">模块新建的数据表：</td>
			<td>
			<input type="text" name="info[tables]" value="<?php echo $info['tables'];?>" size="70" />
			<span>多个数据表用 "," 隔开!</span>
			</td>
		</tr>
		<tr>
			<td width="254" align="right">后台管理菜单：</td>
			<td>
			<textarea name="info[menu_admin]" cols="70" rows="8"><?php echo $info['menu_admin'];?></textarea>
			<span>每个菜单地址用换行隔开, 每行一个 ,地址和名称用|隔开!</span>
			</td>
		</tr>
		<tr>
			<td width="254" align="right">会员中心菜单：</td>
			<td>
			<textarea name="info[menu_member]" cols="70" rows="8"><?php echo $info['menu_member'];?></textarea>
			<span>每个菜单地址用换行隔开, 每行一个 ,地址和名称用|隔开!</span>
			</td>
		</tr>
		<tr>
			<td width="254" align="right">使用协议：</td>
			<td>
			<textarea name="info[agreement]" cols="70" rows="8"><?php echo $info['agreement'];?></textarea>
			</td>
		</tr>
		
		<tr>
			<td width="254" align="right">模块简述：</td>
			<td>
			<textarea name="info[description]" cols="70" rows="8"><?php echo $info['description'];?></textarea>
			</td>
		</tr>
		<tr class="bg2"><td></td><td><input type="button" class="button" onclick="doSubmit(this);" value="配置模块" /> <input type="button" class="button" onclick="window.location.href='<?php echo ADMIN_FILE;?>?file=module&action=manage'" value="取消返回" /></td></tr>
	</table>
	</form>

	</div>
</div>
</body>
</html>
