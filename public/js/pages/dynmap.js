$(function() {
    $("body").prepend('<div class="dynmap-custom-controls"></div>');

    var modifyInterface = setTimeout(function() {
        $("div.largeclock")
            .detach().appendTo("div.dynmap-custom-controls");
        $("div.leaflet-control-zoom, div.leaflet-control-layers-toggle, div.leaflet-control")
            .detach().appendTo("div.dynmap-custom-controls");

        $("div.dynmap-custom-controls")
            .append("<div class='playerlist'>Players</div>")
            .append("<div class='worldlist'>Worlds</div>");

        $("ul.worldlist").detach().appendTo("div.worldlist");
        $("ul.playerlist").detach().appendTo("div.playerlist");

        $("div.sidebar").remove();
    }, 600);
});