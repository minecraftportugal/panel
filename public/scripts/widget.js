function Widget(options) {

  Widget.options = {
    'url' : '/colorbars',
    'title' : 'Title',
    'useIframe' : false,
    'alwaysCreate' : false,
    'css' : {
      'normal' : {
        'top': '0px',
        'left': '0px',
        'width' : '800px',
        'height' : '600px',
        'min-width' : '640px',
        'min-height' : '480px',
        'max-width' : null, //'700px',
        'max-height' : null //'700px' 
      },
      'maximized' : {
        'top' :'0px',
        'left' :'0px',
        'width' : 'calc(100% - 2px)', //parseInt($('div#widget-container').css('width')) - 5 + 'px' ,
        'height' : '100%'//parseInt($('div#widget-container').css('height')) - 8 + 'px'
      }
    }
  }

  this.options = {};
  $.extend(this.options, Widget.options);
  $.extend(this.options, options);

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
  } else if (this.options.alwaysCreate) {
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

  console.log(this);
  $(this.selector).css(this.options.css.normal);

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
      $("iframe").css('pointer-events', 'none');
    },

    stop: function(event, ui) {
      $("iframe").css('pointer-events', 'auto');
    }

  });

  $(this.selector).resizable({ 

    iframeFix: true,
    addClasses: false,
    cancel: ".nointeraction",
    handle: "div.widget-drag",
    snap: true,
    snapMode: "outer",
    containment: "parent",
    start: function(event, ui) {
      $("iframe").css('pointer-events', 'none');
    },

    stop: function(event, ui) {
      $("iframe").css('pointer-events', 'auto');
    }

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
      widgetInstance.minimize();
      widgetInstance.unsetActive();
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
    this.iframeId = this.id + '-iframe';
    var jq_tag = $("<iframe></iframe>");
    jq_tag.attr("id", this.iframeId) ;
    jq_tag.attr("src", this.options.url) ;
    $(this.selector).find("div.widget-body").append(jq_tag);
    $(this.selector).addClass("widget-iframe");

  } else {
    var widgetInstance = this;
    $.ajax({
      url: widgetInstance.options.url,
      success: function(response) {
        $(widgetInstance.selector).find("div.widget-body").html(response);
      }
    });
    $(this.selector).find("div.widget-body").addClass("widget-ajax");
  }
  this.bringTop();
  this.setActive();
}

Widget.prototype._pushState = function() {
  var state = {
    'top': $(this.selector).css('top'),
    'left': $(this.selector).css('left'),
    'width': $(this.selector).css('width'),
    'height': $(this.selector).css('height')
  }
  this.states.push(state);
}

Widget.prototype._popState = function() {
  var state = this.states.pop();
  if (state !== undefined) {
    $(this.selector).css(state);
  }
}

Widget.prototype._initPosition = function() {
  var wLeft = 10;
  var wTop = 10;
  var leftStep = (Widget.counter - 1 % 5);
  var topStep = (Widget.counter - 1 % 5);
  var delta_x = wLeft + 20 * (leftStep + 1);
  var delta_y = wTop + 20 * (topStep + 1);
  $(this.selector).css("left", delta_x + "px");
  $(this.selector).css("top", delta_y + "px");
}

Widget.prototype.setActive = function() {
  this.unsetActive();
  $(this.selector).addClass("widget-active"); 
}

Widget.prototype.unsetActive = function() {
  $.each(Widget.widgets, function (n, elem) {
    $(elem.selector).removeClass("widget-active"); 
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
  $.each(Widget.widgets, function(n, e) { 
    Widget.counter += 1;
    e._initPosition();
    e.bringTop();
  });
}


Widget.tile = function() {
  console.log(Window.counter);
  Widget.counter = 0;
  $.each(Widget.widgets, function(n, e) { 
    Widget.counter += 1;
    e.restore();
    e._initPosition();
    e.bringTop();
  });
}

Widget.prototype.maximize = function() {
  $(this.selector).show();
  this._pushState();
  $(this.selector).css(this.options.css.maximized);
  $(this.buttonSelector).removeClass("minimized");
  $(this.selector).addClass("maximized");
  this.bringTop();
  this.setActive();

}

Widget.prototype.restore = function() {
  $(this.selector).show();
  this._popState();
  $(this.buttonSelector).removeClass("minimized");
  $(this.selector).removeClass("maximized");
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
  var href = $(this).attr("href");
  var useIframe = $(this).data("widget-mode") == "iframe";
  var css = $(this).data("widget-css") || Widget.options;
  css = css["css"];

  switch (action) {

    case "open":
      var createdWidget = new Widget({'name' : name, 'url' : href, 'title' : name, 'useIframe' : useIframe, 'css' : css});
      break;

    case "open-copy":
      var createdWidget = new Widget({'name' : name, 'url' : href, 'title' : name, 'useIframe' : useIframe, 'css' : css});
      break;

    default:
      break;

  }

  event.preventDefault();
});
