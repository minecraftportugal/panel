App.Ajax = {};

App.Ajax.initiator = function(initiator) {

    var tagname = $(initiator).prop("tagName");

    var href, action, type, data, container, loading_blocker;

    switch (tagname) {

        case "A":
            href = $(initiator).attr("href");
            container = $(initiator).closest("div.widget-body");
            loading_blocker = container.next();

            App.Ajax.request(href, undefined, "GET", container, loading_blocker);
            break;

        case "FORM":
            action = $(initiator).attr("action");
            type = $(initiator).attr("method");
            data = $(initiator).serialize();
            container = $(initiator).closest("div.widget-body");
            loading_blocker = container.next();

            App.Ajax.request(action, data, type, container, loading_blocker);
            break;

        default:
            console.log("ERROR: Can't initiate AJAX request");
            break;
    }
};

App.Ajax.handleError = function(jqXHR, textStatus, errorThrown) {

    // console.log(jqxHR, textStatus, errorThrown);

    switch (jqXHR.status) {

        case 401:
            window.location.href = "/";
            break;
    }

};

App.Ajax.request = function(url, data, type, container, loading_blocker) {

    $.ajax({
      
        url : url,
      
        data : data,
      
        type : type,
      
        beforeSend: function(jqXHR, settings) {
            loading_blocker.addClass("block-enabled");
        },
      
        success : function(data, textStatus, jqXHR) {
            container.html(data);
            loading_blocker.removeClass("block-enabled");
        },
      
        error : function(jqXHR, textStatus, errorThrown) {
            App.Ajax.handleError(jqXHR, textStatus, errorThrown);
            loading_blocker.removeClass("block-enabled");
        }
    
    });

};