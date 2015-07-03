/*s: .a, .i hover and focus class toggle */
$('a, .a, .i').hover(
	function(){
		$(this).addClass("hover");
	},
	function(){
		$(this).removeClass("hover");
	}
);
$('.i').focus(function(){
	$(this).addClass("focus");
});
$('.i').blur(function(){
	$(this).removeClass("focus");
});
/*e: .a, .i hover and focus class toggle */

/*s: .t toggle */
$(".subMenu dd").hide();
$(".subMenu dt:first-child").next().show();
$(".t dt").live("click", function(){
	$(this).next().slideToggle();
});
/*e: .t toggle */

/*s: atab */
$(".atab strong:first-child").addClass("atabOn");
$(".atab dd .tabCntnt").not(":first-child").hide();
$(".atab strong").unbind("click").bind("click", function(){
	$(this).siblings("strong").removeClass("atabOn").end().addClass("atabOn");
	var index = $(".atab strong").index($(this));
	$(".atab dd .tabCntnt").eq(index).siblings(".atab dd .tabCntnt").hide().end().fadeIn();
});
/*e: atab */

/*s: submit form */
$('.required').blur(function() {
	$(this).removeClass('warning');
	if ('' == this.value) {
		$(this).addClass('warning');
	}
});
$("form").submit(function(){
	$(this).find(".required").trigger('blur');
	var numWarnings = $('.warning', this).length;
	if(numWarnings){
		$(this).find(".warning").first().focus();
		alert($(this).find(".warning").first().attr('name'));
		return false;
	}
});
/*e: submit form */

/*s: delete confirm */
function delete_confirm(){
	if(confirm('真的要删除吗？')){
		return true;
	}else{
		return false;
	}
}
/*e: delete comfirm */

/*s: menu */
$(".menu dt").mouseenter(function(){
	var p = $(this).position();
	$(this).siblings('dd').hide();
	$(this).next('dd').css({left:p.left}).show();
});
$(".menu dd").mouseleave(function(){
	$(this).hide();
});
/*e: menu */

/*s: .submit to=form id, action=form action */
$(".submit").bind("click", function(){
	$($(this).attr("to")).attr("action", $(this).attr("action"));
	$($(this).attr("to")).submit();
});
/*e: .submit to=form id, action=form action */

/*s: .main_content append logo */
$(".main_content p").last().append('<span class="logo_tiny"></span><div class="c"></div>');
/*e: .submit to=form id, action=form action */

$(document).ready(function(){
	/* set acbox position */
	$('.acbox').css('left', ($(window).width() - $('.acbox').width()) / 2)
		.css('top', ($(window).height() - $('.acbox').height()) / 2 - 40);
	/* vertical align */
	$(window).resize(function() {
		$('.acbox').css('left', ($(window).width() - $('.acbox').width()) / 2)
			.css('top', ($(window).height() - $('.acbox').height()) / 2 - 40);
	});
});

/* uploadify */
$(document).ready(function(){
	$('.uploader').each(function(){
		var btntext = $(this).attr('btntext'), to_id = $(this).attr('to'), preview_id = $(this).attr('preview'),
			fileTypeDesc, fileTypeExts, uploader, multiUpload = false;
		if('all' == $(this).attr('typeset')){
			fileTypeDesc = type_desc_all;
			fileTypeExts = file_type_exts_all;
			uploader = uploader_all;
		}
		else if('image' == $(this).attr('typeset')){
			fileTypeDesc = type_desc_image;
			fileTypeExts = file_type_exts_image;
			uploader = uploader_image;
			if('yes' == $(this).attr('thumb')){
				uploader = uploader_image_thumb;
			}
		}
		if('yes' == $(this).attr('multi_upload')){
			multiUpload = true;
		}
		$(this).uploadify({
			'buttonClass' : 'btn_upload', 'buttonImage' : '', 'fileObjName' : 'upload',
			'formData' : form_data,
			'swf' : uploadify_swf, 'queueID' : 'uwa_id',
			'buttonText' : btntext, 'fileTypeDesc' : fileTypeDesc, 'fileTypeExts' : fileTypeExts,
			'uploader' : uploader, 'multi' : multiUpload, 'height' : 24, 'width' : 80,
			'onInit': function(){$("#uwa_id").hide();},
			'onUploadSuccess' : function(file, data, response){
				if(multiUpload){
					$(to_id).val($(to_id).val() + data + "\r\n");
				}
				else{
					$(to_id).val(data);
				}
				if(preview_id){
					$(preview_id).attr('src', data);
				}
			},
			'onUploadError' : function(file, errorCode, errorMsg, errorString){
				alert(errorString);
			}
		});
	});
});

/* calendar */
var cal = Calendar.setup({
	onSelect : function(){this.hide()},
	weekNumbers : true,
	showTime : 24,
});
$(document).ready(function(){
	/* calendar */
	$('.calendar').each(function(){
		var format = $(this).attr('format');
		if(!format){
			 format = "Y-m-d H:i:s"
		}
		format = format
			.replace('a', 'P')
			.replace('A', 'p')
			.replace('D', 'a')
			.replace('l', 'A')
			.replace('j', 'e')
			.replace('N', 'u')
			.replace('z', 'j')
			.replace('F', 'B')
			.replace('M', 'b')
			.replace('o', 'Y')
			.replace('n', 'o')
			.replace('g', 'l')
			.replace('G', 'k')
			.replace('h', 'I')
			.replace('i', 'M')
			.replace('s', 'S');
		format = format.replace(/([A-Za-z]+)/g, "%$1");
		cal.manageFields($(this).attr('id'), $(this).attr('id'), format);
	});
});

/*s: member */
$(document).ready(function(){
	setInterval(function(){$('#time').html(new Date().toLocaleString());}, 1000);
});
/*e: member */

/*s: select all */
$(".select_all").bind('click', function(){
	var flag = $(this).attr("checked");
	if(flag == 'checked')
	{
		$("input[name^='" + $(this).attr("to") + "']").attr("checked", flag);
	}
	else
	{
		$("input[name^='" + $(this).attr("to") + "']").removeAttr("checked");
	}
});
/*e: select all */


/*s: toggle tr */
$(".toggle_tr").click(function(){
	$('[p_id='+$(this).attr('toggle_tr_id')+']').toggle();
});
/*e: toggle tr */

/*s: delete comfirm */
function delete_confirm(){
	if(confirm("真的要删除吗？")){
		return true;
	}else{
		return false;
	}
}
/*e: delete comfirm */

