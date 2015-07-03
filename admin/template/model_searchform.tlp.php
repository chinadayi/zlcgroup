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
<script type="text/javascript" src="admin/template/js/admin.js"></script>
</head>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><li><a href="?file=model&action=manage"><?php echo $lang['LEFT-MODULE-2'];?></a></li>
			<li><a href="?file=model&action=install"><?php echo $lang['LEFT-MODULE-3'];?></a></li>	
			<li><a href="?file=model&action=import"><?php echo $lang['LEFT-MODULE-4'];?></a></li>
			<li><a href="javascript:void(0);" class="on"><?php echo $lang['LEFT-MODULE-12'];?></a></li>		
		</ul>
	</div>
	<div class="main">
	<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		1：请将生成的HTML放到模板的相应位置即可! 2：自定义搜索会影响效率,请适量选择可选字段!
	</fieldset>
	<?php if(isset($do_submit)){?>
	<form action="" method="post" name="myform" target="_blank">
	<input type="hidden" name="do_submit" value="2" />
	<table cellspacing="0" class="sub">
		<tr>
			<td width="80" align="right">模板标记：</td>
			<td>
			<textarea cols="80" name="html" id="html" rows="12"><?php echo $htmlcode;?></textarea>
			</td>
		</tr>
		<tr class="bg2"><td></td><td><input type="button" class="button" onclick="javascript:copy($('#html').val());" value="复制代码" />  <input type="submit" class="button" value="预览效果" /></td></tr>
	</table>
	</form>
	<?php }else{?>
	<form action="" method="post" name="myform">
	<input type="hidden" name="do_submit" value="1" />
	<input type="hidden" name="modelid" value="<?php echo $id;?>" />
	<table cellspacing="0" class="sub">
		<tr>
			<td width="80" align="right">模型名称：</td>
			<td>
			<?php echo $modelinfo['name'];?>
			</td>
		</tr>
		<tr>
			<td width="80" align="right">可选字段：</td>
			<td>
			<?php
			if($r)foreach($r as $_r)
			{		
				if(in_array($_r['form'],array('text','expire','number','radio','select','checkbox','author','copyfrom','textarea','fckeditor','title','description')))echo '<input type="checkbox" class="checkbox" name="fields[]" value="'.$_r['id'].'" /> '.$_r['name'].'&nbsp;&nbsp;';
			}
			?>
			
			<span>自定义搜索会影响效率,请适量选择可选字段!</span>
			</td>
		</tr>
		<tr class="bg2"><td></td><td><input type="submit" class="button" value="生成模板搜索表单" /></td></tr>
	</table>
	</form>
	<?php }?>
	</div>
</div>
</body>
</html>
