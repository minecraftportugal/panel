$(document).ready(function() {
  // Accordion
  if (document.location.hash == "" || document.location.hash == "#") {
    $("div.section.default h1").click();
  }

  // Logout
  $("a#logout").click(function(e) {
    top.logout();
    return false;
  });

});