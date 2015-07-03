var T, dayucms = T = dayucms || {
    version: "1.5.2.2"
};
dayucms.guid = "$dayucms$";
dayucms.$$ = window[dayucms.guid] = window[dayucms.guid] || {
    global: {}
};
dayucms.ajax = dayucms.ajax || {};
dayucms.fn = dayucms.fn || {};
dayucms.fn.blank = function() {};
dayucms.ajax.request = function(g, k) {
    var d = k || {},
    r = d.data || "",
    h = !(d.async === false),
    f = d.username || "",
    a = d.password || "",
    c = (d.method || "GET").toUpperCase(),
    b = d.headers || {},
    j = d.timeout || 0,
    l = {},
    o,
    s,
    i;
    function n() {
        if (i.readyState == 4) {
            try {
                var u = i.status
            } catch(t) {
                q("failure");
                return
            }
            q(u);
            if ((u >= 200 && u < 300) || u == 304 || u == 1223) {
                q("success")
            } else {
                q("failure")
            }
            window.setTimeout(function() {
                i.onreadystatechange = dayucms.fn.blank;
                if (h) {
                    i = null
                }
            },
            0)
        }
    }
    function m() {
        if (window.ActiveXObject) {
            try {
                return new ActiveXObject("Msxml2.XMLHTTP")
            } catch(t) {
                try {
                    return new ActiveXObject("Microsoft.XMLHTTP")
                } catch(t) {}
            }
        }
        if (window.XMLHttpRequest) {
            return new XMLHttpRequest()
        }
    }
    function q(v) {
        v = "on" + v;
        var u = l[v],
        w = dayucms.ajax[v];
        if (u) {
            if (o) {
                clearTimeout(o)
            }
            if (v != "onsuccess") {
                u(i)
            } else {
                try {
                    i.responseText
                } catch(t) {
                    return u(i)
                }
                u(i, i.responseText)
            }
        } else {
            if (w) {
                if (v == "onsuccess") {
                    return
                }
                w(i)
            }
        }
    }
    for (s in d) {
        l[s] = d[s]
    }
    b["X-Requested-With"] = "XMLHttpRequest";
    try {
        i = m();
        if (c == "GET") {
            if (r) {
                g += (g.indexOf("?") >= 0 ? "&": "?") + r;
                r = null
            }
            if (d.noCache) {
                g += (g.indexOf("?") >= 0 ? "&": "?") + "b" + ( + new Date) + "=1"
            }
        }
        if (f) {
            i.open(c, g, h, f, a)
        } else {
            i.open(c, g, h)
        }
        if (h) {
            i.onreadystatechange = n
        }
        if (c == "POST") {
            i.setRequestHeader("Content-Type", (b["Content-Type"] || "application/x-www-form-urlencoded"))
        }
        for (s in b) {
            if (b.hasOwnProperty(s)) {
                i.setRequestHeader(s, b[s])
            }
        }
        q("beforerequest");
        if (j) {
            o = setTimeout(function() {
                i.onreadystatechange = dayucms.fn.blank;
                i.abort();
                q("timeout")
            },
            j)
        }
        i.send(r);
        if (!h) {
            n()
        }
    } catch(p) {
        q("failure")
    }
    return i
};
dayucms.url = dayucms.url || {};
dayucms.url.escapeSymbol = function(a) {
    return String(a).replace(/[#%&+=\/\\\ \　\f\r\n\t]/g,
    function(b) {
        return "%" + (256 + b.charCodeAt()).toString(16).substring(1).toUpperCase()
    })
};
dayucms.ajax.form = function(a, c) {
    c = c || {};
    var g = a.elements,
    o = g.length,
    b = a.getAttribute("method"),
    f = a.getAttribute("action"),
    u = c.replacer ||
    function(v, i) {
        return v
    },
    r = {},
    t = [],
    m,
    q,
    s,
    n,
    d,
    h,
    j,
    l,
    k;
    function p(i, v) {
        t.push(i + "=" + v)
    }
    for (m in c) {
        if (c.hasOwnProperty(m)) {
            r[m] = c[m]
        }
    }
    for (m = 0; m < o; m++) {
        q = g[m];
        n = q.name;
        if (!q.disabled && n) {
            s = q.type;
            d = dayucms.url.escapeSymbol(q.value);
            switch (s) {
            case "radio":
            case "checkbox":
                if (!q.checked) {
                    break
                }
            case "textarea":
            case "text":
            case "password":
            case "hidden":
            case "select-one":
                p(n, u(d, n));
                break;
            case "select-multiple":
                h = q.options;
                l = h.length;
                for (j = 0; j < l; j++) {
                    k = h[j];
                    if (k.selected) {
                        p(n, u(k.value, n))
                    }
                }
                break
            }
        }
    }
    r.data = t.join("&");
    r.method = a.getAttribute("method") || "GET";
    return dayucms.ajax.request(f, r)
};
dayucms.ajax.get = function(b, a) {
    return dayucms.ajax.request(b, {
        onsuccess: a
    })
};
dayucms.ajax.post = function(b, c, a) {
    return dayucms.ajax.request(b, {
        onsuccess: a,
        method: "POST",
        data: c
    })
};
dayucms.array = dayucms.array || {};
dayucms.array.indexOf = function(f, b, d) {
    var a = f.length,
    c = b;
    d = d | 0;
    if (d < 0) {
        d = Math.max(0, a + d)
    }
    for (; d < a; d++) {
        if (d in f && f[d] === b) {
            return d
        }
    }
    return - 1
};
dayucms.array.contains = function(a, b) {
    return (dayucms.array.indexOf(a, b) >= 0)
};
dayucms.each = dayucms.array.forEach = dayucms.array.each = function(h, f, b) {
    var d, g, c, a = h.length;
    if ("function" == typeof f) {
        for (c = 0; c < a; c++) {
            g = h[c];
            d = f.call(b || h, g, c);
            if (d === false) {
                break
            }
        }
    }
    return h
};
dayucms.array.empty = function(a) {
    a.length = 0
};
dayucms.array.every = function(f, d, b) {
    var c = 0,
    a = f.length;
    for (; c < a; c++) {
        if (c in f && !d.call(b || f, f[c], c)) {
            return false
        }
    }
    return true
};
dayucms.array.filter = function(j, g, d) {
    var c = [],
    b = 0,
    a = j.length,
    h,
    f;
    if ("function" == typeof g) {
        for (f = 0; f < a; f++) {
            h = j[f];
            if (true === g.call(d || j, h, f)) {
                c[b++] = h
            }
        }
    }
    return c
};
dayucms.array.find = function(f, c) {
    var d, b, a = f.length;
    if ("function" == typeof c) {
        for (b = 0; b < a; b++) {
            d = f[b];
            if (true === c.call(f, d, b)) {
                return d
            }
        }
    }
    return null
};
dayucms.array.hash = function(f, b) {
    var g = {},
    d = b && b.length,
    c = 0,
    a = f.length;
    for (; c < a; c++) {
        g[f[c]] = (d && d > c) ? b[c] : true
    }
    return g
};
dayucms.array.lastIndexOf = function(d, b, c) {
    var a = d.length;
    c = c | 0;
    if (!c || c >= a) {
        c = a - 1
    }
    if (c < 0) {
        c += a
    }
    for (; c >= 0; c--) {
        if (c in d && d[c] === b) {
            return c
        }
    }
    return - 1
};
dayucms.array.map = function(g, f, b) {
    var d = [],
    c = 0,
    a = g.length;
    for (; c < a; c++) {
        d[c] = f.call(b || g, g[c], c)
    }
    return d
};
dayucms.array.reduce = function(g, c, d) {
    var b = 0,
    a = g.length,
    f = 0;
    if (arguments.length < 3) {
        for (; b < a; b++) {
            d = g[b++];
            f = 1;
            break
        }
        if (!f) {
            return
        }
    }
    for (; b < a; b++) {
        if (b in g) {
            d = c(d, g[b], b, g)
        }
    }
    return d
};
dayucms.array.remove = function(c, b) {
    var a = c.length;
    while (a--) {
        if (a in c && c[a] === b) {
            c.splice(a, 1)
        }
    }
    return c
};
dayucms.array.removeAt = function(b, a) {
    return b.splice(a, 1)[0]
};
dayucms.array.some = function(f, d, b) {
    var c = 0,
    a = f.length;
    for (; c < a; c++) {
        if (c in f && d.call(b || f, f[c], c)) {
            return true
        }
    }
    return false
};
dayucms.array.unique = function(f, g) {
    var b = f.length,
    a = f.slice(0),
    d,
    c;
    if ("function" != typeof g) {
        g = function(i, h) {
            return i === h
        }
    }
    while (--b > 0) {
        c = a[b];
        d = b;
        while (d--) {
            if (g(c, a[d])) {
                a.splice(b, 1);
                break
            }
        }
    }
    return a
};
dayucms.async = dayucms.async || {};
dayucms.object = dayucms.object || {};
dayucms.extend = dayucms.object.extend = function(c, a) {
    for (var b in a) {
        if (a.hasOwnProperty(b)) {
            c[b] = a[b]
        }
    }
    return c
};
dayucms.lang = dayucms.lang || {};
dayucms.lang.isFunction = function(a) {
    return "[object Function]" == Object.prototype.toString.call(a)
};
dayucms.async._isDeferred = function(b) {
    var a = dayucms.lang.isFunction;
    return b && a(b.success) && a(b.then) && a(b.fail) && a(b.cancel)
};
dayucms.async.Deferred = function() {
    var b = this;
    dayucms.extend(b, {
        _fired: 0,
        _firing: 0,
        _cancelled: 0,
        _resolveChain: [],
        _rejectChain: [],
        _result: [],
        _isError: 0
    });
    function a() {
        if (b._cancelled || b._firing) {
            return
        }
        if (b._nextDeferred) {
            b._nextDeferred.then(b._resolveChain[0], b._rejectChain[0]);
            return
        }
        b._firing = 1;
        var g = b._isError ? b._rejectChain: b._resolveChain,
        c = b._result[b._isError ? 1 : 0];
        while (g[0] && (!b._cancelled)) {
            try {
                var d = g.shift().call(b, c);
                if (dayucms.async._isDeferred(d)) {
                    b._nextDeferred = d; [].push.apply(d._resolveChain, b._resolveChain); [].push.apply(d._rejectChain, b._rejectChain);
                    g = b._resolveChain = [];
                    b._rejectChain = []
                }
            } catch(f) {
                throw f
            } finally {
                b._fired = 1;
                b._firing = 0
            }
        }
    }
    b.resolve = b.fireSuccess = function(c) {
        b._result[0] = c;
        a();
        return b
    };
    b.reject = b.fireFail = function(c) {
        b._result[1] = c;
        b._isError = 1;
        a();
        return b
    };
    b.then = function(c, d) {
        b._resolveChain.push(c);
        b._rejectChain.push(d);
        if (b._fired) {
            a()
        }
        return b
    };
    b.success = function(c) {
        return b.then(c, dayucms.fn.blank)
    };
    b.fail = function(c) {
        return b.then(dayucms.fn.blank, c)
    };
    b.cancel = function() {
        b._cancelled = 1
    }
};
dayucms.async.get = function(b) {
    var a = new dayucms.async.Deferred();
    dayucms.ajax.request(b, {
        onsuccess: function(d, c) {
            a.resolve({
                xhr: d,
                responseText: c
            })
        },
        onfailure: function(c) {
            a.reject({
                xhr: c
            })
        }
    });
    return a
};
dayucms.async.post = function(b, c) {
    var a = new dayucms.async.Deferred();
    dayucms.ajax.request(b, {
        method: "POST",
        data: c,
        onsuccess: function(f, d) {
            a.resolve({
                xhr: f,
                responseText: d
            })
        },
        onfailure: function(d) {
            a.reject({
                xhr: d
            })
        }
    });
    return a
};
dayucms.async.when = function(c, b, d) {
    if (dayucms.async._isDeferred(c)) {
        c.then(b, d);
        return c
    }
    var a = new dayucms.async.Deferred();
    a.then(b, d).resolve(c);
    return a
};
dayucms.browser = dayucms.browser || {};
dayucms.browser.chrome = /chrome\/(\d+\.\d+)/i.test(navigator.userAgent) ? +RegExp["\x241"] : undefined;
dayucms.browser.firefox = /firefox\/(\d+\.\d+)/i.test(navigator.userAgent) ? +RegExp["\x241"] : undefined;
dayucms.browser.ie = dayucms.ie = /msie (\d+\.\d+)/i.test(navigator.userAgent) ? (document.documentMode || +RegExp["\x241"]) : undefined;
dayucms.browser.isGecko = /gecko/i.test(navigator.userAgent) && !/like gecko/i.test(navigator.userAgent);
dayucms.browser.isStrict = document.compatMode == "CSS1Compat";
dayucms.browser.isWebkit = /webkit/i.test(navigator.userAgent);
try {
    if (/(\d+\.\d+)/.test(external.max_version)) {
        dayucms.browser.maxthon = +RegExp["\x241"]
    }
} catch(e) {}
dayucms.browser.opera = /opera(\/| )(\d+(\.\d+)?)(.+?(version\/(\d+(\.\d+)?)))?/i.test(navigator.userAgent) ? +(RegExp["\x246"] || RegExp["\x242"]) : undefined; (function() {
    var a = navigator.userAgent;
    dayucms.browser.safari = /(\d+\.\d)?(?:\.\d)?\s+safari\/?(\d+\.\d+)?/i.test(a) && !/chrome/i.test(a) ? +(RegExp["\x241"] || RegExp["\x242"]) : undefined
})();
dayucms.cookie = dayucms.cookie || {};
dayucms.cookie._isValidKey = function(a) {
    return (new RegExp('^[^\\x00-\\x20\\x7f\\(\\)<>@,;:\\\\\\"\\[\\]\\?=\\{\\}\\/\\u0080-\\uffff]+\x24')).test(a)
};
dayucms.cookie.getRaw = function(b) {
    if (dayucms.cookie._isValidKey(b)) {
        var c = new RegExp("(^| )" + b + "=([^;]*)(;|\x24)"),
        a = c.exec(document.cookie);
        if (a) {
            return a[2] || null
        }
    }
    return null
};
dayucms.cookie.get = function(a) {
    var b = dayucms.cookie.getRaw(a);
    if ("string" == typeof b) {
        b = decodeURIComponent(b);
        return b
    }
    return null
};
dayucms.cookie.setRaw = function(c, d, b) {
    if (!dayucms.cookie._isValidKey(c)) {
        return
    }
    b = b || {};
    var a = b.expires;
    if ("number" == typeof b.expires) {
        a = new Date();
        a.setTime(a.getTime() + b.expires)
    }
    document.cookie = c + "=" + d + (b.path ? "; path=" + b.path: "") + (a ? "; expires=" + a.toGMTString() : "") + (b.domain ? "; domain=" + b.domain: "") + (b.secure ? "; secure": "")
};
dayucms.cookie.remove = function(b, a) {
    a = a || {};
    a.expires = new Date(0);
    dayucms.cookie.setRaw(b, "", a)
};
dayucms.cookie.set = function(b, c, a) {
    dayucms.cookie.setRaw(b, encodeURIComponent(c), a)
};
dayucms.date = dayucms.date || {};
dayucms.number = dayucms.number || {};
dayucms.number.pad = function(d, c) {
    var f = "",
    b = (d < 0),
    a = String(Math.abs(d));
    if (a.length < c) {
        f = (new Array(c - a.length + 1)).join("0")
    }
    return (b ? "-": "") + f + a
};
dayucms.date.format = function(a, g) {
    if ("string" != typeof g) {
        return a.toString()
    }
    function d(m, l) {
        g = g.replace(m, l)
    }
    var b = dayucms.number.pad,
    h = a.getFullYear(),
    f = a.getMonth() + 1,
    k = a.getDate(),
    i = a.getHours(),
    c = a.getMinutes(),
    j = a.getSeconds();
    d(/yyyy/g, b(h, 4));
    d(/yy/g, b(parseInt(h.toString().slice(2), 10), 2));
    d(/MM/g, b(f, 2));
    d(/M/g, f);
    d(/dd/g, b(k, 2));
    d(/d/g, k);
    d(/HH/g, b(i, 2));
    d(/H/g, i);
    d(/hh/g, b(i % 12, 2));
    d(/h/g, i % 12);
    d(/mm/g, b(c, 2));
    d(/m/g, c);
    d(/ss/g, b(j, 2));
    d(/s/g, j);
    return g
};
dayucms.date.parse = function(c) {
    var a = new RegExp("^\\d+(\\-|\\/)\\d+(\\-|\\/)\\d+\x24");
    if ("string" == typeof c) {
        if (a.test(c) || isNaN(Date.parse(c))) {
            var g = c.split(/ |T/),
            b = g.length > 1 ? g[1].split(/[^\d]/) : [0, 0, 0],
            f = g[0].split(/[^\d]/);
            return new Date(f[0] - 0, f[1] - 1, f[2] - 0, b[0] - 0, b[1] - 0, b[2] - 0)
        } else {
            return new Date(c)
        }
    }
    return new Date()
};
dayucms.dom = dayucms.dom || {};
dayucms.dom.g = function(a) {
    if (!a) {
        return null
    }
    if ("string" == typeof a || a instanceof String) {
        return document.getElementById(a)
    } else {
        if (a.nodeName && (a.nodeType == 1 || a.nodeType == 9)) {
            return a
        }
    }
    return null
};
dayucms.g = dayucms.G = dayucms.dom.g;
dayucms.string = dayucms.string || {}; (function() {
    var a = new RegExp("(^[\\s\\t\\xa0\\u3000]+)|([\\u3000\\xa0\\s\\t]+\x24)", "g");
    dayucms.string.trim = function(b) {
        return String(b).replace(a, "")
    }
})();
dayucms.trim = dayucms.string.trim;
dayucms.dom.addClass = function(g, h) {
    g = dayucms.dom.g(g);
    var b = h.split(/\s+/),
    a = g.className,
    f = " " + a + " ",
    d = 0,
    c = b.length;
    for (; d < c; d++) {
        if (f.indexOf(" " + b[d] + " ") < 0) {
            a += (a ? " ": "") + b[d]
        }
    }
    g.className = a;
    return g
};
dayucms.addClass = dayucms.dom.addClass;
dayucms.dom.children = function(b) {
    b = dayucms.dom.g(b);
    for (var a = [], c = b.firstChild; c; c = c.nextSibling) {
        if (c.nodeType == 1) {
            a.push(c)
        }
    }
    return a
};
dayucms.lang.isString = function(a) {
    return "[object String]" == Object.prototype.toString.call(a)
};
dayucms.isString = dayucms.lang.isString;
dayucms.dom._g = function(a) {
    if (dayucms.lang.isString(a)) {
        return document.getElementById(a)
    }
    return a
};
dayucms._g = dayucms.dom._g;
dayucms.dom.contains = function(a, b) {
    var c = dayucms.dom._g;
    a = c(a);
    b = c(b);
    return a.contains ? a != b && a.contains(b) : !!(a.compareDocumentPosition(b) & 16)
};
dayucms.dom._NAME_ATTRS = (function() {
    var a = {
        cellpadding: "cellPadding",
        cellspacing: "cellSpacing",
        colspan: "colSpan",
        rowspan: "rowSpan",
        valign: "vAlign",
        usemap: "useMap",
        frameborder: "frameBorder"
    };
    if (dayucms.browser.ie < 8) {
        a["for"] = "htmlFor";
        a["class"] = "className"
    } else {
        a.htmlFor = "for";
        a.className = "class"
    }
    return a
})();
dayucms.dom.setAttr = function(b, a, c) {
    b = dayucms.dom.g(b);
    if ("style" == a) {
        b.style.cssText = c
    } else {
        a = dayucms.dom._NAME_ATTRS[a] || a;
        b.setAttribute(a, c)
    }
    return b
};
dayucms.setAttr = dayucms.dom.setAttr;
dayucms.dom.setAttrs = function(c, a) {
    c = dayucms.dom.g(c);
    for (var b in a) {
        dayucms.dom.setAttr(c, b, a[b])
    }
    return c
};
dayucms.setAttrs = dayucms.dom.setAttrs;
dayucms.dom.create = function(c, a) {
    var d = document.createElement(c),
    b = a || {};
    return dayucms.dom.setAttrs(d, b)
};
dayucms.lang.guid = function() {
    return "TANGRAM$" + dayucms.$$._counter++
};
dayucms.$$._counter = dayucms.$$._counter || 1;
dayucms.lang.Class = function() {
    this.guid = dayucms.lang.guid(); ! this.__decontrolled && (dayucms.$$._instances[this.guid] = this)
};
dayucms.$$._instances = dayucms.$$._instances || {};
dayucms.lang.Class.prototype.dispose = function() {
    delete dayucms.$$._instances[this.guid];
    for (var a in this) {
        typeof this[a] != "function" && delete this[a]
    }
    this.disposed = true
};
dayucms.lang.Class.prototype.toString = function() {
    return "[object " + (this.__type || this._className || "Object") + "]"
};
window.dayucmsInstance = function(a) {
    return dayucms.$$._instances[a]
};
dayucms.lang.Class.prototype.un = dayucms.lang.Class.prototype.removeEventListener = function(d, c) {
    var b, a = this.__listeners;
    if (!a) {
        return
    }
    if (typeof d == "undefined") {
        for (b in a) {
            delete a[b]
        }
        return
    }
    d.indexOf("on") && (d = "on" + d);
    if (typeof c == "undefined") {
        delete a[d]
    } else {
        if (a[d]) {
            typeof c == "string" && (c = a[d][c]) && delete a[d][c];
            for (b = a[d].length - 1; b >= 0; b--) {
                if (a[d][b] === c) {
                    a[d].splice(b, 1)
                }
            }
        }
    }
};
dayucms.lang.Event = function(a, b) {
    this.type = a;
    this.returnValue = true;
    this.target = b || null;
    this.currentTarget = null
};
dayucms.lang.Class.prototype.fire = dayucms.lang.Class.prototype.dispatchEvent = function(f, a) {
    dayucms.lang.isString(f) && (f = new dayucms.lang.Event(f)); ! this.__listeners && (this.__listeners = {});
    a = a || {};
    for (var c in a) {
        f[c] = a[c]
    }
    var c, h, d = this,
    b = d.__listeners,
    g = f.type;
    f.target = f.target || (f.currentTarget = d);
    g.indexOf("on") && (g = "on" + g);
    typeof d[g] == "function" && d[g].apply(d, arguments);
    if (typeof b[g] == "object") {
        for (c = 0, h = b[g].length; c < h; c++) {
            b[g][c] && b[g][c].apply(d, arguments)
        }
    }
    return f.returnValue
};
dayucms.lang.Class.prototype.on = dayucms.lang.Class.prototype.addEventListener = function(f, d, c) {
    if (typeof d != "function") {
        return
    } ! this.__listeners && (this.__listeners = {});
    var b, a = this.__listeners;
    f.indexOf("on") && (f = "on" + f);
    typeof a[f] != "object" && (a[f] = []);
    for (b = a[f].length - 1; b >= 0; b--) {
        if (a[f][b] === d) {
            return d
        }
    }
    a[f].push(d);
    c && typeof c == "string" && (a[f][c] = d);
    return d
};
dayucms.lang.createSingle = function(b) {
    var d = new dayucms.lang.Class();
    for (var a in b) {
        d[a] = b[a]
    }
    return d
};
dayucms.dom.ddManager = dayucms.lang.createSingle({
    _targetsDroppingOver: {}
});
dayucms.dom.getDocument = function(a) {
    a = dayucms.dom.g(a);
    return a.nodeType == 9 ? a: a.ownerDocument || a.document
};
dayucms.dom.getComputedStyle = function(b, a) {
    b = dayucms.dom._g(b);
    var d = dayucms.dom.getDocument(b),
    c;
    if (d.defaultView && d.defaultView.getComputedStyle) {
        c = d.defaultView.getComputedStyle(b, null);
        if (c) {
            return c[a] || c.getPropertyValue(a)
        }
    }
    return ""
};
dayucms.dom._styleFixer = dayucms.dom._styleFixer || {};
dayucms.dom._styleFilter = dayucms.dom._styleFilter || [];
dayucms.dom._styleFilter.filter = function(b, f, g) {
    for (var a = 0,
    d = dayucms.dom._styleFilter,
    c; c = d[a]; a++) {
        if (c = c[g]) {
            f = c(b, f)
        }
    }
    return f
};
dayucms.string.toCamelCase = function(a) {
    if (a.indexOf("-") < 0 && a.indexOf("_") < 0) {
        return a
    }
    return a.replace(/[-_][^-_]/g,
    function(b) {
        return b.charAt(1).toUpperCase()
    })
};
dayucms.dom.getStyle = function(c, b) {
    var f = dayucms.dom;
    c = f.g(c);
    b = dayucms.string.toCamelCase(b);
    var d = c.style[b] || (c.currentStyle ? c.currentStyle[b] : "") || f.getComputedStyle(c, b);
    if (!d || d == "auto") {
        var a = f._styleFixer[b];
        if (a) {
            d = a.get ? a.get(c, b, d) : dayucms.dom.getStyle(c, a)
        }
    }
    if (a = f._styleFilter) {
        d = a.filter(b, d, "get")
    }
    return d
};
dayucms.getStyle = dayucms.dom.getStyle;
dayucms.event = dayucms.event || {};
dayucms.event._listeners = dayucms.event._listeners || [];
dayucms.event.on = function(b, f, h) {
    f = f.replace(/^on/i, "");
    b = dayucms.dom._g(b);
    var g = function(j) {
        h.call(b, j)
    },
    a = dayucms.event._listeners,
    d = dayucms.event._eventFilter,
    i,
    c = f;
    f = f.toLowerCase();
    if (d && d[f]) {
        i = d[f](b, f, g);
        c = i.type;
        g = i.listener
    }
    if (b.addEventListener) {
        b.addEventListener(c, g, false)
    } else {
        if (b.attachEvent) {
            b.attachEvent("on" + c, g)
        }
    }
    a[a.length] = [b, f, h, g, c];
    return b
};
dayucms.on = dayucms.event.on;
dayucms.page = dayucms.page || {};
dayucms.page.getScrollTop = function() {
    var a = document;
    return window.pageYOffset || a.documentElement.scrollTop || a.body.scrollTop
};
dayucms.page.getScrollLeft = function() {
    var a = document;
    return window.pageXOffset || a.documentElement.scrollLeft || a.body.scrollLeft
}; (function() {
    dayucms.page.getMousePosition = function() {
        return {
            x: dayucms.page.getScrollLeft() + a.x,
            y: dayucms.page.getScrollTop() + a.y
        }
    };
    var a = {
        x: 0,
        y: 0
    };
    dayucms.event.on(document, "onmousemove",
    function(b) {
        b = window.event || b;
        a.x = b.clientX;
        a.y = b.clientY
    })
})();
dayucms.event.un = function(c, g, b) {
    c = dayucms.dom._g(c);
    g = g.replace(/^on/i, "").toLowerCase();
    var j = dayucms.event._listeners,
    d = j.length,
    f = !b,
    i, h, a;
    while (d--) {
        i = j[d];
        if (i[1] === g && i[0] === c && (f || i[2] === b)) {
            h = i[4];
            a = i[3];
            if (c.removeEventListener) {
                c.removeEventListener(h, a, false)
            } else {
                if (c.detachEvent) {
                    c.detachEvent("on" + h, a)
                }
            }
            j.splice(d, 1)
        }
    }
    return c
};
dayucms.un = dayucms.event.un;
dayucms.event.preventDefault = function(a) {
    if (a.preventDefault) {
        a.preventDefault()
    } else {
        a.returnValue = false
    }
};
dayucms.lang.isObject = function(a) {
    return "function" == typeof a || !!(a && "object" == typeof a)
};
dayucms.isObject = dayucms.lang.isObject; (function() {
    var j, i, f, d, c, g, m, a, l, n;
    dayucms.dom.drag = function(p, o) {
        if (! (j = dayucms.dom.g(p))) {
            return false
        }
        i = dayucms.object.extend({
            autoStop: true,
            capture: true,
            interval: 16
        },
        o);
        a = g = parseInt(dayucms.dom.getStyle(j, "left")) || 0;
        l = m = parseInt(dayucms.dom.getStyle(j, "top")) || 0;
        setTimeout(function() {
            var q = dayucms.page.getMousePosition();
            f = i.mouseEvent ? (dayucms.page.getScrollLeft() + i.mouseEvent.clientX) : q.x;
            d = i.mouseEvent ? (dayucms.page.getScrollTop() + i.mouseEvent.clientY) : q.y;
            clearInterval(c);
            c = setInterval(b, i.interval)
        },
        1);
        i.autoStop && dayucms.event.on(document, "mouseup", k);
        dayucms.event.on(document, "selectstart", h);
        if (i.capture && j.setCapture) {
            j.setCapture()
        } else {
            if (i.capture && window.captureEvents) {
                window.captureEvents(Event.MOUSEMOVE | Event.MOUSEUP)
            }
        }
        n = document.body.style.MozUserSelect;
        document.body.style.MozUserSelect = "none";
        dayucms.lang.isFunction(i.ondragstart) && i.ondragstart(j, i);
        return {
            stop: k,
            dispose: k,
            update: function(q) {
                dayucms.object.extend(i, q)
            }
        }
    };
    function k() {
        clearInterval(c);
        if (i.capture && j.releaseCapture) {
            j.releaseCapture()
        } else {
            if (i.capture && window.captureEvents) {
                window.captureEvents(Event.MOUSEMOVE | Event.MOUSEUP)
            }
        }
        document.body.style.MozUserSelect = n;
        dayucms.event.un(document, "selectstart", h);
        i.autoStop && dayucms.event.un(document, "mouseup", k);
        dayucms.lang.isFunction(i.ondragend) && i.ondragend(j, i, {
            left: a,
            top: l
        })
    }
    function b(s) {
        var p = i.range || [],
        o = dayucms.page.getMousePosition(),
        q = g + o.x - f,
        r = m + o.y - d;
        if (dayucms.lang.isObject(p) && p.length == 4) {
            q = Math.max(p[3], q);
            q = Math.min(p[1] - j.offsetWidth, q);
            r = Math.max(p[0], r);
            r = Math.min(p[2] - j.offsetHeight, r)
        }
        j.style.left = q + "px";
        j.style.top = r + "px";
        a = q;
        l = r;
        dayucms.lang.isFunction(i.ondrag) && i.ondrag(j, i, {
            left: a,
            top: l
        })
    }
    function h(o) {
        return dayucms.event.preventDefault(o, false)
    }
})();
dayucms.dom.setStyle = function(c, b, d) {
    var f = dayucms.dom,
    a;
    c = f.g(c);
    b = dayucms.string.toCamelCase(b);
    if (a = f._styleFilter) {
        d = a.filter(b, d, "set")
    }
    a = f._styleFixer[b]; (a && a.set) ? a.set(c, d, b) : (c.style[a || b] = d);
    return c
};
dayucms.setStyle = dayucms.dom.setStyle;
dayucms.dom.draggable = function(b, l) {
    l = dayucms.object.extend({
        toggle: function() {
            return true
        }
    },
    l);
    l.autoStop = true;
    b = dayucms.dom.g(b);
    l.handler = l.handler || b;
    var a, j = ["ondragstart", "ondrag", "ondragend"],
    c = j.length - 1,
    d,
    k,
    g = {
        dispose: function() {
            k && k.stop();
            dayucms.event.un(l.handler, "onmousedown", h);
            dayucms.lang.Class.prototype.dispose.call(g)
        }
    },
    f = this;
    if (a = dayucms.dom.ddManager) {
        for (; c >= 0; c--) {
            d = j[c];
            l[d] = (function(i) {
                var m = l[i];
                return function() {
                    dayucms.lang.isFunction(m) && m.apply(f, arguments);
                    a.dispatchEvent(i, {
                        DOM: b
                    })
                }
            })(d)
        }
    }
    if (b) {
        function h(m) {
            var i = l.mouseEvent = window.event || m;
            l.mouseEvent = {
                clientX: i.clientX,
                clientY: i.clientY
            };
            if (i.button > 1 || (dayucms.lang.isFunction(l.toggle) && !l.toggle())) {
                return
            }
            if (dayucms.lang.isFunction(l.onbeforedragstart)) {
                l.onbeforedragstart(b)
            }
            k = dayucms.dom.drag(b, l);
            g.stop = k.stop;
            g.update = k.update;
            dayucms.event.preventDefault(i)
        }
        dayucms.event.on(l.handler, "onmousedown", h)
    }
    return {
        cancel: function() {
            g.dispose()
        }
    }
};
dayucms.dom.getPosition = function(a) {
    a = dayucms.dom.g(a);
    var k = dayucms.dom.getDocument(a),
    d = dayucms.browser,
    h = dayucms.dom.getStyle,
    c = d.isGecko > 0 && k.getBoxObjectFor && h(a, "position") == "absolute" && (a.style.top === "" || a.style.left === ""),
    i = {
        left: 0,
        top: 0
    },
    g = (d.ie && !d.isStrict) ? k.body: k.documentElement,
    l,
    b;
    if (a == g) {
        return i
    }
    if (a.getBoundingClientRect) {
        b = a.getBoundingClientRect();
        i.left = Math.floor(b.left) + Math.max(k.documentElement.scrollLeft, k.body.scrollLeft);
        i.top = Math.floor(b.top) + Math.max(k.documentElement.scrollTop, k.body.scrollTop);
        i.left -= k.documentElement.clientLeft;
        i.top -= k.documentElement.clientTop;
        var j = k.body,
        m = parseInt(h(j, "borderLeftWidth")),
        f = parseInt(h(j, "borderTopWidth"));
        if (d.ie && !d.isStrict) {
            i.left -= isNaN(m) ? 2 : m;
            i.top -= isNaN(f) ? 2 : f
        }
    } else {
        l = a;
        do {
            i.left += l.offsetLeft;
            i.top += l.offsetTop;
            if (d.isWebkit > 0 && h(l, "position") == "fixed") {
                i.left += k.body.scrollLeft;
                i.top += k.body.scrollTop;
                break
            }
            l = l.offsetParent
        } while ( l && l != a );
        if (d.opera > 0 || (d.isWebkit > 0 && h(a, "position") == "absolute")) {
            i.top -= k.body.offsetTop
        }
        l = a.offsetParent;
        while (l && l != k.body) {
            i.left -= l.scrollLeft;
            if (!d.opera || l.tagName != "TR") {
                i.top -= l.scrollTop
            }
            l = l.offsetParent
        }
    }
    return i
};
dayucms.dom.intersect = function(j, i) {
    var h = dayucms.dom.g,
    f = dayucms.dom.getPosition,
    a = Math.max,
    c = Math.min;
    j = h(j);
    i = h(i);
    var d = f(j),
    b = f(i);
    return a(d.left, b.left) <= c(d.left + j.offsetWidth, b.left + i.offsetWidth) && a(d.top, b.top) <= c(d.top + j.offsetHeight, b.top + i.offsetHeight)
};
dayucms.dom.droppable = function(f, c) {
    c = c || {};
    var d = dayucms.dom.ddManager,
    h = dayucms.dom.g(f),
    b = dayucms.lang.guid(),
    g = function(k) {
        var j = d._targetsDroppingOver,
        i = {
            trigger: k.DOM,
            reciever: h
        };
        if (dayucms.dom.intersect(h, k.DOM)) {
            if (!j[b]) { (typeof c.ondropover == "function") && c.ondropover.call(h, i);
                d.dispatchEvent("ondropover", i);
                j[b] = true
            }
        } else {
            if (j[b]) { (typeof c.ondropout == "function") && c.ondropout.call(h, i);
                d.dispatchEvent("ondropout", i)
            }
            delete j[b]
        }
    },
    a = function(j) {
        var i = {
            trigger: j.DOM,
            reciever: h
        };
        if (dayucms.dom.intersect(h, j.DOM)) {
            typeof c.ondrop == "function" && c.ondrop.call(h, i);
            d.dispatchEvent("ondrop", i)
        }
        delete d._targetsDroppingOver[b]
    };
    d.addEventListener("ondrag", g);
    d.addEventListener("ondragend", a);
    return {
        cancel: function() {
            d.removeEventListener("ondrag", g);
            d.removeEventListener("ondragend", a)
        }
    }
};
dayucms.dom.empty = function(a) {
    a = dayucms.dom.g(a);
    while (a.firstChild) {
        a.removeChild(a.firstChild)
    }
    return a
};
dayucms.dom._matchNode = function(a, c, d) {
    a = dayucms.dom.g(a);
    for (var b = a[d]; b; b = b[c]) {
        if (b.nodeType == 1) {
            return b
        }
    }
    return null
};
dayucms.dom.first = function(a) {
    return dayucms.dom._matchNode(a, "nextSibling", "firstChild")
};
dayucms.dom.getAttr = function(b, a) {
    b = dayucms.dom.g(b);
    if ("style" == a) {
        return b.style.cssText
    }
    a = dayucms.dom._NAME_ATTRS[a] || a;
    return b.getAttribute(a)
};
dayucms.getAttr = dayucms.dom.getAttr;
dayucms.dom.setStyles = function(b, c) {
    b = dayucms.dom.g(b);
    for (var a in c) {
        dayucms.dom.setStyle(b, a, c[a])
    }
    return b
};
dayucms.setStyles = dayucms.dom.setStyles;
dayucms.page.getViewHeight = function() {
    var b = document,
    a = b.compatMode == "BackCompat" ? b.body: b.documentElement;
    return a.clientHeight
};
dayucms.page.getViewWidth = function() {
    var b = document,
    a = b.compatMode == "BackCompat" ? b.body: b.documentElement;
    return a.clientWidth
};
dayucms.dom._styleFilter[dayucms.dom._styleFilter.length] = {
    set: function(a, b) {
        if (b.constructor == Number && !/zIndex|fontWeight|opacity|zoom|lineHeight/i.test(a)) {
            b = b + "px"
        }
        return b
    }
};
dayucms.dom.fixable = function(a, b) {
    var u = dayucms.g(a),
    p = dayucms.browser.ie && dayucms.browser.ie <= 7 ? true: false,
    k = b.vertival || "top",
    s = b.horizontal || "left",
    r = typeof b.autofix != "undefined" ? b.autofix: true,
    j,
    d,
    i = false,
    m = b.onrender || new Function(),
    c = b.onupdate || new Function(),
    l = b.onrelease || new Function();
    if (!u) {
        return
    }
    j = h();
    d = {
        y: p ? (j.position == "static" ? dayucms.dom.getPosition(u).top: dayucms.dom.getPosition(u).top - dayucms.dom.getPosition(u.parentNode).top) : u.offsetTop,
        x: p ? (j.position == "static" ? dayucms.dom.getPosition(u).left: dayucms.dom.getPosition(u).left - dayucms.dom.getPosition(u.parentNode).left) : u.offsetLeft
    };
    dayucms.extend(d, b.offset || {});
    r && t();
    function q() {
        return {
            top: k == "top" ? d.y: dayucms.page.getViewHeight() - d.y - j.height,
            left: s == "left" ? d.x: dayucms.page.getViewWidth() - d.x - j.width
        }
    }
    function n() {
        var v = q();
        u.style.setExpression("left", "eval((document.body.scrollLeft || document.documentElement.scrollLeft) + " + v.left + ") + 'px'");
        u.style.setExpression("top", "eval((document.body.scrollTop || document.documentElement.scrollTop) + " + v.top + ") + 'px'")
    }
    function h() {
        var v = {
            position: dayucms.getStyle(u, "position"),
            height: function() {
                var w = dayucms.getStyle(u, "height");
                return (w != "auto") ? (/\d+/.exec(w)[0]) : u.offsetHeight
            } (),
            width: function() {
                var x = dayucms.getStyle(u, "width");
                return (x != "auto") ? (/\d+/.exec(x)[0]) : u.offsetWidth
            } ()
        };
        f("top", v);
        f("left", v);
        f("bottom", v);
        f("right", v);
        return v
    }
    function f(w, x) {
        var v;
        if (x.position == "static") {
            x[w] = ""
        } else {
            v = dayucms.getStyle(u, w);
            if (v == "auto" || v == "0px") {
                x[w] = ""
            } else {
                x[w] = v
            }
        }
    }
    function t() {
        if (i) {
            return
        }
        dayucms.setStyles(u, {
            top: "",
            left: "",
            bottom: "",
            right: ""
        });
        if (!p) {
            var v = {
                position: "fixed"
            };
            v[k == "top" ? "top": "bottom"] = d.y + "px";
            v[s == "left" ? "left": "right"] = d.x + "px";
            dayucms.setStyles(u, v)
        } else {
            dayucms.setStyle(u, "position", "absolute");
            n()
        }
        m();
        i = true
    }
    function o() {
        if (!i) {
            return
        }
        var v = {
            position: j.position,
            left: j.left == "" ? "auto": j.left,
            top: j.top == "" ? "auto": j.top,
            bottom: j.bottom == "" ? "auto": j.bottom,
            right: j.right == "" ? "auto": j.right
        };
        if (p) {
            u.style.removeExpression("left");
            u.style.removeExpression("top")
        }
        dayucms.setStyles(u, v);
        l();
        i = false
    }
    function g(v) {
        if (!v) {
            return
        }
        m = v.onrender || m;
        c = v.onupdate || c;
        l = v.onrelease || l;
        k = v.vertival || "top";
        s = v.horizontal || "left";
        dayucms.extend(d, v.offset || {});
        c()
    }
    return {
        render: t,
        update: g,
        release: o
    }
};
dayucms.dom.getAncestorBy = function(a, b) {
    a = dayucms.dom.g(a);
    while ((a = a.parentNode) && a.nodeType == 1) {
        if (b(a)) {
            return a
        }
    }
    return null
};
dayucms.dom.getAncestorByClass = function(a, b) {
    a = dayucms.dom.g(a);
    b = new RegExp("(^|\\s)" + dayucms.string.trim(b) + "(\\s|\x24)");
    while ((a = a.parentNode) && a.nodeType == 1) {
        if (b.test(a.className)) {
            return a
        }
    }
    return null
};
dayucms.dom.getAncestorByTag = function(b, a) {
    b = dayucms.dom.g(b);
    a = a.toUpperCase();
    while ((b = b.parentNode) && b.nodeType == 1) {
        if (b.tagName == a) {
            return b
        }
    }
    return null
};
dayucms.dom.getCurrentStyle = function(b, a) {
    b = dayucms.dom.g(b);
    return b.style[a] || (b.currentStyle ? b.currentStyle[a] : "") || dayucms.dom.getComputedStyle(b, a)
};
dayucms.dom.getParent = function(a) {
    a = dayucms.dom._g(a);
    return a.parentElement || a.parentNode || null
};
dayucms.dom.getText = function(d) {
    var b = "",
    f, c = 0,
    a;
    d = dayucms._g(d);
    if (d.nodeType === 3 || d.nodeType === 4) {
        b += d.nodeValue
    } else {
        if (d.nodeType !== 8) {
            f = d.childNodes;
            for (a = f.length; c < a; c++) {
                b += dayucms.dom.getText(f[c])
            }
        }
    }
    return b
};
dayucms.dom.getWindow = function(a) {
    a = dayucms.dom.g(a);
    var b = dayucms.dom.getDocument(a);
    return b.parentWindow || b.defaultView || null
};
dayucms.dom.hasAttr = function(c, b) {
    c = dayucms.g(c);
    var a = c.attributes.getNamedItem(b);
    return !! (a && a.specified)
};
dayucms.dom.hasClass = function(c, d) {
    c = dayucms.dom.g(c);
    if (!c || !c.className) {
        return false
    }
    var b = dayucms.string.trim(d).split(/\s+/),
    a = b.length;
    d = c.className.split(/\s+/).join(" ");
    while (a--) {
        if (! (new RegExp("(^| )" + b[a] + "( |\x24)")).test(d)) {
            return false
        }
    }
    return true
};
dayucms.dom.hide = function(a) {
    a = dayucms.dom.g(a);
    a.style.display = "none";
    return a
};
dayucms.hide = dayucms.dom.hide;
dayucms.dom.insertAfter = function(d, c) {
    var b, a;
    b = dayucms.dom._g;
    d = b(d);
    c = b(c);
    a = c.parentNode;
    if (a) {
        a.insertBefore(d, c.nextSibling)
    }
    return d
};
dayucms.dom.insertBefore = function(d, c) {
    var b, a;
    b = dayucms.dom._g;
    d = b(d);
    c = b(c);
    a = c.parentNode;
    if (a) {
        a.insertBefore(d, c)
    }
    return d
};
dayucms.dom.insertHTML = function(d, a, c) {
    d = dayucms.dom.g(d);
    var b, f;
    if (d.insertAdjacentHTML && !dayucms.browser.opera) {
        d.insertAdjacentHTML(a, c)
    } else {
        b = d.ownerDocument.createRange();
        a = a.toUpperCase();
        if (a == "AFTERBEGIN" || a == "BEFOREEND") {
            b.selectNodeContents(d);
            b.collapse(a == "AFTERBEGIN")
        } else {
            f = a == "BEFOREBEGIN";
            b[f ? "setStartBefore": "setEndAfter"](d);
            b.collapse(f)
        }
        b.insertNode(b.createContextualFragment(c))
    }
    return d
};
dayucms.insertHTML = dayucms.dom.insertHTML;
dayucms.dom.last = function(a) {
    return dayucms.dom._matchNode(a, "previousSibling", "lastChild")
};
dayucms.dom.next = function(a) {
    return dayucms.dom._matchNode(a, "nextSibling", "nextSibling")
};
dayucms.dom.opacity = function(b, a) {
    b = dayucms.dom.g(b);
    if (!dayucms.browser.ie) {
        b.style.opacity = a;
        b.style.KHTMLOpacity = a
    } else {
        b.style.filter = "progid:DXImageTransform.Microsoft.Alpha(opacity:" + Math.floor(a * 100) + ")"
    }
};
dayucms.dom.prev = function(a) {
    return dayucms.dom._matchNode(a, "previousSibling", "previousSibling")
};
dayucms.string.escapeReg = function(a) {
    return String(a).replace(new RegExp("([.*+?^=!:\x24{}()|[\\]/\\\\])", "g"), "\\\x241")
};
dayucms.dom.q = function(j, f, b) {
    var k = [],
    d = dayucms.string.trim,
    h,
    g,
    a,
    c;
    if (! (j = d(j))) {
        return k
    }
    if ("undefined" == typeof f) {
        f = document
    } else {
        f = dayucms.dom.g(f);
        if (!f) {
            return k
        }
    }
    b && (b = d(b).toUpperCase());
    if (f.getElementsByClassName) {
        a = f.getElementsByClassName(j);
        h = a.length;
        for (g = 0; g < h; g++) {
            c = a[g];
            if (b && c.tagName != b) {
                continue
            }
            k[k.length] = c
        }
    } else {
        j = new RegExp("(^|\\s)" + dayucms.string.escapeReg(j) + "(\\s|\x24)");
        a = b ? f.getElementsByTagName(b) : (f.all || f.getElementsByTagName("*"));
        h = a.length;
        for (g = 0; g < h; g++) {
            c = a[g];
            j.test(c.className) && (k[k.length] = c)
        }
    }
    return k
};
dayucms.q = dayucms.Q = dayucms.dom.q;
/*
 * Sizzle CSS Selector Engine
 *  Copyright 2011, The Dojo Foundation
 *  Released under the MIT, BSD, and GPL Licenses.
 *  More information: http://sizzlejs.com/
 */
(function() {
    var n = /((?:\((?:\([^()]+\)|[^()]+)+\)|\[(?:\[[^\[\]]*\]|['"][^'"]*['"]|[^\[\]'"]+)+\]|\\.|[^ >+~,(\[\\]+)+|[>+~])(\s*,\s*)?((?:.|\r|\n)*)/g,
    i = "sizcache" + (Math.random() + "").replace(".", ""),
    o = 0,
    r = Object.prototype.toString,
    h = false,
    g = true,
    q = /\\/g,
    u = /\r\n/g,
    w = /\W/; [0, 0].sort(function() {
        g = false;
        return 0
    });
    var d = function(C, x, F, G) {
        F = F || [];
        x = x || document;
        var I = x;
        if (x.nodeType !== 1 && x.nodeType !== 9) {
            return []
        }
        if (!C || typeof C !== "string") {
            return F
        }
        var z, K, N, y, J, M, L, E, B = true,
        A = d.isXML(x),
        D = [],
        H = C;
        do {
            n.exec("");
            z = n.exec(H);
            if (z) {
                H = z[3];
                D.push(z[1]);
                if (z[2]) {
                    y = z[3];
                    break
                }
            }
        } while ( z );
        if (D.length > 1 && j.exec(C)) {
            if (D.length === 2 && k.relative[D[0]]) {
                K = s(D[0] + D[1], x, G)
            } else {
                K = k.relative[D[0]] ? [x] : d(D.shift(), x);
                while (D.length) {
                    C = D.shift();
                    if (k.relative[C]) {
                        C += D.shift()
                    }
                    K = s(C, K, G)
                }
            }
        } else {
            if (!G && D.length > 1 && x.nodeType === 9 && !A && k.match.ID.test(D[0]) && !k.match.ID.test(D[D.length - 1])) {
                J = d.find(D.shift(), x, A);
                x = J.expr ? d.filter(J.expr, J.set)[0] : J.set[0]
            }
            if (x) {
                J = G ? {
                    expr: D.pop(),
                    set: l(G)
                }: d.find(D.pop(), D.length === 1 && (D[0] === "~" || D[0] === "+") && x.parentNode ? x.parentNode: x, A);
                K = J.expr ? d.filter(J.expr, J.set) : J.set;
                if (D.length > 0) {
                    N = l(K)
                } else {
                    B = false
                }
                while (D.length) {
                    M = D.pop();
                    L = M;
                    if (!k.relative[M]) {
                        M = ""
                    } else {
                        L = D.pop()
                    }
                    if (L == null) {
                        L = x
                    }
                    k.relative[M](N, L, A)
                }
            } else {
                N = D = []
            }
        }
        if (!N) {
            N = K
        }
        if (!N) {
            d.error(M || C)
        }
        if (r.call(N) === "[object Array]") {
            if (!B) {
                F.push.apply(F, N)
            } else {
                if (x && x.nodeType === 1) {
                    for (E = 0; N[E] != null; E++) {
                        if (N[E] && (N[E] === true || N[E].nodeType === 1 && d.contains(x, N[E]))) {
                            F.push(K[E])
                        }
                    }
                } else {
                    for (E = 0; N[E] != null; E++) {
                        if (N[E] && N[E].nodeType === 1) {
                            F.push(K[E])
                        }
                    }
                }
            }
        } else {
            l(N, F)
        }
        if (y) {
            d(y, I, F, G);
            d.uniqueSort(F)
        }
        return F
    };
    d.uniqueSort = function(y) {
        if (p) {
            h = g;
            y.sort(p);
            if (h) {
                for (var x = 1; x < y.length; x++) {
                    if (y[x] === y[x - 1]) {
                        y.splice(x--, 1)
                    }
                }
            }
        }
        return y
    };
    d.matches = function(x, y) {
        return d(x, null, null, y)
    };
    d.matchesSelector = function(x, y) {
        return d(y, null, null, [x]).length > 0
    };
    d.find = function(E, x, F) {
        var D, z, B, A, C, y;
        if (!E) {
            return []
        }
        for (z = 0, B = k.order.length; z < B; z++) {
            C = k.order[z];
            if ((A = k.leftMatch[C].exec(E))) {
                y = A[1];
                A.splice(1, 1);
                if (y.substr(y.length - 1) !== "\\") {
                    A[1] = (A[1] || "").replace(q, "");
                    D = k.find[C](A, x, F);
                    if (D != null) {
                        E = E.replace(k.match[C], "");
                        break
                    }
                }
            }
        }
        if (!D) {
            D = typeof x.getElementsByTagName !== "undefined" ? x.getElementsByTagName("*") : []
        }
        return {
            set: D,
            expr: E
        }
    };
    d.filter = function(I, H, L, B) {
        var D, x, G, N, K, y, A, C, J, z = I,
        M = [],
        F = H,
        E = H && H[0] && d.isXML(H[0]);
        while (I && H.length) {
            for (G in k.filter) {
                if ((D = k.leftMatch[G].exec(I)) != null && D[2]) {
                    y = k.filter[G];
                    A = D[1];
                    x = false;
                    D.splice(1, 1);
                    if (A.substr(A.length - 1) === "\\") {
                        continue
                    }
                    if (F === M) {
                        M = []
                    }
                    if (k.preFilter[G]) {
                        D = k.preFilter[G](D, F, L, M, B, E);
                        if (!D) {
                            x = N = true
                        } else {
                            if (D === true) {
                                continue
                            }
                        }
                    }
                    if (D) {
                        for (C = 0; (K = F[C]) != null; C++) {
                            if (K) {
                                N = y(K, D, C, F);
                                J = B ^ N;
                                if (L && N != null) {
                                    if (J) {
                                        x = true
                                    } else {
                                        F[C] = false
                                    }
                                } else {
                                    if (J) {
                                        M.push(K);
                                        x = true
                                    }
                                }
                            }
                        }
                    }
                    if (N !== undefined) {
                        if (!L) {
                            F = M
                        }
                        I = I.replace(k.match[G], "");
                        if (!x) {
                            return []
                        }
                        break
                    }
                }
            }
            if (I === z) {
                if (x == null) {
                    d.error(I)
                } else {
                    break
                }
            }
            z = I
        }
        return F
    };
    d.error = function(x) {
        throw "Syntax error, unrecognized expression: " + x
    };
    var b = d.getText = function(B) {
        var z, A, x = B.nodeType,
        y = "";
        if (x) {
            if (x === 1) {
                if (typeof B.textContent === "string") {
                    return B.textContent
                } else {
                    if (typeof B.innerText === "string") {
                        return B.innerText.replace(u, "")
                    } else {
                        for (B = B.firstChild; B; B = B.nextSibling) {
                            y += b(B)
                        }
                    }
                }
            } else {
                if (x === 3 || x === 4) {
                    return B.nodeValue
                }
            }
        } else {
            for (z = 0; (A = B[z]); z++) {
                if (A.nodeType !== 8) {
                    y += b(A)
                }
            }
        }
        return y
    };
    var k = d.selectors = {
        order: ["ID", "NAME", "TAG"],
        match: {
            ID: /#((?:[\w\u00c0-\uFFFF\-]|\\.)+)/,
            CLASS: /\.((?:[\w\u00c0-\uFFFF\-]|\\.)+)/,
            NAME: /\[name=['"]*((?:[\w\u00c0-\uFFFF\-]|\\.)+)['"]*\]/,
            ATTR: /\[\s*((?:[\w\u00c0-\uFFFF\-]|\\.)+)\s*(?:(\S?=)\s*(?:(['"])(.*?)\3|(#?(?:[\w\u00c0-\uFFFF\-]|\\.)*)|)|)\s*\]/,
            TAG: /^((?:[\w\u00c0-\uFFFF\*\-]|\\.)+)/,
            CHILD: /:(only|nth|last|first)-child(?:\(\s*(even|odd|(?:[+\-]?\d+|(?:[+\-]?\d*)?n\s*(?:[+\-]\s*\d+)?))\s*\))?/,
            POS: /:(nth|eq|gt|lt|first|last|even|odd)(?:\((\d*)\))?(?=[^\-]|$)/,
            PSEUDO: /:((?:[\w\u00c0-\uFFFF\-]|\\.)+)(?:\((['"]?)((?:\([^\)]+\)|[^\(\)]*)+)\2\))?/
        },
        leftMatch: {},
        attrMap: {
            "class": "className",
            "for": "htmlFor"
        },
        attrHandle: {
            href: function(x) {
                return x.getAttribute("href")
            },
            type: function(x) {
                return x.getAttribute("type")
            }
        },
        relative: {
            "+": function(D, y) {
                var A = typeof y === "string",
                C = A && !w.test(y),
                E = A && !C;
                if (C) {
                    y = y.toLowerCase()
                }
                for (var z = 0,
                x = D.length,
                B; z < x; z++) {
                    if ((B = D[z])) {
                        while ((B = B.previousSibling) && B.nodeType !== 1) {}
                        D[z] = E || B && B.nodeName.toLowerCase() === y ? B || false: B === y
                    }
                }
                if (E) {
                    d.filter(y, D, true)
                }
            },
            ">": function(D, y) {
                var C, B = typeof y === "string",
                z = 0,
                x = D.length;
                if (B && !w.test(y)) {
                    y = y.toLowerCase();
                    for (; z < x; z++) {
                        C = D[z];
                        if (C) {
                            var A = C.parentNode;
                            D[z] = A.nodeName.toLowerCase() === y ? A: false
                        }
                    }
                } else {
                    for (; z < x; z++) {
                        C = D[z];
                        if (C) {
                            D[z] = B ? C.parentNode: C.parentNode === y
                        }
                    }
                    if (B) {
                        d.filter(y, D, true)
                    }
                }
            },
            "": function(A, y, C) {
                var B, z = o++,
                x = t;
                if (typeof y === "string" && !w.test(y)) {
                    y = y.toLowerCase();
                    B = y;
                    x = a
                }
                x("parentNode", y, z, A, B, C)
            },
            "~": function(A, y, C) {
                var B, z = o++,
                x = t;
                if (typeof y === "string" && !w.test(y)) {
                    y = y.toLowerCase();
                    B = y;
                    x = a
                }
                x("previousSibling", y, z, A, B, C)
            }
        },
        find: {
            ID: function(y, z, A) {
                if (typeof z.getElementById !== "undefined" && !A) {
                    var x = z.getElementById(y[1]);
                    return x && x.parentNode ? [x] : []
                }
            },
            NAME: function(z, C) {
                if (typeof C.getElementsByName !== "undefined") {
                    var y = [],
                    B = C.getElementsByName(z[1]);
                    for (var A = 0,
                    x = B.length; A < x; A++) {
                        if (B[A].getAttribute("name") === z[1]) {
                            y.push(B[A])
                        }
                    }
                    return y.length === 0 ? null: y
                }
            },
            TAG: function(x, y) {
                if (typeof y.getElementsByTagName !== "undefined") {
                    return y.getElementsByTagName(x[1])
                }
            }
        },
        preFilter: {
            CLASS: function(A, y, z, x, D, E) {
                A = " " + A[1].replace(q, "") + " ";
                if (E) {
                    return A
                }
                for (var B = 0,
                C; (C = y[B]) != null; B++) {
                    if (C) {
                        if (D ^ (C.className && (" " + C.className + " ").replace(/[\t\n\r]/g, " ").indexOf(A) >= 0)) {
                            if (!z) {
                                x.push(C)
                            }
                        } else {
                            if (z) {
                                y[B] = false
                            }
                        }
                    }
                }
                return false
            },
            ID: function(x) {
                return x[1].replace(q, "")
            },
            TAG: function(y, x) {
                return y[1].replace(q, "").toLowerCase()
            },
            CHILD: function(x) {
                if (x[1] === "nth") {
                    if (!x[2]) {
                        d.error(x[0])
                    }
                    x[2] = x[2].replace(/^\+|\s*/g, "");
                    var y = /(-?)(\d*)(?:n([+\-]?\d*))?/.exec(x[2] === "even" && "2n" || x[2] === "odd" && "2n+1" || !/\D/.test(x[2]) && "0n+" + x[2] || x[2]);
                    x[2] = (y[1] + (y[2] || 1)) - 0;
                    x[3] = y[3] - 0
                } else {
                    if (x[2]) {
                        d.error(x[0])
                    }
                }
                x[0] = o++;
                return x
            },
            ATTR: function(B, y, z, x, C, D) {
                var A = B[1] = B[1].replace(q, "");
                if (!D && k.attrMap[A]) {
                    B[1] = k.attrMap[A]
                }
                B[4] = (B[4] || B[5] || "").replace(q, "");
                if (B[2] === "~=") {
                    B[4] = " " + B[4] + " "
                }
                return B
            },
            PSEUDO: function(B, y, z, x, C) {
                if (B[1] === "not") {
                    if ((n.exec(B[3]) || "").length > 1 || /^\w/.test(B[3])) {
                        B[3] = d(B[3], null, null, y)
                    } else {
                        var A = d.filter(B[3], y, z, true ^ C);
                        if (!z) {
                            x.push.apply(x, A)
                        }
                        return false
                    }
                } else {
                    if (k.match.POS.test(B[0]) || k.match.CHILD.test(B[0])) {
                        return true
                    }
                }
                return B
            },
            POS: function(x) {
                x.unshift(true);
                return x
            }
        },
        filters: {
            enabled: function(x) {
                return x.disabled === false && x.type !== "hidden"
            },
            disabled: function(x) {
                return x.disabled === true
            },
            checked: function(x) {
                return x.checked === true
            },
            selected: function(x) {
                if (x.parentNode) {
                    x.parentNode.selectedIndex
                }
                return x.selected === true
            },
            parent: function(x) {
                return !! x.firstChild
            },
            empty: function(x) {
                return ! x.firstChild
            },
            has: function(z, y, x) {
                return !! d(x[3], z).length
            },
            header: function(x) {
                return (/h\d/i).test(x.nodeName)
            },
            text: function(z) {
                var x = z.getAttribute("type"),
                y = z.type;
                return z.nodeName.toLowerCase() === "input" && "text" === y && (x === y || x === null)
            },
            radio: function(x) {
                return x.nodeName.toLowerCase() === "input" && "radio" === x.type
            },
            checkbox: function(x) {
                return x.nodeName.toLowerCase() === "input" && "checkbox" === x.type
            },
            file: function(x) {
                return x.nodeName.toLowerCase() === "input" && "file" === x.type
            },
            password: function(x) {
                return x.nodeName.toLowerCase() === "input" && "password" === x.type
            },
            submit: function(y) {
                var x = y.nodeName.toLowerCase();
                return (x === "input" || x === "button") && "submit" === y.type
            },
            image: function(x) {
                return x.nodeName.toLowerCase() === "input" && "image" === x.type
            },
            reset: function(y) {
                var x = y.nodeName.toLowerCase();
                return (x === "input" || x === "button") && "reset" === y.type
            },
            button: function(y) {
                var x = y.nodeName.toLowerCase();
                return x === "input" && "button" === y.type || x === "button"
            },
            input: function(x) {
                return (/input|select|textarea|button/i).test(x.nodeName)
            },
            focus: function(x) {
                return x === x.ownerDocument.activeElement
            }
        },
        setFilters: {
            first: function(y, x) {
                return x === 0
            },
            last: function(z, y, x, A) {
                return y === A.length - 1
            },
            even: function(y, x) {
                return x % 2 === 0
            },
            odd: function(y, x) {
                return x % 2 === 1
            },
            lt: function(z, y, x) {
                return y < x[3] - 0
            },
            gt: function(z, y, x) {
                return y > x[3] - 0
            },
            nth: function(z, y, x) {
                return x[3] - 0 === y
            },
            eq: function(z, y, x) {
                return x[3] - 0 === y
            }
        },
        filter: {
            PSEUDO: function(z, E, D, F) {
                var x = E[1],
                y = k.filters[x];
                if (y) {
                    return y(z, D, E, F)
                } else {
                    if (x === "contains") {
                        return (z.textContent || z.innerText || b([z]) || "").indexOf(E[3]) >= 0
                    } else {
                        if (x === "not") {
                            var A = E[3];
                            for (var C = 0,
                            B = A.length; C < B; C++) {
                                if (A[C] === z) {
                                    return false
                                }
                            }
                            return true
                        } else {
                            d.error(x)
                        }
                    }
                }
            },
            CHILD: function(z, B) {
                var A, H, D, G, x, C, F, E = B[1],
                y = z;
                switch (E) {
                case "only":
                case "first":
                    while ((y = y.previousSibling)) {
                        if (y.nodeType === 1) {
                            return false
                        }
                    }
                    if (E === "first") {
                        return true
                    }
                    y = z;
                case "last":
                    while ((y = y.nextSibling)) {
                        if (y.nodeType === 1) {
                            return false
                        }
                    }
                    return true;
                case "nth":
                    A = B[2];
                    H = B[3];
                    if (A === 1 && H === 0) {
                        return true
                    }
                    D = B[0];
                    G = z.parentNode;
                    if (G && (G[i] !== D || !z.nodeIndex)) {
                        C = 0;
                        for (y = G.firstChild; y; y = y.nextSibling) {
                            if (y.nodeType === 1) {
                                y.nodeIndex = ++C
                            }
                        }
                        G[i] = D
                    }
                    F = z.nodeIndex - H;
                    if (A === 0) {
                        return F === 0
                    } else {
                        return (F % A === 0 && F / A >= 0)
                    }
                }
            },
            ID: function(y, x) {
                return y.nodeType === 1 && y.getAttribute("id") === x
            },
            TAG: function(y, x) {
                return (x === "*" && y.nodeType === 1) || !!y.nodeName && y.nodeName.toLowerCase() === x
            },
            CLASS: function(y, x) {
                return (" " + (y.className || y.getAttribute("class")) + " ").indexOf(x) > -1
            },
            ATTR: function(C, A) {
                var z = A[1],
                x = d.attr ? d.attr(C, z) : k.attrHandle[z] ? k.attrHandle[z](C) : C[z] != null ? C[z] : C.getAttribute(z),
                D = x + "",
                B = A[2],
                y = A[4];
                return x == null ? B === "!=": !B && d.attr ? x != null: B === "=" ? D === y: B === "*=" ? D.indexOf(y) >= 0 : B === "~=" ? (" " + D + " ").indexOf(y) >= 0 : !y ? D && x !== false: B === "!=" ? D !== y: B === "^=" ? D.indexOf(y) === 0 : B === "$=" ? D.substr(D.length - y.length) === y: B === "|=" ? D === y || D.substr(0, y.length + 1) === y + "-": false
            },
            POS: function(B, y, z, C) {
                var x = y[2],
                A = k.setFilters[x];
                if (A) {
                    return A(B, z, y, C)
                }
            }
        }
    };
    var j = k.match.POS,
    c = function(y, x) {
        return "\\" + (x - 0 + 1)
    };
    for (var f in k.match) {
        k.match[f] = new RegExp(k.match[f].source + (/(?![^\[]*\])(?![^\(]*\))/.source));
        k.leftMatch[f] = new RegExp(/(^(?:.|\r|\n)*?)/.source + k.match[f].source.replace(/\\(\d+)/g, c))
    }
    var l = function(y, x) {
        y = Array.prototype.slice.call(y, 0);
        if (x) {
            x.push.apply(x, y);
            return x
        }
        return y
    };
    try {
        Array.prototype.slice.call(document.documentElement.childNodes, 0)[0].nodeType
    } catch(v) {
        l = function(B, A) {
            var z = 0,
            y = A || [];
            if (r.call(B) === "[object Array]") {
                Array.prototype.push.apply(y, B)
            } else {
                if (typeof B.length === "number") {
                    for (var x = B.length; z < x; z++) {
                        y.push(B[z])
                    }
                } else {
                    for (; B[z]; z++) {
                        y.push(B[z])
                    }
                }
            }
            return y
        }
    }
    var p, m;
    if (document.documentElement.compareDocumentPosition) {
        p = function(y, x) {
            if (y === x) {
                h = true;
                return 0
            }
            if (!y.compareDocumentPosition || !x.compareDocumentPosition) {
                return y.compareDocumentPosition ? -1 : 1
            }
            return y.compareDocumentPosition(x) & 4 ? -1 : 1
        }
    } else {
        p = function(F, E) {
            if (F === E) {
                h = true;
                return 0
            } else {
                if (F.sourceIndex && E.sourceIndex) {
                    return F.sourceIndex - E.sourceIndex
                }
            }
            var C, y, z = [],
            x = [],
            B = F.parentNode,
            D = E.parentNode,
            G = B;
            if (B === D) {
                return m(F, E)
            } else {
                if (!B) {
                    return - 1
                } else {
                    if (!D) {
                        return 1
                    }
                }
            }
            while (G) {
                z.unshift(G);
                G = G.parentNode
            }
            G = D;
            while (G) {
                x.unshift(G);
                G = G.parentNode
            }
            C = z.length;
            y = x.length;
            for (var A = 0; A < C && A < y; A++) {
                if (z[A] !== x[A]) {
                    return m(z[A], x[A])
                }
            }
            return A === C ? m(F, x[A], -1) : m(z[A], E, 1)
        };
        m = function(y, x, z) {
            if (y === x) {
                return z
            }
            var A = y.nextSibling;
            while (A) {
                if (A === x) {
                    return - 1
                }
                A = A.nextSibling
            }
            return 1
        }
    } (function() {
        var y = document.createElement("div"),
        z = "script" + (new Date()).getTime(),
        x = document.documentElement;
        y.innerHTML = "<a name='" + z + "'/>";
        x.insertBefore(y, x.firstChild);
        if (document.getElementById(z)) {
            k.find.ID = function(B, C, D) {
                if (typeof C.getElementById !== "undefined" && !D) {
                    var A = C.getElementById(B[1]);
                    return A ? A.id === B[1] || typeof A.getAttributeNode !== "undefined" && A.getAttributeNode("id").nodeValue === B[1] ? [A] : undefined: []
                }
            };
            k.filter.ID = function(C, A) {
                var B = typeof C.getAttributeNode !== "undefined" && C.getAttributeNode("id");
                return C.nodeType === 1 && B && B.nodeValue === A
            }
        }
        x.removeChild(y);
        x = y = null
    })(); (function() {
        var x = document.createElement("div");
        x.appendChild(document.createComment(""));
        if (x.getElementsByTagName("*").length > 0) {
            k.find.TAG = function(y, C) {
                var B = C.getElementsByTagName(y[1]);
                if (y[1] === "*") {
                    var A = [];
                    for (var z = 0; B[z]; z++) {
                        if (B[z].nodeType === 1) {
                            A.push(B[z])
                        }
                    }
                    B = A
                }
                return B
            }
        }
        x.innerHTML = "<a href='#'></a>";
        if (x.firstChild && typeof x.firstChild.getAttribute !== "undefined" && x.firstChild.getAttribute("href") !== "#") {
            k.attrHandle.href = function(y) {
                return y.getAttribute("href", 2)
            }
        }
        x = null
    })();
    if (document.querySelectorAll) { (function() {
            var x = d,
            A = document.createElement("div"),
            z = "__sizzle__";
            A.innerHTML = "<p class='TEST'></p>";
            if (A.querySelectorAll && A.querySelectorAll(".TEST").length === 0) {
                return
            }
            d = function(L, C, G, K) {
                C = C || document;
                if (!K && !d.isXML(C)) {
                    var J = /^(\w+$)|^\.([\w\-]+$)|^#([\w\-]+$)/.exec(L);
                    if (J && (C.nodeType === 1 || C.nodeType === 9)) {
                        if (J[1]) {
                            return l(C.getElementsByTagName(L), G)
                        } else {
                            if (J[2] && k.find.CLASS && C.getElementsByClassName) {
                                return l(C.getElementsByClassName(J[2]), G)
                            }
                        }
                    }
                    if (C.nodeType === 9) {
                        if (L === "body" && C.body) {
                            return l([C.body], G)
                        } else {
                            if (J && J[3]) {
                                var F = C.getElementById(J[3]);
                                if (F && F.parentNode) {
                                    if (F.id === J[3]) {
                                        return l([F], G)
                                    }
                                } else {
                                    return l([], G)
                                }
                            }
                        }
                        try {
                            return l(C.querySelectorAll(L), G)
                        } catch(H) {}
                    } else {
                        if (C.nodeType === 1 && C.nodeName.toLowerCase() !== "object") {
                            var D = C,
                            E = C.getAttribute("id"),
                            B = E || z,
                            N = C.parentNode,
                            M = /^\s*[+~]/.test(L);
                            if (!E) {
                                C.setAttribute("id", B)
                            } else {
                                B = B.replace(/'/g, "\\$&")
                            }
                            if (M && N) {
                                C = C.parentNode
                            }
                            try {
                                if (!M || N) {
                                    return l(C.querySelectorAll("[id='" + B + "'] " + L), G)
                                }
                            } catch(I) {} finally {
                                if (!E) {
                                    D.removeAttribute("id")
                                }
                            }
                        }
                    }
                }
                return x(L, C, G, K)
            };
            for (var y in x) {
                d[y] = x[y]
            }
            A = null
        })()
    } (function() {
        var x = document.documentElement,
        z = x.matchesSelector || x.mozMatchesSelector || x.webkitMatchesSelector || x.msMatchesSelector;
        if (z) {
            var B = !z.call(document.createElement("div"), "div"),
            y = false;
            try {
                z.call(document.documentElement, "[test!='']:sizzle")
            } catch(A) {
                y = true
            }
            d.matchesSelector = function(D, F) {
                F = F.replace(/\=\s*([^'"\]]*)\s*\]/g, "='$1']");
                if (!d.isXML(D)) {
                    try {
                        if (y || !k.match.PSEUDO.test(F) && !/!=/.test(F)) {
                            var C = z.call(D, F);
                            if (C || !B || D.document && D.document.nodeType !== 11) {
                                return C
                            }
                        }
                    } catch(E) {}
                }
                return d(F, null, null, [D]).length > 0
            }
        }
    })(); (function() {
        var x = document.createElement("div");
        x.innerHTML = "<div class='test e'></div><div class='test'></div>";
        if (!x.getElementsByClassName || x.getElementsByClassName("e").length === 0) {
            return
        }
        x.lastChild.className = "e";
        if (x.getElementsByClassName("e").length === 1) {
            return
        }
        k.order.splice(1, 0, "CLASS");
        k.find.CLASS = function(y, z, A) {
            if (typeof z.getElementsByClassName !== "undefined" && !A) {
                return z.getElementsByClassName(y[1])
            }
        };
        x = null
    })();
    function a(y, D, C, G, E, F) {
        for (var A = 0,
        z = G.length; A < z; A++) {
            var x = G[A];
            if (x) {
                var B = false;
                x = x[y];
                while (x) {
                    if (x[i] === C) {
                        B = G[x.sizset];
                        break
                    }
                    if (x.nodeType === 1 && !F) {
                        x[i] = C;
                        x.sizset = A
                    }
                    if (x.nodeName.toLowerCase() === D) {
                        B = x;
                        break
                    }
                    x = x[y]
                }
                G[A] = B
            }
        }
    }
    function t(y, D, C, G, E, F) {
        for (var A = 0,
        z = G.length; A < z; A++) {
            var x = G[A];
            if (x) {
                var B = false;
                x = x[y];
                while (x) {
                    if (x[i] === C) {
                        B = G[x.sizset];
                        break
                    }
                    if (x.nodeType === 1) {
                        if (!F) {
                            x[i] = C;
                            x.sizset = A
                        }
                        if (typeof D !== "string") {
                            if (x === D) {
                                B = true;
                                break
                            }
                        } else {
                            if (d.filter(D, [x]).length > 0) {
                                B = x;
                                break
                            }
                        }
                    }
                    x = x[y]
                }
                G[A] = B
            }
        }
    }
    if (document.documentElement.contains) {
        d.contains = function(y, x) {
            return y !== x && (y.contains ? y.contains(x) : true)
        }
    } else {
        if (document.documentElement.compareDocumentPosition) {
            d.contains = function(y, x) {
                return !! (y.compareDocumentPosition(x) & 16)
            }
        } else {
            d.contains = function() {
                return false
            }
        }
    }
    d.isXML = function(x) {
        var y = (x ? x.ownerDocument || x: 0).documentElement;
        return y ? y.nodeName !== "HTML": false
    };
    var s = function(z, x, D) {
        var C, E = [],
        B = "",
        F = x.nodeType ? [x] : x;
        while ((C = k.match.PSEUDO.exec(z))) {
            B += C[0];
            z = z.replace(k.match.PSEUDO, "")
        }
        z = k.relative[z] ? z + "*": z;
        for (var A = 0,
        y = F.length; A < y; A++) {
            d(z, F[A], E, D)
        }
        return d.filter(B, E)
    };
    dayucms.dom.query = d
})(); (function() {
    var a = dayucms.dom.ready = function() {
        var h = false,
        g = [],
        c;
        if (document.addEventListener) {
            c = function() {
                document.removeEventListener("DOMContentLoaded", c, false);
                d()
            }
        } else {
            if (document.attachEvent) {
                c = function() {
                    if (document.readyState === "complete") {
                        document.detachEvent("onreadystatechange", c);
                        d()
                    }
                }
            }
        }
        function d() {
            if (!d.isReady) {
                d.isReady = true;
                for (var l = 0,
                k = g.length; l < k; l++) {
                    g[l]()
                }
            }
        }
        function b() {
            try {
                document.documentElement.doScroll("left")
            } catch(i) {
                setTimeout(b, 1);
                return
            }
            d()
        }
        function f() {
            if (h) {
                return
            }
            h = true;
            if (document.readyState === "complete") {
                d.isReady = true
            } else {
                if (document.addEventListener) {
                    document.addEventListener("DOMContentLoaded", c, false);
                    window.addEventListener("load", d, false)
                } else {
                    if (document.attachEvent) {
                        document.attachEvent("onreadystatechange", c);
                        window.attachEvent("onload", d);
                        var i = false;
                        try {
                            i = window.frameElement == null
                        } catch(j) {}
                        if (document.documentElement.doScroll && i) {
                            b()
                        }
                    }
                }
            }
        }
        f();
        return function(i) {
            d.isReady ? i() : g.push(i)
        }
    } ();
    a.isReady = false
})();
dayucms.dom.remove = function(a) {
    a = dayucms.dom._g(a);
    var b = a.parentNode;
    b && b.removeChild(a)
};
dayucms.dom.removeClass = function(g, h) {
    g = dayucms.dom.g(g);
    var d = g.className.split(/\s+/),
    k = h.split(/\s+/),
    b,
    a = k.length,
    c,
    f = 0;
    for (; f < a; ++f) {
        for (c = 0, b = d.length; c < b; ++c) {
            if (d[c] == k[f]) {
                d.splice(c, 1);
                break
            }
        }
    }
    g.className = d.join(" ");
    return g
};
dayucms.removeClass = dayucms.dom.removeClass;
dayucms.dom.removeStyle = function() {
    var b = document.createElement("DIV"),
    a,
    c = dayucms.dom._g;
    if (b.style.removeProperty) {
        a = function(f, d) {
            f = c(f);
            f.style.removeProperty(d);
            return f
        }
    } else {
        if (b.style.removeAttribute) {
            a = function(f, d) {
                f = c(f);
                f.style.removeAttribute(dayucms.string.toCamelCase(d));
                return f
            }
        }
    }
    b = null;
    return a
} ();
dayucms.object.each = function(f, c) {
    var b, a, d;
    if ("function" == typeof c) {
        for (a in f) {
            if (f.hasOwnProperty(a)) {
                d = f[a];
                b = c.call(f, d, a);
                if (b === false) {
                    break
                }
            }
        }
    }
    return f
};
dayucms.lang.isNumber = function(a) {
    return "[object Number]" == Object.prototype.toString.call(a) && isFinite(a)
};
dayucms.event.getTarget = function(a) {
    return a.target || a.srcElement
};
dayucms.dom.setBorderBoxSize = function(c, b) {
    var a = {};
    b.width && (a.width = parseFloat(b.width));
    b.height && (a.height = parseFloat(b.height));
    function d(g, f) {
        return parseFloat(dayucms.getStyle(g, f)) || 0
    }
    if (dayucms.browser.isStrict) {
        if (b.width) {
            a.width = parseFloat(b.width) - d(c, "paddingLeft") - d(c, "paddingRight") - d(c, "borderLeftWidth") - d(c, "borderRightWidth");
            a.width < 0 && (a.width = 0)
        }
        if (b.height) {
            a.height = parseFloat(b.height) - d(c, "paddingTop") - d(c, "paddingBottom") - d(c, "borderTopWidth") - d(c, "borderBottomWidth");
            a.height < 0 && (a.height = 0)
        }
    }
    return dayucms.dom.setStyles(c, a)
};
dayucms.dom.setOuterHeight = dayucms.dom.setBorderBoxHeight = function(b, a) {
    return dayucms.dom.setBorderBoxSize(b, {
        height: a
    })
};
dayucms.dom.setOuterWidth = dayucms.dom.setBorderBoxWidth = function(a, b) {
    return dayucms.dom.setBorderBoxSize(a, {
        width: b
    })
};
dayucms.dom.resizable = function(d, h) {
    var A, n, j = {},
    c, a = {},
    s, y, v, b, f, l, p, t = false,
    k = false,
    w = {
        direction: ["e", "s", "se"],
        minWidth: 16,
        minHeight: 16,
        classPrefix: "tangram",
        directionHandlePosition: {}
    };
    if (! (A = dayucms.dom.g(d)) && dayucms.getStyle(A, "position") == "static") {
        return false
    }
    b = A.offsetParent;
    var o = dayucms.getStyle(A, "position");
    n = dayucms.extend(w, h);
    dayucms.each(["minHeight", "minWidth", "maxHeight", "maxWidth"],
    function(B) {
        n[B] && (n[B] = parseFloat(n[B]))
    });
    s = [n.minWidth || 0, n.maxWidth || Number.MAX_VALUE, n.minHeight || 0, n.maxHeight || Number.MAX_VALUE];
    z();
    function z() {
        l = dayucms.extend({
            e: {
                right: "-5px",
                top: "0px",
                width: "7px",
                height: A.offsetHeight
            },
            s: {
                left: "0px",
                bottom: "-5px",
                height: "7px",
                width: A.offsetWidth
            },
            n: {
                left: "0px",
                top: "-5px",
                height: "7px",
                width: A.offsetWidth
            },
            w: {
                left: "-5px",
                top: "0px",
                height: A.offsetHeight,
                width: "7px"
            },
            se: {
                right: "1px",
                bottom: "1px",
                height: "16px",
                width: "16px"
            },
            sw: {
                left: "1px",
                bottom: "1px",
                height: "16px",
                width: "16px"
            },
            ne: {
                right: "1px",
                top: "1px",
                height: "16px",
                width: "16px"
            },
            nw: {
                left: "1px",
                top: "1px",
                height: "16px",
                width: "16px"
            }
        },
        n.directionHandlePosition);
        dayucms.each(n.direction,
        function(B) {
            var C = n.classPrefix.split(" ");
            C[0] = C[0] + "-resizable-" + B;
            var E = dayucms.dom.create("div", {
                className: C.join(" ")
            }),
            D = l[B];
            D.cursor = B + "-resize";
            D.position = "absolute";
            dayucms.setStyles(E, D);
            E.key = B;
            E.style.MozUserSelect = "none";
            A.appendChild(E);
            j[B] = E;
            dayucms.on(E, "mousedown", i)
        });
        t = false
    }
    function g() {
        f && u();
        dayucms.object.each(j,
        function(B) {
            dayucms.un(B, "mousedown", i);
            dayucms.dom.remove(B)
        });
        t = true
    }
    function m(B) {
        if (!t) {
            n = dayucms.extend(n, B || {});
            g();
            z()
        }
    }
    function i(D) {
        k && u();
        var C = dayucms.event.getTarget(D),
        B = C.key;
        f = C;
        k = true;
        if (C.setCapture) {
            C.setCapture()
        } else {
            if (window.captureEvents) {
                window.captureEvents(Event.MOUSEMOVE | Event.MOUSEUP)
            }
        }
        v = dayucms.getStyle(document.body, "cursor");
        dayucms.setStyle(document.body, "cursor", B + "-resize");
        dayucms.on(document.body, "mouseup", u);
        dayucms.on(document.body, "selectstart", q);
        y = document.body.style.MozUserSelect;
        document.body.style.MozUserSelect = "none";
        var E = dayucms.page.getMousePosition();
        a = r();
        p = setInterval(function() {
            x(B, E)
        },
        20);
        dayucms.lang.isFunction(n.onresizestart) && n.onresizestart();
        dayucms.event.preventDefault(D)
    }
    function u() {
        if (f && f.releaseCapture) {
            f.releaseCapture()
        } else {
            if (window.releaseEvents) {
                window.releaseEvents(Event.MOUSEMOVE | Event.MOUSEUP)
            }
        }
        dayucms.un(document.body, "mouseup", u);
        dayucms.un(document, "selectstart", q);
        document.body.style.MozUserSelect = y;
        dayucms.un(document.body, "selectstart", q);
        clearInterval(p);
        dayucms.setStyle(document.body, "cursor", v);
        f = null;
        k = false;
        dayucms.lang.isFunction(n.onresizeend) && n.onresizeend()
    }
    function x(C, I) {
        var H = dayucms.page.getMousePosition(),
        D = a.width,
        B = a.height,
        G = a.top,
        F = a.left,
        E;
        if (C.indexOf("e") >= 0) {
            D = Math.max(H.x - I.x + a.width, s[0]);
            D = Math.min(D, s[1])
        } else {
            if (C.indexOf("w") >= 0) {
                D = Math.max(I.x - H.x + a.width, s[0]);
                D = Math.min(D, s[1]);
                F -= D - a.width
            }
        }
        if (C.indexOf("s") >= 0) {
            B = Math.max(H.y - I.y + a.height, s[2]);
            B = Math.min(B, s[3])
        } else {
            if (C.indexOf("n") >= 0) {
                B = Math.max(I.y - H.y + a.height, s[2]);
                B = Math.min(B, s[3]);
                G -= B - a.height
            }
        }
        E = {
            width: D,
            height: B,
            top: G,
            left: F
        };
        dayucms.dom.setOuterHeight(A, B);
        dayucms.dom.setOuterWidth(A, D);
        dayucms.setStyles(A, {
            top: G,
            left: F
        });
        j.n && dayucms.setStyle(j.n, "width", D);
        j.s && dayucms.setStyle(j.s, "width", D);
        j.e && dayucms.setStyle(j.e, "height", B);
        j.w && dayucms.setStyle(j.w, "height", B);
        dayucms.lang.isFunction(n.onresize) && n.onresize({
            current: E,
            original: a
        })
    }
    function q(B) {
        return dayucms.event.preventDefault(B, false)
    }
    function r() {
        var B = dayucms.dom.getPosition(A.offsetParent),
        C = dayucms.dom.getPosition(A),
        E,
        D;
        if (o == "absolute") {
            E = C.top - (A.offsetParent == document.body ? 0 : B.top);
            D = C.left - (A.offsetParent == document.body ? 0 : B.left)
        } else {
            E = parseFloat(dayucms.getStyle(A, "top")) || -parseFloat(dayucms.getStyle(A, "bottom")) || 0;
            D = parseFloat(dayucms.getStyle(A, "left")) || -parseFloat(dayucms.getStyle(A, "right")) || 0
        }
        dayucms.setStyles(A, {
            top: E,
            left: D
        });
        return {
            width: A.offsetWidth,
            height: A.offsetHeight,
            top: E,
            left: D
        }
    }
    return {
        cancel: g,
        update: m,
        enable: z
    }
};
dayucms.dom.setPixel = function(b, a, c) {
    typeof c != "undefined" && (dayucms.dom.g(b).style[a] = c + (!isNaN(c) ? "px": ""))
};
dayucms.dom.setPosition = function(b, a) {
    return dayucms.dom.setStyles(b, {
        left: a.left - (parseFloat(dayucms.dom.getStyle(b, "margin-left")) || 0),
        top: a.top - (parseFloat(dayucms.dom.getStyle(b, "margin-top")) || 0)
    })
};
dayucms.dom.show = function(a) {
    a = dayucms.dom.g(a);
    a.style.display = "";
    return a
};
dayucms.show = dayucms.dom.show;
dayucms.dom.toggle = function(a) {
    a = dayucms.dom.g(a);
    a.style.display = a.style.display == "none" ? "": "none";
    return a
};
dayucms.dom.toggleClass = function(a, b) {
    if (dayucms.dom.hasClass(a, b)) {
        dayucms.dom.removeClass(a, b)
    } else {
        dayucms.dom.addClass(a, b)
    }
};
dayucms.dom._styleFilter[dayucms.dom._styleFilter.length] = {
    get: function(c, d) {
        if (/color/i.test(c) && d.indexOf("rgb(") != -1) {
            var f = d.split(",");
            d = "#";
            for (var b = 0,
            a; a = f[b]; b++) {
                a = parseInt(a.replace(/[^\d]/gi, ""), 10).toString(16);
                d += a.length == 1 ? "0" + a: a
            }
            d = d.toUpperCase()
        }
        return d
    }
};
dayucms.dom._styleFixer.display = dayucms.browser.ie && dayucms.browser.ie < 8 ? {
    set: function(a, b) {
        a = a.style;
        if (b == "inline-block") {
            a.display = "inline";
            a.zoom = 1
        } else {
            a.display = b
        }
    }
}: dayucms.browser.firefox && dayucms.browser.firefox < 3 ? {
    set: function(a, b) {
        a.style.display = b == "inline-block" ? "-moz-inline-box": b
    }
}: null;
dayucms.dom._styleFixer["float"] = dayucms.browser.ie ? "styleFloat": "cssFloat";
dayucms.dom._styleFixer.opacity = dayucms.browser.ie ? {
    get: function(a) {
        var b = a.style.filter;
        return b && b.indexOf("opacity=") >= 0 ? (parseFloat(b.match(/opacity=([^)]*)/)[1]) / 100) + "": "1"
    },
    set: function(a, c) {
        var b = a.style;
        b.filter = (b.filter || "").replace(/alpha\([^\)]*\)/gi, "") + (c == 1 ? "": "alpha(opacity=" + c * 100 + ")");
        b.zoom = 1
    }
}: null;
dayucms.dom._styleFixer.width = dayucms.dom._styleFixer.height = {
    get: function(b, a, c) {
        var a = a.replace(/^[a-z]/,
        function(f) {
            return f.toUpperCase()
        }),
        d = b["client" + a] || b["offset" + a];
        return d > 0 ? d + "px": !c || c == "auto" ? 0 + "px": d
    },
    set: function(b, c, a) {
        b.style[a] = c
    }
};
dayucms.dom._styleFixer.textOverflow = (function() {
    var b = {};
    function a(f) {
        var g = f.length;
        if (g > 0) {
            g = f[g - 1];
            f.length--
        } else {
            g = null
        }
        return g
    }
    function c(f, g) {
        f[dayucms.browser.firefox ? "textContent": "innerText"] = g
    }
    function d(n, j, t) {
        var l = dayucms.browser.ie ? n.currentStyle || n.style: getComputedStyle(n, null),
        s = l.fontWeight,
        r = "font-family:" + l.fontFamily + ";font-size:" + l.fontSize + ";word-spacing:" + l.wordSpacing + ";font-weight:" + ((parseInt(s) || 0) == 401 ? 700 : s) + ";font-style:" + l.fontStyle + ";font-variant:" + l.fontVariant,
        f = b[r];
        if (!f) {
            l = n.appendChild(document.createElement("div"));
            l.style.cssText = "float:left;" + r;
            f = b[r] = [];
            for (var p = 0; p < 256; p++) {
                p == 32 ? (l.innerHTML = "&nbsp;") : c(l, String.fromCharCode(p));
                f[p] = l.offsetWidth
            }
            c(l, "\u4e00");
            f[256] = l.offsetWidth;
            c(l, "\u4e00\u4e00");
            f[257] = l.offsetWidth - f[256] * 2;
            f[258] = f[".".charCodeAt(0)] * 3 + f[257] * 3;
            n.removeChild(l)
        }
        for (var m = n.firstChild,
        q = f[256], h = f[257], g = f[258], v = [], t = t ? g: 0; m; m = m.nextSibling) {
            if (j < t) {
                n.removeChild(m)
            } else {
                if (m.nodeType == 3) {
                    for (var p = 0,
                    u = m.nodeValue,
                    k = u.length; p < k; p++) {
                        l = u.charCodeAt(p);
                        v[v.length] = [j, m, p];
                        j -= (p ? h: 0) + (l < 256 ? f[l] : q);
                        if (j < t) {
                            break
                        }
                    }
                } else {
                    l = m.tagName;
                    if (l == "IMG" || l == "TABLE") {
                        l = m;
                        m = m.previousSibling;
                        n.removeChild(l)
                    } else {
                        v[v.length] = [j, m];
                        j -= m.offsetWidth
                    }
                }
            }
        }
        if (j < t) {
            while (l = a(v)) {
                j = l[0];
                m = l[1];
                l = l[2];
                if (m.nodeType == 3) {
                    if (j >= g) {
                        m.nodeValue = m.nodeValue.substring(0, l) + "...";
                        return true
                    } else {
                        if (!l) {
                            n.removeChild(m)
                        }
                    }
                } else {
                    if (d(m, j, true)) {
                        return true
                    } else {
                        n.removeChild(m)
                    }
                }
            }
            n.innerHTML = ""
        }
    }
    return {
        get: function(h) {
            var g = dayucms.browser,
            f = dom.getStyle;
            return (g.opera ? f("OTextOverflow") : g.firefox ? h._dayucmsOverflow: f("textOverflow")) || "clip"
        },
        set: function(g, i) {
            var f = dayucms.browser;
            if (g.tagName == "TD" || g.tagName == "TH" || f.firefox) {
                g._dayucmsHTML && (g.innerHTML = g._dayucmsHTML);
                if (i == "ellipsis") {
                    g._dayucmsHTML = g.innerHTML;
                    var j = document.createElement("div"),
                    h = g.appendChild(j).offsetWidth;
                    g.removeChild(j);
                    d(g, h)
                } else {
                    g._dayucmsHTML = ""
                }
            }
            j = g.style;
            f.opera ? (j.OTextOverflow = i) : f.firefox ? (g._dayucmsOverflow = i) : (j.textOverflow = i)
        }
    }
})();
dayucms.lang.isArray = function(a) {
    return "[object Array]" == Object.prototype.toString.call(a)
};
dayucms.lang.toArray = function(b) {
    if (b === null || b === undefined) {
        return []
    }
    if (dayucms.lang.isArray(b)) {
        return b
    }
    if (typeof b.length !== "number" || typeof b === "string" || dayucms.lang.isFunction(b)) {
        return [b]
    }
    if (b.item) {
        var a = b.length,
        c = new Array(a);
        while (a--) {
            c[a] = b[a]
        }
        return c
    }
    return [].slice.call(b)
};
dayucms.fn.methodize = function(b, a) {
    return function() {
        return b.apply(this, [(a ? this[a] : this)].concat([].slice.call(arguments)))
    }
};
dayucms.fn.wrapReturnValue = function(a, c, b) {
    b = b | 0;
    return function() {
        var d = a.apply(this, arguments);
        if (!b) {
            return new c(d)
        }
        if (b > 0) {
            return new c(arguments[b - 1])
        }
        return d
    }
};
dayucms.fn.multize = function(d, b, a) {
    var c = function() {
        var m = arguments[0],
        j = b ? c: d,
        g = [],
        l = [].slice.call(arguments, 0),
        h = 0,
        f,
        k;
        if (m instanceof Array) {
            for (f = m.length; h < f; h++) {
                l[0] = m[h];
                k = j.apply(this, l);
                if (a) {
                    if (k) {
                        g = g.concat(k)
                    }
                } else {
                    g.push(k)
                }
            }
            return g
        } else {
            return d.apply(this, arguments)
        }
    };
    return c
};
dayucms.element = function(b) {
    var a = dayucms._g(b);
    if (!a && dayucms.dom.query) {
        a = dayucms.dom.query(b)
    }
    return new dayucms.element.Element(a)
};
dayucms.e = dayucms.element;
dayucms.element.Element = function(a) {
    if (!dayucms.element._init) {
        dayucms.element._makeChain();
        dayucms.element._init = true
    }
    this._dom = (a.tagName || "").toLowerCase() == "select" ? [a] : dayucms.lang.toArray(a)
};
dayucms.element.Element.prototype.each = function(a) {
    dayucms.array.each(this._dom,
    function(c, b) {
        a.call(c, c, b)
    })
};
dayucms.element._toChainFunction = function(c, b, a) {
    return dayucms.fn.methodize(dayucms.fn.wrapReturnValue(dayucms.fn.multize(c, 0, 1), dayucms.element.Element, b), "_dom")
};
dayucms.element._makeChain = function() {
    var b = dayucms.element.Element.prototype,
    c = dayucms.element._toChainFunction;
    dayucms.each(("draggable droppable resizable fixable").split(" "),
    function(d) {
        b[d] = c(dayucms.dom[d], 1)
    });
    dayucms.each(("remove getText contains getAttr getPosition getStyle hasClass intersect hasAttr getComputedStyle").split(" "),
    function(d) {
        b[d] = b[d.replace(/^get[A-Z]/g, a)] = c(dayucms.dom[d], -1)
    });
    dayucms.each(("addClass empty hide show insertAfter insertBefore insertHTML removeClass setAttr setAttrs setStyle setStyles show toggleClass toggle next first getAncestorByClass getAncestorBy getAncestorByTag getDocument getParent getWindow last next prev g removeStyle setBorderBoxSize setOuterWidth setOuterHeight setBorderBoxWidth setBorderBoxHeight setPosition children query").split(" "),
    function(d) {
        b[d] = b[d.replace(/^get[A-Z]/g, a)] = c(dayucms.dom[d], 0)
    });
    b.q = b.Q = c(function(f, d) {
        return dayucms.dom.q.apply(this, [d, f].concat([].slice.call(arguments, 2)))
    },
    0);
    dayucms.each(("on un").split(" "),
    function(d) {
        b[d] = c(dayucms.event[d], 0)
    });
    dayucms.each(("blur focus focusin focusout load resize scroll unload click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup error").split(" "),
    function(d) {
        b[d] = function(f) {
            return this.on(d, f)
        }
    });
    function a(d) {
        return d.charAt(3).toLowerCase()
    }
};
dayucms.element.extend = function(a) {
    var b = dayucms.element;
    dayucms.object.each(a,
    function(d, c) {
        b.Element.prototype[c] = dayucms.element._toChainFunction(d, -1)
    })
};
dayucms.event.EventArg = function(c, f) {
    f = f || window;
    c = c || f.event;
    var d = f.document;
    this.target = (c.target) || c.srcElement;
    this.keyCode = c.which || c.keyCode;
    for (var a in c) {
        var b = c[a];
        if ("function" != typeof b) {
            this[a] = b
        }
    }
    if (!this.pageX && this.pageX !== 0) {
        this.pageX = (c.clientX || 0) + (d.documentElement.scrollLeft || d.body.scrollLeft);
        this.pageY = (c.clientY || 0) + (d.documentElement.scrollTop || d.body.scrollTop)
    }
    this._event = c
};
dayucms.event.EventArg.prototype.preventDefault = function() {
    if (this._event.preventDefault) {
        this._event.preventDefault()
    } else {
        this._event.returnValue = false
    }
    return this
};
dayucms.event.EventArg.prototype.stopPropagation = function() {
    if (this._event.stopPropagation) {
        this._event.stopPropagation()
    } else {
        this._event.cancelBubble = true
    }
    return this
};
dayucms.event.EventArg.prototype.stop = function() {
    return this.stopPropagation().preventDefault()
};
dayucms.object.values = function(d) {
    var a = [],
    c = 0,
    b;
    for (b in d) {
        if (d.hasOwnProperty(b)) {
            a[c++] = d[b]
        }
    }
    return a
}; (function() {
    var d = dayucms.browser,
    l = {
        keydown: 1,
        keyup: 1,
        keypress: 1
    },
    a = {
        click: 1,
        dblclick: 1,
        mousedown: 1,
        mousemove: 1,
        mouseup: 1,
        mouseover: 1,
        mouseout: 1
    },
    i = {
        abort: 1,
        blur: 1,
        change: 1,
        error: 1,
        focus: 1,
        load: d.ie ? 0 : 1,
        reset: 1,
        resize: 1,
        scroll: 1,
        select: 1,
        submit: 1,
        unload: d.ie ? 0 : 1
    },
    g = {
        scroll: 1,
        resize: 1,
        reset: 1,
        submit: 1,
        change: 1,
        select: 1,
        error: 1,
        abort: 1
    },
    k = {
        KeyEvents: ["bubbles", "cancelable", "view", "ctrlKey", "altKey", "shiftKey", "metaKey", "keyCode", "charCode"],
        MouseEvents: ["bubbles", "cancelable", "view", "detail", "screenX", "screenY", "clientX", "clientY", "ctrlKey", "altKey", "shiftKey", "metaKey", "button", "relatedTarget"],
        HTMLEvents: ["bubbles", "cancelable"],
        UIEvents: ["bubbles", "cancelable", "view", "detail"],
        Events: ["bubbles", "cancelable"]
    };
    dayucms.object.extend(g, l);
    dayucms.object.extend(g, a);
    function c(r, p) {
        var o = 0,
        n = r.length,
        q = {};
        for (; o < n; o++) {
            q[r[o]] = p[r[o]];
            delete p[r[o]]
        }
        return q
    }
    function f(p, o, n) {
        n = dayucms.object.extend({},
        n);
        var q = dayucms.object.values(c(k[o], n)),
        r = document.createEvent(o);
        q.unshift(p);
        if ("KeyEvents" == o) {
            r.initKeyEvent.apply(r, q)
        } else {
            if ("MouseEvents" == o) {
                r.initMouseEvent.apply(r, q)
            } else {
                if ("UIEvents" == o) {
                    r.initUIEvent.apply(r, q)
                } else {
                    r.initEvent.apply(r, q)
                }
            }
        }
        dayucms.object.extend(r, n);
        return r
    }
    function b(n) {
        var o;
        if (document.createEventObject) {
            o = document.createEventObject();
            dayucms.object.extend(o, n)
        }
        return o
    }
    function h(q, n) {
        n = c(k.KeyEvents, n);
        var r;
        if (document.createEvent) {
            try {
                r = f(q, "KeyEvents", n)
            } catch(p) {
                try {
                    r = f(q, "Events", n)
                } catch(o) {
                    r = f(q, "UIEvents", n)
                }
            }
        } else {
            n.keyCode = n.charCode > 0 ? n.charCode: n.keyCode;
            r = b(n)
        }
        return r
    }
    function m(o, n) {
        n = c(k.MouseEvents, n);
        var p;
        if (document.createEvent) {
            p = f(o, "MouseEvents", n);
            if (n.relatedTarget && !p.relatedTarget) {
                if ("mouseout" == o.toLowerCase()) {
                    p.toElement = n.relatedTarget
                } else {
                    if ("mouseover" == o.toLowerCase()) {
                        p.fromElement = n.relatedTarget
                    }
                }
            }
        } else {
            n.button = n.button == 0 ? 1 : n.button == 1 ? 4 : dayucms.lang.isNumber(n.button) ? n.button: 0;
            p = b(n)
        }
        return p
    }
    function j(p, n) {
        n.bubbles = g.hasOwnProperty(p);
        n = c(k.HTMLEvents, n);
        var r;
        if (document.createEvent) {
            try {
                r = f(p, "HTMLEvents", n)
            } catch(q) {
                try {
                    r = f(p, "UIEvents", n)
                } catch(o) {
                    r = f(p, "Events", n)
                }
            }
        } else {
            r = b(n)
        }
        return r
    }
    dayucms.event.fire = function(o, p, n) {
        var q;
        p = p.replace(/^on/i, "");
        o = dayucms.dom._g(o);
        n = dayucms.object.extend({
            bubbles: true,
            cancelable: true,
            view: window,
            detail: 1,
            screenX: 0,
            screenY: 0,
            clientX: 0,
            clientY: 0,
            ctrlKey: false,
            altKey: false,
            shiftKey: false,
            metaKey: false,
            keyCode: 0,
            charCode: 0,
            button: 0,
            relatedTarget: null
        },
        n);
        if (l[p]) {
            q = h(p, n)
        } else {
            if (a[p]) {
                q = m(p, n)
            } else {
                if (i[p]) {
                    q = j(p, n)
                } else {
                    throw (new Error(p + " is not support!"))
                }
            }
        }
        if (q) {
            if (o.dispatchEvent) {
                o.dispatchEvent(q)
            } else {
                if (o.fireEvent) {
                    o.fireEvent("on" + p, q)
                }
            }
        }
    }
})();
dayucms.event.get = function(a, b) {
    return new dayucms.event.EventArg(a, b)
};
dayucms.event.getEvent = function(a) {
    if (window.event) {
        return window.event
    } else {
        var b = arguments.callee;
        do {
            if (/Event/.test(b.arguments[0])) {
                return b.arguments[0]
            }
        } while ( b = b . caller );
        return null
    }
};
dayucms.event.getKeyCode = function(a) {
    return a.which || a.keyCode
};
dayucms.event.getPageX = function(b) {
    var a = b.pageX,
    c = document;
    if (!a && a !== 0) {
        a = (b.clientX || 0) + (c.documentElement.scrollLeft || c.body.scrollLeft)
    }
    return a
};
dayucms.event.getPageY = function(b) {
    var a = b.pageY,
    c = document;
    if (!a && a !== 0) {
        a = (b.clientY || 0) + (c.documentElement.scrollTop || c.body.scrollTop)
    }
    return a
};
dayucms.event.once = function(a, b, c) {
    a = dayucms.dom._g(a);
    function d(f) {
        c.call(a, f);
        dayucms.event.un(a, b, d)
    }
    dayucms.event.on(a, b, d);
    return a
};
dayucms.event.stopPropagation = function(a) {
    if (a.stopPropagation) {
        a.stopPropagation()
    } else {
        a.cancelBubble = true
    }
};
dayucms.event.stop = function(a) {
    var b = dayucms.event;
    b.stopPropagation(a);
    b.preventDefault(a)
};
dayucms.event._eventFilter = dayucms.event._eventFilter || {};
dayucms.event._eventFilter._crossElementBoundary = function(a, d) {
    var c = d.relatedTarget,
    b = d.currentTarget;
    if (c === false || b == c || (c && (c.prefix == "xul" || dayucms.dom.contains(b, c)))) {
        return
    }
    return a.call(b, d)
};
dayucms.fn.bind = function(b, a) {
    var c = arguments.length > 2 ? [].slice.call(arguments, 2) : null;
    return function() {
        var f = dayucms.lang.isString(b) ? a[b] : b,
        d = (c) ? c.concat([].slice.call(arguments, 0)) : arguments;
        return f.apply(a || f, d)
    }
};
dayucms.event._eventFilter.mouseenter = window.attachEvent ? null: function(a, b, c) {
    return {
        type: "mouseover",
        listener: dayucms.fn.bind(dayucms.event._eventFilter._crossElementBoundary, this, c)
    }
};
dayucms.event._eventFilter.mouseleave = window.attachEvent ? null: function(a, b, c) {
    return {
        type: "mouseout",
        listener: dayucms.fn.bind(dayucms.event._eventFilter._crossElementBoundary, this, c)
    }
};
dayucms.event._unload = function() {
    var c = dayucms.event._listeners,
    a = c.length,
    b = !!window.removeEventListener,
    f, d;
    while (a--) {
        f = c[a];
        if (f[1] == "unload") {
            continue
        }
        if (! (d = f[0])) {
            continue
        }
        if (d.removeEventListener) {
            d.removeEventListener(f[1], f[3], false)
        } else {
            if (d.detachEvent) {
                d.detachEvent("on" + f[1], f[3])
            }
        }
    }
    if (b) {
        window.removeEventListener("unload", dayucms.event._unload, false)
    } else {
        window.detachEvent("onunload", dayucms.event._unload)
    }
};
if (window.attachEvent) {
    window.attachEvent("onunload", dayucms.event._unload)
} else {
    window.addEventListener("unload", dayucms.event._unload, false)
}
dayucms.fn.abstractMethod = function() {
    throw Error("unimplemented abstract method")
};
dayucms.form = dayucms.form || {};
dayucms.form.json = function(c, f) {
    var b = c.elements,
    f = f ||
    function(r, i) {
        return r
    },
    j = {},
    p,
    l,
    q,
    d,
    a,
    o,
    n,
    m;
    function g(i, r) {
        var s = j[i];
        if (s) {
            s.push || (j[i] = [s]);
            j[i].push(r)
        } else {
            j[i] = r
        }
    }
    for (var h = 0,
    k = b.length; h < k; h++) {
        p = b[h];
        q = p.name;
        if (!p.disabled && q) {
            l = p.type;
            d = dayucms.url.escapeSymbol(p.value);
            switch (l) {
            case "radio":
            case "checkbox":
                if (!p.checked) {
                    break
                }
            case "textarea":
            case "text":
            case "password":
            case "hidden":
            case "file":
            case "select-one":
                g(q, f(d, q));
                break;
            case "select-multiple":
                a = p.options;
                n = a.length;
                for (o = 0; o < n; o++) {
                    m = a[o];
                    if (m.selected) {
                        g(q, f(m.value, q))
                    }
                }
                break
            }
        }
    }
    return j
};
dayucms.form.serialize = function(c, f) {
    var b = c.elements,
    f = f ||
    function(r, i) {
        return r
    },
    j = [],
    p,
    l,
    q,
    d,
    a,
    o,
    n,
    m;
    function g(i, r) {
        j.push(i + "=" + r)
    }
    for (var h = 0,
    k = b.length; h < k; h++) {
        p = b[h];
        q = p.name;
        if (!p.disabled && q) {
            l = p.type;
            d = dayucms.url.escapeSymbol(p.value);
            switch (l) {
            case "radio":
            case "checkbox":
                if (!p.checked) {
                    break
                }
            case "textarea":
            case "text":
            case "password":
            case "hidden":
            case "file":
            case "select-one":
                g(q, f(d, q));
                break;
            case "select-multiple":
                a = p.options;
                n = a.length;
                for (o = 0; o < n; o++) {
                    m = a[o];
                    if (m.selected) {
                        g(q, f(m.value, q))
                    }
                }
                break
            }
        }
    }
    return j
};
dayucms.global = dayucms.global || {};
window[dayucms.guid].global = window[dayucms.guid].global || {}; (function() {
    var a = window[dayucms.guid].global;
    dayucms.global.get = function(b) {
        return a[b]
    }
})(); (function() {
    var a = window[dayucms.guid].global;
    dayucms.global.set = function(f, g, d) {
        var c = !d || (d && typeof a[f] == "undefined");
        c && (a[f] = g);
        return a[f]
    }
})();
dayucms.global.getZIndex = function(a, c) {
    var b = dayucms.global.get("zIndex");
    if (a) {
        b[a] = b[a] + (c || 1)
    }
    return b[a]
};
dayucms.global.set("zIndex", {
    popup: 50000,
    dialog: 1000
},
true);
dayucms.json = dayucms.json || {};
dayucms.json.parse = function(a) {
    return (new Function("return (" + a + ")"))()
};
dayucms.json.decode = dayucms.json.parse;
dayucms.json.stringify = (function() {
    var b = {
        "\b": "\\b",
        "\t": "\\t",
        "\n": "\\n",
        "\f": "\\f",
        "\r": "\\r",
        '"': '\\"',
        "\\": "\\\\"
    };
    function a(g) {
        if (/["\\\x00-\x1f]/.test(g)) {
            g = g.replace(/["\\\x00-\x1f]/g,
            function(h) {
                var i = b[h];
                if (i) {
                    return i
                }
                i = h.charCodeAt();
                return "\\u00" + Math.floor(i / 16).toString(16) + (i % 16).toString(16)
            })
        }
        return '"' + g + '"'
    }
    function d(n) {
        var h = ["["],
        j = n.length,
        g,
        k,
        m;
        for (k = 0; k < j; k++) {
            m = n[k];
            switch (typeof m) {
            case "undefined":
            case "function":
            case "unknown":
                break;
            default:
                if (g) {
                    h.push(",")
                }
                h.push(dayucms.json.stringify(m));
                g = 1
            }
        }
        h.push("]");
        return h.join("")
    }
    function c(g) {
        return g < 10 ? "0" + g: g
    }
    function f(g) {
        return '"' + g.getFullYear() + "-" + c(g.getMonth() + 1) + "-" + c(g.getDate()) + "T" + c(g.getHours()) + ":" + c(g.getMinutes()) + ":" + c(g.getSeconds()) + '"'
    }
    return function(l) {
        switch (typeof l) {
        case "undefined":
            return "undefined";
        case "number":
            return isFinite(l) ? String(l) : "null";
        case "string":
            return a(l);
        case "boolean":
            return String(l);
        default:
            if (l === null) {
                return "null"
            } else {
                if (l instanceof Array) {
                    return d(l)
                } else {
                    if (l instanceof Date) {
                        return f(l)
                    } else {
                        var h = ["{"],
                        k = dayucms.json.stringify,
                        g,
                        j;
                        for (var i in l) {
                            if (Object.prototype.hasOwnProperty.call(l, i)) {
                                j = l[i];
                                switch (typeof j) {
                                case "undefined":
                                case "unknown":
                                case "function":
                                    break;
                                default:
                                    if (g) {
                                        h.push(",")
                                    }
                                    g = 1;
                                    h.push(k(i) + ":" + k(j))
                                }
                            }
                        }
                        h.push("}");
                        return h.join("")
                    }
                }
            }
        }
    }
})();
dayucms.json.encode = dayucms.json.stringify;
dayucms.lang.Class.prototype.addEventListeners = function(c, d) {
    if (typeof d == "undefined") {
        for (var b in c) {
            this.addEventListener(b, c[b])
        }
    } else {
        c = c.split(",");
        var b = 0,
        a = c.length,
        f;
        for (; b < a; b++) {
            this.addEventListener(dayucms.trim(c[b]), d)
        }
    }
};
dayucms.lang.createClass = function(b, k) {
    k = k || {};
    var h = k.superClass || dayucms.lang.Class;
    var j = function() {
        var n = this;
        k.decontrolled && (n.__decontrolled = true);
        h.apply(n, arguments);
        for (l in j.options) {
            n[l] = j.options[l]
        }
        b.apply(n, arguments);
        for (var l = 0,
        m = j["\x06r"]; m && l < m.length; l++) {
            m[l].apply(n, arguments)
        }
    };
    j.options = k.options || {};
    var a = function() {},
    g = b.prototype;
    a.prototype = h.prototype;
    var d = j.prototype = new a();
    for (var c in g) {
        d[c] = g[c]
    }
    var f = k.className || k.type;
    typeof f == "string" && (d.__type = f);
    d.constructor = g.constructor;
    j.extend = function(m) {
        for (var l in m) {
            j.prototype[l] = m[l]
        }
        return j
    };
    return j
};
window[dayucms.guid]._instances = window[dayucms.guid]._instances || {};
dayucms.lang.decontrol = function(b) {
    var a = window[dayucms.guid];
    a._instances && (delete a._instances[b])
};
dayucms.lang.eventCenter = dayucms.lang.eventCenter || dayucms.lang.createSingle();
dayucms.lang.getModule = function(b, c) {
    var d = b.split("."),
    f = c || window,
    a;
    for (; a = d.shift();) {
        if (f[a] != null) {
            f = f[a]
        } else {
            return null
        }
    }
    return f
};
dayucms.lang.inherits = function(h, f, d) {
    var c, g, a = h.prototype,
    b = new Function();
    b.prototype = f.prototype;
    g = h.prototype = new b();
    for (c in a) {
        g[c] = a[c]
    }
    h.prototype.constructor = h;
    h.superClass = f.prototype;
    typeof d == "string" && (g.__type = d);
    h.extend = function(k) {
        for (var j in k) {
            g[j] = k[j]
        }
        return h
    };
    return h
};
dayucms.inherits = dayucms.lang.inherits;
dayucms.lang.instance = function(a) {
    return window[dayucms.guid]._instances[a] || null
};
dayucms.lang.isBoolean = function(a) {
    return typeof a === "boolean"
};
dayucms.lang.isDate = function(a) {
    return {}.toString.call(a) === "[object Date]" && a.toString() !== "Invalid Date" && !isNaN(a)
};
dayucms.lang.isElement = function(a) {
    return !! (a && a.nodeName && a.nodeType == 1)
};
dayucms.lang.module = function(name, module, owner) {
    var packages = name.split("."),
    len = packages.length - 1,
    packageName,
    i = 0;
    if (!owner) {
        try {
            if (! (new RegExp("^[a-zA-Z_\x24][a-zA-Z0-9_\x24]*\x24")).test(packages[0])) {
                throw ""
            }
            owner = eval(packages[0]);
            i = 1
        } catch(e) {
            owner = window
        }
    }
    for (; i < len; i++) {
        packageName = packages[i];
        if (!owner[packageName]) {
            owner[packageName] = {}
        }
        owner = owner[packageName]
    }
    if (!owner[packages[len]]) {
        owner[packages[len]] = module
    }
};
dayucms.lang.register = function(b, d, a) {
    var c = b["\x06r"] || (b["\x06r"] = []);
    c[c.length] = d;
    for (var f in a) {
        b.prototype[f] = a[f]
    }
};
dayucms.number.comma = function(b, a) {
    if (!a || a < 1) {
        a = 3
    }
    b = String(b).split(".");
    b[0] = b[0].replace(new RegExp("(\\d)(?=(\\d{" + a + "})+$)", "ig"), "$1,");
    return b.join(".")
};
dayucms.number.randomInt = function(b, a) {
    return Math.floor(Math.random() * (a - b + 1) + b)
};
dayucms.object.isPlain = function(c) {
    var b = Object.prototype.hasOwnProperty,
    a;
    if (!c || Object.prototype.toString.call(c) !== "[object Object]" || !("isPrototypeOf" in c)) {
        return false
    }
    if (c.constructor && !b.call(c, "constructor") && !b.call(c.constructor.prototype, "isPrototypeOf")) {
        return false
    }
    for (a in c) {}
    return a === undefined || b.call(c, a)
};
dayucms.object.clone = function(f) {
    var b = f,
    c, a;
    if (!f || f instanceof Number || f instanceof String || f instanceof Boolean) {
        return b
    } else {
        if (dayucms.lang.isArray(f)) {
            b = [];
            var d = 0;
            for (c = 0, a = f.length; c < a; c++) {
                b[d++] = dayucms.object.clone(f[c])
            }
        } else {
            if (dayucms.object.isPlain(f)) {
                b = {};
                for (c in f) {
                    if (f.hasOwnProperty(c)) {
                        b[c] = dayucms.object.clone(f[c])
                    }
                }
            }
        }
    }
    return b
};
dayucms.object.isEmpty = function(b) {
    for (var a in b) {
        return false
    }
    return true
};
dayucms.object.keys = function(d) {
    var a = [],
    c = 0,
    b;
    for (b in d) {
        if (d.hasOwnProperty(b)) {
            a[c++] = b
        }
    }
    return a
};
dayucms.object.map = function(d, c) {
    var b = {};
    for (var a in d) {
        if (d.hasOwnProperty(a)) {
            b[a] = c(d[a], a)
        }
    }
    return b
}; (function() {
    var b = function(c) {
        return dayucms.lang.isObject(c) && !dayucms.lang.isFunction(c)
    };
    function a(h, g, f, d, c) {
        if (g.hasOwnProperty(f)) {
            if (c && b(h[f])) {
                dayucms.object.merge(h[f], g[f], {
                    overwrite: d,
                    recursive: c
                })
            } else {
                if (d || !(f in h)) {
                    h[f] = g[f]
                }
            }
        }
    }
    dayucms.object.merge = function(j, c, l) {
        var f = 0,
        m = l || {},
        h = m.overwrite,
        k = m.whiteList,
        d = m.recursive,
        g;
        if (k && k.length) {
            g = k.length;
            for (; f < g; ++f) {
                a(j, c, k[f], h, d)
            }
        } else {
            for (f in c) {
                a(j, c, f, h, d)
            }
        }
        return j
    }
})();
dayucms.page.createStyleSheet = function(a) {
    var g = a || {},
    d = g.document || document,
    c;
    if (dayucms.browser.ie) {
        if (!g.url) {
            g.url = ""
        }
        return d.createStyleSheet(g.url, g.index)
    } else {
        c = "<style type='text/css'></style>";
        g.url && (c = "<link type='text/css' rel='stylesheet' href='" + g.url + "'/>");
        dayucms.dom.insertHTML(d.getElementsByTagName("HEAD")[0], "beforeEnd", c);
        if (g.url) {
            return null
        }
        var b = d.styleSheets[d.styleSheets.length - 1],
        f = b.rules || b.cssRules;
        return {
            self: b,
            rules: b.rules || b.cssRules,
            addRule: function(h, k, j) {
                if (b.addRule) {
                    return b.addRule(h, k, j)
                } else {
                    if (b.insertRule) {
                        isNaN(j) && (j = f.length);
                        return b.insertRule(h + "{" + k + "}", j)
                    }
                }
            },
            removeRule: function(h) {
                if (b.removeRule) {
                    b.removeRule(h)
                } else {
                    if (b.deleteRule) {
                        isNaN(h) && (h = 0);
                        b.deleteRule(h)
                    }
                }
            }
        }
    }
};
dayucms.page.getHeight = function() {
    var d = document,
    a = d.body,
    c = d.documentElement,
    b = d.compatMode == "BackCompat" ? a: d.documentElement;
    return Math.max(c.scrollHeight, a.scrollHeight, b.clientHeight)
};
dayucms.page.getWidth = function() {
    var d = document,
    a = d.body,
    c = d.documentElement,
    b = d.compatMode == "BackCompat" ? a: d.documentElement;
    return Math.max(c.scrollWidth, a.scrollWidth, b.clientWidth)
};
dayucms.page.lazyLoadImage = function(a) {
    a = a || {};
    a.preloadHeight = a.preloadHeight || 0;
    dayucms.dom.ready(function() {
        var f = document.getElementsByTagName("IMG"),
        g = f,
        h = f.length,
        d = 0,
        l = c(),
        k = "data-tangram-ori-src",
        j;
        if (a.className) {
            g = [];
            for (; d < h; ++d) {
                if (dayucms.dom.hasClass(f[d], a.className)) {
                    g.push(f[d])
                }
            }
        }
        function c() {
            return dayucms.page.getScrollTop() + dayucms.page.getViewHeight() + a.preloadHeight
        }
        for (d = 0, h = g.length; d < h; ++d) {
            j = g[d];
            if (dayucms.dom.getPosition(j).top > l) {
                j.setAttribute(k, j.src);
                a.placeHolder ? j.src = a.placeHolder: j.removeAttribute("src")
            }
        }
        var b = function() {
            var n = c(),
            p,
            q = true,
            o = 0,
            m = g.length;
            for (; o < m; ++o) {
                j = g[o];
                p = j.getAttribute(k);
                p && (q = false);
                if (dayucms.dom.getPosition(j).top < n && p) {
                    j.src = p;
                    j.removeAttribute(k);
                    dayucms.lang.isFunction(a.onlazyload) && a.onlazyload(j)
                }
            }
            q && dayucms.un(window, "scroll", b)
        };
        dayucms.on(window, "scroll", b)
    })
};
dayucms.page.load = function(c, k, f) {
    k = k || {};
    var i = dayucms.page.load,
    a = i._cache = i._cache || {},
    h = i._loadingCache = i._loadingCache || {},
    g = k.parallel;
    function d() {
        for (var m = 0,
        l = c.length; m < l; ++m) {
            if (!a[c[m].url]) {
                setTimeout(arguments.callee, 10);
                return
            }
        }
        k.onload()
    }
    function b(n, p) {
        var o, m, l;
        switch (n.type.toLowerCase()) {
        case "css":
            o = document.createElement("link");
            o.setAttribute("rel", "stylesheet");
            o.setAttribute("type", "text/css");
            break;
        case "js":
            o = document.createElement("script");
            o.setAttribute("type", "text/javascript");
            o.setAttribute("charset", n.charset || i.charset);
            break;
        case "html":
            o = document.createElement("iframe");
            o.frameBorder = "none";
            break;
        default:
            return
        }
        l = function() {
            if (!m && (!this.readyState || this.readyState === "loaded" || this.readyState === "complete")) {
                m = true;
                dayucms.un(o, "load", l);
                dayucms.un(o, "readystatechange", l);
                p.call(window, o)
            }
        };
        dayucms.on(o, "load", l);
        dayucms.on(o, "readystatechange", l);
        if (n.type == "css") { (function() {
                if (m) {
                    return
                }
                try {
                    o.sheet.cssRule
                } catch(q) {
                    setTimeout(arguments.callee, 20);
                    return
                }
                m = true;
                p.call(window, o)
            })()
        }
        o.href = o.src = n.url;
        document.getElementsByTagName("head")[0].appendChild(o)
    }
    dayucms.lang.isString(c) && (c = [{
        url: c
    }]);
    if (! (c && c.length)) {
        return
    }
    function j(n) {
        var m = n.url,
        o = !!g,
        l, p = function(q) {
            a[n.url] = q;
            delete h[n.url];
            if (dayucms.lang.isFunction(n.onload)) {
                if (false === n.onload.call(window, q)) {
                    return
                }
            } ! g && i(c.slice(1), k, true);
            if ((!f) && dayucms.lang.isFunction(k.onload)) {
                d()
            }
        };
        n.type = n.type || m.replace(/^[^\?#]+\.(css|js|html)(\?|#| |$)[^\?#]*/i, "$1");
        n.requestType = n.requestType || (n.type == "html" ? "ajax": "dom");
        if (l = a[n.url]) {
            p(l);
            return o
        }
        if (!k.refresh && h[n.url]) {
            setTimeout(function() {
                j(n)
            },
            10);
            return o
        }
        h[n.url] = true;
        if (n.requestType.toLowerCase() == "dom") {
            b(n, p)
        } else {
            dayucms.ajax.get(n.url,
            function(r, q) {
                p(q)
            })
        }
        return o
    }
    dayucms.each(c, j)
};
dayucms.page.load.charset = "UTF8";
dayucms.page.loadCssFile = function(b) {
    var a = document.createElement("link");
    a.setAttribute("rel", "stylesheet");
    a.setAttribute("type", "text/css");
    a.setAttribute("href", b);
    document.getElementsByTagName("head")[0].appendChild(a)
};
dayucms.page.loadJsFile = function(b) {
    var a = document.createElement("script");
    a.setAttribute("type", "text/javascript");
    a.setAttribute("src", b);
    a.setAttribute("defer", "defer");
    document.getElementsByTagName("head")[0].appendChild(a)
};
dayucms.platform = dayucms.platform || {};
dayucms.platform.isAndroid = /android/i.test(navigator.userAgent);
dayucms.platform.isIpad = /ipad/i.test(navigator.userAgent);
dayucms.platform.isIphone = /iphone/i.test(navigator.userAgent);
dayucms.platform.isMacintosh = /macintosh/i.test(navigator.userAgent);
dayucms.platform.isWindows = /windows/i.test(navigator.userAgent);
dayucms.platform.isX11 = /x11/i.test(navigator.userAgent);
dayucms.sio = dayucms.sio || {};
dayucms.sio._createScriptTag = function(b, a, c) {
    b.setAttribute("type", "text/javascript");
    c && b.setAttribute("charset", c);
    b.setAttribute("src", a);
    document.getElementsByTagName("head")[0].appendChild(b)
};
dayucms.sio._removeScriptTag = function(b) {
    if (b.clearAttributes) {
        b.clearAttributes()
    } else {
        for (var a in b) {
            if (b.hasOwnProperty(a)) {
                delete b[a]
            }
        }
    }
    if (b && b.parentNode) {
        b.parentNode.removeChild(b)
    }
    b = null
};
dayucms.sio.callByBrowser = function(a, h, j) {
    var d = document.createElement("SCRIPT"),
    f = 0,
    k = j || {},
    c = k.charset,
    i = h ||
    function() {},
    g = k.timeOut || 0,
    b;
    d.onload = d.onreadystatechange = function() {
        if (f) {
            return
        }
        var l = d.readyState;
        if ("undefined" == typeof l || l == "loaded" || l == "complete") {
            f = 1;
            try {
                i();
                clearTimeout(b)
            } finally {
                d.onload = d.onreadystatechange = null;
                dayucms.sio._removeScriptTag(d)
            }
        }
    };
    if (g) {
        b = setTimeout(function() {
            d.onload = d.onreadystatechange = null;
            dayucms.sio._removeScriptTag(d);
            k.onfailure && k.onfailure()
        },
        g)
    }
    dayucms.sio._createScriptTag(d, a, c)
};
dayucms.sio.callByServer = function(a, n, o) {
    var j = document.createElement("SCRIPT"),
    i = "bd__cbs__",
    l,
    f,
    p = o || {},
    d = p.charset,
    g = p.queryField || "callback",
    m = p.timeOut || 0,
    b,
    c = new RegExp("(\\?|&)" + g + "=([^&]*)"),
    h;
    if (dayucms.lang.isFunction(n)) {
        l = i + Math.floor(Math.random() * 2147483648).toString(36);
        window[l] = k(0)
    } else {
        if (dayucms.lang.isString(n)) {
            l = n
        } else {
            if (h = c.exec(a)) {
                l = h[2]
            }
        }
    }
    if (m) {
        b = setTimeout(k(1), m)
    }
    a = a.replace(c, "\x241" + g + "=" + l);
    if (a.search(c) < 0) {
        a += (a.indexOf("?") < 0 ? "?": "&") + g + "=" + l
    }
    dayucms.sio._createScriptTag(j, a, d);
    function k(q) {
        return function() {
            try {
                if (q) {
                    p.onfailure && p.onfailure()
                } else {
                    n.apply(window, arguments);
                    clearTimeout(b)
                }
                window[l] = null;
                delete window[l]
            } catch(r) {} finally {
                dayucms.sio._removeScriptTag(j)
            }
        }
    }
};
dayucms.sio.log = function(b) {
    var a = new Image(),
    c = "tangram_sio_log_" + Math.floor(Math.random() * 2147483648).toString(36);
    window[c] = a;
    a.onload = a.onerror = a.onabort = function() {
        a.onload = a.onerror = a.onabort = null;
        window[c] = null;
        a = null
    };
    a.src = b
};
dayucms.string.decodeHTML = function(a) {
    var b = String(a).replace(/&quot;/g, '"').replace(/&lt;/g, "<").replace(/&gt;/g, ">").replace(/&amp;/g, "&");
    return b.replace(/&#([\d]+);/g,
    function(d, c) {
        return String.fromCharCode(parseInt(c, 10))
    })
};
dayucms.decodeHTML = dayucms.string.decodeHTML;
dayucms.string.encodeHTML = function(a) {
    return String(a).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#39;")
};
dayucms.encodeHTML = dayucms.string.encodeHTML;
dayucms.string.filterFormat = function(c, a) {
    var b = Array.prototype.slice.call(arguments, 1),
    d = Object.prototype.toString;
    if (b.length) {
        b = b.length == 1 ? (a !== null && (/\[object Array\]|\[object Object\]/.test(d.call(a))) ? a: b) : b;
        return c.replace(/#\{(.+?)\}/g,
        function(g, k) {
            var m, j, h, f, l;
            if (!b) {
                return ""
            }
            m = k.split("|");
            j = b[m[0]];
            if ("[object Function]" == d.call(j)) {
                j = j(m[0])
            }
            for (h = 1, f = m.length; h < f; ++h) {
                l = dayucms.string.filterFormat[m[h]];
                if ("[object Function]" == d.call(l)) {
                    j = l(j)
                }
            }
            return (("undefined" == typeof j || j === null) ? "": j)
        })
    }
    return c
};
dayucms.string.filterFormat.escapeJs = function(f) {
    if (!f || "string" != typeof f) {
        return f
    }
    var d, a, b, c = [];
    for (d = 0, a = f.length; d < a; ++d) {
        b = f.charCodeAt(d);
        if (b > 255) {
            c.push(f.charAt(d))
        } else {
            c.push("\\x" + b.toString(16))
        }
    }
    return c.join("")
};
dayucms.string.filterFormat.js = dayucms.string.filterFormat.escapeJs;
dayucms.string.filterFormat.escapeString = function(a) {
    if (!a || "string" != typeof a) {
        return a
    }
    return a.replace(/["'<>\\\/`]/g,
    function(b) {
        return "&#" + b.charCodeAt(0) + ";"
    })
};
dayucms.string.filterFormat.e = dayucms.string.filterFormat.escapeString;
dayucms.string.filterFormat.toInt = function(a) {
    return parseInt(a, 10) || 0
};
dayucms.string.filterFormat.i = dayucms.string.filterFormat.toInt;
dayucms.string.format = function(c, a) {
    c = String(c);
    var b = Array.prototype.slice.call(arguments, 1),
    d = Object.prototype.toString;
    if (b.length) {
        b = b.length == 1 ? (a !== null && (/\[object Array\]|\[object Object\]/.test(d.call(a))) ? a: b) : b;
        return c.replace(/#\{(.+?)\}/g,
        function(f, h) {
            var g = b[h];
            if ("[object Function]" == d.call(g)) {
                g = g(h)
            }
            return ("undefined" == typeof g ? "": g)
        })
    }
    return c
};
dayucms.format = dayucms.string.format; (function() {
    var c = /^\#[\da-f]{6}$/i,
    b = /^rgb\((\d+), (\d+), (\d+)\)$/,
    a = {
        black: "#000000",
        silver: "#c0c0c0",
        gray: "#808080",
        white: "#ffffff",
        maroon: "#800000",
        red: "#ff0000",
        purple: "#800080",
        fuchsia: "#ff00ff",
        green: "#008000",
        lime: "#00ff00",
        olive: "#808000",
        yellow: "#ffff0",
        navy: "#000080",
        blue: "#0000ff",
        teal: "#008080",
        aqua: "#00ffff"
    };
    dayucms.string.formatColor = function(f) {
        if (c.test(f)) {
            return f
        } else {
            if (b.test(f)) {
                for (var k, j = 1,
                f = "#"; j < 4; j++) {
                    k = parseInt(RegExp["\x24" + j]).toString(16);
                    f += ("00" + k).substr(k.length)
                }
                return f
            } else {
                if (/^\#[\da-f]{3}$/.test(f)) {
                    var h = f.charAt(1),
                    g = f.charAt(2),
                    d = f.charAt(3);
                    return "#" + h + h + g + g + d + d
                } else {
                    if (a[f]) {
                        return a[f]
                    }
                }
            }
        }
        return ""
    }
})();
dayucms.string.getByteLength = function(a) {
    return String(a).replace(/[^\x00-\xff]/g, "ci").length
};
dayucms.string.stripTags = function(a) {
    return String(a || "").replace(/<[^>]+>/g, "")
};
dayucms.string.subByte = function(c, b, a) {
    c = String(c);
    a = a || "";
    if (b < 0 || dayucms.string.getByteLength(c) <= b) {
        return c + a
    }
    c = c.substr(0, b).replace(/([^\x00-\xff])/g, "\x241 ").substr(0, b).replace(/[^\x00-\xff]$/, "").replace(/([^\x00-\xff]) /g, "\x241");
    return c + a
};
dayucms.string.toHalfWidth = function(a) {
    return String(a).replace(/[\uFF01-\uFF5E]/g,
    function(b) {
        return String.fromCharCode(b.charCodeAt(0) - 65248)
    }).replace(/\u3000/g, " ")
};
dayucms.string.wbr = function(a) {
    return String(a).replace(/(?:<[^>]+>)|(?:&#?[0-9a-z]{2,6};)|(.{1})/gi, "$&<wbr>").replace(/><wbr>/g, ">")
};
dayucms.swf = dayucms.swf || {};
dayucms.swf.version = (function() {
    var h = navigator;
    if (h.plugins && h.mimeTypes.length) {
        var d = h.plugins["Shockwave Flash"];
        if (d && d.description) {
            return d.description.replace(/([a-zA-Z]|\s)+/, "").replace(/(\s)+r/, ".") + ".0"
        }
    } else {
        if (window.ActiveXObject && !window.opera) {
            for (var b = 12; b >= 2; b--) {
                try {
                    var g = new ActiveXObject("ShockwaveFlash.ShockwaveFlash." + b);
                    if (g) {
                        var a = g.GetVariable("$version");
                        return a.replace(/WIN/g, "").replace(/,/g, ".")
                    }
                } catch(f) {}
            }
        }
    }
})();
dayucms.swf.createHTML = function(t) {
    t = t || {};
    var l = dayucms.swf.version,
    h = t.ver || "6.0.0",
    g, d, f, c, j, s, a = {},
    p = dayucms.string.encodeHTML;
    for (c in t) {
        a[c] = t[c]
    }
    t = a;
    if (l) {
        l = l.split(".");
        h = h.split(".");
        for (f = 0; f < 3; f++) {
            g = parseInt(l[f], 10);
            d = parseInt(h[f], 10);
            if (d < g) {
                break
            } else {
                if (d > g) {
                    return ""
                }
            }
        }
    } else {
        return ""
    }
    var n = t.vars,
    m = ["classid", "codebase", "id", "width", "height", "align"];
    t.align = t.align || "middle";
    t.classid = "clsid:d27cdb6e-ae6d-11cf-96b8-444553540000";
    t.codebase = "http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0";
    t.movie = t.url || "";
    delete t.vars;
    delete t.url;
    if ("string" == typeof n) {
        t.flashvars = n
    } else {
        var q = [];
        for (c in n) {
            s = n[c];
            q.push(c + "=" + encodeURIComponent(s))
        }
        t.flashvars = q.join("&")
    }
    var o = ["<object "];
    for (f = 0, j = m.length; f < j; f++) {
        s = m[f];
        o.push(" ", s, '="', p(t[s]), '"')
    }
    o.push(">");
    var b = {
        wmode: 1,
        scale: 1,
        quality: 1,
        play: 1,
        loop: 1,
        menu: 1,
        salign: 1,
        bgcolor: 1,
        base: 1,
        allowscriptaccess: 1,
        allownetworking: 1,
        allowfullscreen: 1,
        seamlesstabbing: 1,
        devicefont: 1,
        swliveconnect: 1,
        flashvars: 1,
        movie: 1
    };
    for (c in t) {
        s = t[c];
        c = c.toLowerCase();
        if (b[c] && (s || s === false || s === 0)) {
            o.push('<param name="' + c + '" value="' + p(s) + '" />')
        }
    }
    t.src = t.movie;
    t.name = t.id;
    delete t.id;
    delete t.movie;
    delete t.classid;
    delete t.codebase;
    t.type = "application/x-shockwave-flash";
    t.pluginspage = "http://www.macromedia.com/go/getflashplayer";
    o.push("<embed");
    var r;
    for (c in t) {
        s = t[c];
        if (s || s === false || s === 0) {
            if ((new RegExp("^salign\x24", "i")).test(c)) {
                r = s;
                continue
            }
            o.push(" ", c, '="', p(s), '"')
        }
    }
    if (r) {
        o.push(' salign="', p(r), '"')
    }
    o.push("></embed></object>");
    return o.join("")
};
dayucms.swf.create = function(a, c) {
    a = a || {};
    var b = dayucms.swf.createHTML(a) || a.errorMessage || "";
    if (c && "string" == typeof c) {
        c = document.getElementById(c)
    }
    dayucms.dom.insertHTML(c || document.body, "beforeEnd", b)
};
dayucms.swf.getMovie = function(c) {
    var a = document[c],
    b;
    return dayucms.browser.ie == 9 ? a && a.length ? (b = dayucms.array.remove(dayucms.lang.toArray(a),
    function(d) {
        return d.tagName.toLowerCase() != "embed"
    })).length == 1 ? b[0] : b: a: a || window[c]
};
dayucms.swf.Proxy = function(g, c, d) {
    var b = this,
    a = this._flash = dayucms.swf.getMovie(g),
    f;
    if (!c) {
        return this
    }
    f = setInterval(function() {
        try {
            if (a[c]) {
                b._initialized = true;
                clearInterval(f);
                if (d) {
                    d()
                }
            }
        } catch(h) {}
    },
    100)
};
dayucms.swf.Proxy.prototype.getFlash = function() {
    return this._flash
};
dayucms.swf.Proxy.prototype.isReady = function() {
    return !! this._initialized
};
dayucms.swf.Proxy.prototype.call = function(a, f) {
    try {
        var c = this.getFlash(),
        b = Array.prototype.slice.call(arguments);
        b.shift();
        if (c[a]) {
            c[a].apply(c, b)
        }
    } catch(d) {}
};
dayucms.url.getQueryValue = function(b, c) {
    var d = new RegExp("(^|&|\\?|#)" + dayucms.string.escapeReg(c) + "=([^&#]*)(&|\x24|#)", "");
    var a = b.match(d);
    if (a) {
        return a[2]
    }
    return null
};
dayucms.url.jsonToQuery = function(c, f) {
    var a = [],
    d,
    b = f ||
    function(g) {
        return dayucms.url.escapeSymbol(g)
    };
    dayucms.object.each(c,
    function(h, g) {
        if (dayucms.lang.isArray(h)) {
            d = h.length;
            while (d--) {
                a.push(g + "=" + b(h[d], g))
            }
        } else {
            a.push(g + "=" + b(h, g))
        }
    });
    return a.join("&")
};
dayucms.url.queryToJson = function(a) {
    var g = a.substr(a.lastIndexOf("?") + 1),
    c = g.split("&"),
    f = c.length,
    l = {},
    d = 0,
    j,
    h,
    k,
    b;
    for (; d < f; d++) {
        if (!c[d]) {
            continue
        }
        b = c[d].split("=");
        j = b[0];
        h = b[1];
        k = l[j];
        if ("undefined" == typeof k) {
            l[j] = h
        } else {
            if (dayucms.lang.isArray(k)) {
                k.push(h)
            } else {
                l[j] = [k, h]
            }
        }
    }
    return l
};