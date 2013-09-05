//i18n links

$(function() {
  $("a[data-lang]").click(function() {
    var lang = $(this).data("lang");
    setCookie("i18n", lang);
    location.reload();
  });
});
