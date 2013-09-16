// redirect to home if not loaded in frame.
// execute asap, not when dom loaded
if (window.self == window.top) {
  window.top.location.href = "/";
}

$(document).ready(function() {
  $('span.stevehead > img.pixels')
    .on('error', function(){
      $(this).attr('src', '/images/steve.png');
    })
    .on('load', function(){
      // webkit anti image smothing hack
      if (navigator.userAgent.indexOf("AppleWebKit") == -1)
        return;

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
    })
    .attr('src', function(){
      return $(this).attr('data-src');
    });
});

