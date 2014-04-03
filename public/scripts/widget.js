function Widget(options) {

  Widget.options = {
    "url" : "/colorbars",
    "title" : "Title",
    "useIframe" : false,
    "alwaysCreate" : false,
    "maximized" : false,
    "classes" : "widget-not-scrollable",
    "css" : {
      "top": "0px",
      "left": "0px",
      "width" : "800px",
      "height" : "400px",
      "min-width" : "480px",
      "min-height" : "360px",
      "max-width" : null, //"700px",
      "max-height" : null //"700px"
    }
  }

  this.options = {};
  this.options.css = {};

  $.extend(this.options, Widget.options);
  $.extend(this.options, options);

  if (options.css !== undefined) {
    $.extend(this.options.css, options.css);
  }

  if (this.options.alwaysCreate) {
    this.options.name += new Date().getTime();
  }

  this.id = "widget-" + this.options.name;
  this.selector = "div#widget-" + this.options.name;

  this.buttonId = "button-widget-" + this.options.name;
  this.buttonSelector = "div#button-widget-" + this.options.name;

  this.states = [];

  if (Widget.counter === undefined) {
    Widget.counter = 1;
  } else {
    Widget.counter += 1;
  }

  this.serial = Widget.counter;

  var existing = null;
  if (Widget.widgets === undefined) {
    Widget.widgets = [];
  } else {
    var widgetInstance = this;
    $.each(Widget.widgets, function(n, e) {
      if (e.options.name == widgetInstance.options.name) {
        existing = e;
      }
    });
  }

  if (existing == null) {
    this.widget = this;
    Widget.widgets.push(this);
    this._init();
    this._load();
    this._initPosition();
  } else {
    this.bringTop();
    this.setActive();

    if ($(this.buttonSelector).hasClass("minimized")) {
      this.restore();
    }
  }

}

Widget.prototype._init = function() {

  var widget = $("div#html-templates div#widget-template > div").clone();
  var button = $("div#html-templates div#widget-button-template > div").clone();

  this.widget = widget;
  this.button = button;

  $(widget).attr("id", this.id);
  $(widget).find("div.widget-title").html(this.options.title);
  $(widget).appendTo("div#widget-container");

  $(button).attr("id", this.buttonId);
  $(button).html(this.options.title);
  $(button).appendTo("div#widget-button-container");

  $(this.selector).css(this.options.css);

  $(this.selector).find("div.widget-body").addClass(this.options.classes);

  if (this.options.maximized) {
    this.maximize();
  }

  var widgetInstance = this;

  $(this.selector).click(function(event) {
    widgetInstance.setActive();
  });

  $(this.selector).draggable({

    addClasses: false,
    cancel: ".nointeraction",
    handle: "div.widget-drag",
    snap: true,
    snapMode: "outer",
    containment: "parent",
    start: function(event, ui) {
      $("iframe").css("pointer-events", "none");
    },

    stop: function(event, ui) {
      $("iframe").css("pointer-events", "auto");
    }

  });

  $(this.selector).resizable({

    iframeFix: true,
    addClasses: false,
    cancel: ".nointeraction",
    snap: true,
    snapMode: "outer",
    containment: "parent",
    start: function(event, ui) {
      $("iframe").css("pointer-events", "none");
    },

    stop: function(event, ui) {
      $("iframe").css("pointer-events", "auto");
    }

  });

  $(this.selector).find("div.widget-refresh").click(function() {
    widgetInstance._load();
  });

  $(this.selector).find("div.widget-maximize").click(function() {
    if ($(widgetInstance.selector).hasClass("maximized")) {
      widgetInstance.restore();
    } else {
      widgetInstance.maximize();
    }
  });

  $(this.selector).find("div.widget-minimize").click(function() {
    widgetInstance.minimize();
  });

  $(this.selector).find("div.widget-close").click(function() {
    widgetInstance.close();
  });

  $(this.buttonSelector).click(function() {
    if ($(widgetInstance.buttonSelector).hasClass("minimized")) {
      widgetInstance.restore();
    } else {
      if ($(widgetInstance.selector).hasClass("widget-active")) {
        widgetInstance.minimize();
        widgetInstance.unsetActive();
      } else {
        widgetInstance.bringTop();
        widgetInstance.setActive();
      }
    }
  });

  $(this.selector).find("div.widget-drag").mousedown(function() {
    widgetInstance.bringTop();
    widgetInstance.setActive();
  });

  $(this.selector).mousedown(function() {
    widgetInstance.bringTop();
    widgetInstance.setActive();
  });

}

Widget.prototype._load = function() {
  if (this.options.useIframe == true) {

    this.iframeId = this.id + "-iframe";
    var jq_tag = $("<iframe></iframe>");
    jq_tag.attr("id", this.iframeId) ;
    jq_tag.attr("src", this.options.url) ;
    $(this.selector).find("div.widget-body").html(jq_tag);
    $(this.selector).addClass("widget-iframe");

  } else {

    var widgetInstance = this;
    var loading_blocker = $(widgetInstance.selector).find("div.widget-body").next();

    $.ajax({
      url: widgetInstance.options.url,
      beforeSend: function() {
          loading_blocker.addClass("block-enabled");
      },
      success: function(response) {
          $(widgetInstance.selector).find("div.widget-body").html(response);
          loading_blocker.removeClass("block-enabled");
      },
      error: function() {
          loading_blocker.removeClass("block-enabled");
      }
    });
  }
  this.bringTop();
  this.setActive();
}

Widget._serializeState = function() {

}

Widget._saveState = function() {

}

Widget._loadState = function() {

}

Widget.prototype._pushState = function() {
  var state = {
    "css" : {
      "top": $(this.selector).css("top"),
      "left": $(this.selector).css("left"),
      "width": $(this.selector).css("width"),
      "height": $(this.selector).css("height")
    },
    "maximized" : $(this.selector).hasClass("maximized")
  }

  this.states.push(state);
}

Widget.prototype._popState = function() {
  var state = this.states.pop();
  if (state !== undefined) {
    if (state.maximized) {
      this.maximize();
    } else {
      $(this.selector).css(state.css);
    }
  }
}

Widget.prototype._initPosition = function() {
  var wLeft = 5;
  var wTop = 5;
  var leftStep = (Widget.counter - 1 % 5);
  var topStep = (Widget.counter - 1 % 5);
  var delta_x = wLeft + 30 * (leftStep + 1);
  var delta_y = wTop + 25 * (topStep + 1);
  $(this.selector).css("left", delta_x + "px");
  $(this.selector).css("top", delta_y + "px");
}

Widget.prototype.setActive = function() {
  this.unsetActive();
  $(this.selector).addClass("widget-active");
  $(this.buttonSelector).addClass("widget-button-active");
}

Widget.prototype.unsetActive = function() {
  $.each(Widget.widgets, function (n, elem) {
    $(elem.selector).removeClass("widget-active");
    $(this.buttonSelector).removeClass("widget-button-active");
  });
}

Widget.prototype.bringTop = function() {
  var max_z = 0;
  $(Widget.widgets).each(function(n, e) {
    var z = parseInt($(e.selector).css("z-index"));
    if (z > max_z)
      max_z = z;
  });
  $(this.selector).css("z-index", max_z + 1);
}


Widget.cascade = function() {
  Widget.counter = 0;
  $("div.widget").css("z-index", "0"); // reset all z-index. so pq posso.
  $.each(Widget.widgets, function(n, e) {
    Widget.counter += 1;
    e.shrink();
    e._initPosition();
    e.bringTop();

  });
}

Widget.tile = function() {
  var wLeft = 0;
  var wTop = 0;
  $.each(Widget.widgets, function(n, e) {
    e.shrink();
    $(this.selector).css("left", wLeft + "px");
    $(this.selector).css("top", wTop + "px");
    e.bringTop();

    wLeft = wLeft + parseInt($(this.selector).css("width"));

    if (wLeft > $("div#widget-container").width()) {
      wTop = wTop + parseInt($(this.selector).css("height"));
      wLeft = 0;

      if (wTop > $("div#widget-container").height()) {
        wTop = 0;
      }
    }
  });
}

Widget.embiggen = function() {
  $.each(Widget.widgets, function(n, e) {
    e.maximize();
    //e.bringTop();
    //e.setActive();
  });
}

Widget.prototype.maximize = function() {
  $(this.selector).show();
  this._pushState();
  $(this.buttonSelector).removeClass("minimized");
  $(this.selector).addClass("maximized"); //css in class
  this.bringTop();
  this.setActive();

}

Widget.prototype.restore = function() {
  $(this.selector).show();
  $(this.buttonSelector).removeClass("minimized");
  $(this.selector).removeClass("maximized");
  this._popState();
  this.bringTop();
  this.setActive();
}

Widget.prototype.shrink = function() {
  $(this.selector).show();
  $(this.buttonSelector).removeClass("minimized");
  $(this.selector).removeClass("maximized");

  var len = Widget.widgets.length;
  // var gridSizeH = Math.ceil(len / 2);
  // var gridSizeV = Math.ceil(len / 2);
  // var width = parseInt($("div#widget-container").css("width"));
  // var height = parseInt($("div#widget-container").css("height"));
  //var newWidth = (width / gridSizeV);
  ///var newHeight = (height / gridSizeH);
  //console.log(width, height, gridSizeH, gridSizeV)

  var newWidth = this.options.css["min-width"];
  var newHeight = this.options.css["min-height"];
  $(this.selector).css({
     "width" : newWidth,
     "height" : newHeight
  });
  this.bringTop();
  this.setActive();
}


Widget.prototype.minimize = function() {
  $(this.selector).hide();
  this._pushState();
  $(this.buttonSelector).addClass("minimized");
  $(this.selector).removeClass("maximized");
}

Widget.prototype.close = function() {
  $(this.selector).remove();
  $(this.buttonSelector).remove();

  var widgetInstance = this;
  var elementIndex = null;
  $.each(Widget.widgets, function(n, e) {
    if (e.options.name == widgetInstance.options.name) {
      elementIndex = n;
    }
  });

  if (elementIndex !== null) {
    Widget.widgets.splice(elementIndex, 1);
  }
}


$(document).on("click", "[data-widget-action]", function(event) {
  var action = $(this).data("widget-action");
  var name = $(this).data("widget-name");
  var title = $(this).data("widget-title") || name;
  var href = $(this).attr("href");
  var useIframe = $(this).data("widget-mode") == "iframe";
  var css = $(this).data("widget-css")
  var maximized = $(this).data("widget-maximized") || false;
  var classes = $(this).data("widget-classes") || "widget-not-scrollable";

  switch (action) {

    case "open":
      var createdWidget = new Widget({
        "name" : name,
        "url" : href,
        "title" : name,
        "useIframe" : useIframe,
        "title" : title,
        "css" : css,
        "maximized" : maximized,
        "classes" : classes
      });
      break;

    case "open-always":
      var createdWidget = new Widget({
        "name" : name,
        "url" : href,
        "title" : name,
        "useIframe" : useIframe,
        "title" : title,
        "css" : css,
        "maximized" : maximized,
        "classes" : classes,
        "alwaysCreate" : true
      });
      break;

    default:
      break;

  }

  event.preventDefault();
});
