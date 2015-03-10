App.Toaster = {


};

App.Toaster.toasters = [];

App.Toaster.fadeIn = function(params) {

    var defaults = {

        "title" : "Toaster Title",
        "message" : "The message that goes on the toaster balloon tip! You should add stylings to this!",
        "classes" : "neutral",
        "fadeInDuration" : 250,
        "duration" : 500,
        "fadeOutDuration" : 250,
        "unclickable" : false,
        "hovertip" : false,
        "sound" : null

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
        $toaster.fadeOut(options.fadeOutDuration, function() {
            $toaster.remove();
        });
    });

    $.each(App.Toaster.toasters, function(n, elem) {
       $(elem).remove();
    });

    App.Toaster.toasters.push($toaster);

    $toaster.fadeIn(options.fadeInDuration, function() {

        if (options.sound) {
            App.Sound.play(options.sound);
        }

        if (options.duration > 0) {
            setTimeout(function() {
                $toaster.fadeOut(250, function() {
                    $toaster.remove();
                });
            }, options.duration);
        }
    });

};

App.Toaster.fadeOut = function() {
    $.each(App.Toaster.toasters, function(n, elem) {
        $(elem).remove();
    });
};