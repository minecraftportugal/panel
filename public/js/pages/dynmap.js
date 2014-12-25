$(function() {

    var loadingDelay = 500;

    $("body").prepend('<div class="dynmap-custom-controls"></div>');

    $("body").append('<div class="dynmap-loading-cover"></div>');

    var modifyInterface = setTimeout(function() {
        $("div.largeclock")
            .detach().appendTo("div.dynmap-custom-controls");
        $("div.leaflet-control-zoom, div.leaflet-control-layers-toggle, div.leaflet-control")
            .detach().appendTo("div.dynmap-custom-controls");

        $("div.dynmap-custom-controls")
            .append("<div class='overlay_button'>Escolher Jogador/Mundo</div>");
        $("div.dynmap-custom-controls").parent()
            .append("<div class='overlay'><div class='overlay-left'></div><div class='overlay-right'></div></div>");

        $("ul.worldlist").detach().appendTo("div.overlay-left");
        $("ul.playerlist").detach().appendTo("div.overlay-right");

        $("ul.playerlist").prepend("<h1>Jogadores</h1>");
        $("ul.worldlist").prepend("<h1>Mundos</h1>");

        $("ul.worldlist li.world").each(function() {
            var text = $(this).contents().get(0).wholeText;

        });

        $("div.sidebar").remove();

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

        $("div.dynmap-loading-cover").remove();
        $("div.dynmap-custom-controls").css("visibility", "visible");

    }, loadingDelay);
});