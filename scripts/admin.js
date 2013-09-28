$(function() {
  $("a#logout").click(function(e) {
    top.logout();
    return false;
  });

  $("input#select_a").click(function() {
  	var checked = $(this).is(":checked");
  	if (checked) {
  		$('tr[data-no-login=true] input[name="delete[]"]:not(:checked)').click();
  	}

  });
});
