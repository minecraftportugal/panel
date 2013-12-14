$(function() {

  $("h2#select-all-active").click(function() {
  	$("input.fake-active").click();
  });

  $("h2#select-all-delete").click(function() {
    $("input.check-delete").click();
  });

  $("input.fakecheckbox").click(function() {
    var value = $(this).is(":checked") ? 1 : 0;
    $(this).next().val(value);
  });

});
