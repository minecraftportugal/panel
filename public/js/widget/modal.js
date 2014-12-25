App.Widget.Modal = function(options) {

    App.Widget.Modal.options = {
        "name" : "default",
        "title" : "Title",
        "body" : undefined,
        "url" : undefined,
        "buttons" : {

            "OK" : {
                "callback" : function() {
                    App.Widget.Modal.hide();
                }
            },

            "Cancel" : {
                "callback" : function() {
                    App.Widget.Modal.hide();
                }
            }
        }
    }

    App.Widget.Modal.modalStore = {

    }

    /* Init stops here */
    if (options === undefined) {
        return false;
    }

    /* Innards */
    this.options = {};

    $.extend(this.options, App.Widget.Modal.options);
    $.extend(this.options, options);


    this.id = "modal-" + this.options.name;
    this.selector = "div#modal-" + this.options.name;
}

App.Widget.Modal.show = function(options) {



    var $modal = $("div#modal-template").clone();

    $modal.appendTo("div#widget-container");
    $("div#modal-blocker").fadeIn(100);
}

App.Widget.Modal.hide = function() {

    $("div#widget-container").find("div.modal").remove();
    $("div#modal-blocker").fadeOut(100);

}

//App.Widget.Modal._init();