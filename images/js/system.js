/**
* JS操作框
* @author dayu
* @copyright			(C) 2009-2011 DayuCMS
* @lastmodify			2011-6-20 17:30
*/
function redirect(url)
{
	if(url=="javascript:history.back();")eval(url);
	else self.location.href=url;
}

function openDialog(title,apiurl,width,height)
{
	width=width?width:510;
	height=height?height:340;
	art.dialog({
		padding: 0,
		title:title,
		content: '<iframe src="'+apiurl+'" frameborder="0" scrolling="yes" width="'+width+'" height="'+height+'"></iframe> ',
		yesFn: function () {
			return true;
		}
	});	
}


