$(window).load(function() {

  $("input").keypress(function(e) {
    if (e.which ==  13) {
      e.preventDefault();
      $("input[type=submit]").click();
    }
  });

  $(".email").html("mail" + "&#64;" + "minecraft.pt");

  // Chrome autocomplete shadow
  if (navigator.userAgent.toLowerCase().indexOf("chrome") >= 0) {
      $('input:-webkit-autofill').each(function () {
          var text = $(this).val();
          var name = $(this).attr('name');
          $(this).after(this.outerHTML).remove();
          $('input[name=' + name + ']').val(text);
      });
  }
});



// redirect in top if loaded in frame.
// execute asap, not when dom loaded
if (window.self !== window.top) {
  window.top.location.href = window.self.location.href;
}
