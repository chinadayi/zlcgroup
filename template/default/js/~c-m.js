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

