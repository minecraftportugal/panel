App.Ajax = (function() {

    var Ajax = {};

    Ajax.jsonActionMap = {

        "login": {

            "ok": function(data) {
                App.session = data.session;
                App.Desktop.logIn();
            },

            "ko": function(data) {

            }
        },


        "register": {

            "ok": function(data) {

            },

            "ko": function(data) {

            }
        },

        "logout": {

            "ok": function(data) {
                App.Desktop.logOut();
            }

        }
    };

    Ajax.handles = [];

    Ajax.initiator = function(initiator) {

        var tagname = $(initiator).prop("tagName");

        var href, action, type, data, container, loading_blocker;

        container = $(initiator).closest("div.body");

        //loading_blocker = $("div#loading-blocker");
        loading_blocker = container.next();

        switch (tagname) {

            case "A":
                href = $(initiator).attr("href");
                type = "GET";

                Ajax.request(href, undefined, type, container, loading_blocker);

                break;

            case "FORM":
                action = $(initiator).attr("action");
                type = $(initiator).attr("method");
                data = $(initiator).serialize();

                Ajax.request(action, data, type, container, loading_blocker);

                break;

            default:
                console.log("ERROR: Can't initiate AJAX request");
                break;
        }
    };

    Ajax.handleSuccess = function(data, textStatus, jqXHR, container) {
        var contentType = jqXHR.getResponseHeader("Content-Type").split(";")[0];

        switch (contentType) {
            case "text/html" :
                this.handleHTML(data, container);
                break;

            case "application/json" :
                this.handleJSON(data);
                break;

            default:
                console.log("Unable to handle Content Type ", contentType);
                break;
        }

    };

    Ajax.handleJSON = function(data) {

            if (!!data.notice) {
                $.each(data.notice, function(key, value) {
                    App.Toaster.fadeIn(value);
                });
            }

            var fn = null;
            try {
                var fn = Ajax.jsonActionMap[data.action][data.status];
            } catch(e) {
                console.log(e);
            }

            if (fn !== null) {
                fn(data);
            } else {
                console.log("Couldn't map JSON data to an action");
            }


    };

    Ajax.handleHTML = function(data, container) {
        //container.fadeOut(100, function() {
            container.html(data);
            container.fadeIn(100);
        //});

    };

    Ajax.handleError = function(jqXHR, textStatus, errorThrown) {

        switch (jqXHR.status) {

            case 401:
                Ajax.abortAll();
                App.Desktop.logOut();
                break;

            default:
                break;

        }

    };

    Ajax.request = function(url, data, type, container, loading_blocker) {

        var handle = $.ajax({

            url: url,

            data: data,

            type: type,

            beforeSend: function(jqXHR, settings) {
                loading_blocker.addClass("block-enabled");
            },

            success: function(data, textStatus, jqXHR) {
                Ajax.handleSuccess(data, textStatus, jqXHR, container);
                loading_blocker.removeClass("block-enabled");
            },

            error: function(jqXHR, textStatus, errorThrown) {
                Ajax.handleError(jqXHR, textStatus, errorThrown);
                loading_blocker.removeClass("block-enabled");
            },

            complete: function(e, jqXHR, options) {
                Ajax.handles = $.grep(Ajax.handles, function(handle) { return handle != jqXHR });
            }

        });

        Ajax.handles.push(handle);
    };


    Ajax.abortAll = function() {

        $.each(Ajax.handles, function(n, elem) {
            elem.abort();
        });

    };

    return Ajax;

})();