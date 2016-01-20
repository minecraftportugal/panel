/* Constructor: creates a new Widget instance */


App.Desktop = (function() {

    var Desktop = {};

    Desktop.widgets = [];

    /* Settings */
    Desktop.settings = {};
    $.extend(Desktop.settings, App.Defaults.settings);
    $.extend(Desktop.settings.background, App.Defaults.settings.background);

    /* Globals */
    Desktop.globals = {
        saveOnExit: true
    };

    Desktop.getWidgetSerialNumber = function() {

        if (Desktop.counter === undefined) {
            Desktop.counter = 1;
        } else {
            Desktop.counter += 1;
        }

        return Desktop.counter;
    };

    Desktop.serializeState = function() {

        // Pick widgets to serialize
        var widgets = [];
        if (Desktop.widgets === undefined) {
            Desktop.widgets = [];
        }

        $.each(Desktop.widgets, function(n, widget) {

            /* Don't save modal widgets */
            if (widget.options.modal) {
                return true;
            }

            widget.pushState();

            var object = {
                options: widget.options,
                states: widget.states
            };

            widgets.push(object);
        });

        // Serialize these items in an object
        return JSON.stringify({
            widgets: widgets,
            settings: Desktop.settings
        }, function(name, value) {
            return value;
        });


    };

    Desktop.saveState = function() {
        if (!!App.session) {
            var serializedObject = Desktop.serializeState();
            var base64Object = btoa(serializedObject);
            localStorage.setItem("widgetState_" + App.session.username, base64Object);
        }
    };

    Desktop.loadState = function() {

        var dfd = $.Deferred();
        var widgets;
        var settings;
        var defaultWidgets = App.Defaults.fixedStates["basic"];

        /* load an empty state if no user is logged in */
        if (!App.session) {
            return dfd.resolve({
                widgets: [],
                settings: App.Defaults.settings
            });
        }

        /* try to load the base64 object from localStorage */
        var base64Object = localStorage.getItem("widgetState_" + App.session.username);
        if ((base64Object === undefined) || (base64Object === null)) {
            return dfd.resolve({
                widgets: defaultWidgets,
                settings: App.Defaults.settings
            });
        }

        /* try to parse the base64 object into a JSON structure */
        var serializedObject = atob(base64Object); //base64Object; // atob(base64Object);
        var userData = {
            widgets: defaultWidgets,
            settings: App.Defaults.settings
        };
        try {
            userData = JSON.parse(serializedObject);
        } catch (e) {
            console.log("Couldn't load widget states from localStorage")
        }

        widgets = userData.widgets || [];
        settings = userData.settings || App.Defaults.settings;

        return dfd.resolve({
            widgets: widgets,
            settings: settings
        });

    };

    Desktop.setState = function(data) {

        /* Restore widgets and settings */
        Desktop.settings = data.settings;

        $.each(data.widgets, function(n, widget) {
            var createdWidget = new Desktop.Widget(widget.options, widget.states);
            createdWidget.popState();
        });

    };

    Desktop.clearState = function() {
        Desktop.globals.saveOnExit = false;
        if (!!App.session.username) {
            delete(localStorage["widgetState_" + App.session.username])
        } else {
            localStorage.clear();
        }
        window.location.reload();
    };

    Desktop.closeAll = function() {

        var toClose = [];

        $.each(Desktop.widgets, function(n, widget) {

            if (!widget.options.modal && !widget.options.pinned) {
                toClose.push(widget);
            }

        });

        $.each(toClose, function(n, widget) {
            widget.close();
        });
    };

    Desktop.cascade = function() {
        Desktop.counter = 0;
        $("div.widget").css("z-index", "0"); // reset all z-index. so pq posso.
        $.each(Desktop.widgets, function(n, e) {
            Desktop.counter += 1;
            e.shrink();
            e.initPosition();
            e.bringTop();
        });
    };

    Desktop.tile = function() {
        var wLeft = 0;
        var wTop = 0;
        $.each(Desktop.widgets, function(n, e) {
            e.shrink();
            $(e.selector).css("left", wLeft + "px");
            $(e.selector).css("top", wTop + "px");
            e.bringTop();

            wLeft = wLeft + parseInt($(e.selector).css("width"));

            var $container = $("div#widget-container");
            if (wLeft > $container.width()) {
                wTop = wTop + parseInt($(e.selector).css("height"));
                wLeft = 0;

                if (wTop > $container.height()) {
                    wTop = 0;
                }
            }
        });
    };

    Desktop.embiggen = function() {
        $.each(Desktop.widgets, function(n, e) {
            e.maximize();
            //e.bringTop();
            //e.setActive();
        });
    };

    Desktop.minimizeAll = function() {
        $.each(Desktop.widgets, function(n, widget) {
            widget.minimize();
        });
    };

    Desktop.getWidgetByName = function(name) {

        var widget;

        $.each(Desktop.widgets, function(n, e) {

            if (e.options.name == name) {

                widget = e;
                return false;
            }
            return true;
        });

        return widget;

    };

    Desktop.open = function(param) {

        var createdWidget;

        if (typeof(param) === typeof({})) {

            createdWidget = new Desktop.Widget(param);

        } else if (typeof(param) === typeof("")) {

            if (param in App.Defaults.fixedWidgets) {
                var config = App.Defaults.fixedWidgets[param];
                createdWidget = new Desktop.Widget(config);
            }

        }

        return createdWidget;
    };


    Desktop.bootstrap = function() {

        var dfd = $.Deferred();

        $.when(
            Desktop.loadState()
        ).then(function(state, background) {
            Desktop.setState(state);
            Desktop.setBackground(Desktop.settings.background).then(function() {    
                dfd.resolve();
            }).fail(function() {
                dfd.resolve();
            });
        });

        return dfd;
    };

    Desktop.changeDomWithoutReloadForLogin = function() {

        /* add meta tags */
        $("<meta>").appendTo("head").attr("name", "xsrf_token").attr("content", App.session.xsrf_token);
        $("<meta>").appendTo("head").attr("name", "username").attr("content", App.session.username);
        $("<meta>").appendTo("head").attr("name", "admin").attr("content", App.session.admin);
        $("<meta>").appendTo("head").attr("name", "donor").attr("content", App.session.donor);
        $("<meta>").appendTo("head").attr("name", "contributor").attr("content", App.session.contributor);

        /* Adjust taskbar items position if admin menu is to be present */
        (function() {
            var $menu_admin_button = $("div#widget-button-admin-menu");

            if (App.session.admin == "1") {
                $("div#widget-button-container").css({ left : 73 });
                $("div#widget-button-container-scroll-left").css({left: 62});
                $menu_admin_button.show();
            } else {
                $("div#widget-button-container").css({ left : 42 });
                $("div#widget-button-container-scroll-left").css({left: 31});
                $menu_admin_button.hide();
            }
        })();

        /* Adjust taskbar items position if admin menu is to be present */
        (function() {
            var $menu_admin_button = $("div#widget-button-admin-menu");

            if (App.session.admin == "1") {
                $("div#widget-button-container").css({ left : 73 });
                $("div#widget-button-container-scroll-left").css({left: 62});
                $menu_admin_button.show();
            } else {
                $("div#widget-button-container").css({ left : 42 });
                $("div#widget-button-container-scroll-left").css({left: 31});
                $menu_admin_button.hide();
            }
        })();

        /* Change user menu icon, username label and profile menu link */
        (function() {
            var $menu_profile = $("a#menu-profile");
            $menu_profile.attr("data-widget-title", "<i class='fa fa-user'></i> " + App.session.username);
            $menu_profile.attr("data-widget-name", "profile-" + App.session.username);

            $("a#usermenu-small").css("background-image", "url('//minotar.mcpt.eu/avatar/" + App.session.username + "/16')");

            $("li#usermenu-name i").css("background-image", "url('//minotar.mcpt.eu/avatar/" + App.session.username + "/16')");
            $("li#usermenu-name span").html(App.session.username);

        })();

        /* Logo / Donation request */
        /* * * */

        /* remove ads if user is a donor */
        (function() {
            if (App.session.donor === "1") {
                $("div#container-ad-desktop").hide();
            } else {
                $("div#container-ad-desktop").show();
            }
        })();
    };

    Desktop.changeDomWithoutReloadForLogout = function() {

        /* remove meta tags */
        $("meta[name=xsrf_token]").remove();
        $("meta[name=username]").remove();
        $("meta[name=admin]").remove();

        /* Change user menu icon and username label */
        (function() {
            var $menu_profile = $("a#menu-profile");
            $menu_profile.attr("data-widget-title", "<i class='fa fa-user'></i> ");
            $menu_profile.attr("data-widget-name", "profile-");

            $("a#usermenu-small").css("background-image", "");

            $("li#usermenu-name i").css("background-image", "");
            $("li#usermenu-name span").html("");

        })();
    };

    Desktop.logIn = function() {

        Desktop.showCurtain();
        Desktop.bootstrap().then(function() {

            /* show elements that appear when logged in */
            $(".show-when-logged-in").show();

            if (!!App.session) { /* !!! */
                Desktop.changeDomWithoutReloadForLogin();
            }

            /* Turn on saving state when opening the panel to the user */
            Desktop.globals.saveOnExit = true;

            /* hide modal login if it is open */
            var w = Desktop.getWidgetByName("public-login");
            (!!w) && w.close();
            Desktop.hideCurtain();
        });
    };

    Desktop.logOut = function() {

        Desktop.showCurtain();
        Desktop.bootstrap().then(function() {

            /* hide elements that appear when logged in */
            $(".show-when-logged-in").hide();

            if (!!App.session) {
                Desktop.saveState();
                App.session = undefined;
                Desktop.globals.saveOnExit = false;
            }

            $.each(Desktop.widgets.slice(), function(n, widget) {
                widget.close();
            });
            Desktop.open("public-login");

            Desktop.changeDomWithoutReloadForLogout();
            Desktop.hideCurtain();
        });
    };

    Desktop.setBackground = function(bg) {

        var background = $.extend({}, App.Defaults.settings.background);
        $.extend(background, bg);

        var dfd = $.Deferred();

        var $body = $("body");
        $body.css("background-repeat", background.backgroundRepeat);
        $body.css("background-position", background.backgroundPosition);
        $body.css("background-attachment", background.backgroundAttachment);
        $body.css("-webkit-background-size", background.backgroundSize);
        $body.css("-moz-background-size", background.backgroundSize);
        $body.css("-o-background-size", background.backgroundSize);
        $body.css("background-size", background.backgroundSize);

        // http://stackoverflow.com/questions/5057990/how-can-i-check-if-a-background-image-is-loaded
        $("<img/>").attr("src", background.image).load(function() {
            $(this).remove(); // prevent memory leaks as @benweet suggested
            $("body").css("background-image", "url(" + background.image + ")");
            dfd.resolve(background);
        }).error(function(e) {
            Desktop.settings.background = App.Defaults.settings.background;
            dfd.reject();
        });

        return dfd;
    };

    Desktop.hideCurtain = function() {

        //var loadingDelay = 1000 + Math.round(Math.random() * 100);
        //var loadingTimeout = setTimeout(function() {

            /* remove huge loading blocker */
            //$("div#loading-blocker").fadeOut(200, function() {
            $("div#loading-blocker").removeClass("block-enabled");

            /* fadeOut adds style { display: none } to this element */
            //    $("div#loading-blocker").removeAttr("style");
            //});

        //}, loadingDelay);

    };

    Desktop.showCurtain = function() {

        /* show loading blocker */
        $("div#loading-blocker").addClass("block-enabled");
    };

    /* DOM event initializations */
    (function() {
        /*
         * Data API - Desktop.open
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
                    Desktop.open({
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
         * Data API - Desktop.open
         * Open a widget referencing it by name
         */
        $(document).on("click", "[data-widget-open]", function(event) {

            var name = $(this).data("widget-open");
            var override = $(this).data("widget-open-override");

            if (override !== undefined) {
                //override = JSON.parse(override);
                var params = App.Defaults.fixedWidgets[name];
                if (params === undefined) {
                    console.log('No widget named ' + name);
                    return false;
                }
                var newParams = {};
                $.extend(newParams, params);
                $.extend(newParams, override);

                Desktop.open(newParams);
            } else {
                Desktop.open(name);
            }

            event.preventDefault();

        });

        $(window).on("unload", function() {

            if (Desktop.globals.saveOnExit) {
                var username = $("meta[name=username]").attr("content");
                var loggedIn = !!username;
                if (loggedIn) {
                    Desktop.saveState();
                }
            } else {
                Desktop.globals.saveOnExit = true;
            }
        });

        $(function() {
            $("div#widget-button-container").sortable();
        });

    }());

    return Desktop;

})();