//created by:JasonZeng on 2014/5/25
function parseUrl() { var c, d, e, f, g, a = {}, b = location.search; if (0 != b.indexOf("?")) return a; for (b = b.substr(1).split("&"), c = 0; c < b.length; c++) d = b[c], e = d.indexOf("="), f = d.substr(0, e), g = d.substr(e + 1), a[f] = g; return a }
function load_cases() { function getData(data) { document.hasMore && lock && (lock = !1, $.ajax({ type: "POST", url: "action/GetData.ashx", ifModified: !0, data: data, success: function(msg) { var retInfo = eval("(" + msg + ")"); "ok" == retInfo.status && ("1" == retInfo.hasMore ? 1 == document.hasMore : document.hasMore = !1, count++, $(retInfo.content).hide().appendTo($(".case_ny_content ul")).show(1e3), lock = !0, formatLi()) } })) } function formatLi() { $(".case_ny_content ul").children("li").each(function(a) { 0 == (a + 1) % 3 && $(this).addClass("row_last") }) } var lock, params = parseUrl(), count = 1; $(function() { formatLi(), $(window).scroll(function() { var b = ($(this).height(), $(this).scrollTop()), c = parseInt(document.documentElement.offsetHeight || document.body.offsetHeight) - parseInt(document.documentElement.clientHeight || document.body.clientHeight); 100 > c - b && ("1" == params.f ? getData("type=108&count=" + count + "&f=1") : getData("type=108&count=" + count)) }) }), document.hasMore = !0, lock = !0 } function load_news() { function getData(data) { document.hasMore && lock && (lock = !1, $.ajax({ type: "POST", url: "action/GetData.ashx", ifModified: !0, data: data, success: function(msg) { var retInfo = eval("(" + msg + ")"); "ok" == retInfo.status && ("1" == retInfo.hasMore ? 1 == document.hasMore : document.hasMore = !1, count++, $(retInfo.content).hide().appendTo($(".news_list ul")).show(1e3), lock = !0) } })) } var lock, params = parseUrl(), count = 1; $(function() { $(window).scroll(function() { var b = ($(this).height(), $(this).scrollTop()), c = parseInt(document.documentElement.offsetHeight || document.body.offsetHeight) - parseInt(document.documentElement.clientHeight || document.body.clientHeight); 100 > c - b && null != params.type && getData("type=" + params.type + "&count=" + count) }) }), document.hasMore = !0, lock = !0 }

function change() { $(".nav").children("ul").children("li").hover(function(a) { a.cancelBubble = !0, $(".nav").children("ul").children("li").each(function() { }), $(this).children("a").css("color", "#fff"), $(this).siblings("li").children("a").css("color", "#666"), that.children("a").css("color", "#fff") }, function() { $(this).children("a").css("color", "#ccc"), $(this).siblings("li").children("a").css("color", "#ccc"), that.children("a").css("color", "#fff") }), $(".nav").children("ul").children("li").each(function() { var a = $(this).children("a").attr("href"); fileName.toLowerCase().indexOf(a.substr(0, a.indexOf("."))) >= 0 && (that = $(this), $(this).children("a").css("color", "#fff")) }), ("" == fileName || "/" == fileName) && $(".nav").children("ul").children("li:eq(0)").children("a").css("color", "#fff") } function getUrl() { var f, a = window.document.location.href, b = window.document.location.pathname, c = a.indexOf(b); return a.substring(0, c), b.substring(0, b.substr(1).indexOf("/") + 1), f = b.substr(b.lastIndexOf("/") + 1), f.substr(0, f.indexOf(".")) }

//弹出框begin
function openModal() {
    var w = document.createElement("div");
    w.setAttribute("id", "myBody");
    with (w.style) {
        left = "0";
        top = "0";
        background = "#fefefe";
        opacity = "0.8";
        filter = "Alpha(opacity=80)";
        position = "absolute";
        zIndex = "10000";
    }
    w.setAttribute("onclick", "closeDialog()");
    document.body.appendChild(w);
}

function openDialog(o) {
    //modal背景
    openModal();
    with (o.style) {
        display = "block";
        position = "absolute";
        zIndex = "10001";
    }
    onWindowResize(o);
}
function Style() {
    this.width = 0;
    this.height = 0;
}
function closeDialog() {
    var _bg = document.getElementById("myBody");
    var dialog = document.getElementById("dialog");
    if (!_bg) return false;
    document.body.removeChild(_bg);
    dialog.style.display = "none";
}


//document.getElementById("btn").onclick = function() {
//    openDialog(document.getElementById("dialog"));

//}

document.getElementById("close").onclick = function() {

    closeDialog();
}

function onWindowResize(o) {

    if (!o) return;
    var _bg = document.getElementById("myBody");
    var dialog = o;
    var style = new Style();
    style.width = Math.max(document.documentElement.scrollWidth, document.documentElement.clientWidth || document.body.clientWidth) + "px";
    style.height = Math.max(document.documentElement.scrollHeight, document.documentElement.clientHeight || document.body.clientHeight) + "px";
    if (!_bg) return;
    _bg.style.width = style.width;
    _bg.style.height = style.height;

    with (o.style) {
        left = (parseInt(document.documentElement.clientWidth || document.body.clientWidth)) / 2 + (document.documentElement.scrollLeft || document.body.scrollLeft) - parseInt(width) / 2 + "px";
        top = (parseInt(document.documentElement.clientHeight || document.body.clientHeight) / 2) + (document.documentElement.scrollTop || document.body.scrollTop) - parseInt(height) / 2 + "px";
    }
}
window.onresize = function() {
    onWindowResize(document.getElementById("dialog"));
}
//弹出框end

//登录begin
function login() {

    var uName = $("#txtName").val(), uPwd = $("#txtPwd").val(), vCode = $("#txtCode").val();
    if (uName == "") {
        alert("用户名不能为空！");
        return false;
    }
    else if (uPwd == "") { alert("密码不能为空！"); return false; }
    else if (vCode == "") {
    alert("验证码不能为空！");
    
     return false; }

     $.ajax({ type: "POST",
         url: "Action/UserOperation.ashx",
         ifModified: true,
         data: "uName=" + uName + "&uPwd=" + uPwd + "&vCode=" + vCode,
         success: function(msg) {
             var retInfo = eval("(" + msg + ")");
             if (retInfo.status == "ok") {
                 closeDialog();
                 $("#txtName").val(); $("#txtPwd").val(); $("#txtCode").val();
                 uname = uName;
             } else {
                 $("#imgCode").click();
             }
             alert(retInfo.msg);
         }
     });

}



//登录end
