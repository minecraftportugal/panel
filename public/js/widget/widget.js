/* Constructor: creates a new Widget instance */
function Widget(options, states) {

    this.init(options, states);

}

/* Store opened widgets here */
Widget.widgets = [];

/* Defaults */

Widget.defaults = {
    "source" : "/testpattern",
    "title" : "Title",
    "mode" : "ajax",
    "modal" : false,
    "pinned" : false,
    "modalButtons" : {},
    "alwaysCreate" : false,
    "alwaysReload" : true,
    "maximized" : false,
    "classes" : "widget-not-scrollable",
    "css" : {
        "top": "0px",
        "left": "0px",
        "width" : "800px",
        "height" : "400px",
        "min-width" : "480px",
        "min-height" : "360px",
        "max-width" : null, //"700px",
        "max-height" : null //"700px"
    },
    "cssBody" : {

    }
};

/* Settings */
Widget.saveOnExit = true;

/*
 * Widget.count
 */
Widget.count = function() {

    if (Widget.counter === undefined) {
        Widget.counter = 1;
    } else {
        Widget.counter += 1;
    }

    return Widget.counter;
}

Widget.serializeState = function() {

    var widgets = [];

    if (Widget.widgets === undefined) {
        Widget.widgets = [];
    }

    $.each(Widget.widgets, function(n, widget) {

        /* Don't save modal widgets */
        if (widget.options.modal) {
            widget.close();
            return true;
        }

        widget.pushState();

        var object = {

                options : widget.options,

                states : widget.states

        };

        widgets.push(object);
    });


    var serializedObject = JSON.stringify(widgets, function(name, value) {
        return value;
    });

    return serializedObject;

}

Widget.saveState = function() {

    var serializedObject = Widget.serializeState();
    var base64Object = btoa(serializedObject);
    localStorage.setItem("widgetState", base64Object);

}

Widget.loadState = function() {

    var base64Object = localStorage.getItem("widgetState");
    if ((base64Object === undefined) || (base64Object === null)) {
        return;
    }

    var serializedObject = atob(base64Object); //base64Object; // atob(base64Object);
    var object = [];
    try {
        object = JSON.parse(serializedObject);
    } catch(e) {
        console.log("Couldn't load widget states from localStorage")
    }


    $.each(object, function(n, object) {

        var createdWidget = new Widget(object.options, object.states);
        createdWidget.popState();

    });

}

Widget.clearState = function() {
    Widget.saveOnExit = false;
    localStorage.clear();
    window.location.reload();
}

Widget.closeAll = function() {

    var toClose = [];

    $.each(Widget.widgets, function(n, widget) {
        if (!widget.options.modal && !widget.options.pinned) {
            toClose.push(widget);
        }
    });

    $.each(toClose, function(n, widget) {
        widget.close();
    });
}

Widget.cascade = function() {
    Widget.counter = 0;
    $("div.widget").css("z-index", "0"); // reset all z-index. so pq posso.
    $.each(Widget.widgets, function(n, e) {
        Widget.counter += 1;
        e.shrink();
        e.initPosition();
        e.bringTop();
    });
}

Widget.tile = function() {
    var wLeft = 0;
    var wTop = 0;
    $.each(Widget.widgets, function(n, e) {
        e.shrink();
        $(e.selector).css("left", wLeft + "px");
        $(e.selector).css("top", wTop + "px");
        e.bringTop();

        wLeft = wLeft + parseInt($(e.selector).css("width"));

        if (wLeft > $("div#widget-container").width()) {
            wTop = wTop + parseInt($(e.selector).css("height"));
            wLeft = 0;

            if (wTop > $("div#widget-container").height()) {
                wTop = 0;
            }
        }
    });
}

Widget.embiggen = function() {
    $.each(Widget.widgets, function(n, e) {
        e.maximize();
        //e.bringTop();
        //e.setActive();
    });
}

Widget.minimizeAll = function() {
    $.each(Widget.widgets, function(n, widget) {
            widget.minimize();
    });
}

Widget.get = function(name) {

    var widget;
    $.each(Widget.widgets, function(n, e) {
        if (e.options.name == name) {
            widget = e;
            return false;
        }
        return true;
    });

    return widget;

}

Widget.open = function(param) {

    var createdWidget;

    if (typeof(param) === typeof({})) {

        createdWidget = new Widget(param);

    } else if (typeof(param) === typeof("")) {

        if (param in Widget.widgetStore) {

            var config = Widget.widgetStore[param];

            createdWidget = new Widget(config);

        } else {

            console.log("No widget named " + param);
        }
    }

    return createdWidget;
}

Widget.prototype.init = function(options, states) {

    this.options = {};
    this.options.css = {};

    /* Mix given options and defaults */
    $.extend(this.options, Widget.defaults);
    $.extend(this.options, options);

    /* Mix CSS */
    if (options.css !== undefined) {
        $.extend(this.options.css, options.css);
    }

    /* Stack of states for this widget */
    this.states = states || [];

    /* Widget Property alwaysCreate requires a different name for each widget copy */
    if (this.options.alwaysCreate) {
        this.options.name += new Date().getTime();
    }

    /* Widget and taskbar button - ID and CSS selector */
    /* Modal Widgets do not have buttons */


    if (this.options.modal) {

        this.id = "modal-" + this.options.name;
        this.selector = "div#modal-" + this.options.name;

        this.buttonId = null;
        this.buttonSelector = null;

    } else {

        this.id = "widget-" + this.options.name;
        this.selector = "div#widget-" + this.options.name;

        this.buttonId = "button-widget-" + this.options.name;
        this.buttonSelector = "div#button-widget-" + this.options.name;

    }

    /* Widget serial number */
    this.serial = Widget.count();

    var existing = Widget.get(this.options.name);

    if (existing == null) {

        this.widget = this;
        Widget.widgets.push(this);

        var notApplyingStates = states === undefined;
        this.build(notApplyingStates);

        this.load();

        if (this.options.modal) {

            this.initButtons();

        } else {

            this.initPosition();

        }


    } else {

        this.bringTop();
        this.setActive();

        if ($(this.buttonSelector).hasClass("minimized")) {
            this.restore();
        }

        if (this.options.alwaysReload) {
            this.load(this.options.source);
        }

    }

};

Widget.prototype.setTitle = function(title) {

    $(this.widget).find("div.title").html(this.options.title);
};

Widget.prototype.build = function(notApplyingStates) {


    /* clone markup for the widget */
    if (!this.options.modal) {
        this.widget = $("div#html-templates div#widget-template > div").clone();
        this.button = $("div#html-templates div#widget-button-template > div").clone();
    } else {
        this.widget = $("div#html-templates div#modal-template > div").clone();
        this.button = null;
    }

    /* * initialize properties * */

    $(this.widget).attr("id", this.id);

    this.setTitle(this.options.title);

    $(this.widget).appendTo("div#widget-container");

    if (!this.options.modal) {
        $(this.button).attr("id", this.buttonId);
        $(this.button).html(this.options.title);
        $(this.button).appendTo("div#widget-button-container");
    }

    $(this.selector).css(this.options.css);

    $(this.selector).find("div.body").css(this.options.cssBody);

    $(this.selector).find("div.widget-body").addClass(this.options.classes);

    if (notApplyingStates) {
        this.bringTop();
        this.setActive();
        if (this.options.maximized) {
            this.maximize();
        }
    }

    var widgetInstance = this;

    $(this.selector).click(function(event) {
        widgetInstance.setActive();
    });

    /* Widget is draggable */
    (!this.options.modal) && $(this.selector).draggable({

        addClasses: false,
        cancel: ".nointeraction",
        handle: "div.widget-drag",
        snap: true,
        snapMode: "outer",
        snapTolerance: 5,
        containment: "parent",
        start: function(event, ui) {
            $("iframe").css("pointer-events", "none");
        },

        stop: function(event, ui) {
            $("iframe").css("pointer-events", "auto");
        }

    });

    /* Widget is resizable */
    (!this.options.modal) && $(this.selector).resizable({

        iframeFix: true,
        handles : 'nw, n, ne, e, se, s, sw, w',
        addClasses: false,
        cancel: ".nointeraction",
        snap: true,
        snapMode: "outer",
        containment: "parent",
        start: function(event, ui) {
            $("iframe").css("pointer-events", "none");
        },

        stop: function(event, ui) {
            $("iframe").css("pointer-events", "auto");
        }

    });

    /* Widget refresh button */
    (!this.options.modal) && $(this.selector).find("div.widget-refresh").click(function() {
        widgetInstance.load();
    });

    /* Widget pin button */
    (!this.options.modal) && $(this.selector).find("div.widget-pin").click(function() {
        if ($(widgetInstance.selector).hasClass("pinned")) {
            widgetInstance.unpin();
        } else {
            widgetInstance.pin();
        }
    });

    /* Pinned widget hover for titlebar */
    (!this.options.modal) && $(this.selector).find("div.widget-pinned-invisible-bar").mouseenter(function() {

        if (!widgetInstance.timeoutId) {
            widgetInstance.timeoutId = window.setTimeout(function() {

                widgetInstance.timeoutId = null; // EDIT: added this line
                $(widgetInstance.selector).find("div.widget-titlebar").fadeIn(100);
            }, 1000);
        }

        return false;
    }).mouseleave(function() {

        window.clearTimeout(widgetInstance.timeoutId);
        widgetInstance.timeoutId = null;

        return false;
    });

    (!this.options.modal) && $(this.selector).find("div.widget-titlebar").mouseleave(function () {

        if ($(widgetInstance.selector).hasClass("pinned")) {
            if (widgetInstance.timeoutId) {
                window.clearTimeout(widgetInstance.timeoutId);
                widgetInstance.timeoutId = null;
            }
            else {
                widgetInstance.timeoutId = window.setTimeout(function() {
                    widgetInstance.timeoutId = null;
                    $(widgetInstance.selector).find("div.widget-titlebar").fadeOut(100);
                }, 200);
            }
        }

        return false;

    });

    /* Widget maximize button */
    (!this.options.modal) && $(this.selector).find("div.widget-maximize").click(function() {
        var maximized = $(widgetInstance.selector).hasClass("maximized");

        if (maximized) {
            widgetInstance.restore();
        } else {
            widgetInstance.maximize();
        }

    });

    /* Widget titlebar double click */
    (!this.options.modal) && $(this.selector).find("div.widget-title").dblclick(function() {
        var maximized = $(widgetInstance.selector).hasClass("maximized");

        if (maximized) {
            widgetInstance.restore();
        } else {
            widgetInstance.maximize();
        }

    });


    /* Widget minimize button */
    (!this.options.modal) && $(this.selector).find("div.widget-minimize").click(function() {
        if ($(widgetInstance.selector).hasClass("pinned")) {
            widgetInstance.unpin();
        }
        widgetInstance.minimize();
    });

    /* Widget close button */
    $(this.selector).find("div.widget-close").click(function() {
        widgetInstance.close();
    });

    /* Widget taskbar button event */
    (!this.options.modal) && $(this.buttonSelector).click(function() {
        if ($(widgetInstance.buttonSelector).hasClass("minimized")) {
            widgetInstance.restore();
        } else {
            if ($(widgetInstance.selector).hasClass("widget-active")) {
                widgetInstance.minimize();
                widgetInstance.unsetActive();
            } else {
                widgetInstance.bringTop();
                widgetInstance.setActive();
            }
        }
    });

    /* Bring widget to top on widget-drag mousedown */
    (!this.options.modal) && $(this.selector).find("div.widget-drag").mousedown(function() {
        widgetInstance.bringTop();
        widgetInstance.setActive();
    });

    /* Bring widget to top on mousedown */
    $(this.selector).mousedown(function() {
        widgetInstance.bringTop();
        widgetInstance.setActive();
    });

    /* Modal widget */
    if (this.options.modal) {

        /* modal blocker*/
        var max_z = Widget.getMaxZindex("div.widget.modal");
        $("div.modal-blocker").fadeIn(100);
        widgetInstance.bringTop();

    }

    if (this.options.pinned) {

        this.pin();

    }

};

Widget.prototype.initButtons = function() {

    $(this.selector).css("left", 0);
    $(this.selector).css("top", 0);

    (function(that) {
        $.each(that.options.modalButtons, function(k, v) {

            $btn = $("<input>");
            $btn.val(k);
            $btn.attr("type", "button");

            (function(that) {

                $btn.click(function() {

                    if (!(v())) {
                        that.close();
                    }

                });

            })(that);

            $(that.selector).find("div.modal-buttons").append($btn);

        });
    })(this);

};

Widget.prototype.load = function(source) {

    var source = source || this.options.source;

    switch (this.options.mode) {

        case "iframe":

            this.iframeId = this.id + "-iframe";
            var jq_tag = $("<iframe></iframe>");
            jq_tag.attr("id", this.iframeId) ;
            jq_tag.attr("src", source) ;
            $(this.selector).find("div.widget-body").html(jq_tag);
            $(this.selector).addClass("widget-iframe");

            break;

        case "ajax":

            var container = $(this.selector).find("div.body");
            var loading_blocker = $(this.selector).find("div.body").next();
            Ajax.request(source, undefined, "GET", container, loading_blocker);

            break;

        case "static":

            var container = $(this.selector).find("div.body");
            var loading_blocker = $(this.selector).find("div.body").next();

            $(container).html(source);

            break;

        default:

            break;

    }

    //    this.bringTop();
    //    this.setActive();

}


Widget.prototype.pushState = function() {
    var maximized =    $(this.selector).hasClass("maximized");
    var state = {
        "css" : {
            "top": $(this.selector).css("top"),
            "left": $(this.selector).css("left"),
            "width": $(this.selector).css("width"),
            "height": $(this.selector).css("height"),
            "z-index": $(this.selector).css("z-index")
        },
        "maximized" : $(this.selector).hasClass("maximized"),
        "minimized" : $(this.buttonSelector).hasClass("minimized"),
        "active" : $(this.selector).hasClass("widget-active")
    }

    this.states.push(state);
};

Widget.prototype.popState = function() {


    var state = this.states.pop();

    if (state !== undefined) {
        if (state.maximized) {
            this.maximize();
        }

        if (state.minimized) {
            this.minimize();
        }

        if (state.active) {
            this.setActive();
        }

        if (state.maximized) {
                delete state.css.height;
                delete state.css.width;
                delete state.css.top;
                delete state.css.left;
        }

        $(this.selector).css(state.css);
    }

    //console.log("pop", state);
};

Widget.prototype.initPosition = function() {
    var wLeft = 5;
    var wTop = 5;
    var leftStep = (Widget.counter - 1 % 5);
    var topStep = (Widget.counter - 1 % 5);
    var delta_x = wLeft + 30 * (leftStep + 1);
    var delta_y = wTop + 25 * (topStep + 1);
    $(this.selector).css("left", delta_x + "px");
    $(this.selector).css("top", delta_y + "px");
};

Widget.prototype.setActive = function() {
    this.unsetActive();
    Widget.active = this.selector;
    $(this.selector).addClass("widget-active");
    $(this.buttonSelector).addClass("widget-button-active");
};

Widget.prototype.unsetActive = function() {
    Widget.active = undefined;
    $.each(Widget.widgets, function (n, elem) {
        $(elem.selector).removeClass("widget-active");
        $(this.buttonSelector).removeClass("widget-button-active");
    });
};

Widget.getMaxZindex = function(selector) {

    var selector = selector || "div.widget";
    var max_z = 0;
    $(selector).each(function(n, e) {

        var z = parseInt($(e).css("z-index"));

        if (z > max_z) {
            max_z = z;
        }

    });

    return max_z;
};

Widget.prototype.bringTop = function() {

    var max_z;

    if (this.options.pinned) {
        max_z = Widget.getMaxZindex("div.widget.pinned");
        max_z = max_z == 0 ? 10 : max_z;
    } else if (this.options.modal) {
        max_z = Widget.getMaxZindex("div.widget.modal");
        max_z = max_z == 0 ? 2000000000 : max_z;
    } else {
        max_z = Widget.getMaxZindex("div.widget");
        max_z = max_z == 0 ? 1000000000 : max_z;
    }

    $(this.selector).css("z-index", max_z + 1);
};

Widget.prototype.maximize = function() {
    $(this.selector).show();
    $(this.buttonSelector).removeClass("minimized");
    $(this.selector).addClass("maximized"); //css in class
    this.bringTop();
    this.setActive();

};

Widget.prototype.restore = function() {
    $(this.selector).show();
    $(this.buttonSelector).removeClass("minimized");
    $(this.selector).removeClass("maximized");
    this.bringTop();
    this.setActive();
};

Widget.prototype.shrink = function() {
    $(this.selector).show();
    $(this.buttonSelector).removeClass("minimized");
    $(this.selector).removeClass("maximized");

    var len = Widget.widgets.length;
    // var gridSizeH = Math.ceil(len / 2);
    // var gridSizeV = Math.ceil(len / 2);
    // var width = parseInt($("div#widget-container").css("width"));
    // var height = parseInt($("div#widget-container").css("height"));
    //var newWidth = (width / gridSizeV);
    ///var newHeight = (height / gridSizeH);
    //console.log(width, height, gridSizeH, gridSizeV);

    var newWidth = this.options.css["min-width"];
    var newHeight = this.options.css["min-height"];
    $(this.selector).css({
         "width" : newWidth,
         "height" : newHeight
    });
    this.bringTop();
    this.setActive();
};

Widget.prototype.minimize = function() {
    $(this.selector).hide();
    $(this.buttonSelector).addClass("minimized");
    $(this.selector).removeClass("maximized");
};

Widget.prototype.close = function() {
    $(this.selector).remove();
    $(this.buttonSelector).remove();

    var widgetInstance = this;
    var elementIndex = null;
    $.each(Widget.widgets, function(n, e) {
        if (e.options.name == widgetInstance.options.name) {
            elementIndex = n;
        }
    });

    if (elementIndex !== null) {
        Widget.widgets.splice(elementIndex, 1);
    }


    /* Modal widget */
    if (this.options.modal) {

        $("div.modal-blocker").fadeOut(100);

    }

};

Widget.prototype.hilight = function(data) {
  
    if ($(this.buttonSelector).hasClass("minimized")) {
        $(this.buttonSelector).addClass("activity");

        $(this.buttonSelector).one("click", function() {
            $(this).removeClass("activity");
        });
    }

};

Widget.prototype.pin = function() {

    this.options.pinned = true;
    $(this.selector).addClass("pinned");
    $(this.selector).css("z-index", 10);
    $(this.buttonSelector).fadeOut(100);

};

Widget.prototype.unpin = function() {

    this.options.pinned = false;
    $(this.selector).removeClass("pinned");
    $(this.selector).css("z-index", 1000000000);
    $(this.buttonSelector).fadeIn(100);

};

/*
 * Data API - Widget.open
 * Describe widget to open using data- tags
 */
$(document).on("click", "[data-widget-action]", function(event) {
    var action = $(this).data("widget-action");
    var name = $(this).data("widget-name");
    var title = $(this).data("widget-title") || name;
    var href = $(this).attr("href");
    var mode = $(this).data("widget-mode");
    var css = $(this).data("widget-css");
    var maximized = $(this).data("widget-maximized") || false;
    var alwaysCreate = $(this).data("widget-always-create") || false;
    var alwaysReload = $(this).data("widget-always-reload") || true;
    var classes = $(this).data("widget-classes") || "widget-not-scrollable";

    switch (action) {

        case "open":
            Widget.open({
                "name" : name,
                "source" : href,
                "title" : title,
                "mode" : mode,
                "css" : css,
                "maximized" : maximized,
                "classes" : classes,
                "alwaysCreate" : alwaysCreate,
                "alwaysReload" : alwaysReload
            });
            break;

        default:
            break;

    }

    event.preventDefault();
});

/*
 * Data API - Widget.open
 * Open a widget referencing it by name
 */
$(document).on("click", "[data-widget-open]", function(event) {
    var name = $(this).data("widget-open");

    Widget.open(name);

    event.preventDefault();
});

$(window).on("unload", function() {
        if (Widget.saveOnExit) {
                Widget.saveState();
        } else {
                Widget.saveOnExit = true;
        }
});

$(function() {
        Widget.loadState();
});