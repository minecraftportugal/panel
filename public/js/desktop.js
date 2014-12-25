App.Desktop = {


};

App.Desktop.toasters = [];

/* todo: args in object */
App.Desktop.toasterFadeIn = function(params) {

    var defaults = {

        "title" : "Toaster Title",
        "message" : "The message that goes on the toaster balloon tip! You should add stylings to this!",
        "classes" : "neutral",
        "duration" : 500,
        "unclickable" : false,
        "hovertip" : false

    };

    var options = {};

    /* Mix given options and defaults */
    $.extend(options, defaults);
    $.extend(options, params);

    var $toaster = $("div#html-templates div#toaster-template > div").clone();

    $toaster.css("display", "none");

    $toaster.find("div.toaster-title").html(options.title);
    $toaster.find("div.toaster-body").html(options.message);

    $toaster.addClass(options.classes);

    $toaster.appendTo("body");


    $toaster.click(function() {
        $toaster.fadeOut(500, function() {
            $toaster.remove();
        });
    });

    $.each(App.Desktop.toasters, function(n, elem) {
       $(elem).remove();
    });

    App.Desktop.toasters.push($toaster);

    $toaster.fadeIn(500, function() {

        if (options.duration > 0) {
            setTimeout(function() {
                $toaster.fadeOut(250, function() {
                    $toaster.remove();
                });
            }, options.duration);
        }
    });

};

App.Desktop.toasterFadeOut = function() {
    $.each(App.Desktop.toasters, function(n, elem) {
        $(elem).remove();
    });
};