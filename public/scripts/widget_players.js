// bypass same origin policy
document.domain = "minecraft.pt";

// redirect to /forbidden if not loaded in frame.
// execute asap, not when dom loaded
if (window.self == window.top) {
  window.top.location.href = "/forbidden";
}

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
