$(function() {
    if (window.menuOpened === undefined) {
        window.menuOpened = false; // <3 window
    }

    $(document).on("click", "div#widget-button-home-menu", function(event) {
        $("")
        event.stopPropagation();
    });

    $(document).on("click", "div#widget-button-container-minimize-all", function(event) {
        Widget.minimizeAll();
        event.stopPropagation();
    });


    $(document).mousedown(function(event) {
        $("ul.menu-selected").removeClass("menu-selected");
    });


    $("div#widget-button-container-scroll-left").mousedown(function() {
        var interval = setInterval(function() {
            $('div#widget-button-container').scrollTo({top:'+=0', left:'-=10'}, 5);
        }, 20);
        $(document).one("mouseup", function() {
            clearInterval(interval);
        });
    });

    $("div#widget-button-container-scroll-right").mousedown(function() {
        var interval = setInterval(function() {
            $('div#widget-button-container').scrollTo({top:'+=0', left:'+=10'}, 5);
        }, 20);
        $(document).one("mouseup", function() {
            clearInterval(interval);
        })
    });
});

