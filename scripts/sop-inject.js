document.domain = "minecraft.pt";


// hide dynmap elements
$(window.top.document).find("iframe#map").load(function() {
	this.contentWindow.$('head').append('<link rel="stylesheet" type="text/css" href="//www.minecraft.pt/styles/dynmap-patch.css">');
});

