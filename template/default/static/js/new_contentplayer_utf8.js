if ("undefined" == typeof ContentPlayer) {
    var ContentPlayer = {}
}
var Observable = (function() {
    function a(c) {
        if (c && typeof c == "object" && c.handleMessage) {
            this.observers.push(c)
        }
    }
    function b(d) {
        var e = this.observers;
        for (var c = 0; c < e.length; c++) {
            e[c].handleMessage(d)
        }
    }
    return {
        addObserver: a,
        notify: b
    }
})();
function implement(a, c) {
    for (var b in a) {
        c[b] = a[b]
    }
}
ContentPlayer.View = function(a) {
    this.container = a.container;
    this.data = a.data || null;
    this.tpl = a.tpl || "";
    this.curIndex = a.curIndex || 0;
    this.needFadeIn = a.needFadeIn || false;
    this.observers = [];
    this.fadeInTimer = 0;
    this.initOpacity = 0.1;
    this.curOpacity = 0.1;
    this.opacityDiff = 0.1
};
ContentPlayer.View.prototype.init = function() {
    this.registerEvent();
    this.render()
};
ContentPlayer.View.prototype.registerEvent = function() {
    var a = this;
    on(this.container, "mouseover",
    function(b) {
        a.notify({
            type: "STOP"
        })
    });
    on(this.container, "mouseout",
    function(b) {
        a.notify({
            type: "PLAY",
            param: {
                step: 1
            }
        })
    })
};
ContentPlayer.View.prototype.render = function() {
    this.container.innerHTML = Fe.format(this.tpl, this.data[this.curIndex])
};
ContentPlayer.View.prototype.fadeIn = function() {
    var a = this;
    window.clearInterval(this.fadeInTimer);
    this.curOpacity = this.initOpacity;
    this.fadeInTimer = window.setInterval(function() {
        var b;
        b = a.opacityDiff;
        if (Fe.Browser.isIE) {
            if (a.curOpacity < 1) {
                a.curOpacity += b;
                a.container.style.filter = "alpha(opacity=" + a.curOpacity * 100 + ")"
            } else {
                a.curOpacity = 1;
                a.container.style.filter = "alpha(opacity=" + a.curOpacity * 100 + ")";
                window.clearInterval(this.fadeInTimer)
            }
        } else {
            if (a.curOpacity < 1) {
                a.curOpacity += b;
                a.container.style.opacity = a.curOpacity
            } else {
                a.curOpacity = 1;
                a.container.style.opacity = a.curOpacity;
                window.clearInterval(this.fadeInTimer)
            }
        }
    },
    50)
};
ContentPlayer.View.prototype.handleMessage = function(f) {
    var g, b, d, a, e, c;
    g = this.data;
    b = this.tpl;
    d = this.curIndex;
    a = g.length;
    switch (f.type) {
    case "NEXT":
        e = f.param.step;
        d = (d + e) % a;
        break;
    case "PREV":
        e = f.param.step;
        d = (a + d - e) % a;
        break;
    case "GOTO":
        c = f.param.index;
        d = c % a;
        break;
    default:
        return
    }
    this.curIndex = d;
    this.render();
    if (this.needFadeIn) {
        this.fadeIn()
    }
};
implement(Observable, ContentPlayer.View.prototype);
ContentPlayer.ControlPanel = function(a) {
    this.getBtns = a.getBtns ||
    function() {
        return []
    };
    this.data = a.data || [];
    this.curIndex = a.curIndex || 0;
    this.style = a.style || null;
    this.observers = [];
    this.imgCache = window[Math.random()] = [];
    this.prevBtn = a.prevBtn;
    this.nextBtn = a.nextBtn;
    this.changeAction = a.changeAction || "mousedown"
};
ContentPlayer.ControlPanel.prototype.init = function() {
    this.registerEvent();
    this.setStyle();
    this.imgPreload()
};
ContentPlayer.ControlPanel.prototype.next = function(c) {
    var a, b;
    a = this.data.length;
    b = this.curIndex;
    this.curIndex = (a + b + c) % a;
    this.setStyle();
    this.notify({
        type: "NEXT",
        param: {
            step: c
        }
    })
};
ContentPlayer.ControlPanel.prototype.prev = function(c) {
    var a, b;
    a = this.data.length;
    b = this.curIndex;
    this.curIndex = (a + b - c) % a;
    this.setStyle();
    this.notify({
        type: "PREV",
        param: {
            step: c
        }
    })
};
ContentPlayer.ControlPanel.prototype.go = function() {
    this.setStyle();
    this.notify({
        type: "GOTO",
        param: {
            index: this.curIndex
        }
    })
};
ContentPlayer.ControlPanel.prototype.registerEvent = function() {
    var c, b;
    b = this;
    c = this.getBtns();
    for (var a = 0; a < c.length; a++) { (function() {
            var e = c[a],
            d = a;
            on(e, b.changeAction,
            function(f) {
                b.curIndex = d;
                b.setStyle();
                b.go()
            });
            on(e, "mouseover",
            function(f) {
                b.notify({
                    type: "STOP"
                })
            });
            on(e, "mouseout",
            function(f) {
                b.notify({
                    type: "PLAY",
                    param: {
                        step: 1
                    }
                })
            })
        })()
    }
    if (this.prevBtn) {
        on(this.prevBtn, "click",
        function() {
            this.blur();
            b.prev(1)
        });
        on(this.prevBtn, "mouseover",
        function(d) {
            b.notify({
                type: "STOP"
            })
        });
        on(this.prevBtn, "mouseout",
        function(d) {
            b.notify({
                type: "PLAY",
                param: {
                    step: 1
                }
            })
        })
    }
    if (this.nextBtn) {
        on(this.nextBtn, "click",
        function() {
            this.blur();
            b.next(1)
        });
        on(this.nextBtn, "mouseover",
        function(d) {
            b.notify({
                type: "STOP"
            })
        });
        on(this.nextBtn, "mouseout",
        function(d) {
            b.notify({
                type: "PLAY",
                param: {
                    step: 1
                }
            })
        })
    }
};
ContentPlayer.ControlPanel.prototype.setStyle = function() {
    var c;
    c = this.getBtns();
    for (var b = 0,
    a = c.length; b < a; b++) {
        if (b != this.curIndex) {
            c[b].className = this.style.off
        } else {
            c[b].className = this.style.on
        }
    }
};
ContentPlayer.ControlPanel.prototype.handleMessage = function(a) {};
ContentPlayer.ControlPanel.prototype.imgPreload = function() {
    var c, a;
    c = this.data;
    for (var b = 0; b < c.length; b++) {
        if (c[b].imgUrl) {
            a = new Image();
            a.src = c[b].imgUrl;
            this.imgCache.push(a)
        }
    }
};
implement(Observable, ContentPlayer.ControlPanel.prototype);
ContentPlayer.Model = function(a) {
    this.interval = a.interval || 4000;
    a.container = a.mainViewContainer;
    a.tpl = a.mainViewTpl;
    a.needFadeIn = false;
    this.mv = new ContentPlayer.View(a);
    a.container = a.subViewContainer;
    a.tpl = a.subViewTpl;
    a.needFadeIn = false;
    this.sv = new ContentPlayer.View(a);
    this.cp = new ContentPlayer.ControlPanel(a);
    this.timerId = 0;
    this.observers = [];
    this.init()
};
ContentPlayer.Model.prototype.init = function() {
    this.mv.init();
    this.sv.init();
    this.cp.init();
    this.cp.addObserver(this.mv);
    this.cp.addObserver(this.sv);
    this.cp.addObserver(this);
    this.mv.addObserver(this);
    this.sv.addObserver(this)
};
ContentPlayer.Model.prototype.play = function(b) {
    var a = this;
    this.stop();
    this.timerId = window.setInterval(function() {
        a.cp.next(b)
    },
    this.interval)
};
ContentPlayer.Model.prototype.stop = function() {
    window.clearInterval(this.timerId)
};
ContentPlayer.Model.prototype.handleMessage = function(a) {
    switch (a.type) {
    case "STOP":
        this.stop();
        break;
    case "PLAY":
        this.play(a.param.step);
        break
    }
};