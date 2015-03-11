/* On DOM loaded... */
$(function() {

    /* Open menus with oepn-menu data- API */
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

    /* Click on Button: minimize all */
    $(document).on("click", "a#menu-container-minimize-all", function(event) {
        App.Widget.minimizeAll();
    });

    /* Click on Button: tile */
    $(document).on("click", "a#menu-container-tile", function(event) {
        App.Widget.tile();
    });

    /* Click on Button: cascade */
    $(document).on("click", "a#menu-container-cascade", function(event) {
        App.Widget.cascade();
    });

    /* Click on Button: embiggen */
    $(document).on("click", "a#menu-container-embiggen", function(event) {
        App.Widget.embiggen();
    });

    /* Click on Button: close all */
    $(document).on("click", "a#menu-close-all", function(event) {
        App.Widget.closeAll();
    });

    /* Click on Button: reset */
    $(document).on("click", "a#menu-reset-widgets", function(event) {
        App.Widget.clearState();
    });

    /* Click on Button: logout */
    $(document).on("click", "a#menu-logout", function(event) {
        App.Widget.open("logout");
    });

    /* OnMouseDown: hide opened menus */
    $(document).mousedown(function(event) {
        $("ul.menu-selected").removeClass("menu-selected");
    });

    /* OnMouseDown: scroll taskbar left */
    $("div#widget-button-container-scroll-left").mousedown(function() {
        var interval = setInterval(function() {
            $('div#widget-button-container').scrollTo({top:'+=0', left:'-=10'}, 5);
        }, 20);
        $(document).one("mouseup", function() {
            clearInterval(interval);
        });
    });

    /* OnMouseDown: scroll taskbar right */
    $("div#widget-button-container-scroll-right").mousedown(function() {
        var interval = setInterval(function() {
            $('div#widget-button-container').scrollTo({top:'+=0', left:'+=10'}, 5);
        }, 20);
        $(document).one("mouseup", function() {
            clearInterval(interval);
        })
    });

    /* OnClick: fake checkboxes */
    $(document).on("click", "input.fake-checkbox", function() {
        var value = $(this).is(":checked") ? 1 : 0;
        $(this).next().val(value);
    });

    /* OnClick: fake form reset */
    $(document).on("click", "input[type=reset]", function() {
        var $form = $(this).closest("form");
        $form.find("input[type=text]").attr("value", "");
        $form.find("input[type=date]").attr("value", "");
        $form.find("input[type=checkbox]").attr("checked", false);

        $form.submit();
    });

    /* OnClick: collapsible */
    $(document).on("click", "div.layout-col-clickable.layout-col-collapsible", function() {
        $(this).closest("div.layout-col").toggleClass("collapsed");
    });

    /* OnHover: Show menu toaster context help */
    $("[role=toaster-launcher]").hover(
        function(event) {
            var title = $(this).html();
            var id = $(this).attr("id");
            var message = $(this).parent().clone().find("span[rel=" + id + "]").html();

            if (App.settings.showBaloonTips) {

                var classes = "neutral";
                if (event.pageX > window.innerWidth / 2) {
                    classes += " otherside";
                }

                App.Toaster.fadeIn({
                    "title" : title,
                    "message" : message,
                    "duration" : 0,
                    "classes" : classes
                });

            }
        },
        function() {

            App.Toaster.fadeOut();

        }
    );

    $(document).on("click", function (event) {
        if (event.which === 2)
            event.preventDefault();
    });

    /* it's hash time! */
    window.location = "#";
});