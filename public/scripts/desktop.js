$(function() {

    $(document).on("click", "div#widget-button-home-menu", function(event) {
        var menuVisible = $("div#widget-homemenu").is(":visible");
        console.log(menuVisible);

        if (!menuVisible) {
            $("div#widget-homemenu").slideDown(100, function() {
                $(document).one("click", function(event) {
                    $("div#widget-homemenu").slideUp(100);
                    $("div#widget-button-home-menu").removeClass("active");
                });
            });
            $("div#widget-button-home-menu").addClass("active");
        } else {
            $("div#widget-homemenu").slideUp(100);
            $("div#widget-button-home-menu").removeClass("active");
        }
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

