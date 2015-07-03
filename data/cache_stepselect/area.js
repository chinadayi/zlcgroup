var stepselect_area=new Array();
stepselect_area[0]=["石家庄市",609,0];
stepselect_area[1]=["辛集市",610,609];
stepselect_area[2]=["鹿泉市",611,609];
function killerror_area()
{
	return true; 
}
 
window.onerror=killerror_area;

var area_top_select=document.getElementById(stepselect+"_top_select");
var area_self_select=document.getElementById(stepselect+"_self_select");
var area_son_select=document.getElementById(stepselect+"_son_select");

area_top_select.options[0]=new Option("请选择..",0);
area_self_select.options[0]=new Option("请选择..",0);
area_son_select.options[0]=new Option("请选择..",0);

area_self_select.style.display="none";
area_son_select.style.display="none";

//function load_area_config()
//{
	for(var i=0,n=1;i<stepselect_area.length;i++)
	{
		if(stepselect_area[i][2]==0)
		{
			area_top_select.options[n]=null;
			area_top_select.options[n]=new Option(stepselect_area[i][0],stepselect_area[i][1]);
			n++;
		}
	}
	area_top_select.focus();
//}

function reset_areaselectnemu()
{
	area_top_select.options[0]=new Option("请选择..",0);
	area_top_select.value=0;
	area_top_select.disabled="";
}

function get_areaself_select(name,table,value)
{
	area_self_select.options.length=1;
	area_son_select.options.length=1;
	
	area_self_select.style.display="none";
	area_son_select.style.display="none";
	
	if(area_top_select.value!=0)
	{
		for(var i=0,n=1;i<stepselect_area.length;i++)
		{
			if(stepselect_area[i][2]==area_top_select.value)
			{
				area_self_select.options[n]=null;
				area_self_select.options[n]=new Option(stepselect_area[i][0],stepselect_area[i][1]);
				n++;
			}
		}
		if(n>1)area_self_select.style.display="";
	}
	if(value)
	{
		document.getElementById(name+'_id_'+table).value=value;
		document.getElementById(table).value=value;
	}
	area_self_select.focus();
}

function get_areason_select(name,table,value)
{
	area_son_select.options.length=1;
	area_son_select.style.display="none";
	
	if(area_self_select.value!=0)
	{		
		for(var i=0,n=1;i<stepselect_area.length;i++)
		{
			if(stepselect_area[i][2]==area_self_select.value)
			{
				area_son_select.options[n]=null;
				area_son_select.options[n]=new Option(stepselect_area[i][0],stepselect_area[i][1]);
				n++;
			}
		}
		if(n>1)area_son_select.style.display="";
	}
	if(value)
	{
		document.getElementById(name+'_id_'+table).value=value;
		document.getElementById(table).value=value;
	}
	area_son_select.focus();
}

function get_area_value(name,table,value)
{
	if(value)
	{
		document.getElementById(name+'_id_'+table).value=value;
		document.getElementById(table).value=value;
	}
}
//window.onload(load_area_config());
