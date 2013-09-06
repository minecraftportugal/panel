jQuery.fn.visibilityToggle = function() {
    return this.css('visibility', function(i, visibility) {
        return (visibility == 'visible') ? 'hidden' : 'visible';
    });
}

function logout() {
    var form = $('<form></form>');
    form.attr("method", "post");
    form.attr("action", "login/index.php");

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
    $("div#sitechat").css("visibility", "hidden");
  } else {
    $("div#sitechat").hide();
  }
  $("div#button-chat").show();
}

function showChat() {
  if ($.browser.mozilla) {
    $("div#sitechat").css("visibility", "visible");
  } else {
    $("div#sitechat").show();
  }
  $("div#button-chat").hide();
}

function hideNews() {
  $("div#sitenews").hide();
  $("div#button-news").show();
}

function showNews() {
  $("div#sitenews").show();
  $("div#button-news").hide();
}

function toggleChat() {
    if ($.browser.mozilla) {
      $("div#sitechat").visibilityToggle();
    } else {
      $("div#sitechat").toggle();
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
    $("div#sitenews").fadeToggle({'duration':150});
    $("div#button-news").fadeToggle({'duration':150})
    var p = getCookie("showNews");
    if (p === undefined) {
        p = 1;
    }
    p = p == 0 ? 1 : 0;
    setCookie("showNews", p);
}

function dockChat() {
  $("div#sitechat").css('left', '6px');
  $("div#sitechat").css('bottom', '6px');
  $("div#sitechat").css('top', '');
  savePosition();
}

function chatHilight(command) {
  if (!$("div#sitechat").is(":visible") || ($("div#sitechat").css("visibility") == "hidden")) {
    $("div#button-chat").addClass("activity");
    $("div#button-chat").one("click", function() {
      $("div#button-chat").removeClass("activity");
    });
  }
  //console.log(command);
}

function savePosition() {
  setCookie("chatPosLeft", $("div#sitechat").css("left"));
  setCookie("chatPosTop", $("div#sitechat").css("top"));
  setCookie("chatSizeWidth", $("div#sitechat").css("width"));
  setCookie("chatSizeHeight", $("div#sitechat").css("height"));
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

  if (l !== undefined) $("div#sitechat").css("left", l);;
  if (t !== undefined) $("div#sitechat").css("top", t);
  if (w !== undefined) $("div#sitechat").width(w);
  if (h !== undefined) $("div#sitechat").height(h);

  $("#button-chat, #minimize").click(toggleChat);
  $("#button-news").click(toggleNews);

  $("div#sitechat").draggable({
    addClasses: false,
    iframeFix: true,
    cancel: ".nointeraction",
    handle: "div#drag",
    stop: function(event, ui) {
      var l = $("div#sitechat").css("left");
      var t = $("div#sitechat").css("top");
      savePosition();
    }
  });

  $("div#sitechat").resizable({ 
    handles: { 'se' : 'div#resize' },
    minHeight: 200,
    minWidth: 400,
    start: function(event, ui) {
      $("iframe").css('pointer-events', 'none');
    },
    stop: function(event, ui) {
      $("iframe").css('pointer-events', 'auto');
      var w = $("div#sitechat").width();
      var h = $("div#sitechat").height();
      savePosition();
    },
  });

 $("div#dock").click(function() {
   dockChat();
  });
});
