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

