function killerrors() 
{ 
	return true; 
}
window.onerror = killerrors;
function showHide(a) {
    var b = document.getElementById(a);
    if (b.style.display == 'block') {
        b.style.display = 'none'
    } else {
        b.style.display = 'block'
    }
};
function togglecat(a, b) {
    if (document.getElementById(b).style.display == '') {
        document.getElementById(b).style.display = 'none';
        document.getElementById(a).className = 'plus'
    } else {
        document.getElementById(b).style.display = '';
        document.getElementById(a).className = 'minus'
    }
};
document.getElementById('bott_ban').innerHTML = unescape('RETENGCMS%u5185%u5BB9%u7BA1%u7406%u7CFB%u7EDF%20%u7248%u6743%u6240%u6709');