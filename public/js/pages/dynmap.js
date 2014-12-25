$(function() {

    $(document).on("click", function (event) {
        if (event.which === 2)
            event.preventDefault();
    });

    var loadingDelay = 500;

    $("body").prepend('<div class="dynmap-custom-controls"></div>');

    $("body").append('<div class="dynmap-loading-cover"></div>');

    var modifyInterface = setTimeout(function() {

        $("div.dynmap-custom-controls").parent()
            .append("<div class='overlay'><div class='overlay-worlds'></div><div class='overlay-players'></div><div class='overlay-layers'></div></div>");

        $("div.largeclock")
            .detach().appendTo("div.dynmap-custom-controls");

        $("div.leaflet-control-zoom, div.leaflet-control-layers-toggle")
            .detach().appendTo("div.dynmap-custom-controls");

        $("div.dynmap-custom-controls")
            .append("<div class='overlay_button'><a href='#'></a></div>");

        $("div.leaflet-control")
            .detach().appendTo("div.dynmap-custom-controls");

        $("ul.worldlist").detach().appendTo("div.overlay-worlds");
        $("ul.playerlist").detach().appendTo("div.overlay-players");
        $("form.leaflet-control-layers-list").detach().appendTo("div.overlay-layers");

        $("ul.playerlist").prepend("<h1>Jogadores</h1>");
        $("ul.worldlist").prepend("<h1>Mundos</h1>");
        $("form.leaflet-control-layers-list").prepend("<h1>Layers</h1>");

        $("div.sidebar").remove();
        $("div.leaflet-control-layers").remove();

        $("div.overlay_button").click(function() {
            $("div.dynmap-custom-controls").css("visibility", "hidden");
            $("div.overlay").fadeIn(250, function() {

            })
        });

        $("div.overlay").click(function() {
            $("div.dynmap-custom-controls").css("visibility", "visible");
            $(this).fadeOut(250, function() {

            })
        });

        $("div.dynmap-loading-cover").fadeOut(100);
        $("div.dynmap-custom-controls").css("visibility", "visible");

    }, loadingDelay);
});