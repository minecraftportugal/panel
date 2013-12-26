$(function() {

  $("input").keypress(function(e) {
    if (e.which ==  13) {
      e.preventDefault();
      $("input[type=submit]").click();
    }
  });

  $(".email").html("mail" + "&#64;" + "minecraftia.pt");

});

var RecaptchaOptions = {
  theme : 'white'
};

// redirect in top if loaded in frame.
// execute asap, not when dom loaded
if (window.self !== window.top) {
  window.top.location.href = window.self.location.href;
}
