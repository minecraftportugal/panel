var urlDefault = "//dynmap.minecraft.pt/";
var urlChangePlayer = "//dynmap.minecraft.pt/?playername=#{1}";

function getDynmap() {
  var dynmap;
  try {
    dynmap = $(window.top.document).find("iframe#map")[0].contentWindow.dynmap;
  } catch(e) {
  	console.log(e);
  	dynmap = null;
  }

  return dynmap;
}

$(function() {


	$("a[data-dynmap-gotoplayer]").click(function() {
		var playername = $(this).data("dynmap-gotoplayer");
		var isOnline = $(this).data("online");
		if (isOnline) {
			var gotoUrl = urlChangePlayer.replace("#{1}", playername);
			var currentSrc = $(window.top.document).find("iframe#map").attr("src");
			if (currentSrc != gotoUrl) {
			    $(window.top.document).find("iframe#map").attr("src", gotoUrl);
			}
		}
	});

	$("a[data-dynmap-default]").click(function() {
		var gotoUrl = urlDefault;
		var currentSrc = $(window.top.document).find("iframe#map").attr("src");
		if (currentSrc != gotoUrl) {
   	  	    $(window.top.document).find("iframe#map").attr("src", gotoUrl);
   		}
	});

	$("[data-dynmap-copy]").each(function(n, elem) {
		var target = $(elem).data("dynmap-copy");
		var dynmap = getDynmap();
		var object = dynmap[target].clone(true);

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

