$(function() {

    $(document).on("click", "div[data-open-menu]", function(event) {
        var $button = $(this);
        var menu_selector = $button.data("open-menu");
        var $menu = $(menu_selector);

        var menuVisible = $menu.is(":visible");
        if (!menuVisible) {
            $menu.slideDown(100, function() {
                $(document).one("click", function(event) {
                    $menu.slideUp(100);
                    $button.removeClass("active");
                });
            });
            $button.addClass("active");
        } else {
            $menu.slideUp(100);
            $button.removeClass("active");
        }
        //event.stopPropagation();
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

