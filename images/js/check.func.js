/**
* 表单验证
* @author dayu
* @copyright			(C) 2009-2011 DayuCMS
* @lastmodify			2011-6-23 16:06
*/
var ispass=false;
var formObj,formId,elements;
var email=/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
var phone=/^((\(\d{2,3}\))|(\d{3}\-))?(\(0\d{2,3}\)|0\d{2,3}-)?[1-9]\d{6,7}(\-\d{1,4})?$/;
var mobile=/^((\(\d{3}\))|(\d{3}\-))?13[0-9]\d{8}?$|15[0-9]\d{8}?$/;
var url=/^http:\/\/[A-Za-z0-9]+\.?[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/;
var number=/^[\d\.]*$/;
var ip=/^[\d\.]{7,15}$/;
var qq=/^\d{0,14}$/;
var integer=/^[-\+]?\d+$/;
var double=/^[-\+]?\d+(\.\d+)?$/;
var table=/^[A-Za-z0-9_]{0,30}$/;
var english=/^[A-Za-z0-9_]+$/;
var chinese=/^[\u0391-\uFFE5]+$/;
var userName=/^[0-9a-z_\u0391-\uFFE5]{1,30}$/;
var usePsw=/^[0-9a-z_]{3,25}$/;
var checkcode=/^[0-9a-zA-Z\!\@\#\$]{4}$/;
document.writeln('<style type="text\/css">');
document.writeln('.err_span{border:#FF6600 1px solid;padding:0px 4px; margin:0px; margin-top:1px; margin-left:6px; line-height:20px; background:#FFFF99; font-size:12px; font-family:SimSun,Arial, Helvetica, sans-serif; clear:both; position:absolute;}');
document.writeln('* html .err_span{border:#FF6600 1px solid;padding:0px 4px; margin:0px;margin-top:1px; margin-left:6px; height:20px; line-height:20px; background:#FFFF99; font-size:12px; font-family:SimSun,Arial, Helvetica, sans-serif; clear:both; position:absolute}');
document.writeln('<\/style>');

function checkForm(formid)
{
	formId=formid;
	formObj=$(document.forms[formid]);
	elements=formObj.find("input,textarea");
	elements.each(function(){
		switch($(this).attr('datatype')){
			case 'limit':
				if($(this).val().length>$(this).attr('max')||$(this).val().length<$(this).attr('min')){
					$("span.err_span").remove();$("<span class='err_span' id='err_span' onmouseover='$(\"#err_span\").hide(\"slow\");'>* 字符长度在"+$(this).attr('min')+"与"+$(this).attr('max')+"之间</span>").insertAfter($(this));ispass=false;$(this).focus();return false;
				}else {ispass=true;return true;}
				;
				break;
			case 'min':
				if($(this).val().length<$(this).attr('min')){
					$("span.err_span").remove();$("<span class='err_span' id='err_span' onmouseover='$(\"#err_span\").hide(\"slow\");'>* 长度不得少于"+$(this).attr('min')+"个字符!</span>").insertAfter($(this));ispass=false;$(this).focus();return false;
				}else {ispass=true;return true;}
				;
				break;
			case 'max':
				if($(this).val().length>$(this).attr('max')){
					$("span.err_span").remove();$("<span class='err_span' id='err_span' onmouseover='$(\"#err_span\").hide(\"slow\");'>* 长度不得大于"+$(this).attr('max')+"个字符!</span>").insertAfter($(this));ispass=false;$(this).focus();return false;
				}else {ispass=true;return true;}
				;
				break;
			case 'table':
				if(!table.test($(this).val())){
					$("span.err_span").remove();$("<span class='err_span' id='err_span' onmouseover='$(\"#err_span\").hide(\"slow\");'>* 该项应由2-30个英文，数字，下划线组成</span>").insertAfter($(this));ispass=false;$(this).focus();return false;
				}else {ispass=true;return true;}
				;
				break;
			case 'email':
				if(!email.test($(this).val())){
					$("span.err_span").remove();$("<span class='err_span' id='err_span' onmouseover='$(\"#err_span\").hide(\"slow\");'>* 邮箱格式不正确</span>").insertAfter($(this));ispass=false;$(this).focus();return false;
				}else{ispass=true;return true;}
				break;
			case 'url':
				if(!url.test($(this).val())&&$(this).val()!='http://'){
					$("span.err_span").remove();$("<span class='err_span' id='err_span' onmouseover='$(\"#err_span\").hide(\"slow\");'>* 链接格式不正确</span>").insertAfter($(this));ispass=false;$(this).focus();return false;
				}else{ispass=true;return true;}
				break;
			case 'number':
				if(!number.test($(this).val())){
					$("span.err_span").remove();$("<span class='err_span' id='err_span' onmouseover='$(\"#err_span\").hide(\"slow\");'>* 输入必须为数字</span>").insertAfter($(this));ispass=false;$(this).focus();return false;
				}else{ispass=true;return true;}
				break;
			case 'ip':
				if(!ip.test($(this).val())){
					$("span.err_span").remove();$("<span class='err_span' id='err_span' onmouseover='$(\"#err_span\").hide(\"slow\");'>* IP地址不正确</span>").insertAfter($(this));ispass=false;$(this).focus();return false;
				}else{ispass=true;return true;}
				break;
			case 'qq':
				if(!qq.test($(this).val())){
					$("span.err_span").remove();$("<span class='err_span' id='err_span' onmouseover='$(\"#err_span\").hide(\"slow\");'>* QQ号码不正确</span>").insertAfter($(this));ispass=false;$(this).focus();return false;
				}else{ispass=true;return true;}
				break;
			case 'integer':
				if(!integer.test($(this).val())){
					$("span.err_span").remove();$("<span class='err_span' id='err_span' onmouseover='$(\"#err_span\").hide(\"slow\");'>* 输入必须为整数</span>").insertAfter($(this));ispass=false;$(this).focus();return false;
				}else{ispass=true;return true;}
				break;
			case 'double':
				if(!double.test($(this).val())){
					$("span.err_span").remove();$("<span class='err_span' id='err_span' onmouseover='$(\"#err_span\").hide(\"slow\");'>* 数据格式不正确</span>").insertAfter($(this));ispass=false;$(this).focus();return false;
				}else{ispass=true;return true;}
				break;
			case 'english':
				if(!english.test($(this).val())&&$(this).val()!=''){
					$("span.err_span").remove();$("<span class='err_span' id='err_span' onmouseover='$(\"#err_span\").hide(\"slow\");'>* 只能输入字母、数字、下划线</span>").insertAfter($(this));ispass=false;$(this).focus();return false;
				}else{ispass=true;return true;}
				break;
			case 'chinese':
				if(!chinese.test($(this).val())){
					$("span.err_span").remove();$("<span class='err_span' id='err_span' onmouseover='$(\"#err_span\").hide(\"slow\");'>* 输入不正确，请检查</span>").insertAfter($(this));ispass=false;$(this).focus();return false;
				}else{ispass=true;return true;}
				break;
			case 'userName':
				if(!userName.test($(this).val())){
					$("span.err_span").remove();$("<span class='err_span' id='err_span' onmouseover='$(\"#err_span\").hide(\"slow\");'>* 用户名由1-30位中文，数字，字母，下划线组成</span>").insertAfter($(this));ispass=false;$(this).focus();return false;
				}else{ispass=true;return true;}
				break;
			case 'usePsw':
				if(!usePsw.test($(this).val())){
					$("span.err_span").remove();$("<span class='err_span' id='err_span' onmouseover='$(\"#err_span\").hide(\"slow\");'>* 密码由3-20位之间的数字，字母，下划线组成</span>").insertAfter($(this));ispass=false;$(this).focus();return false;
				}else{ispass=true;return true;}
				break;
			case 'checkcode':
				if(!checkcode.test($(this).val())){
					$("span.err_span").remove();$("<span class='err_span' id='err_span' onmouseover='$(\"#err_span\").hide(\"fast\");'>* 请输入正确的验证码!</span>").insertAfter($(this));ispass=false;$(this).focus();return false;
				}else{ispass=true;return true;}
				break;
		}	
	});
}

function doSubmit(obj){
	checkForm(formId);
	if(ispass){obj.form.submit();return true;}
	else {return false;}
}

