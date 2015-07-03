// 评论表单验证
$(document).ready(function(){
	$("#commentform").submit(function(){
		if($("#c_content").val()=='')
		{
			$("#commentmsg").html('您没有输入任何内容!<br />');
			$("#c_content").focus();
			return false;
		}
		if($("#c_chkcode").val()=='')
		{
			$("#commentmsg").html("请输入验证码!<br />");
			$("#c_chkcode").focus();
			return false;
		}
	});						   
});
