App.Desktop.Widget = (function() {

    var Desktop = App.Desktop;

    var defaults = {

        "source" : "/testpattern",
        "title" : "Title",
        "mode" : "ajax",
        "modal" : false,
        "pinned" : false,
        "alwaysCreate" : false,
        "alwaysReload" : true,
        "maximized" : false,
        "classes" : "widget-not-scrollable",

        "css" : {
            "top": "0px",
            "left": "0px",
            "width" : "800px",
            "height" : "400px",
            "min-width" : null, // "480px",
            "min-height" : null,// "360px",
            "max-width" : null, //"700px",
            "max-height" : null //"700px"
        },

        "modalOptions" : {
            "closeButton": true,
            "icon": true,
            "buttons": {},
            "transparentBlocker": false
        },

        "cssBody" : {

        },

        "iframe" : {

        }

    };

    var Widget = function(options, states) {
        var options = options || defaults;
        return this.init(options, states);
    };

    Widget.defaults = defaults;

    Widget.prototype.init = function(options, states) {

        /* Deep Mix given options and defaults */
        this.options = {};
        $.extend(true, this.options, Widget.defaults, options);

        /* Stack of states for this widget */
        this.states = states || [];

        /* Widget Property alwaysCreate requires a different name for each widget copy */
        if (this.options.alwaysCreate && states === undefined) {
            this.options.name += new Date().getTime();
        }

        /* Event timeouts for this widget (used with timers) */
        this.timeouts = {

        };

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
        this.serial = Desktop.getWidgetSerialNumber();

        var existing = Desktop.getWidgetByName(this.options.name);

        if (existing == null) {
            Desktop.widgets.push(this);

            var notApplyingStates = states === undefined;
            this.build(notApplyingStates);

            this.load();

            if (this.options.modal) {

                this.initModal();

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

        if (this.options.modal) {
            $(this.selector).find("div.modal-body").addClass(this.options.classes);
        } else {
            $(this.selector).find("div.widget-body").addClass(this.options.classes);
        }

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
        (!this.options.modal) && $(this.selector).find("div.widget-pinned-invisible-bar").hover(


                function() {

                    if (!widgetInstance.timeouts.titleBarGhost) {
                        widgetInstance.timeouts.titleBarGhost = window.setTimeout(function() {

                            widgetInstance.timeouts.titleBarGhost = null; // EDIT: added this line
                            $(widgetInstance.selector).find("div.widget-titlebar").fadeIn(100, function() {

                            });
                        }, 500);
                    }

                    return false;

                },

                function() {

                    window.clearTimeout(widgetInstance.timeouts.titleBarGhost);

                    widgetInstance.timeouts.titleBarGhost = null;

                    return false;
                }

        );

        (!this.options.modal) && $(this.selector).find("div.widget-titlebar").hover(


            function() {
            },

            function() {

                if (!$(widgetInstance.selector).hasClass("pinned")) {
                    return false;
                }

                if (widgetInstance.timeouts.titleBar) {

                    window.clearTimeout(widgetInstance.timeouts.titleBar);

                    widgetInstance.timeouts.titleBar = null;

                } else {
                    widgetInstance.timeouts.titleBar = window.setTimeout(function() {

                        widgetInstance.timeouts.titleBar = null;

                        $(widgetInstance.selector).find("div.widget-titlebar").fadeOut(100, function(){

                        });

                    }, 200);
                }

                return false;
            }

        );

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

            /* Modal blocker*/
            if (this.options.modalOptions.transparentBlocker) {
                $("div#modal-blocker").addClass("transparent");
            } else {
                $("div#modal-blocker").removeClass("transparent");
            }

            $("div#modal-blocker").show();
            widgetInstance.bringTop();

        }

        if (this.options.pinned) {
            this.pin();
        }

    };

    Widget.prototype.initModal = function() {

        $(this.selector).css("left", 0);
        $(this.selector).css("top", 0);

        (function(that) {

            if (Object.keys(that.options.modalOptions.buttons).length > 0) {
                $.each(that.options.modalOptions.buttons, function (k, v) {

                    $btn = $("<button></button>");

                    $btn.html(k);
                    $btn.attr("type", "button");

                    (function (that) {

                        $btn.click(function () {

                            if (!(v())) {
                                that.close();
                            }

                        });

                    })(that);

                    $(that.selector).find("div.modal-buttons").append($btn);

                });
            } else {
                $(that.selector).find("div.modal-buttons").hide();
                $(that.selector).find("div.modal-body").css("bottom", 0);
            }

            if (that.options.modalOptions.closeButton !== undefined) {
                if (!that.options.modalOptions.closeButton) {
                    $(that.selector).find(".modal-close").hide();
                }
            }

            if (!that.options.modalOptions.icon) {
                $(that.selector).find(".modal-icon").hide();
            }
        })(this);

    };

    Widget.prototype.load = function(source) {

        var source = source || this.options.source;

        switch (this.options.mode) {

            case "iframe":

                this.iframeId = this.id + "-iframe";
                var jq_tag = $("<iframe></iframe>");
                jq_tag.attr("id", this.iframeId) ;
                jq_tag.attr("src", source);

                $.each(this.options.iframe, function(k, v) {
                    jq_tag.attr(k, v);
                });

                $(this.selector).find("div.widget-body").html(jq_tag);
                $(this.selector).addClass("widget-iframe");

                break;

            case "ajax":

                var container = $(this.selector).find("div.body");
                var loading_blocker = $(this.selector).find("div.body").next();
                App.Ajax.request(source, undefined, "GET", container, loading_blocker);

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

    };

    Widget.prototype.initPosition = function() {
        var wLeft = 5;
        var wTop = 5;
        var leftStep = (Desktop.counter - 1 % 5);
        var topStep = (Desktop.counter - 1 % 5);
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
        $.each(Desktop.widgets, function (n, elem) {
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
        $.each(Desktop.widgets, function(n, e) {
            if (e.options.name == widgetInstance.options.name) {
                elementIndex = n;
            }
        });

        if (elementIndex !== null) {
            Desktop.widgets.splice(elementIndex, 1);
        }


        /* Modal widget */
        if (this.options.modal) {

            $("div#modal-blocker").fadeOut(100);

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

    return Widget;

})();