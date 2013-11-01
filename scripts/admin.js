$(function() {
  $("a#logout").click(function(e) {
    top.logout();
    return false;
  });

  $("input#select_a").click(function() {
  	var checked = $(this).is(":checked");
  	if (checked) {
  		$('tr[data-no-login=true] input[name="delete[]"]:not(:checked)').attr("checked", "checked");
  	} else {
      $('tr[data-no-login=true] input[name="delete[]"]:checked').removeAttr("checked");
    }
  });

  $("input.fakecheckbox").click(function() {
    var value = $(this).is(":checked") ? 1 : 0;
    $(this).next().val(value);
    console.log(value);
  });
});
