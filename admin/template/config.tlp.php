<?php
	!defined('RETENGCMS_FLAG') && exit('Access Denied!');
	if(!$check_admin->roleid_check(2,$_roleid))showmsg_nourl($lang['RETURN_NOPRI']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>系统设置</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<link rel="stylesheet" type="text/css" href="admin/template/css/style.css" />
<script src="images/js/jquery.min.js"></script>
<script src="images/js/check.func.js"></script>
<!--编辑器引用文件-->
<script type="text/javascript" charset=utf-8 src="ueditor/ueditor.config.js" ></script>
<script type="text/javascript" charset=utf-8 src="ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset=utf-8 src="ueditor/lang/zh-cn/zh-cn.js" ></script>

<script language="javascript" src="admin/template/js/css.js"></script>


<script type="text/javascript">
$(document).ready(function(){
	for(var i=1;i<7;i++)
	{
		$("#"+i).removeClass("on");
		$("#tab_"+i).css("display","none");
	}
	$("#<?php echo $tab;?>").addClass("on");
	$("#tab_<?php echo $tab;?>").css("display","block");
	$("#timedf").val('<?php echo TIMEDF;?>');
	if(<?php echo FTP;?>)
	{
		$('#uploadftp').show();
	}
	else
	{
		$('#uploadftp').hide();
	}
});

$(function () {
	$(".tab a").each(function () {
		$(this).click(function () {
			$(".tab a").each(function(){
				$(this).attr('class','');
				$("#tab_" + $(this).attr('id')).css('display','none');
			});
			$(this).attr('class', 'on');
			$("#tab_" + $(this).attr('id')).css('display','block');

		});
	});
});

function passportKey()
{
	var randStr='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	var passport_key='';
	for(var i=0;i<10;i++)
	{
		passport_key+=randStr.charAt(Math.random()*randStr.length);
	}
	if($.trim($("#passport_key").val())==''||confirm('更改私有密钥需要同时在其他使用通行证接口的应用程序中修改私有密钥，您确认要更改私有密钥？'))
	{
		$("#passport_key").val(passport_key);
	}
}

function authKey()
{
	var randStr='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	var auth_key='';
	for(var i=0;i<20;i++)
	{
		auth_key+=randStr.charAt(Math.random()*randStr.length);
	}
	$("#auth_key").val(auth_key);
}
</script>
</head>
<body>
<div id="wrap">
	<div class="tab">
	<ul>
		<li><a href="javascript:void(0);" class="on" id="1"><?php echo $lang['LEFT-SYSTEM-2'];?></a></li>
		<li><a href="javascript:void(0);" id="2"><?php echo $lang['LEFT-SYSTEM-3'];?></a></li>
		<li><a href="javascript:void(0);" id="3"><?php echo $lang['LEFT-SYSTEM-4'];?></a></li>
		<?php if($install['member']){?><li><a href="javascript:void(0);" id="5"><?php echo $lang['LEFT-SYSTEM-5'];?></a></li><?php }?>
		<li><a href="javascript:void(0);" id="6"><?php echo $lang['LEFT-SYSTEM-6'];?></a></li>
		<li><a href="javascript:void(0);" id="7"><?php echo $lang['LEFT-SYSTEM-7'];?></a></li>
		<li><a href="<?php echo ADMIN_FILE;?>?file=config&action=config_add"><?php echo $lang['LEFT-SYSTEM-19'];?></a></li>
	</ul>
	</div>
	<div class="main">
		<fieldset>
		<legend><?php echo $lang['RETURN_TIPS'];?></legend>
		合理的网站配置，会使您的网站更加快速高效。
		</fieldset>
	<form action="" method="post" name="myform" id="myform">		
	<input type="hidden" name="do_submit" value="1" /> 
		<table width="100%">
		<tr><td>
			
			<div id="tab_1">
			<table class="sub">
				<tr>
					<td width="200" align="right" style="color:#ff0000">主站安装目录： </td>
					<td>
					<input type="text" name="info[retengcms_path]" value="<?php echo RETENG_PATH;?>" size="14" /> 
					<span>以"/"结尾, 此项必须正确填写, 否则可能导致编辑器无法加载。</span>
					</td>
				</tr>
				<tr>
					<td width="200" align="right" style="color:#ff0000">主站访问域名： </td>
					<td>
					<input type="text" name="info[site_url]" value="<?php echo SITE_URL;?>" size="30" /> 
					<span>以"/"结尾, 此项必须正确填写, 否则可能导致编辑器无法加载。</span>
					</td>
				</tr>
				<tr>
					<td width="200" align="right">后台语言包：</td>
					<td><?php echo $langselect;?>
					<span>针对网站后台</span>
					</td>
				</tr>
				<tr>
					<td width="200" align="right">网站名称：</td>
					<td><input type="text"  name="mem[site_name]" value="<?php echo $RETENG['site_name']?$RETENG['site_name']:'新建站点';?>" size="25" /></td>
				</tr>
				
				<tr>
					<td width="200" align="right">默认模板：</td>
					<td><?php echo $tlp_name;?></td>
				</tr>
				<tr>
					<td width="200" align="right">网站地址：</td>
					<td>
					<input type="text"  name="mem[childsite_url]" size="30" value="<?php echo $RETENG['childsite_url'];?>" />
					<span>请填写完整URL地址，以"/"结尾</span>
					</td>
				</tr>
				<tr>
					<td width="200" align="right">网站副标题：</td>
					<td>
					<input type="text" name="mem[meta_title]" value="<?php echo $RETENG['meta_title'];?>" size="50" />
					</td>
				</tr>
				<tr>
					<td width="200" align="right">网站关键字：</td>
					<td>
					<input type="text" name="mem[meta_keywords]" value="<?php echo $RETENG['meta_keywords'];?>" size="50" />
					<span>设置Meta标签的关键字，用英文逗号分隔</span>
					</td>
				</tr>
				<tr>
					<td width="200" align="right">网站描述：</td>
					<td>
					<textarea name="mem[meta_description]" cols="60" rows="5" ><?php echo $RETENG['meta_description'];?></textarea> 
					<span>设置Meta标签的描述信息</span>
					</td>
				</tr>
				<tr>
					<td width="200" align="right">导航分隔符： </td>
					<td>
					<input type="text" name="mem[separator]" value="<?php echo $RETENG['separator']?$RETENG['separator']:'>';?>" size="4" /> 
					<span>如：网站首页 <b><font color="#FF0000">&gt;</font></b> 新闻</span>
					</td>
				</tr>
				<tr>
				<td width="200"  align="right">HTML后缀：</td>
				<td>
				<input type="text" name="mem[htmlext]" size="10" datatype="limit" min=1  max=30 value="<?php echo $RETENG['htmlext']?$RETENG['htmlext']:'.htm';?>" />
				<span>HTML后缀不要经常修改!修改后请更新内容。</span>
				</td></tr> <!------
				<tr>
				<td width="200"  align="right">只读取默认地区数据： </td>
				<td>
				<input type="radio" class="radio" name="mem[iscity]" value="1"  <?php echo $RETENG['iscity']?'checked="checked"':'';?> />启用
				<input type="radio" class="radio" name="mem[iscity]" value="0"  <?php echo !$RETENG['iscity']?'checked="checked"':'';?>/>关闭
				<span>开启后, 将自动读取默认地区数据，其他地区数据将不显示在前台。 </span>
				</td></tr>
				<tbody>
				<tr>
				<td width="200"  align="right">默认地区名称： </td>
				<td>
				<?php echo js_selectmenu('area','city','mem',$RETENG['city']);?>
				</td></tr>
				</tbody>
				<tr>
				<td width="200"  align="right">地图精准定位： </td>
				<td>
				<?php echo $mapapi;?>
				<input type="text" id="map_map" value="<?php echo $RETENG['map'];?>" onclick="alert('不可手动输入，请点击按钮标注地图!');" readonly="1" name="mem[map]" size="20"  /> <input type="button" value="标注地图" onclick="javascript:window.open('api/map/map_api_'+$('#mapapi').val()+'.php?action=distancepole&x=<?php echo $mapx;?>&y=<?php echo $mapy;?>&id=map_map&config=1','upload','width=600,height=500');"  class="button"/>
				</td></tr>  ---->
				<tr>
					<td width="200" align="right">首页是否静态化： </td>
					<td>
					<input type="radio" class="radio" name="mem[ishtml]" value="1"  <?php echo $RETENG['ishtml']?'checked="checked"':'';?> />静态化
					  
					<input type="radio" class="radio" name="mem[ishtml]" value="0"  <?php echo !$RETENG['ishtml']?'checked="checked"':'';?>/>动态
					</td>
				</tr>
				<tr>
				<td width="200"  align="right">默认时区： </td>
				<td>
				<select name="info[timedf]" id="timedf">
					<option value="-12" >(标准时-12:00) 日界线西</option>
					<option value="-11" >(标准时-11:00) 中途岛、萨摩亚群岛</option>
					<option value="-10" >(标准时-10:00) 夏威夷</option>
					<option value="-9" >(标准时-9:00) 阿拉斯加</option>
					<option value="-8" >(标准时-8:00) 太平洋时间(美国和加拿大)</option>
					<option value="-7" >(标准时-7:00) 山地时间(美国和加拿大)</option>
					<option value="-6" >(标准时-6:00) 中部时间(美国和加拿大)、墨西哥城</option>
					<option value="-5" >(标准时-5:00) 东部时间(美国和加拿大)、波哥大</option>
					<option value="-4" >(标准时-4:00) 大西洋时间(加拿大)、加拉加斯</option>
					<option value="-3.5" >(标准时-3:30) 纽芬兰</option>
					<option value="-3" >(标准时-3:00) 巴西、布宜诺斯艾利斯、乔治敦</option>
					<option value="-2" >(标准时-2:00) 中大西洋</option>
					<option value="-1" >(标准时-1:00) 亚速尔群岛、佛得角群岛</option>
					<option value="111" >(格林尼治标准时) 西欧时间、伦敦、卡萨布兰卡</option>
					<option value="1" >(标准时+1:00) 中欧时间、安哥拉、利比亚</option>
					<option value="2" >(标准时+2:00) 东欧时间、开罗，雅典</option>
					<option value="3" >(标准时+3:00) 巴格达、科威特、莫斯科</option>
					<option value="3.5" >(标准时+3:30) 德黑兰</option>
					<option value="4" >(标准时+4:00) 阿布扎比、马斯喀特、巴库</option>
					<option value="4.5" >(标准时+4:30) 喀布尔</option>
					<option value="5" >(标准时+5:00) 叶卡捷琳堡、伊斯兰堡、卡拉奇</option>
					<option value="5.5" >(标准时+5:30) 孟买、加尔各答、新德里</option>
					<option value="6" >(标准时+6:00) 阿拉木图、 达卡、新亚伯利亚</option>
					<option value="7" >(标准时+7:00) 曼谷、河内、雅加达</option>
					<option value="8" SELECTED>(北京时间) 北京、重庆、香港、新加坡</option>
					<option value="9" >(标准时+9:00) 东京、汉城、大阪、雅库茨克</option>
					<option value="9.5" >(标准时+9:30) 阿德莱德、达尔文</option>
					<option value="10" >(标准时+10:00) 悉尼、关岛</option>
					<option value="11" >(标准时+11:00) 马加丹、索罗门群岛</option>
					<option value="12" >(标准时+12:00) 奥克兰、惠灵顿、堪察加半岛</option>
				</select>
				</td></tr>
				<tr>
					<td width="200" align="right">版权信息：</td>
					<td>
					<textarea name="mem[copyright]" cols="60" rows="5" ><?php echo $RETENG['copyright'];?></textarea> 
					</td>
				</tr>			
				<tr>
					<td width="200" align="right">网站ICP备案序号：</td>
					<td>
					<input type="text" name="mem[icpno]" value="<?php echo $RETENG['icpno'];?>" />
					</td>
				</tr>
				<?php
					foreach($expendvar[1] as $_r)
					{
				?>
				<tr>
					<td width="200" align="right"><?php echo $_r['desc'];?>：</td>
					<td>
					<?php echo createform($_r['type'],$_r['varname'],$_r['value'])?>
					
					<span><?php echo $_r['alt'];?> 模板调用方法： {$RETENG['<?php echo $_r['varname'];?>']}</span>
					<a href="?file=config&action=config_delete&id=<?php echo $_r['id'];?>" onclick="if(!confirm('确实要删除该自定义变量？')){return false}"><u>删除</u></a>
					</td>
				</tr>
				<?php
					}
				?>
			</table>
			</div>
		
			<div id="tab_2" style="display:none">
			<table class="sub">
				<tr>
					<td width="200" align="right">允许附件类型：</td>
					<td><input type="text" name="info[upload_ftype]" value="<?php echo UPLOAD_FTYPE;?>" size="50" /> <span>用|分隔，如jpg|png</span></td>
				</tr>
				<tr>
					<td width="200" align="right">允许附件大小：</td>
					<td><input type="text" name="info[upload_size]" value="<?php echo UPLOAD_SIZE;?>" size="10" /> <span>Byte，1MB = 1024 KB ，1KB = 1024 Byte</span></td>
				</tr>
				<tr>
					<td width="200" align="right">允许同时上传的附件个数</td>
					<td><input type="text" name="info[upload_limit]" value="<?php echo UPLOAD_LIMIT;?>" size="10" /> <span>建议不要超过10个, 0为不限!</span></td>
				</tr>
				<tr>
					<td width="200" align="right">启用远程附件： </td>
					<td>
					 <input type="radio" class="radio" name="info[ftp]" onclick="$('#uploadftp').show()" value="1" <?php echo FTP?' checked="checked"':'';?> /> 开启
					 <input type="radio" class="radio" name="info[ftp]" onclick="$('#uploadftp').hide()" value="0"  <?php echo !FTP?' checked="checked"':'';?>/> 关闭
					 <span>启用远程附件具有减少服务器流量、减轻服务器负载、节约 WEB 空间等优点，建议较大规模的站点开启</span>
					</td>
				</tr>
				<tbody id="uploadftp" style="display:none">
				<tr>
					<td width="200" align="right">启用 SSL 连接： </td>
					<td>
					 <input type="radio" class="radio" name="info[ssl]" value="1" <?php echo SSL?' checked="checked"':'';?> /> 开启
					 <input type="radio" class="radio" name="info[ssl]" value="0"  <?php echo !SSL?' checked="checked"':'';?>/> 关闭
					</td>
				</tr>
				<tr>
					<td width="200" align="right">FTP 服务器地址：</td>
					<td><input type="text" name="info[ftp_server]" size="30" value="<?php echo FTP_SERVER;?>" /> 
					<span>可以是 FTP 服务器的 IP 地址或域名</span></td>
				</tr>
				<tr>
					<td width="200" align="right">FTP 服务器端口：</td>
					<td><input type="text" name="info[ftp_port]" value="<?php echo FTP_PORT;?>" size="6" /> <span>默认为21，一般不需要改</span></td>
				</tr>
				<tr>
					<td width="200" align="right">FTP 帐号：</td>
					<td>
					<input type="text" name="info[ftp_user]" size="20" value="<?php echo FTP_USER;?>"/>
					<span>该帐号必需具有以下权限：读取文件、写入文件、删除文件、创建目录、子目录继承</span>
					</td>
				</tr>
				<tr>
					<td width="200" align="right">FTP 密码：</td>
					<td>
					<input type="password" name="info[ftp_pwd]" size="20" value="<?php echo FTP_PWD;?>"/>
					</td>
				</tr>
				<tr>
					<td width="200" align="right">启用被动模式： </td>
					<td>
					 <input type="radio" class="radio" name="info[pasv]" value="1" <?php echo PASV?' checked="checked"':'';?> /> 开启
					 <input type="radio" class="radio" name="info[pasv]" value="0"  <?php echo !PASV?' checked="checked"':'';?>/> 关闭
					</td>
				</tr>
				<tr>
					<td width="200" align="right">远程附件目录：</td>
					<td>
					<input type="text" name="info[ftp_dir]" size="8" value="<?php echo FTP_DIR;?>"/>
					<span>远程附件目录的绝对路径或相对于 FTP 主目录的相对路径，结尾不要加斜杠 "/" , ./ 表示FTP根目录</span>
					</td>
				</tr>
				<tr>
					<td width="200" align="right">远程访问 URL：</td>
					<td>
					<input type="text" name="info[ftp_url]" size="40" value="<?php echo FTP_URL;?>"/>
					<span>支持 HTTP 和 FTP 协议，结尾不要加斜杠“/”；如果使用 FTP 协议，FTP 服务器必需支持 PASV 模式，为了安全起见，使用 FTP 连接的帐号不要设置可写权限和列表权限</span>
					</td>
				</tr>
				<tr>
					<td width="200" align="right">FTP 传输超时时间：</td>
					<td>
					<input type="text" name="info[ftp_timeout]" size="4" value="<?php echo FTP_TIMEOUT;?>"/>
					<span>单位：秒，90 为服务器默认</span>
					</td>
				</tr>
				</tbody>
				<tr>
					<td width="200" align="right">图片是否启用水印： </td>
					<td>
					 <input type="radio" class="radio" name="info[watermark_enabled]" value="1" <?php echo WATERMARK_ENABLED?' checked="checked"':'';?> /> 开启
					 <input type="radio" class="radio" name="info[watermark_enabled]" value="0"  <?php echo !WATERMARK_ENABLED?' checked="checked"':'';?>/>关闭
					</td>
				</tr>
				<tr>
					<td width="200" align="right">水印显示文字：</td>
					<td>
					<input type="text" name="info[watermark_words]" size="30" value="<?php echo WATERMARK_WORDS;?>" />
					<span>针对不存在水印图片时的情况,只支持英文字符!</span>
					</td>
				</tr>
				<tr>
					<td width="200" align="right">文字水印颜色：</td>
					<td>
					<input type="text" name="info[watermark_color]" size="8" value="<?php echo WATERMARK_COLOR;?>" />
					<span>十六进制颜色! 如： 红色: #FF0000 绿色: #00FF00 蓝色: #0000FF </span>
					</td>
				</tr>
				<tr>
					<td width="200" align="right">水印透明度：</td>
					<td>
					<input type="text" name="info[watermark_pct]" size="4" datatype="number" value="<?php echo WATERMARK_PCT;?>" />
					<span>范围为 1~100 的整数，数值越小水印图片越透明</span>
					</td>
				</tr>
				<tr>
				<td width="200" align="right">水印添加位置：</td>
				<td>
					  <table cellspacing="1" cellpadding="4" width="400">
					  <tr align="center" ><td><input type="radio" class="radio" name="info[watermark_pos]" value="1" <?php echo WATERMARK_POS==1?' checked="checked"':'';?> > 顶部居左</td><td><input type="radio" class="radio" name="info[watermark_pos]" value="2" <?php echo WATERMARK_POS==2?' checked="checked"':'';?>> 顶部居中</td><td><input type="radio" class="radio" name="info[watermark_pos]" value="3" <?php echo WATERMARK_POS==3?' checked="checked"':'';?>> 顶部居右</td></tr>
					  <tr align="center"><td><input type="radio" class="radio" name="info[watermark_pos]" value="4"<?php echo WATERMARK_POS==4?' checked="checked"':'';?> > 中部居左</td><td><input type="radio" class="radio" name="info[watermark_pos]" value="5" <?php echo WATERMARK_POS==5?' checked="checked"':'';?>> 中部居中</td><td><input type="radio" class="radio" name="info[watermark_pos]" value="6" <?php echo WATERMARK_POS==6?' checked="checked"':'';?>> 中部居右</td></tr>
					  <tr align="center"><td><input type="radio" class="radio" name="info[watermark_pos]" value="7"<?php echo WATERMARK_POS==7?' checked="checked"':'';?> > 底部居左</td><td><input type="radio" class="radio" name="info[watermark_pos]" value="8" <?php echo WATERMARK_POS==8?' checked="checked"':'';?>> 底部居中</td><td><input type="radio" class="radio" name="info[watermark_pos]" value="9" <?php echo WATERMARK_POS==9?' checked="checked"':'';?> > 底部居右</td></tr>
					  </table>
					  <span>请将水印图片上传到网站目录下的 images/<?php echo basename(WATERMARK_FILE);?></span>
				</td>
				
				</tr>
			
				<?php
					foreach($expendvar[2] as $_r)
					{
				?>
				<tr>
					<td width="200" align="right"><?php echo $_r['desc'];?>：</td>
					<td>
					<?php echo createform($_r['type'],$_r['varname'],$_r['value'])?>
					
					<span><?php echo $_r['alt'];?> 模板调用方法： {$RETENG['<?php echo $_r['varname'];?>']}</span>
					<a href="?file=config&action=config_delete&id=<?php echo $_r['id'];?>" onclick="if(!confirm('确实要删除该自定义变量？')){return false}"><u>删除</u></a>
					</td>
				</tr>
				<?php
					}
				?>
			</table>
			</div>
			<div id="tab_3" style="display:none">
			<table class="sub">
				<tr>
					<td width="200" align="right">邮件发送方式：</td>
					<td>
					<input type="radio" class="radio" checked="checked" name="info[mail_type]" value="1" <?php echo MAIL_TYPE==1?' checked="checked"':'';?>/>通过SMTP协议发送（支持ESMTP验证，推荐）<br />
				<input type="radio" class="radio" name="info[mail_type]" <?php if(strtolower(substr(PHP_OS,0,3))=='win')echo ' disabled="disabled" ';?>value="2" <?php echo MAIL_TYPE==2?' checked="checked"':'';?>/>通过mail函数发送（仅*unix类主机支持）<br />
				<input type="radio" class="radio" name="info[mail_type]" <?php if(strtolower(substr(PHP_OS,0,3))!='win')echo ' disabled="disabled" ';?> value="3" <?php echo MAIL_TYPE==3?' checked="checked"':'';?>/>通过SOCKET连接SMTP服务器发送（仅Windows主机支持）
					</td>
				</tr>
				<tr>
					<td width="200" align="right">邮件服务器：</td>
					<td><input type="text" name="info[mail_server]" size="30" value="<?php echo MAIL_SERVER;?>" /> <span>用来发送邮件的SMTP服务器，不设置将不能发送邮件，如果你不清楚此参数含义，请联系你的空间商</span></td>
				</tr>
				<tr>
					<td width="200" align="right">邮件发送端口：</td>
					<td><input type="text" name="info[mail_port]" value="<?php echo MAIL_PORT;?>" size="6" /> <span>默认为25，一般不需要改</span></td>
				</tr>
				<tr>
					<td width="200" align="right">发送邮箱帐号：</td>
					<td>
					<input type="text" name="info[mail_user]" size="30" value="<?php echo MAIL_USER;?>"/>
					</td>
				</tr>
				<tr>
					<td width="200" align="right">发送邮箱密码：</td>
					<td>
					<input type="password" name="info[mail_pwd]" size="30" value="<?php echo MAIL_PWD;?>"/>
					</td>
				</tr>
				<tr>
				<td width="200" align="right">邮件内容结尾（邮件签名）： </td>
				<td>
				<textarea name="info[mail_sign]" cols="60" rows="5"><?php echo MAIL_SIGN;?></textarea>
				</td>
				</tr>
				<?php
					foreach($expendvar[3] as $_r)
					{
				?>
				<tr>
					<td width="200" align="right"><?php echo $_r['desc'];?>：</td>
					<td>
					<?php echo createform($_r['type'],$_r['varname'],$_r['value'])?>
					
					<span><?php echo $_r['alt'];?> 模板调用方法： {$RETENG['<?php echo $_r['varname'];?>']}</span>
					<a href="?file=config&action=config_delete&id=<?php echo $_r['id'];?>" onclick="if(!confirm('确实要删除该自定义变量？')){return false}"><u>删除</u></a>
					</td>
				</tr>
				<?php
					}
				?>
			</table>
			</div>
			<div id="tab_4" style="display:none">
			<table class="sub">
				<tr>
					<td width="200" align="right">短信发送账号：</td>
					<td><input type="text" name="info[phone_username]" size="30" value="<?php echo PHONE_USERNAME;?>" /> <span>(注：请到中国短信网申请 <a href="http://www.c123.com" target="_blank">http://www.c123.com</a>) </span></td>
				</tr>
				<tr>
					<td width="200" align="right">短信发送密码：</td>
					<td><input type="text" name="info[phone_pwd]" value="<?php echo PHONE_PWD;?>" size="30" /> </td>
				</tr>
				
				<?php
					foreach($expendvar[4] as $_r)
					{
				?>
				<tr>
					<td width="200" align="right"><?php echo $_r['desc'];?>：</td>
					<td>
					<?php echo createform($_r['type'],$_r['varname'],$_r['value'])?>
					
					<span><?php echo $_r['alt'];?> 模板调用方法： {$RETENG['<?php echo $_r['varname'];?>']}</span>
					<a href="?file=config&action=config_delete&id=<?php echo $_r['id'];?>" onclick="if(!confirm('确实要删除该自定义变量？')){return false}"><u>删除</u></a>
					</td>
				</tr>
				<?php
					}
				?>
			</table>
			</div>
			
			<?php if($install['member']){?>
				
			<div id="tab_5" style="display:none">
			<table class="sub">
				<tr>
					<td width="200"  align="right">是否启用UC：</td>
					<td>
					<input type="radio" class="radio" name="info[uc]" value="1" <?php echo UC?' checked="checked"':'';?>/>启用 
					<input type="radio" class="radio" name="info[uc]" value="0"  <?php echo !UC?' checked="checked"':'';?>/>关闭
					</td>
				</tr>
				<tr>
					<td width="200"  align="right">Ucenter api 地址：</td>
					<td>
					<input type="text" name="info[uc_api]" value="<?php echo UC_API;?>"  size="35" />
					<span>最后不要带斜线 /</span>
					</td>
				</tr>
				<tr>
					<td width="200"  align="right">Ucenter 主机IP地址：</td>
					<td>
					<input type="text" name="info[uc_ip]" value="<?php echo UC_IP;?>" size="18" />
					<span>一般不用填写,遇到无法同步时,请填写ucenter主机的IP地址</span>
					</td>
				</tr>
				<tr>
					<td width="200"  align="right">Ucenter 数据库主机名：</td>
					<td>
					<input type="text" name="info[uc_dbhost]" value="<?php echo UC_DBHOST;?>" size="20" />
					</td>
				</tr>
				<tr>
					<td width="200"  align="right">Ucenter 数据库用户名：</td>
					<td>
					<input type="text" name="info[uc_dbuser]" value="<?php echo UC_DBUSER;?>" size="20" />
					</td>
				</tr>
				<tr>
					<td width="200"  align="right">Ucenter 数据库密码：</td>
					<td>
					<input type="password" name="info[uc_dbpw]" value="<?php echo UC_DBPW;?>" size="20" />
					</td>
				</tr>
				<tr>
					<td width="200"  align="right">Ucenter 数据库名：</td>
					<td>
					<input type="text" name="info[uc_dbname]" value="<?php echo UC_DBNAME;?>" size="20" />
					</td>
				</tr>
				<tr>
					<td width="200"  align="right">Ucenter 数据库表前缀：</td>
					<td>
					<input type="text" name="info[uc_dbtablepre]" value="<?php echo UC_DBTABLEPRE;?>" size="20" />
					</td>
				</tr>
				<tr>
					<td width="200"  align="right">Ucenter 数据库字符集：</td>
					<td>
					<select name="info[uc_dbcharset]">
						<option value="gbk"  <?php echo UC_DBCHARSET=='gbk'?'selected':'';?>>GBK/GB2312</option>
						<option value="utf8" <?php echo UC_DBCHARSET=='utf8'?'selected':'';?>>UTF-8</option>
						<option value="big5" <?php echo UC_DBCHARSET=='big5'?'selected':'';?>>BIG5</option>
					</select>
					</td>
				</tr>
				<tr>
					<td width="200"  align="right">应用id(APP ID)：</td>
					<td><input type="text" name="info[uc_appid]" value="<?php echo UC_APPID;?>" size="4"></td>
				</tr>
				<tr>
					<td width="200"  align="right">Ucenter 通信密钥：</td>
					<td><input type="text" name="info[uc_key]" value="<?php echo UC_KEY;?>" size="20"></td>
				</tr>
				<?php
					foreach($expendvar[5] as $_r)
					{
				?>
				<tr>
					<td width="200" align="right"><?php echo $_r['desc'];?>：</td>
					<td>
				<?php echo createform($_r['type'],$_r['varname'],$_r['value'])?>
					
					<span><?php echo $_r['alt'];?> 模板调用方法： {$RETENG['<?php echo $_r['varname'];?>']}</span>
					<a href="?file=config&action=config_delete&id=<?php echo $_r['id'];?>" onclick="if(!confirm('确实要删除该自定义变量？')){return false}"><u>删除</u></a>
					</td>
				</tr>
				<?php
					}
				?>
			</table>
			</div>
			<?php }?>
			<div id="tab_6" style="display:none">
			<table class="sub">
				<tr>
				<td width="200"  align="right">启用后台管理日志：</td>
				<td>
				<input type="radio" class="radio" name="info[log_disabled]" value="0"  <?php echo !LOG_DISABLED?'checked="checked"':'';?> />启用
				<input type="radio" class="radio" name="info[log_disabled]" value="1"  <?php echo LOG_DISABLED?'checked="checked"':'';?>/>关闭
				<span>开启日志将耗费一定的资源</span>
				</td></tr>
				<tr>
				<td width="200"  align="right">列表页默认信息数：</td>
				<td>
				<input type="text" name="info[pagesize]" size="6" value="<?php echo PAGESIZE;?>" /> 条
				</td>
				</tr>
				
				<tr>
				<td width="200"  align="right">启用页面Gzip压缩：</td>
				<td>
				<input type="radio" class="radio" name="info[gzip]" value="1"  <?php echo GZIP?'checked="checked"':'';?> />启用
				<input type="radio" class="radio" name="info[gzip]" value="0"  <?php echo !GZIP?'checked="checked"':'';?>/>关闭
				<span>将页面内容以gzip压缩后传输，可加快传输速度</span>
				</td></tr>
				<tr>
				<td width="200"  align="right">缓存存储方式：</td>
				<td>
				<input type="radio" class="radio" name="info[cache_storage]" value="files"  <?php echo CACHE_STORAGE=='files'?'checked="checked"':'';?> /> files
				<input type="radio" class="radio" name="info[cache_storage]" value="mysql"  <?php echo CACHE_STORAGE=='mysql'?'checked="checked"':'';?>/> mysql
				<input type="radio" class="radio" name="info[cache_storage]" value="memcache"  <?php echo CACHE_STORAGE=='memcache'?'checked="checked"':'';?>/> memcache
				<span>如果您有服务器支持memcache,建议使用这种缓存方式</span>
				</td></tr>
				<tr>
				<td width="200"  align="right">Session 存储方式：</td>
				<td>
				<input type="radio" class="radio" name="info[session_storage]" value="files"  <?php echo SESSION_STORAGE=='files'?'checked="checked"':'';?> /> files
				<input type="radio" class="radio" name="info[session_storage]" value="mysql"  <?php echo SESSION_STORAGE=='mysql'?'checked="checked"':'';?>/> mysql
				<input type="radio" class="radio" name="info[session_storage]" value="memcache"  <?php echo SESSION_STORAGE=='memcache'?'checked="checked"':'';?>/> memcache
				<span>建议使用mysql存储方式</span>
				</td></tr>
				<tr>
				<td width="200"  align="right">MemCache服务器主机：</td>
				<td>
				<input type="text" name="info[memcache_host]" size="18" value="<?php echo MEMCACHE_HOST;?>" />
				</td></tr>
				<tr>
				<td width="200"  align="right">MemCache服务器端口：</td>
				<td>
				<input type="text" name="info[memcache_port]" size="6" datatype="number" value="<?php echo MEMCACHE_PORT;?>" />
				<span>一般为 11211，无需更改</span>
				</td></tr>
				<tr>
				<td width="200"  align="right">MemCache服务器连接超时：</td>
				<td>
				<input type="text" name="info[memcache_timeout]" size="6" datatype="number" value="<?php echo MEMCACHE_TIMEOUT;?>" /> 秒
				
				</td></tr>
				<tr>
				<td width="200"  align="right">需缓存内容全局缓存时间：</td>
				<td>
				<input type="text" name="info[cache_ttl]" size="6" datatype="number" value="<?php echo CACHE_TTL;?>" /> 秒
				</td></tr>
				<tr>
				<td width="200"  align="right">全文搜索缓存时间：</td>
				<td>
				<input type="text" name="info[searchttl]" size="6" datatype="number" value="<?php echo SEARCHTTL;?>" /> 秒
				</td></tr>
				<?php
					foreach($expendvar[6] as $_r)
					{
				?>
				<tr>
					<td width="200" align="right"><?php echo $_r['desc'];?>：</td>
					<td>
					<?php echo createform($_r['type'],$_r['varname'],$_r['value'])?>
					
					<span><?php echo $_r['alt'];?> 模板调用方法： {$RETENG['<?php echo $_r['varname'];?>']}</span>
					<a href="?file=config&action=config_delete&id=<?php echo $_r['id'];?>" onclick="if(!confirm('确实要删除该自定义变量？')){return false}"><u>删除</u></a>
					</td>
				</tr>
				<?php
					}
				?>
			</table>
			</div>
			
			<div id="tab_7" style="display:none">
			<table class="sub">
  				<tr>
				<td width="200"  align="right">后台文件名：</td>
				<td>
				<input type="text" name="info[admin_file]" size="15" datatype="limit" min=1  max=30 value="<?php echo ADMIN_FILE;?>" />
				</td></tr>
				<tr>
				<td width="200"  align="right">启用标题检测：</td>
				<td>
					<input type="radio" class="radio" name="info[titlecheck]" value="1"  <?php echo TITLECHECK?'checked="checked"':'';?> />启用
					<input type="radio" class="radio" name="info[titlecheck]" value="0"  <?php echo !TITLECHECK?'checked="checked"':'';?>/>关闭
					</td>
				</tr>
				<tr>
				<td width="200"  align="right">发布/编辑内容时更新网站主页： </td>
				<td>
				<input type="radio" class="radio" name="info[autocreateindex]" value="1"  <?php echo AUTOCREATEINDEX?'checked="checked"':'';?> />启用
				<input type="radio" class="radio" name="info[autocreateindex]" value="0"  <?php echo !AUTOCREATEINDEX?'checked="checked"':'';?>/>关闭
				</td></tr>
				<tr>
				<td width="200"  align="right">发布/编辑内容时更新对应栏目： </td>
				<td>
				<input type="radio" class="radio" name="info[autocreatecategory]" value="1"  <?php echo AUTOCREATECATEGORY?'checked="checked"':'';?> />启用
				<input type="radio" class="radio" name="info[autocreatecategory]" value="0"  <?php echo !AUTOCREATECATEGORY?'checked="checked"':'';?>/>关闭
				</td></tr>
				<tr>
				<td width="200"  align="right">发布/编辑时列表页最大更新页数：</td>
				<td>
				<input type="text" name="info[htmlsize]" size="6" value="<?php echo HTMLSIZE;?>" /> 页
				<span>不建议超过100页,太多会影响内容发布的速度!</span>
				</td>
				</tr>
				<tr>
				<td width="200"  align="right">发布/编辑内容时启用伪原创：</td>
				<td>
				<input type="radio" class="radio" name="info[autowyc]" value="1"  <?php echo AUTOWYC?'checked="checked"':'';?> />启用
				<input type="radio" class="radio" name="info[autowyc]" value="0"  <?php echo !AUTOWYC?'checked="checked"':'';?>/>关闭
				</td></tr>
				<tr>
					<td width="200"  align="right">开启评论审核： </td>
					<td>
					<input type="radio" class="radio" name="info[commentpass]" value="1"  <?php echo COMMENTPASS?'checked="checked"':'';?> />启用
					<input type="radio" class="radio" name="info[commentpass]" value="0"  <?php echo !COMMENTPASS?'checked="checked"':'';?>/>关闭
					</td>
				</tr>
				<tr>
					<td width="200" align="right" valign="top">词语过滤：</td>
					<td>
					<textarea name="badwords" cols="60" rows="5" ><?php echo $badwords;?></textarea> 
					<span>不良词语和替换词语之间使用“=”进行分割; 每组词语用换行隔开!</span>
					</td>
				</tr>
				<?php
					foreach($expendvar[7] as $_r)
					{
				?>
				<tr>
					<td width="200" align="right"><?php echo $_r['desc'];?>：</td>
					<td>
				<?php echo createform($_r['type'],$_r['varname'],$_r['value'])?>
					
					<span><?php echo $_r['alt'];?> 模板调用方法： {$RETENG['<?php echo $_r['varname'];?>']}</span>
					<a href="?file=config&action=config_delete&id=<?php echo $_r['id'];?>" onclick="if(!confirm('确实要删除该自定义变量？')){return false}"><u>删除</u></a>
					</td>
				</tr>
				<?php
					}
				?>
			</table>
			</div>
			
			</td>
		</tr>
		<tr>
			<td><input type="button" onfocus="blur();" value="<?php echo $lang['SUBMIT_CONFIG_SAVE'];?>" class="button" onclick="this.form.submit();" style="margin-left:160px" /></td>
		</tr>
	</table>
	</form>
	</div>
</div>
</body>
</html>
