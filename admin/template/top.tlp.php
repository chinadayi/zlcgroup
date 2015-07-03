<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>头部</title>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/top.css" />
<script type="text/javascript" src="images/js/jquery.min.js"></script>
<script language="javascript" type="text/javascript" charset="utf-8" src="admin/template/js/topmenu.js"></script>
<script language="javascript" type="text/javascript">

var displayBar=true;
function switchBar(obj)
{
	if (document.all) //IE
	{
		if (displayBar)
		{
			parent.frame.cols="0,*";
			displayBar=false;
			obj.value="<?php echo $lang['TOP-LANG-6-1'];?>";
		}
		else{
			parent.frame.cols="210,*";
			displayBar=true;
			obj.value="<?php echo $lang['TOP-LANG-6'];?>";
		}
	}
	else //Firefox 
	{  
		if (displayBar)
		{
			self.top.document.getElementById('frame').cols="0,*";
			displayBar=false;
			obj.value="<?php echo $lang['TOP-LANG-6-1'];?>";
		}
		else{
			self.top.document.getElementById('frame').cols="210,*";
			displayBar=true;
			obj.value="<?php echo $lang['TOP-LANG-6'];?>";
		}
	}
}
</script>
</head>

<body oncontextmenu="return false" ondragstart="return false" onSelectStart="return false">
<div class="top_box">
    <div class="top_logo"></div>
    <div class="top_nav">
         <div class="top_nav_sm">
		 <?php if($_roleid<=5){?>
		 <span style="float:right; padding-right:12px"><?php foreach($allcrowd as $crowd){if($crowd['id']==SITEID){echo '[<b><u><span  title="当前站点">'.trim($crowd['site_name']).'</span></u></b>] ';}else{?>[<a href="<?php echo ADMIN_FILE;?>?file=sitecrowd&action=setting&id=<?php echo $crowd['id'];?>" target='main'><?php echo $crowd['site_name'];?></a>] <?php }}?> [<a href="<?php echo ADMIN_FILE;?>?file=sitecrowd&action=manage" target='main'>分站管理</a>]</span>
		 <?php }?>
		<?php echo $lang['HELLO'];?>！<?php echo $_username;?> [<?php 
				if($_userid==ADMIN_FOUNDERS)
				{
					echo $lang['ADMIN_FOUNDERS'];
				}
				else
				{
					echo $admin->get_rolename($_roleid);
				}
		?>]  &nbsp;&nbsp;&nbsp;&nbsp; <a href="index.php?nocache=1&siteid=<?php echo SITEID;?>" target="_blank"><?php echo $lang['TOP-LANG-1'];?></a> | <a href="http://cms.reteng.org" target="_blank"><?php echo $lang['TOP-LANG-2'];?></a> &nbsp; 
		</div>
         <div class="top_nav_xm">
             <div class="navtit" id="navtit">
                <?php if($_roleid<=5){?><span onclick="changeMenu(this);" class="hover"><a href="javascript:void(0);" onclick="goindex()"><i><?php echo $lang['TOP-LANG-10'];?></i></a></span><?php }?>
		        <?php if($check_admin->roleid_check(1,$_roleid)){?><span onclick="changeMenu(this);"><a href="<?php echo ADMIN_FILE;?>?file=left&menu=system" target='leftFrame'><i><?php echo $lang['TOP-LANG-11'];?></i></a></span><?php }?>
				
				<?php if($check_admin->roleid_check(6,$_roleid)){?><span onclick="changeMenu(this);"><a href="<?php echo ADMIN_FILE;?>?file=left&menu=category" target='leftFrame'><i><?php echo $lang['TOP-LANG-12'];?></i></a></span><?php }?>
				<?php if($check_admin->roleid_check(6,$_roleid)){?><span onclick="changeMenu(this);"><a href="<?php echo ADMIN_FILE;?>?file=left&menu=content" target='leftFrame'><i><?php echo $lang['TOP-LANG-12-1'];?></i></a></span><?php }?>		
				<?php
					if($moduleinfo)foreach($moduleinfo as $_moduleinfo)
					{
						echo '<span onclick="changeMenu(this);"><a href="'.ADMIN_FILE.'?file=left&menu=module&path='.$_moduleinfo['folder'].'" target="leftFrame"><i>'.$_moduleinfo['name'].'</i></a></span>';
					}
				?>
				<?php if($_roleid<=5){?>
				<span onclick="changeMenu(this);"><a href="<?php echo ADMIN_FILE;?>?file=left&menu=other" target='leftFrame'><i>拓展功能</i></a></span>
				<?php }?>
             </div>
         </div>
    </div>
    <div class="top_bar"><input onClick="switchBar(this)" type="button" value="<?php echo $lang['TOP-LANG-6'];?>" name="SubmitBtn" class="bntof"/> 
    <div class="top_she">  
		<a href="javascript:void(0);" onClick="self.top.location.href='<?php echo ADMIN_FILE;?>?file=login&action=logout'"><?php echo $lang['ADMIN_LOGOUT'];?></a>
		<?php if($check_admin->roleid_check(10,$_roleid)){?><a href="<?php echo ADMIN_FILE;?>?file=left&menu=template" target='leftFrame'><?php echo $lang['TOP-LANG-13'];?></a><?php }?>
		<?php if($check_admin->roleid_check(14,$_roleid)){?><a href="<?php echo ADMIN_FILE;?>?file=left&menu=module" target='leftFrame'>模块插件</a><?php }?>
         <?php if($check_admin->roleid_check(8,$_roleid)){?><a href="<?php echo ADMIN_FILE;?>?file=left&menu=html" target='leftFrame'><?php echo $lang['TOP-LANG-15'];?></a><?php }?>
    </div>
    </div>
</div>
</body>
</html>

