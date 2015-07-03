<?php
	@header("Cache-Control: no-cache, must-revalidate");
	require substr(dirname(__FILE__),0,-11).'/include/common.inc.php';
?>
function killerrors() 
{ 
	return true; 
}
window.onerror = killerrors;
$(document).ready(function(){
<?php


	if($_userid)
	{
		echo '$(".nologin").hide();';
		echo '$(".haslogin").show();';
	}
	else
	{
		echo '$(".nologin").show();';
		echo '$(".haslogin").hide();';
	}
?>
});

<?php
	require substr(dirname(__FILE__),0,-4).'/data/config.inc.php';
	if(LOGIN_CHECKCODE_ENABLED)
	{
		echo 'var checkcode = "<label>验证码：</label> <input name=\"chkcode\" id=\"checkcode\" style=\"height:16px; line-height:16px; padding:3px 2px 1px; border:solid 1px #b3b3b3\" type=\"text\" size=\"4\" /> <img width=\"65\" align=\"absmiddle\" height=\"22\" src=\"'.$RETENG['site_url'].'api/imcode/checkcode.php\" id=\"img_chkcode\" style=\"cursor:pointer\" onclick=\"this.src=\'api/imcode/checkcode.php?id=\'+Math.random()*5;\" />";';
	}
	else
	{
		echo 'var checkcode="";';
	}
?>
var js_userid='<?php echo $_userid;?>';
var js_username='<?php echo $_username;?>';
var js_facephoto='<?php echo $_facephoto;?>';
var js_email='<?php echo $_email;?>';
var js_message='<?php echo $_message;?>';
var js_email='<?php echo $_email;?>';
var js_amount='<?php echo $_amount;?>';
var js_point='<?php echo $_point;?>';
var js_regtime='<?php echo $_regtime;?>';
var js_logintime='<?php echo $_logintime;?>';
var js_logintimes='<?php echo $_logintime;?>';
var js_loginip='<?php echo $_loginip;?>';
