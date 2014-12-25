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
    $(document).on("click", "a#widget-button-container-minimize-all", function(event) {
        Widget.minimizeAll();
    });

    /* Click on Button: tile */
    $(document).on("click", "a#widget-button-container-tile", function(event) {
        Widget.tile();
    });

    /* Click on Button: cascade */
    $(document).on("click", "a#widget-button-container-cascade", function(event) {
        Widget.cascade();
    });

    /* Click on Button: embiggen */
    $(document).on("click", "a#widget-button-container-embiggen", function(event) {
        Widget.embiggen();
    });

    /* Click on Button: close all */
    $(document).on("click", "a#menu-close-all", function(event) {
        Widget.closeAll();
    });

    /* Click on Button: reset */
    $(document).on("click", "a#menu-reset-widgets", function(event) {
        Widget.clearState();
    });

    /* Click on Button: logout */
    $(document).on("click", "a#menu-logout", function(event) {
        App.logout();
        event.stopPropagation();
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
        function() {
            var title = $(this).html();
            var id = $(this).attr("id");
            var message = $(this).parent().clone().find("span[rel=" + id + "]").html();

            App.Desktop.toasterFadeIn({
                "title" : title,
                "message" : message,
                "duration" : 0
            });
        },
        function() {
            App.Desktop.toasterFadeOut();
        }
    );

});