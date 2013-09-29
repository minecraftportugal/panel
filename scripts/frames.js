// redirect to home if not loaded in frame.
// execute asap, not when dom loaded
if (window.self == window.top) {
  window.top.location.href = "/";
}

$(document).ready(function() {
  $('span.stevehead > img.pixels').each(function() {
    var ds = $(this).attr('data-src');

    var img = new Image();
    var defimg = this;
   
    var head = function(i) {
        var c = document.createElement('canvas');
        $(c).addClass('pixels');
        var w = c.width = i.width * 2; // XXX ¯\(°_o)/¯
        var h = c.height = i.height * 2;

        $(defimg).replaceWith(c);

        var ctx = c.getContext('2d');
        ctx.imageSmoothingEnabled = false;
        ctx.mozImageSmoothingEnabled = false;
        ctx.oImageSmoothingEnabled = false;
        ctx.webkitImageSmoothingEnabled = false;
        ctx.drawImage(i, 0, 0, w, h);
        ctx.drawImage(i, -w/2, 0, w, h); // nice hat
    }

    img.onload = function() {
      if(this.width < 64 || this.height < 32) {
        // damn you amazdong
        img = defimg;
      }
      head(img)
    }

    img.onerror = function() {
      head(defimg);
    }

    img.src = ds;
  });

  // Accordion
  $("div.section.default h1").click();
  
});



