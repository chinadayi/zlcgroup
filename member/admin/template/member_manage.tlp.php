<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('member',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>会员管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<?php include 'ueditor.js.php';?>
<script type="text/javascript" src="admin/template/js/admin.js"></script>
<script language="javascript" src="admin/template/js/css.js"></script>
<script language="javascript">
$(document).ready(function(){
	$('#stype').val('<?php echo $stype;?>');
	$('#gradeid').val('20');
});
</script>
</head>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="?mod=member&file=member&action=manage&level=1" <?php echo $level?'class="on"':'';?>>已审会员</a></li>
			<li><a href="?mod=member&file=member&action=manage&level=0" <?php echo $level?'':'class="on"';?>>待审会员</a></li>	
			<li><a href="?mod=member&file=member&action=member_add">添加会员</a></li>		
		</ul>
	</div>
	<div class="main">
		<div class="search">
			<form action="?" method="get" name="search">
			<input type="hidden" name="mod" value="<?php echo $mod;?>"> 
			<input type="hidden" name="file" value="<?php echo $file;?>"> 
			<input type="hidden" name="action" value="<?php echo $action;?>"> 
			<input type="hidden" name="ispassed" value="<?php echo $ispassed;?>"> 
				<fieldset>
					<legend>会员查找</legend>
						搜索条件：
						<select name="stype" id="stype">
							<option value="username">用户名</option>
							<option value="id">用户ID</option>
						</select>
						&nbsp;&nbsp;
						<input type="text" name="k" size="35" value="<?php echo isset($k)?htmlspecialchars(stripslashes($k)):'';?>" />
						<input type="submit" class="button" value="开始查找" />
				</fieldset>
			</form>
		</div>
		<table cellspacing="0" class="datalist" id="list">
		<tr>
			<th width="40" class="firstcol">反选</th>
			<th width="129">用户名</th>
			<th width="75">会员组</th>
			<th width="75">会员等级</th>
			<th width="75">会员模型</th>
			<th width="52"><a title="按照资金降序排序" href="<?php echo ADMIN_FILE;?>?mod=member&file=member&action=manage&orderby=<?php echo urlencode('amount DESC');?>">资金</a></th>
			<th width="49"><a title="按照积分降序排序" href="<?php echo ADMIN_FILE;?>?mod=member&file=member&action=manage&orderby=<?php echo urlencode('point DESC');?>">积分</a></th>
			<th width="109"><a title="按照注册时间降序排序" href="<?php echo ADMIN_FILE;?>?mod=member&file=member&action=manage&orderby=<?php echo urlencode('regtime DESC');?>">注册时间</a></th>
			<th width="107"><a title="按照登录时间降序排序" href="<?php echo ADMIN_FILE;?>?mod=member&file=member&action=manage&orderby=<?php echo urlencode('logintime DESC');?>">上次登录</a></th>
			<th width="130">管理操作</th>
		</tr>
		<form action="" method="post" name="myform">
		<input type="hidden" name="do_submit" value="1" />
		<?php if($result){foreach($result as $val){if($val['id']!=ADMIN_FOUNDERS || $_userid=ADMIN_FOUNDERS){?>
		<tr title="<?php echo '上次登录地址：'.ip2area($val['loginip']);?>">
			<td width="40" align="center">
			<input type="hidden" name="modelid[<?php echo $val['id'];?>]" value="<?php echo $val['modelid'];?>" />
			<input type="hidden" name="groupid[<?php echo $val['id'];?>]" value="<?php echo $val['groupid'];?>" />
			<input type="checkbox" checked="checked" name="id[]" <?php if($val['id']==ADMIN_FOUNDERS)echo 'disabled="disabled"';?> value="<?php echo $val['id'];?>" class="checkbox" />
			</td>
		  <td width="129" align="center"><a href="<?php echo ADMIN_FILE;?>?mod=member&file=<?php echo $file;?>&action=member_edit&id=<?php echo $val['id'];?>"><?php echo $val['username'];?></a></td>
			<td width="75" align="center"><a href="?mod=member&file=member&action=manage&field=groupid&fieldid=<?php echo $val['groupid'];?>"><?php echo $val['group'];?></a></td>
			<td width="75" align="center"><?php echo $val['grade'];?></td>
			<td width="75" align="center"><a href="<?php echo ADMIN_FILE;?>?mod=member&file=<?php echo $file;?>&action=manage&field=modelid&fieldid=<?php echo $val['modelid'];?>"><?php echo $val['model'];?></a></td>
			<td width="52" align="center"><font color="#FF0000"><b><?php echo $val['amount'];?></b></font></td>
			<td width="49" align="center"><font color="#33CC00"><b><?php echo $val['point'];?></b></font></td>
			<td width="109" align="center"><?php echo date('Y-m-d',$val['regtime']);?></td>
			<td width="107" align="center"><?php echo date('Y-m-d',$val['logintime']);?></td>
			<td width="130" align="center"><a href="<?php echo ADMIN_FILE;?>?mod=member&file=<?php echo $file;?>&action=member_edit&id=<?php echo $val['id'];?>">修改信息</a></td>
		</tr>
		<?php }}?>
		<tr>
			<td width="40" align="center">
			<input type="checkbox" name="chkall2" value="1" checked="checked" class="checkbox" onclick="check_all(this)" /></td>
			<td colspan="9" align="left">
			<input type="radio" value="delete" class="radio" name="do" />删除
			&nbsp;&nbsp;
			<input type="radio" value="lock"  <?php echo $level?' checked="checked"':'';?> class="radio" name="do" />待审
			&nbsp;&nbsp;
			<input type="radio" value="unlock" <?php echo !$level?' checked="checked"':'';?> class="radio" name="do" />审核 
			&nbsp;&nbsp;
			<input type="radio" value="upgrade" class="radio" name="do" />升级为
			<select name="expire">
				<option value="31">一个月</option>
				<option value="93">三个月</option>
				<option value="186">六个月</option>
				<option value="279">九个月</option>
				<option value="365" selected="selected">一年</option>
			</select>
			<select name="gradeid" id="gradeid">
				<?php
				if($membergrade)foreach($membergrade as $_r)
				{
					echo '<option value="'.$_r['grade'].'">'.$_r['name'].'</option>';
				}
				?>
			</select>
			
			&nbsp;&nbsp;
			<input type="button" value="执行操作" class="button" onclick="if(confirm('确定进行选定操作吗？')){this.form.submit();}" />
			</td>
		</tr>
		</form>
		<?php }else{?>
		<tr><td colspan="10">尚未存在任何<?php echo $level?'已':'待';?>审核会员...</td></tr>	
		<?php }?>
		<tr>
			<td colspan="10"><?php echo $member->pagestring;?></td>
		</tr>
		</table>
	</div>
</div>
</body>
</html>
