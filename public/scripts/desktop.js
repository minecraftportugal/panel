

$(function() {
    if (window.menuOpened === undefined) {
        window.menuOpened = false; // <3 global namespace
    }

    $(document).on("click", "div#top-bar ul li", function(event) {
        $(this).parent().parent().children("ul").removeClass("menu-selected");
        $(this).parent().addClass("menu-selected");
        event.stopPropagation();
    });

    $(document).click(function(event) {
        $("ul.menu-selected").removeClass("menu-selected");
    });
});
