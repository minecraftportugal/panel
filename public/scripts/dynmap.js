var urlDefault = "//dynmap.minecraft.pt/";

function getDynmap() {
  var dynmap;
  try {
    dynmap = $(window.top.document).find("iframe#map")[0].contentWindow.dynmap;
  } catch(e) {
    dynmap = null;
  }

  return dynmap;
}

$(function() {

  $("[data-dynmap-copy]").each(function(n, elem) {
    var target = $(elem).data("dynmap-copy");
    var dynmap = getDynmap();

    var object = dynmap[target].clone(true);
    object.unmousewheel();

    if ($(this).attr("data-dynmap-set-anchor") !== undefined) {
      var anchor = $(this).attr("data-dynmap-set-anchor");
        $(object).find("a").attr("href", anchor);
    }

    $(elem).append(object);

    if ($(this).attr("data-dynmap-fix-images") == "true") {
      $(this).find("img").each(function(n, elem) {
        var src = $(elem).attr("src").replace("16x16", "32x32");
        $(elem).attr("src", urlDefault+src)
      });
    }
  });

});

