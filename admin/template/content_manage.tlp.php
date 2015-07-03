<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(9,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>内容管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script type="text/javascript" src="admin/template/js/admin.js"></script>
<script language="javascript" src="admin/template/js/css.js"></script>
<script language="javascript">
$(document).ready(function(){
	$('#stype').val('<?php echo isset($stype)?$stype:'title';?>');
	$('#movetocatid').val('<?php echo isset($catid)?$catid:0;?>');
});
</script>
</head>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="javascript:void(0);" class="on"><?php echo $lang['CONTENT-LANG-1'];?></a></li>
			<?php if(isset($catid) && $catid){?><li><a href="?file=content&action=add&catid=<?php echo $catid;?>"><?php echo $lang['CONTENT-LANG-2'];?></a></li><?php }?>
		</ul>
	</div>
	<div class="main">
		<div class="search">
			<form action="?" method="get" name="search">
			<input type="hidden" name="file" value="<?php echo isset($file)?$file:'content';?>"> 
			<input type="hidden" name="action" value="<?php echo isset($action)?$action:'manage';?>"> 
			<input type="hidden" name="field" value="<?php echo isset($field)?$field:'';?>"> 
			<input type="hidden" name="catid" value="<?php echo $catid;?>"> 
			<input type="hidden" name="fieldvalue" value="<?php echo isset($fieldvalue)?$fieldvalue:'';?>"> 
				<fieldset>
					<legend>内容查找</legend>
						搜索条件：
						<select name="stype" id="stype">
							<option value="id">ID</option>
							<option value="title">标题</option>
							<option value="match">简述</option>
						</select>
						&nbsp;&nbsp;
						关键字：
						<input type="text" name="k" size="35" value="<?php echo isset($k) && !empty($k)?htmlspecialchars(stripslashes($k)):'';?>" />
						<input type="submit" class="button" value="开始查找" />
				</fieldset>
			</form>
		</div>
		<table cellspacing="0" class="datalist" id="list" width="98%">
		<tr>
			<th width="5%" class="firstcol">反选</th>
			<th width="5%">排序</th>
			<th width="25%">标题</th>
			<th width="5%">状态</th>
			<th width="10%">所属栏目</th>
			<th width="7%">录入者</th>
			<th width="4%">点击</th>
			<th width="6%">评论</th>
			<th width="7%">录入时间</th>
			<th width="6%">操作</th>
		</tr>
		<form action="" method="post" name="myform">
		<input type="hidden" name="do_submit" value="1" />
		<input type="hidden" name="catid" value="<?php echo $catid;?>" />
		<input type="hidden" name="field" value="<?php echo isset($field)?$field:'';?>"> 
		<input type="hidden" name="fieldvalue" value="<?php echo isset($fieldvalue)?$fieldvalue:'';?>"> 
		<input type="hidden" name="forwardurl" value="<?php echo CURURL;?>" />
		<?php if($result){foreach($result as $val){?>
		<tr>
			<td align="center">
			<input type="hidden" name="modelid[<?php echo $val['id'];?>]" value="<?php echo $val['modelid'];?>" />
			<input type="hidden" name="groupid[<?php echo $val['id'];?>]" value="<?php echo $val['groupid'];?>" />
			<input type="hidden" name="id[]" value="<?php echo $val['id'];?>" />
			<input type="hidden" name="catid[]" value="<?php echo $val['catid'];?>" />
			<input type="checkbox" name="checkedid[]" value="<?php echo $val['id'];?>" class="checkbox" />
			</td>
		 	<td align="center"><input type="text" name="orderby[<?php echo $val['id'];?>]" size="2" value="<?php echo $val['orderby'];?>" /></td>
			<td align="left"><a href="<?php if($val['islink']){echo $val['url'];}else{?>/show/?id=<?php echo $val['id'];?><?php }?>" <?php echo title_style($val['style']);?> title="<?php echo $val['title'];?>" target="_blank"><?php echo htmlspecialchars(sub_string($val['title'],34));?></A><?php echo $val['thumb']?'[<font color="#ff0000">图</font>]':'';?>&nbsp;<?php echo $val['posid']?'[<font color="#33CC00">荐</font>]':'';?><?php echo $val['islink']?'[<font color="#0000ff">外链</font>]':'';?></td>
			<td align="center"><a href="?file=<?php echo $file;?>&action=<?php echo $action;?>&catid=<?php echo $catid;?>&field=status&fieldvalue=<?php echo $val['status'];?>"><?php echo $val['status']?'通过':'<font color="#FF3300">待审</font>';?></a></td>
			<td  align="center"><a href="?file=<?php echo $file;?>&action=<?php echo $action;?>&catid=<?php echo $catid;?>&field=catid&fieldvalue=<?php echo $val['catid'];?>"><?php echo $val['catname'];?></a></td>
			<td align="center"><a href="?file=<?php echo $file;?>&action=<?php echo $action;?>&catid=<?php echo $catid;?>&field=userid&fieldvalue=<?php echo $val['userid'];?>"><?php echo $val['username'];?></a></td>
			<td align="center"><font color="#FF0000"><b><?php echo $val['clicks'];?></b></font></td>
			<td align="center"><a title="管理该内容的评论" href="?file=comment&action=manage&contentid=<?php echo $val['id'];?>">管理(<font color="#33CC00"><b><?php echo $val['comments'];?></b></font>)</a></td>
			<td align="center"><?php echo date('Y-m-d',$val['inputtime']);?></td>
			<td align="center"><a href="?file=content&action=edit&catid=<?php echo $val['catid'];?>&id=<?php echo $val['id'];?>">修改</a> <a href="/show/?id=<?php echo $val['id'];?>" target="_blank">查看</a></td>
		</tr>
		<?php }?>
		<tr>
			<td width="62" align="center">
		  <input type="checkbox" name="chkall2" value="1" class="checkbox" onclick="check_all_bycheckedid(this)" /></td>
			<td colspan="9" align="left">
			<input type="button" value="重置排序" name="clear_order" class="button" onclick="this.form.action='?file=content&action=clear_order';this.form.submit();" />
			&nbsp;&nbsp;
			<input type="button" value="排 序" name="do_order" class="button" onclick="this.form.action='?file=content&action=manage';this.form.submit();" />
			&nbsp;&nbsp;
			<input type="button" value="更新 HTML"   name="do_pass" class="button" onclick="this.form.action='?file=content&action=html';this.form.submit();" />			 				&nbsp;&nbsp;
			<input type="button" value="审 核"   name="do_pass" class="button" onclick="this.form.action='?file=content&action=pass';this.form.submit();" />			 				&nbsp;&nbsp;
			<input type="button" value="待 审"   name="do_unpass" class="button" onclick="this.form.action='?file=content&action=unpass';this.form.submit();" />			&nbsp;&nbsp;
			<input type="button" value="推 荐"   name="do_support" class="button" onclick="this.form.action='?file=content&action=support';this.form.submit();" />
			&nbsp;&nbsp;
			<input type="button" value="删 除"   name="do_delete" class="button" onclick="if(confirm('确定进行删除操作吗？')){this.form.action='?file=content&action=delete';this.form.submit();}" />			
			&nbsp;&nbsp;
			<input type="button" value="移动至" name="do_move" class="button" onclick="if(confirm('确定进行移动操作吗？')){this.form.action='?file=content&action=move';this.form.submit();}" />
			<select name="movetocatid" id="movetocatid">
				<?php $options->catoptions();?>
			</select>
			
			</td>
		</tr>
		</form>
		<?php }else{?>
		<tr><td colspan="10">目前该栏目下尚未添加任何内容...</td></tr>	
		<?php }?>
		<tr>
			<td colspan="10"><?php echo $content->pagestring;?></td>
		</tr>
		</table>
	</div>
</div>
</body>
</html>
