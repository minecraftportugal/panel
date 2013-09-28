// redirect to home if not loaded in frame.
// execute asap, not when dom loaded
if (window.self == window.top) {
  window.top.location.href = "/";
}

$(document).ready(function() {
  $('span.stevehead > img.pixels').each(function() {
    var ds = $(this).attr('data-src');
    var defimg = $(this).attr('src');

    // try to prevent load events and src changing simultaneously
    //$(this).attr('src', '');
    $(this).removeAttr('src');

    $(this)
      .one('error', function(){
        $(this).attr('src', defimg);
      })
      .on('load', function(){
        // webkit anti image smoothing hack
        var c = document.createElement('canvas');
        $(c).addClass('pixels');
        var w = c.width = this.width;
        var h = c.height = this.height;
        $(this).replaceWith(c);

        var ctx = c.getContext('2d');
        ctx.imageSmoothingEnabled = false;
        ctx.mozImageSmoothingEnabled = false;
        ctx.oImageSmoothingEnabled = false;
        ctx.webkitImageSmoothingEnabled = false;
        ctx.drawImage(this, 0, 0, w, h);
        ctx.drawImage(this, -w/2, 0, w, h); // nice hat
      })
      .attr('src', ds);
  });

    $("div.section.default h1").click();
});

