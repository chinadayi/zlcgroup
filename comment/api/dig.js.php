<?php
	/*
		评论顶一下调用JS
	*/
	header("Cache-Control: no-cache, must-revalidate");
	include substr(dirname(__FILE__),0,-12).'/include/common.inc.php';

	if(isset($id) && intval($id) >0)
	{
		include substr(dirname(__FILE__),0,-4).'/include/comment.class.php';
		$commentobj=new comment();
		
		$md5key=md5('comment_'.$id.IP);
		if(!isset($_COOKIE[$md5key]))
		{
			setcookie($md5key,'dc',TIME+3600);

			if($action=='digup')
			{
				$data=$commentobj->digup($id);
			}
			elseif($action=='digdown')
			{
				$data=$commentobj->digdown($id);
			}
		}
		else
		{
			$data='repeat';
		}
		exit($data);
	}
?>
function digcommentup(id)
{
	var url='comment/api/dig.js.php?action=digup&id='+id;
	$.get(url,function(data){
		if(data!='repeat')
		{
			alert('成功表态, 谢谢您的支持!');
			$('#digups_'+id).html(data);
		}
		else
		{
			alert('您已经表过态了!');
		}
	});
}

function digcommentdown(id)
{
	var url='comment/api/dig.js.php?action=digdown&id='+id;
	$.get(url,function(data){
		if(data!='repeat')
		{
			alert('成功表态, 谢谢您的支持!');
			$('#digdowns_'+id).html(data);
		}
		else
		{
			alert('您已经表过态了!');
		}
	});
}
