<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$module->roleid_check('guestbook',$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>留言管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script type="text/javascript" src="admin/template/js/admin.js"></script>
<script language="javascript" src="admin/template/js/css.js"></script>
</head>
<body>
<div id="wrap">
	<div class="tab">
		<ul>
			<li><a href="?mod=guestbook&file=guestbook&action=manage&passed=1" <?php echo !isset($passed) || $passed?'class="on"':'';?>>已审留言</a></li>
			<li><a href="?mod=guestbook&file=guestbook&action=manage&passed=0" <?php echo isset($passed) && $passed==0?'class="on"':'';?>>待审留言</a></li>
		</ul>
	</div>
	<div class="main">
		<div class="search">
			<form action="" method="get" name="search">
			<input type="hidden" name="mod" value="<?php echo $mod;?>"> 
			<input type="hidden" name="file" value="<?php echo $file;?>"> 
			<input type="hidden" name="action" value="<?php echo $action;?>">
			<input type="hidden" name="passed" value="<?php echo $passed;?>">
				<fieldset>
					<legend>搜索评论</legend>
						关键字：
						<input type="text" name="k" size="35" value="<?php echo isset($k)?htmlspecialchars(stripslashes($k)):'';?>" />
						<input type="submit" class="button" value="开始查找" />
				</fieldset>
			</form>
		</div>
		<table cellspacing="0" class="datalist" id="list" width="98%">
		<tr>			
			<th width="6%" class="firstcol">选择</th>
            <th width="9%">姓名</th>
			<th width="13%">标题</th>
            <th width="20%">内容</th>            
			<th width="11%">发表时间</th> 
           <th width="9%">回复</th>
			<th width="9%">状态</th>	
			<th width="9%">隐藏</th>		
            <th width="14%">管理</th>
		</tr>
		<form action="" method="post" name="myform">
		<input type="hidden" name="do_submit" value="1" />
		<?php if($result){foreach($result as $val){?>
		<tr>
			<td align="center"><input type="checkbox" class="checkbox" name="id[]" value="<?php echo $val['id'];?>" /></td>
			 <td align="left" style="padding-left:5px"><a href="mailto:<?php echo $val['email'];?>"><?php echo $val['username'];?></a><?php echo $val['sex'];?></td>
            <td align="left" style="padding-left:5px"><?php echo $val['title'];?></td>
            <td align="center"><?php echo strip_tags($val['content']);?></td>
            <td align="center"><?php echo date('Y-m-d',$val['addtime']);?></td>
			<td align="center"><?php echo $val['reply']?'已回复':'<a href="?mod=guestbook&file=guestbook&action=reply&id='.$val['id'].'" title="回复留言"><font color="#FF3300">未回复</font></a>';?></td>
			<td align="center"><?php echo $val['passed']?'通过 <a href="'.ADMIN_FILE.'?mod=guestbook&file=guestbook&action=pass&passed=0&id='.$val['id'].'"><u>待审</u></a>':'待审 <a href="'.ADMIN_FILE.'?mod=guestbook&file=guestbook&action=pass&passed=1&id='.$val['id'].'"><u>审核</u></a>';?></td>
			<td align="center"><?php echo $val['hidden']?'隐藏 <a href="'.ADMIN_FILE.'?mod=guestbook&file=guestbook&action=hidden&hidden=0&id='.$val['id'].'"><u>显示</u></a>':'显示 <a href="'.ADMIN_FILE.'?mod=guestbook&file=guestbook&action=hidden&hidden=1&id='.$val['id'].'"><u>隐藏</u></a>';?></td>
            <td align="center"><a href="javascript:confirmUrl('您确定要删除留言【<?php echo $val['title'];?>】吗?','?mod=guestbook&file=guestbook&action=delete&id=<?php echo $val['id'];?>')"><u>删除</u></a> &nbsp;| &nbsp; <a href="?mod=guestbook&file=guestbook&action=reply&id=<?php echo $val['id'];?>"><u>回复</u></a></td>
		</tr>
		<?php }?>
		<tr>
			<td width="6%" align="center">
			 <input type="checkbox" name="chkall2" value="1" class="checkbox" onclick="check_all(this)" />
		  </td>
			<td colspan="8">
			<input type="button" onclick="if(confirm('您确定要删除留言吗?')){this.form.action='?mod=guestbook&file=guestbook&action=delete';this.form.submit();}" class="submit" value="批量删除" />
			</td>
		</tr>
		</form>
		<?php }else{?>
		<tr><td colspan="9">目前尚未添加任何留言...</td></tr>	
		<?php }?>
		<tr>
			<td colspan="9"><?php echo $guestbook->pagestring;?></td>
		</tr>
		</table>
	</div>
</div>
</body>
</html>
