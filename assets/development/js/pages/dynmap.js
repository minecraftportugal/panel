$(function() {

    var uiTransformInit = function() {

        $(document).on("click", function (event) {
            if (event.which === 2)
                event.preventDefault();
        });

        $("body").prepend('<div class="dynmap-custom-controls"></div>');

        $("body").append('<div class="dynmap-loading-cover"></div>');
    };

    var mainInterfaceSetup = function() {
        /*
         * General UI changes
         */


        $("div.dynmap-custom-controls").parent()
            .append("<div>" +
                "<div class='overlay overlay-worlds'></div>" +
                "<div class='overlay overlay-players'></div>" +
                "<div class='overlay overlay-layers'></div>" +
                "<div class='overlay overlay-markers'></div>" +
                "</div>");

        $("div.largeclock")
            .detach().appendTo("div.dynmap-custom-controls");

        $("div.leaflet-control-zoom, div.leaflet-control-layers-toggle")
            .detach().appendTo("div.dynmap-custom-controls");

        $("div.dynmap-custom-controls")
            .append("<div class='overlay_button overlay_button_worlds'><a href='#'></a></div>").attr("title", "Mundos")
            .append("<div class='overlay_button overlay_button_layers'><a href='#'></a></div>").attr("title", "Layers")
            .append("<div class='overlay_button overlay_button_players'><a href='#'></a></div>").attr("title", "Jogadores")
            .append("<div class='overlay_button overlay_button_markers'><a href='#'></a></div>").attr("title", "Mapas");

        $("div.leaflet-control")
            .detach().appendTo("div.dynmap-custom-controls");

        $("ul.worldlist").detach().appendTo("div.overlay-worlds");
        $("ul.playerlist").detach().appendTo("div.overlay-players");
        $("form.leaflet-control-layers-list").detach().appendTo("div.overlay-layers");

        $("<ul></ul>").addClass("markerlist").appendTo("div.overlay-markers");
        var $playercontrols = $("<ul></ul>").addClass("playercontrols").appendTo("div.overlay-players");

        var $stopfollow =  $("<li></li>").append("<a>parar de seguir jogador</a>").attr("id", "stopFollowing").click(function() {
            dynmap.followPlayer(null);
        });
        $playercontrols.append($stopfollow);

        $("ul.playerlist")
            .parent()
            .prepend("<h1>Jogadores</h1>")
            .append("<p>Clica no ícone da cabeça de um jogador para o marcar e seguir automáticamente.</p>" +
                   "<p>Clica na área à volta do nome para saltar para a sua posição apenas.</p>")
            .append($playercontrols);

        $("ul.worldlist").parent().prepend("<h1>Mundos</h1>");
        $("form.leaflet-control-layers-list").parent().prepend("<h1>Layers</h1>").addClass("overlay-title");
        $("ul.markerlist").parent().prepend("<h1>Markers</h1>");

        $("div.sidebar").remove();
        $("div.leaflet-control-layers").remove();

        $("div.overlay_button_worlds").click(function() {
            $("div.dynmap-custom-controls").css("visibility", "hidden");
            $("div.overlay-worlds").fadeIn(250, function() { })
        });

        $("div.overlay_button_layers").click(function() {
            $("div.dynmap-custom-controls").css("visibility", "hidden");
            $("div.overlay-layers").fadeIn(250, function() { })
        });

        $("div.overlay_button_players").click(function() {
            $("div.dynmap-custom-controls").css("visibility", "hidden");
            $("div.overlay-players").fadeIn(250, function() { })
        });

        $("div.overlay_button_markers").click(function() {
            $("div.dynmap-custom-controls").css("visibility", "hidden");
            $("div.overlay-markers").fadeIn(250, function() { })
        });

        $("div.overlay").click(function(e) {
            $("div.dynmap-custom-controls").css("visibility", "visible");
            $(this).fadeOut(250, function () { });
        });


        $("div.dynmap-custom-controls").css("visibility", "visible");


        /*
         * Copy location to clipboard
         */
        $(document).keydown(function(e) {
            var text = Math.round(window.dynmap.loc.x) + " " + Math.round(window.dynmap.loc.y) + " " + Math.round(window.dynmap.loc.z);
            if ((e.keyCode == 67) && (!!window.dynmap.loc)) {
                window.prompt("Copy to clipboard: Ctrl+C, Enter", text);
            }
        });

        dynmap.map.on('mousemove', function(mevent) {
            var loc = dynmap.getProjection().fromLatLngToLocation(mevent.latlng, dynmap.world.sealevel+1);
            window.dynmap.loc = loc;
        });

        dynmap.map.on('mouseout', function(mevent) {
            window.dynmap.loc = null;
        });

    };

    var dynmapMarkerSetup = function() {

        /* load markers list */
        var $markerlist = $("ul.markerlist");
        $markerlist.empty();
        $.each(window.dynmapmarkersets, function(k, v) {

            if ((!v.markers) || (Object.keys(v.markers).length === 0)) {
                return;
            }

            var $li = $("<li></li>").addClass("markerset-label");
            $li.append($("<span></span>").html(v.label));
            $li.appendTo($markerlist);


            var $ul = $("<ul></ul>").addClass("markers");;
            $.each(v.markers, function(k, v) {

                if (!v && v.hasOwnProperty('x') && v.hasOwnProperty('y') && v.hasOwnProperty('z')) {
                    return;
                }

                var $li = $("<li></li>").html(v.label.replace(" [home]", "").replace("<br/>", " ")).addClass("marker-label");
                $li.css("background-image", "url(/tiles/_markers_/" + v.icon + ".png)");
                $li.click(function(e) {
                    var dynmapLoc = { x : v.x, y : v.y, z : v.z };
                    var leafletLoc = window.dynmap.getProjection().fromLocationToLatLng(dynmapLoc);
                    window.dynmap.map.panTo(leafletLoc);
                });
                $li.appendTo($ul);
            });

            $li = $("<li></li>");
            $ul.appendTo($li);
            $li.appendTo($markerlist);


        });

        $("div.dynmap-loading-cover").fadeOut(100);
    };


    var loadingDelay = 500;

    uiTransformInit();

    setTimeout(function() {



        mainInterfaceSetup();

        dynmapMarkerSetup();

        $(dynmap).bind("mapchanged", function(e) {
            setTimeout(dynmapMarkerSetup, loadingDelay);
        });

        $(dynmap).bind("mapchanging", function(e) {
        });

    }, loadingDelay);


});