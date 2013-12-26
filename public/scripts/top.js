// toggle the VISIBILITY property
// used by the mozilla 
jQuery.fn.visibilityToggle = function() {
    return this.css('visibility', function(i, visibility) {
        return (visibility == 'visible') ? 'hidden' : 'visible';
    });
}

// call top.logout() to terminate your session!
function logout() {
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

function hideChat() {
  // mozilla unloads the swf when display none ;_;
  if ($.browser.mozilla) {
    $("div#window").css("visibility", "hidden");
  } else {
    $("div#window").hide();
  } 
  $("div#button-chat").show();
}

function showChat() {
  if ($.browser.mozilla) {
    $("div#window").css("visibility", "visible");
  } else {
    $("div#window").show();
  }
  $("div#button-chat").hide();
}

function hideNews() {
  $("div#sidebar").hide();
  $("div#button-news").show();
}

function showNews() {
  $("div#sidebar").show();
  $("div#button-news").hide();
}

function toggleChat() {
    if ($.browser.mozilla) {
      $("div#window").visibilityToggle();
    } else {
      $("div#window").toggle();
    }
    $("div#button-chat").fadeToggle({'duration':150});

    var p = getCookie("showChat");
    if (p === undefined) {
        p = 1;
    }
    p = p == 0 ? 1 : 0;
    setCookie("showChat", p);
}

function toggleNews() {
    $("div#sidebar").fadeToggle({'duration':150});
    $("div#button-news").fadeToggle({'duration':150})
    var p = getCookie("showNews");
    if (p === undefined) {
        p = 1;
    }
    p = p == 0 ? 1 : 0;
    setCookie("showNews", p);
}

function dockChat() {
  $("div#window").css('left', '6px');
  $("div#window").css('bottom', '6px');
  $("div#window").css('top', '');
  savePosition();
}

function chatHilight(command) {
  if (!$("div#window").is(":visible") || ($("div#window").css("visibility") == "hidden")) {
    $("div#button-chat").addClass("activity");
    $("div#button-chat").one("click", function() {
      $("div#button-chat").removeClass("activity");
    });
  }
}

function savePosition() {
  setCookie("chatPosLeft", $("div#window").css("left"));
  setCookie("chatPosTop", $("div#window").css("top"));
  setCookie("chatSizeWidth", $("div#window").css("width"));
  setCookie("chatSizeHeight", $("div#window").css("height"));
}
$(function() {
  var pref = getCookie("showChat");
  if (pref == 0) {
    hideChat();
  } else {
    showChat();
  }

  pref = getCookie("showNews");
  if (pref == 0) {
    hideNews();
  } else {
    showNews();
  }
  
  var l = getCookie("chatPosLeft");
  var t = getCookie("chatPosTop");
  var w = getCookie("chatSizeWidth");
  var h = getCookie("chatSizeHeight");

  if (l !== undefined) $("div#window").css("left", l);;
  if (t !== undefined) $("div#window").css("top", t);
  if (w !== undefined) $("div#window").width(w);
  if (h !== undefined) $("div#window").height(h);

  $("#button-chat, .window-minimize").click(toggleChat);
  $("#button-news").click(toggleNews);

  $("div#window").draggable({
    addClasses: false,
    iframeFix: true,
    cancel: ".nointeraction",
    handle: "div.window-drag",
    stop: function(event, ui) {
      var l = $("div#window").css("left");
      var t = $("div#window").css("top");
      savePosition();
    }
  });

  $("div#window").resizable({ 
    handles: { 'se' : 'div.window-resize' },
    minHeight: 200,
    minWidth: 400,
    start: function(event, ui) {
      $("iframe").css('pointer-events', 'none');
    },
    stop: function(event, ui) {
      $("iframe").css('pointer-events', 'auto');
      var w = $("div#window").width();
      var h = $("div#window").height();
      savePosition();
    },
  });

 $("div.window-dock").click(function() {
   dockChat();
  });
});
