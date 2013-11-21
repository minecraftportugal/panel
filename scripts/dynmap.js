var urlDefault = "http://dynmap.minecraft.pt/";
var urlChangePlayer = "http://dynmap.minecraft.pt/?playername=#{1}&mapname=surface";

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
});