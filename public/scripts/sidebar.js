$(document).ready(function() {
  // Accordion
  if (document.location.hash == "" || document.location.hash == "#") {
    $("div.section.default h1").click();
  }

  $("a[href*='#']").click(function(e) {
    var target = $(this).attr("href");
    var current = window.location.hash;
    if (target == current) {
      window.location.hash = "";
      e.preventDefault();
    }
  });

  $(window).bind("hashchange", function() {
    $(window).scrollTop(0);
  });
  
  // Logout
  $("a#logout").click(function(e) {
    top.logout();
    return false;
  });



});