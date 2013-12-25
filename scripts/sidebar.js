$(document).ready(function() {
  // Accordion
  if (document.location.hash == "" || document.location.hash == "#") {
    $("div.section.default h1").click();
  }

  $("a[href*='#']").click(function(e) {
    var target = $(this).attr("href");
    var current = window.location.hash;
    console.log(target, current);
    if (target == current) {
      console.log("AWMG");
      window.location.hash = "";
      e.preventDefault();
    }
  });
  
  // Logout
  $("a#logout").click(function(e) {
    top.logout();
    return false;
  });



});