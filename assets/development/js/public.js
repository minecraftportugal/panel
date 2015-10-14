App.Public = {};

App.Public.load = function() {

  $("input").keypress(function(e) {
    if (e.which == 13) {
      e.preventDefault();
      $(this).closest("form").find("button[type=submit]").click();
    }
  });

  $("span.email").html("mail" + "&#64;" + "mcpt.eu");

};