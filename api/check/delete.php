<?php
	include '../../include/common.inc.php';
	$contentid=intval($contentid);

	include RETENG_ROOT.'include/content.class.php';
	$conobj= new content();
	if(isset($dosubmit))
	{
		$coninfo=$conobj->get($contentid);
		if(trim($coninfo['password']) && $coninfo['password']==$password)
		{
			$conobj->delete($contentid,'admin',true);
			exit('<script language="javascript">alert("'.$baselang['operation-succss'].'");history.back();</script>');
		}
		else
		{
			exit('<script language="javascript">alert("'.$baselang['operation-error-badpwd'].'");history.back();</script>');
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="javascript" src="<?php echo $RETENG['site_url'];?>images/js/jquery.min.js" type="text/javascript"></script>
<style type="text/css">
body{margin:20px auto; padding:0px; text-align:center; font-size:12px}
input{font-size:12px; padding:2px; margin:0px}
.inputtext{border:#ccc 1px solid}
</style>
<title>信息删除</title>
</head>

<body onload="$('#password').focus();">
<form action="" method="post" name="myform">
<input type="hidden" name="dosubmit" value="1" />
<input type="hidden" name="contentid" value="<?php echo $contentid;?>" />
<?php echo $baselang['delete-password'];?><input class="inputtext" type="text" size="16" id="password" name="password" /> <input type="submit" value="确认删除" />
</form>
</body>
</html>
