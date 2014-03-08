// toggle the VISIBILITY property
// used by the mozilla 
jQuery.fn.visibilityToggle = function() {
    return this.css('visibility', function(i, visibility) {
        return (visibility == 'visible') ? 'hidden' : 'visible';
    });
}

// call top.logout() to terminate your session!
window.logout = function() {
    var form = $('<form></form>');
    form.attr("method", "post");
    form.attr("action", "/logout");

    var field = $('<input></input>');
    field.attr("type", "hidden");
    field.attr("name", "logout");
    field.attr("value", "1");

    form.append(field);
    
    var xsrf_token = $('meta[name=xsrf_token]').attr('content');
    field = $('<input></input>');
    field.attr("type", "hidden");
    field.attr("name", "xsrf_token");
    field.attr("value", xsrf_token);

    form.append(field);

    $(document.body).append(form);
    form.submit(); 
}

function chatHilight(command) {
  if (!$("div#window").is(":visible") || ($("div#window").css("visibility") == "hidden")) {
    $("div#button-chat").addClass("activity");
    $("div#button-chat").one("click", function() {
      $("div#button-chat").removeClass("activity");
    });
  }
}

$(function() {


  widgetTest = new Widget({
    'name': 'test',
    'url' : '/news', 
    'title' : 'Test Title'
  });

  widget2 = new Widget({
    'name' : 'chat',
    'url' : '/irc',
    'title' : 'IRC/Chat',
    useIframe : true
  });

  w3 = new Widget({
    'name' : 'tickl',
    'url' : '/profile?id=6',
    'title' : 'Man of the Year'
  });

  w4 = new Widget({
    'name':'dynmap',
    'url':'//dynmap.minecraft.pt',
    'title':'Dynamic Map',
    'useIframe':true
  });
});

var widgetTest, widget2, w3, w4;
