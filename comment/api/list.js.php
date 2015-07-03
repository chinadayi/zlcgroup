<?php
	/*
		评论列表调用JS
	*/
	include substr(dirname(__FILE__),0,-12).'/include/common.inc.php';

	include substr(dirname(__FILE__),0,-4).'/include/comment.class.php';
	$commentobj=new comment();
	
	$contentid=intval($contentid);
	$len=isset($len) && intval($len) >0?intval($len):10;
	$data=$commentobj->concommentlist($contentid,$len,false);
	if(!isset($contentid) || !$data)exit('document.write("<table cellpadding=\"0\" cellspacing=\"0\" width=\"95%\"><tr><td align=\"center\">暂无评论!</td></tr></table>")');

	if($data)
	{
		echo 'document.write("<table cellpadding=\"0\" cellspacing=\"0\" width=\"98%\" style=\"margin:5px auto\">");';
		foreach($data as $_r)
		{
			echo 'document.write("<tr>");';
			echo 'document.write("<td align=\"center\" valign=\"top\" width=\"100\" style=\"border-bottom:#ccc 1px dashed; padding:5px\"><img alt=\"IP:'.$_r['ip'].'\" src=\"'.$_r['userface'].'\" style=\"border:#ccc 1px solid; padding:1px\" width=\"70\" height=\"55\" /><br />'.$_r['username'].'</td>");';
			echo 'document.write("<td style=\"line-height:20px;border-bottom:#ccc 1px dashed; padding:5px\">'.str_replace(array('"','\'',"\r\n"),'',strip_tags($_r['content'],'<img>')).'</td>");';
			echo 'document.write("<td align=\"right\" valign=\"bottom\" width=\"150\" style=\"border-bottom:#ccc 1px dashed; padding:5px\">'.date('Y-m-d H:i:s',$_r['addtime']).'</td>");';
			echo 'document.write("</tr>");';
		}
		echo 'document.write("</table>")';
	}
	exit();
?>
