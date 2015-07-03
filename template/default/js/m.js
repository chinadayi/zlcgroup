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

