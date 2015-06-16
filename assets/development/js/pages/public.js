$(function() {

  $("input").keypress(function(e) {
    if (e.which ==  13) {
      e.preventDefault();
      $("input[type=submit]").click();
    }
  });

  $("span.email").html("mail" + "&#64;" + "minecraft.pt");
});