<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(9,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>评论管理</title>
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
			<?php 
				if(!isset($status) || !$status)
				{
			?>
			<li><a href="javascript:void(0);" class="on"><?php echo $lang['COMMENT-LANG-0'];?></a></li>
			<li><a href="?file=comment&action=manage&status=1&contentid=<?php echo isset($contentid)?$contentid:0;?>"><?php echo $lang['COMMENT-LANG-1'];?></a></li>
			<li><a href="?file=comment&action=manage&status=99&contentid=<?php echo isset($contentid)?$contentid:0;?>"><?php echo $lang['COMMENT-LANG-2'];?></a></li>	
			<?php 
				}
				else if(isset($status) && $status==1)
				{
			?>
			<li><a href="?file=comment&action=manage&contentid=<?php echo isset($contentid)?$contentid:0;?>"><?php echo $lang['COMMENT-LANG-0'];?></a></li>
			<li><a href="javascript:void(0);" class="on"><?php echo $lang['COMMENT-LANG-1'];?></a></li>
			<li><a href="?file=comment&action=manage&status=99&contentid=<?php echo isset($contentid)?$contentid:0;?>"><?php echo $lang['COMMENT-LANG-2'];?></a></li>	
			<?php 
				}
				else
				{
			?>
			<li><a href="?file=comment&action=manage&contentid=<?php echo isset($contentid)?$contentid:0;?>"><?php echo $lang['COMMENT-LANG-0'];?></a></li>
			<li><a href="?file=comment&action=manage&status=1&contentid=<?php echo isset($contentid)?$contentid:0;?>"><?php echo $lang['COMMENT-LANG-1'];?></a></li>
			<li><a href="javascript:void(0);" class="on"><?php echo $lang['COMMENT-LANG-2'];?></a></li>	
			<?php }?>
		</ul>
	</div>
	<div class="main">
		<div class="search">
			<form action="?" method="get" name="search">
			<input type="hidden" name="file" value="comment"> 
			<input type="hidden" name="action" value="manage">
			<input type="hidden" name="status" value="<?php echo isset($status)?$status:0;?>">
			<input type="hidden" name="contentid" value="<?php echo isset($contentid)?$contentid:0;?>">
				<fieldset>
					<legend>搜索评论</legend>
						关键字：
						<input type="text" name="k" size="35" value="<?php echo isset($k)&&$k?htmlspecialchars(stripslashes($k)):'';?>" />
						<input type="submit" class="button" value="开始查找" />
				</fieldset>
			</form>
		</div>
		<table cellspacing="0" class="datalist" id="list" width="98%">
		<tr>
			<th width="40" class="firstcol">反选</th>
			<th width="110">发布者</th>
			<th width="170">发布IP</th>
			<th width="1000">内容</th>
			<th width="70">状态</th>
			<th width="70">支持</th>
			<th width="70">反对</th>
			<th width="140">评论时间</th>
			<th width="70">原文</th>
		</tr>
		<form action="" method="post" name="myform">
		<input type="hidden" name="do_submit" value="1" />
		<input type="hidden" name="cururl" value="<?php echo getcururl();?>" />
		<?php if($result){foreach($result as $val){?>
		<tr>
			<td width="40" align="center">
			<input type="checkbox" name="id[]" value="<?php echo $val['id'];?>" class="checkbox" />
		  </td>
		  	<td width="110" align="center"><a href="?file=comment&action=manage&userid=<?php echo $val['userid'];?>&contentid=<?php echo isset($contentid)?$contentid:0;?>"><?php echo $val['username'];?></a></td>
			<td width="170" align="center"><a href="?file=comment&action=manage&ip=<?php echo $val['ip'];?>&contentid=<?php echo isset($contentid)?$contentid:0;?>"><?php echo $val['ip'];?></a></td>
			<td width="1000" align="left"><?php echo bbcode($val['content']);?></td>
			<td width="70" align="center"><?php echo $val['status']==1?'通过':'<font color="#ff0000">待审</font>';?></td>
			<td width="70" align="center"><font color="#FF0000"><b><?php echo $val['support'];?></b></font></td>
			<td width="70" align="center"><font color="#33CC00"><b><?php echo $val['against'];?></b></font></td>
			<td width="140" align="center"><?php echo date('Y-m-d',$val['addtime']);?></td>
			<td width="70" align="center"><a href="/show/?id=<?php echo $val['contentid'];?>" target="_blank">查看</a></td>
		</tr>
		<?php }?>
		<tr>
			<td width="40" align="center">
		  <input type="checkbox" name="chkall2" value="1" class="checkbox" onclick="check_all(this)" /></td>
			<td colspan="8" align="left">			
			<input type="button" value="审 核" class="button" name="do_pass" class="dosubmit" onclick="this.form.action='?file=comment&action=pass';this.form.submit();" />
			&nbsp;&nbsp;
			<input type="button" value="待 审" class="button" name="do_unpass" class="dosubmit" onclick="this.form.action='?file=comment&action=unpass';this.form.submit();" />
			&nbsp;&nbsp;
			<input type="button" value="删 除" class="button" name="do_delete" class="dosubmit" onclick="if(confirm('确定进行删除操作吗？')){this.form.action='?file=comment&action=delete';this.form.submit();}" />
			</td>
		</tr>
		</form>
		<?php }else{?>
		<tr><td colspan="9"> 还没有任何评论...</td></tr>	
		<?php }?>
		<tr>
			<td colspan="9"><?php echo $commentobj->pagestring;?></td>
		</tr>
		</table>
	</div>
</div>
</body>
</html>
