<?php
	!defined('MEMBER_CENTER') && exit('Access Denied!');
?>
<script language="javascript" type="text/javascript">
function killerrors() 
{ 
	return true; 
}
window.onerror = killerrors;

function togglemenu(i)
{
	var num=<?php echo sizeof($leftmodmenu);?>;
	for(m=0;m<num;m++)
	{
		if(m!=i)
		{
			$('#img_'+m).attr('src','member/template/images/plus.gif');
			$('#leftmodmenu_'+m).hide();
		}
	}
	$('#img_'+i).attr('src','member/template/images/minus.gif');
	$('#leftmodmenu_'+i).show('fast');
}

function toggleselfmenu(id)
{
	if($('#img_'+id).attr('src')=='member/template/images/minus.gif')
	{
		$('#img_'+id).attr('src','member/template/images/plus.gif');
		$('#menu_'+id).hide();
	}
	else
	{
		$('#img_'+id).attr('src','member/template/images/minus.gif');
		$('#menu_'+id).show();
	}
}
function showHide(a) {
    var b = document.getElementById(a);
    if (b.style.display == 'block') {
        b.style.display = 'none'
    } else {
        b.style.display = 'block'
    }
};
function togglecat(a, b) {
    if (document.getElementById(b).style.display == '') {
        document.getElementById(b).style.display = 'none';
        document.getElementById(a).className = 'plus'
    } else {
        document.getElementById(b).style.display = '';
        document.getElementById(a).className = 'minus'
    }
};
document.getElementById('bott_ban').innerHTML = unescape('%u7248%u6743%u6240%u6709%20RETENGCMS');
</script>
<div id="sidebar">
<div class="box">
<div class="bg">
<h2 class="title"><img src="member/template/images/minus.gif" id="img_myinfo" /> <a href="javascript:void(0);" onclick="toggleselfmenu('myinfo');"><?php echo $memlang['my-info'];?></a></h2>
<div class="menu" id="menu_myinfo">
	<div class="bg">
		<ul>
		<li><img src="member/template/images/friend.gif" /><a href="member/index.php?file=user&action=editphoto"><?php echo $memlang['photo-edit'];?></a><em><a href="member/index.php?file=user&action=editphoto"><?php echo $memlang['go'];?></a></em></li>
		<li><img src="member/template/images/profile.gif" /><a href="member/index.php?file=user&action=edit"><?php echo $memlang['info-edit'];?></a><em><a href="member/index.php?file=user&action=editpsw"><?php echo $memlang['psw-edit'];?></a></em></li>
		<li><img src="member/template/images/upgrade_ico.png" /><a href="member/index.php?file=user&action=upgrade"><?php echo $memlang['my-update'];?></a><em><a href="member/index.php?file=user&action=upgrade"><?php echo $memlang['go'];?></a></em></li>
		</ul>
	</div>
</div>
<?php if($leftcatmenu){?>
<h2 class="title"><img src="member/template/images/minus.gif" id="img_content" /> <a href="javascript:void(0);" onclick="toggleselfmenu('content');"><?php echo $memlang['content-manage'];?></a></h2>
<div class="menu" id="menu_content">
	<div class="bg">
		<ul class="memcon">		
		<?php
			require_once RETENG_ROOT.'/include/options.class.php';
			$options=new options();
			$options->membercatlist();
		?>
		</ul>
	</div>
</div>
<?php }?>
<!-- 模块开始 -->
<?php
	$i=0;
	if($leftmodmenu)foreach($leftmodmenu as $modval)
	{
?>
<div class="bg">
	<h2 class="title"><a href="javascript:void(0);" onclick="javascript:togglemenu(<?php echo $i;?>);"><img src="member/template/images/<?php echo (($i==0 && !isset($_GET['mod'])) || $mod==$modval['folder'])?'minus':'plus';?>.gif" id="img_<?php echo $i;?>" /> <?php echo $modval['name'];?></a></h2>
	<div class="menu" id="leftmodmenu_<?php echo $i;?>" style="display:<?php echo (($i==0 && !isset($_GET['mod'])) || $mod==$modval['folder'])?'block':'none';?>">
		<div class="bg">
			<ul>
			<?php $membermenu=explode("\r\n",$modval['menu_member']);if($membermenu)foreach($membermenu as $_r){$_r=explode("|",$_r);?>
				<li><img src="member/template/images/list.gif" /><a href="<?php echo $_r[0];?>"><?php echo $_r[1];?></a><em><a href="<?php echo $_r[0];?>"><?php echo $memlang['go'];?></a></em></li>
			<?php }?>
			</ul>
		</div>
	</div>
</div>
<?php
	$i++;
	}
?>
<!-- 模块结束 -->
</div>
<h2 class="msgtitle"><img src="member/template/images/minus.gif" id="img_msg" /> <a href="javascript:void(0);" onclick="toggleselfmenu('msg');"><?php echo $memlang['msg-box'];?></a></h2>
<div class="menu" id="menu_msg">
<ul>
	<li><img src="member/template/images/record.gif" /><a href="member/index.php?file=msg&action=send"><?php echo $memlang['send-msg'];?></a><em><a href="member/index.php?file=msg&action=send"><?php echo $memlang['go'];?></a></em></li>
	<li><img src="member/template/images/record.gif" /><a href="member/index.php?file=msg&action=inbox"><?php echo $memlang['receive-box'];?></a><em><a href="member/index.php?file=msg&action=inbox"><?php echo $memlang['go'];?></a></em></li>
	<li><img src="member/template/images/record.gif" /><a href="member/index.php?file=msg&action=outbox"><?php echo $memlang['send-box'];?></a><em><a href="member/index.php?file=msg&action=outbox"><?php echo $memlang['go'];?></a></em></li>
</ul>
</div>
<div class="menu">
<ul>
<li><img src="member/template/images/out.gif" /><a href="member/index.php?file=login&action=logout"><?php echo $memlang['logout-long'];?></a></li>
</ul>
</div>
</div>
</div>
