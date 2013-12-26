// bypass same origin policy on *.minecraft.pt
document.domain = "minecraft.pt";

// hide dynmap elements
$(window.top.document).find("iframe#map").load(function() {
    this.contentWindow.$('head').append('<link rel="stylesheet" type="text/css" href="//www.minecraft.pt/styles/dynmap-patch.css">');
});

// make sure it loads properly inside the panel site
if (window.top.document == window.document) {
    window.location = '//www.minecraft.pt/forbidden'
}