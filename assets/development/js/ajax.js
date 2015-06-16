App.Ajax = {};

App.Ajax.jsonActionMap = {

    "login": {

        "ok": function(data) {
            window.location = "/";
        },

        "ko": function(data) {

        }
    },

    "logout": {

    }
};

App.Ajax.initiator = function(initiator) {

    var tagname = $(initiator).prop("tagName");

    var href, action, type, data, container, loading_blocker;

    switch (tagname) {

        case "A":
            href = $(initiator).attr("href");
            container = $(initiator).closest("div.widget-body");

            App.Ajax.request(href, undefined, "GET", container);
            break;

        case "FORM":
            action = $(initiator).attr("action");
            type = $(initiator).attr("method");
            data = $(initiator).serialize();
            container = $(initiator).closest("div.widget-body");

            App.Ajax.request(action, data, type, container);
            break;

        default:
            console.log("ERROR: Can't initiate AJAX request");
            break;
    }
};

App.Ajax.handleSuccess = function(data, textStatus, jqXHR, container) {
    var contentType = jqXHR.getResponseHeader("Content-Type");

    switch (contentType) {
        case "text/html" :
            this.handleHTML(data, container);
            break;

        case "application/json" :
            this.handleJSON(data);
            break;

        default:
            break;
    }

};

App.Ajax.handleJSON = function(data) {

        if (!!data.notice) {
            $.each(data.notice, function(key, value) {
                App.Toaster.fadeIn(value);
            });
        }

        var fn = null;
        try {
            var fn = App.Ajax.jsonActionMap[data.action][data.status];
        } catch(e) {
            console.log(e);
        }

        if (fn !== null) {
            fn();
        } else {
            console.log("Couldn't map JSON data to an action");
        }


};

App.Ajax.handleHTML = function(data, container) {
    container.html(data);
};

App.Ajax.handleError = function(jqXHR, textStatus, errorThrown) {

    switch (jqXHR.status) {

        case 401:
            App.showLogin();
            break;

        default:
            break;

    }

};

App.Ajax.request = function(url, data, type, container) {

    var loading_blocker = container.next();

    $.ajax({
      
        url : url,
      
        data : data,
      
        type : type,
      
        beforeSend: function(jqXHR, settings) {
            loading_blocker.addClass("block-enabled");
        },
      
        success : function(data, textStatus, jqXHR) {
            App.Ajax.handleSuccess(data, textStatus, jqXHR, container);
            loading_blocker.removeClass("block-enabled");
        },
      
        error : function(jqXHR, textStatus, errorThrown) {
            App.Ajax.handleError(jqXHR, textStatus, errorThrown);
            loading_blocker.removeClass("block-enabled");
        }
    
    });

};