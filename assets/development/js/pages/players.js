// bypass same origin policy
document.domain = "minecraft.pt";

function tryResize() {
    try {
        var f = $("#widget_players", parent.document.body);
    } catch(e) {
        return false;
    }
    f.height($(document.body).height());
    return true;
}

$(document).ready(function() {
    var i = setInterval(function() {
        if (tryResize()) {
            clearInterval(i);
        }
    }, 50);
});
