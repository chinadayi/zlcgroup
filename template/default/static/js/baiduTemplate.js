(function(b) {
    var a = typeof module === "undefined" ? (b.dayucms = b.dayucms || {}) : module.exports;
    a.template = function(f, e) {
        var d = (function() {
            if (!b.document) {
                return bt._compile(f)
            }
            var h = document.getElementById(f);
            if (h) {
                if (bt.cache[f]) {
                    return bt.cache[f]
                }
                var g = /^(textarea|input)$/i.test(h.nodeName) ? h.value: h.innerHTML;
                return bt._compile(g)
            } else {
                return bt._compile(f)
            }
        })();
        var c = bt._isObject(e) ? d(e) : d;
        d = null;
        return c
    };
    bt = a.template;
    bt.versions = bt.versions || [];
    bt.versions.push("1.0.6");
    bt.cache = {};
    bt.LEFT_DELIMITER = bt.LEFT_DELIMITER || "<%";
    bt.RIGHT_DELIMITER = bt.RIGHT_DELIMITER || "%>";
    bt.ESCAPE = true;
    bt._encodeHTML = function(c) {
        return String(c).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/\\/g, "&#92;").replace(/"/g, "&quot;").replace(/'/g, "&#39;")
    };
    bt._encodeReg = function(c) {
        return String(c).replace(/([.*+?^=!:${}()|[\]/\\]) / g,
        "\\$1")
    };
    bt._encodeEventHTML = function(c) {
        return String(c).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#39;").replace(/\\\\/g, "\\").replace(/\\\//g, "/").replace(/\\n/g, "\n").replace(/\\r/g, "\r")
    };
    bt._compile = function(d) {
        var c = "var _template_fun_array=[];\nvar fn=(function(data){\nvar _template_varName='';\nfor(name in data){\n_template_varName+=('var '+name+'=data[\"'+name+'\"];');\n};\neval(_template_varName);\n_template_fun_array.push('" + bt._analysisStr(d) + "');\n_template_varName=null;\n})(_template_object);\nfn = null;\nreturn _template_fun_array.join('');\n";
        return new Function("_template_object", c)
    };
    bt._isObject = function(c) {
        return "function" === typeof c || !!(c && "object" === typeof c)
    };
    bt._analysisStr = function(e) {
        var c = bt.LEFT_DELIMITER;
        var g = bt.RIGHT_DELIMITER;
        var d = bt._encodeReg(c);
        var f = bt._encodeReg(g);
        e = String(e).replace(new RegExp("(" + d + "[^" + f + "]*)//.*\n", "g"), "$1").replace(new RegExp("<!--.*?-->", "g"), "").replace(new RegExp(d + "\\*.*?\\*" + f, "g"), "").replace(new RegExp("[\\r\\t\\n]", "g"), "").replace(new RegExp(d + "(?:(?!" + f + ")[\\s\\S])*" + f + "|((?:(?!" + d + ")[\\s\\S])+)", "g"),
        function(i, h) {
            var j = "";
            if (h) {
                j = h.replace(/\\/g, "&#92;").replace(/'/g, "&#39;");
                while (/<[^<]*?&#39;[^<]*?>/g.test(j)) {
                    j = j.replace(/(<[^<]*?)&#39;([^<]*?>)/g, "$1\r$2")
                }
            } else {
                j = i
            }
            return j
        });
        e = e.replace(new RegExp("(" + d + "[\\s]*?var[\\s]*?.*?[\\s]*?[^;])[\\s]*?" + f, "g"), "$1;" + g).replace(new RegExp("(" + d + ":?[hvu]?[\\s]*?=[\\s]*?[^;|" + f + "]*?);[\\s]*?" + f, "g"), "$1" + g).split(c).join("\t");
        if (bt.ESCAPE) {
            e = e.replace(new RegExp("\\t=(.*?)" + f, "g"), "',typeof($1) === 'undefined'?'':dayucms.template._encodeHTML($1),'")
        } else {
            e = e.replace(new RegExp("\\t=(.*?)" + f, "g"), "',typeof($1) === 'undefined'?'':$1,'")
        }
        e = e.replace(new RegExp("\\t:h=(.*?)" + f, "g"), "',typeof($1) === 'undefined'?'':dayucms.template._encodeHTML($1),'").replace(new RegExp("\\t(?::=|-)(.*?)" + f, "g"), "',typeof($1)==='undefined'?'':$1,'").replace(new RegExp("\\t:u=(.*?)" + f, "g"), "',typeof($1)==='undefined'?'':encodeURIComponent($1),'").replace(new RegExp("\\t:v=(.*?)" + f, "g"), "',typeof($1)==='undefined'?'':dayucms.template._encodeEventHTML($1),'").split("\t").join("');").split(g).join("_template_fun_array.push('").split("\r").join("\\'");
        return e
    }
})(window);