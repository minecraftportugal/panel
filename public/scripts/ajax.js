/*
 *
 */

function AjaxIndicator() {

    if ( arguments.callee._singletonInstance )
        return arguments.callee._singletonInstance;
    arguments.callee._singletonInstance = this;

    this.indicate = function() {
        $("div#ajax-indicator").removeClass("ajax-loadings ajax-error").addClass("ajax-loading");
    }

    this.disappear = function() {
        setTimeout(function() {
                $("div#ajax-indicator").removeClass("ajax-loading ajax-error ajax-loading-https");
        }, 10);

    }
}

var ajaxIndicator = new AjaxIndicator();

$.ajaxSetup({
    beforeSend: function() {
        ajaxIndicator.indicate();
    },
    complete: function() {
        ajaxIndicator.disappear();
    },
    error: function() {
        ajaxIndicator.disappear();
    },
    type: "GET"

});

/*
 *
 */

function Ajax() {

}

Ajax.initiator = function(initiator) {

    var tagname = $(initiator).prop("tagName");

    var href, action, type, data, container, loading_blocker;

    switch (tagname) {

        case "A":
            href = $(initiator).attr("href");
            container = $(initiator).closest("div.widget-body");
            loading_blocker = container.next();

            Ajax.request(href, undefined, "GET", container, loading_blocker);
            break;

        case "FORM":
            action = $(initiator).attr("action");
            type = $(initiator).attr("method");
            data = $(initiator).serialize();
            container = $(initiator).closest("div.widget-body");
            loading_blocker = container.next();

            Ajax.request(action, data, type, container, loading_blocker);
            break;

        default:
            console.log("ERROR: Can't initiate AJAX request");
            break;
    }
}

Ajax.handleError = function(jqXHR, textStatus, errorThrown) {

    // console.log(jqxHR, textStatus, errorThrown);

    switch (jqXHR.status) {

        case 401:
            console.log("AUTHORIZATION REQUIRED");
            break;
    }

}

Ajax.request = function(url, data, type, container, loading_blocker) {

    $.ajax({
      
        url : url,
      
        data : data,
      
        type : type,
      
        beforeSend: function(jqXHR, settings) {
            loading_blocker.addClass("block-enabled");
            ajaxIndicator.indicate();
        },
      
        success : function(data, textStatus, jqXHR) {
            container.html(data);
            loading_blocker.removeClass("block-enabled");
            ajaxIndicator.disappear();
        },
      
        error : function(jqXHR, textStatus, errorThrown) {
            Ajax.handleError(jqXHR, textStatus, errorThrown);
            loading_blocker.removeClass("block-enabled");
            ajaxIndicator.disappear();
        }
    
    });

}


$(function() {

    $(document).on('click', 'div.widget a:not(.noajax)', function(event) {
        Ajax.initiator(this);
        event.preventDefault(); 
    });

    $(document).on('submit', 'form:not(.noajax)', function(event) {
        Ajax.initiator(this);
        event.preventDefault();
    });

});
